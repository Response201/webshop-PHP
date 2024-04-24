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
    $dbContext ->getCartDatabase()-> addCart($username,$id,1, 'add');
} 
?>
<html>
<head>
<?php include_once ('Components/basicHeadItem.php');?>
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="/css/styles.css" rel="stylesheet" />
</head>
<body>

    <article class="productContainer">
    <img src="./assets/images/background.png" class="background___img" />
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