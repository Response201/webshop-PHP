<?php
ob_start();
include_once ('Models/Database.php');
include_once ('Components/productItem.php');
include_once ('Components/searchForm.php');
include_once ('Components/paginationItem.php');
include_once ('functions/UpdateFunc.php');
include_once ('Components/sortAlpaAndPageDropDown.php');
include_once ('Components/sortPriceItem.php');
$dbContext = new DBContext();
$category = $_GET['category'];
$allCat = $dbContext->getAllCategories();
$categoryName = $_GET['name'];
$sort = $_GET['sorting'] ?? '';
$sortingType = $_GET['sortingType'] ?? 'title';
$q = $_GET['q'] ?? "";
$per_page_record = intval($_GET['per_page_record'] ?? 6);
$id = $_POST['id'] ?? "";
if (!isset($_GET['page'])) {
    $page = 1;
} else {
    $page = $_GET['page'] ?? 1;
}
$username = $dbContext->getUsersDatabase()->getAuth()->getEmail();
if (isset($_POST['buy'])) {
    $dbContext->getCartDatabase()->addCart($username, $id, 1, 'add');
}
$list = $dbContext->getProductByCategorySort($category, $categoryName, $sortingType, $sort, $q, $page, $per_page_record);
updateProduct("?category=$category&name=$categoryName&sortingType=$sortingType&sorting=$sort&q=$q&page=$page&per_page_record=$per_page_record");

?>
<!DOCTYPE HTML>

<head>
    <?php include_once ('Components/basicHeadItem.php'); ?>
    <link href="/css/styles.css" rel="stylesheet" />
</head>

<body>
    <article class="categoryContainer">
        <img src="./assets/images/background.png" class="background___img" />
        <section class="categoryContainer___header_sort">
            <h1 class="categoryContainer___h1">
                <?php echo "$categoryName"; ?>
            </h1>
            <div class="categoryContainer___sort">
                <div class="categoryContainer___btn">
                    <div class="btn___item">
                        <?php sortAlpaAndPageDropDown($category, $categoryName, $sortingType, $sort, $q, $page, $per_page_record) ?>
                    </div>
                    <div class="btn___item">
                        <?php
                        searchForm($category, $categoryName, $sort, $sortingType, $q, $per_page_record);
                        sortPriceItem($category, $categoryName, $sortingType, $sort, $q, $page, $per_page_record);
                        ?>

                    </div>
                </div>
                <hr class="categoryContainer___hr">
            </div>
        </section>
        <?php include_once ('Components/navbar.php'); ?>
        <section class="productItemListCon">
            <section class="productItemList">
                <?php
                foreach ($list["data"] as $item) {
                    if ($item) {
                        productItem($item, "?category&name=$categoryName&sortingType=$sortingType&sorting=$sort&q=$q&page=$page&per_page_record=$per_page_record");
                    }
                }
                ;
                ?>
            </section>
        </section>
        <section class="categoryContainer___pages">
            <hr class="categoryContainer___hr">
            <?php
            paginationItem(); ?>
    </article>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/activeBtns.js"></script>
</body>

</html>