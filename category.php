<?php include_once ('Models/Database.php');
include_once ('Components/productItem.php');
$dbContext = new DBContext(); ?>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Shop Homepage - Start Bootstrap Template</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="/css/styles.css" rel="stylesheet" />
</head>

<body>
    <?php

    $category = $_GET['category'];
    $allCat = $dbContext->getAllCategories();
    $categoryName = $_GET['name'];
    

    $list = $dbContext->getProductByCategory($category);
    

    ?>
    <article class="categoryContainer">
        <section class="categoryContainer___header_sort">
            <h1>
                <?php echo "$categoryName";?>
            </h1>

<div class="categoryContainer___btn">
    <a class="itemBtn categoryBtn">s</a> <a class="itemBtn categoryBtn">s</a>
</div>
<hr class="categoryContainer___hr">
        </section>
        <?php include_once ('Components/navbar.php'); ?>
        <section class="productItemList">
            <?php

            foreach ($list as $item) {

                if ($item) {
                    productItem($item);
                }
            }
            ;
            ?>
        </section>
    </article>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>