<?php include_once ('Models/Database.php');
include_once ('Components/productItem.php');
include_once ('Components/searchForm.php');
include_once ('Components/paginationItem.php');
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
    $sort = $_GET['sorting'] ?? '';
    $sortingType = $_GET['sortingType'] ?? 'title';
    $q = $_GET['q'] ?? "";
    if (!isset ($_GET['page']) ) {  
        $page = 1;  
    } else {  
        $page = $_GET['page'];  
    }  

    $list = $dbContext->getProductByCategorySort($category,$categoryName, $sortingType, $sort, $q, $page);
    

    ?>
    <article class="categoryContainer">
        <section class="categoryContainer___header_sort">
            <h1 class="categoryContainer___h1">
                <?php echo "$categoryName"; ?>
            </h1>
            <div class="categoryContainer___sort">
                <div class="categoryContainer___btn">
                    <div class="btn___item"><a class="categoryBtnSort"
                            href="?category=<?php echo "$category"; ?>&name=<?php echo "$categoryName"; ?>&sortingType=title&sorting=ASC&q=<?php echo "$q";?>&page=<?php echo"$page" ?>">
                            <i class="sortBtn bi bi-sort-alpha-down"></i>
                        </a> <a class="categoryBtnSort"
                            href="?category=<?php echo "$category"; ?>&name=<?php echo "$categoryName"; ?>&sortingType=title&sorting=DESC&q=<?php echo "$q"; ?>&page=<?php echo"$page" ?>">
                            <i class="sortBtn bi bi-sort-alpha-up"></i></a></div>



                    <div class="btn___item">

                        <?php
                        searchForm($category, $categoryName, $sort, $sortingType, $q)
                            ?>


                        <a class="categoryBtnSortIcon">
                            <i class=" bi bi-currency-dollar"></i> </a> <a class="categoryBtnSort"
                            href="?category=<?php echo "$category"; ?>&name=<?php echo "$categoryName"; ?>&sortingType=price&sorting=ASC&q=<?php echo "$q"; ?>&page=<?php echo"$page" ?>">
                            <i class="sortBtn bi bi-caret-down-fill"></i></a>
                        <a class="categoryBtnSort"
                            href="?category=<?php echo "$category"; ?>&name=<?php echo "$categoryName"; ?>&sortingType=price&sorting=DESC&q=<?php echo "$q"; ?>&page=<?php echo"$page" ?>">
                            <i class="sortBtn bi bi-caret-up-fill"></i>
                        </a>
                    </div>

                </div>

                <hr class="categoryContainer___hr">
            </div>
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



        <section class="categoryContainer___pages">


            <hr class="categoryContainer___hr">
         
                <?php   
    
   paginationItem();      ?>
      

    </article>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/activeBtns.js"></script>
</body>

</html>