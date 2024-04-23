<?php
ob_start();
include_once ('Models/Database.php');
include_once ('Components/productItem.php');
include_once ('Components/searchForm.php');
include_once ('Components/paginationItem.php');
include_once ('functions/UpdateFunc.php');
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
if (isset($_POST['buy'])){
    $dbContext ->getCartDatabase()-> addCart($username,$id,1, 'add');
} 
$list = $dbContext->getProductByCategorySort($category, $categoryName, $sortingType, $sort, $q, $page, $per_page_record);
updateProduct("?category=$category&name=$categoryName&sortingType=$sortingType&sorting=$sort&q=$q&page=$page&per_page_record=$per_page_record");

?>
<!DOCTYPE HTML>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Shop Homepage - Start Bootstrap Template</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap ikoner-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Core theme CSS (inkluderar Bootstrap)-->
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
                        <a class="categoryBtnSort"
                            href="?category=<?php echo "$category"; ?>&name=<?php echo "$categoryName"; ?>&sortingType=title&sorting=ASC&q=<?php echo "$q"; ?>&page=<?php echo "$page" ?>&per_page_record=<?php echo "$per_page_record" ?>">
                            <i class="sortBtn bi bi-sort-alpha-down"></i>
                        </a>
                        <a class="categoryBtnSort"
                            href="?category=<?php echo "$category"; ?>&name=<?php echo "$categoryName"; ?>&sortingType=title&sorting=DESC&q=<?php echo "$q"; ?>&page=<?php echo "$page" ?>&per_page_record=<?php echo "$per_page_record" ?>">
                            <i class="sortBtn bi bi-sort-alpha-up"></i></a>
                        <li class="categoryBtnSort dropdown me-2 nav-item CategoryDropDown">
                            <a class="dropdown-toggle categoryLink" data-bs-toggle="dropdown" aria-expanded="false">
                                <?php
                                echo " $per_page_record"; ?>
                            </a>
                            <ul class="dropdown-menu mb-2">
                                <?php
                                echo "<li><a class='dropdown-item '  href='?category=$category&name=$categoryName&sortingType=$sortingType&sorting=$sort&q=$q&page=1&per_page_record=6'>6</a></li> 
                            <li><a class='dropdown-item'  href='?category=$category&name=$categoryName&sortingType=$sortingType&sorting=$sort&q=$q&page=1&per_page_record=9'>9</a></li>
                            <li><a class='dropdown-item'  href='?category=$category&name=$categoryName&sortingType=$sortingType&sorting=$sort&q=$q&page=1&per_page_record=12'>12</a></li>
                            ";
                                ?>
                            </ul>
                        </li>
                    </div>
                    <div class="btn___item">
                        <?php
                        searchForm($category, $categoryName, $sort, $sortingType, $q, $per_page_record)
                            ?>
                        <a class="categoryBtnSortIcon">
                            <i class=" bi bi-currency-dollar"></i> </a> <a class="categoryBtnSort"
                            href="?category=<?php echo "$category"; ?>&name=<?php echo "$categoryName"; ?>&sortingType=price&sorting=ASC&q=<?php echo "$q"; ?>&page=<?php echo "$page" ?>&per_page_record=<?php echo "$per_page_record" ?>">
                            <i class="sortBtn bi bi-caret-down-fill"></i></a>
                        <a class="categoryBtnSort"
                            href="?category=<?php echo "$category"; ?>&name=<?php echo "$categoryName"; ?>&sortingType=price&sorting=DESC&q=<?php echo "$q"; ?>&page=<?php echo "$page" ?>&per_page_record=<?php echo "$per_page_record" ?>">
                            <i class="sortBtn bi bi-caret-up-fill"></i>
                        </a>
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
                    productItem($item,"?category&name=$categoryName&sortingType=$sortingType&sorting=$sort&q=$q&page=$page&per_page_record=$per_page_record");
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