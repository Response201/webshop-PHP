<?php


ob_start();
include_once ('Models/Database.php');
include_once ('components/productItem.php');
include_once ('functions/UpdateFunc.php');
$dbContext = new DBContext();
$id = $_GET['id'];

/* uppdate function connected to productItem => send link to refresh/ show page whit new value */
updateProduct("/product?id=$id");
$username = $dbContext->getUsersDatabase()->getAuth()->getEmail();


if (isset($_POST['buy'])){
 
    $dbContext -> addCart($username,$id,1, 'add');

} 


?>
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
    <article class="productContainer">




        <?php include_once ('Components/navbar.php'); ?>





        <section class="productItem">
            <?php

            productItem($dbContext->getProduct($_GET['id']), "/product?id=$id");
            ?>
        </section>
    </article>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>