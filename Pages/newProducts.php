<?php
ob_start();
include_once ("Models/Database.php");
include_once ('Components/productItem.php');
include_once ('functions/UpdateFunc.php');
$dbContext = new DBContext();
$id = $_POST['id'] ?? '';
$username = $dbContext->getUsersDatabase()->getAuth()->getEmail();
updateProduct("/new");
if (isset($_POST['buy'])){
    $dbContext ->getCartDatabase()-> addCart($username,$id,1, 'add');
} 
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php include_once ('Components/basicHeadItem.php');?>
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="/css/styles.css" rel="stylesheet" />
    <link href="/css/newProducts.css" rel="stylesheet" />
</head>
<body>
    <!-- Navigation-->
    <?php include_once ('Components/navbar.php'); ?>

<article>
<img src="./assets/images/background.png" class="background___img" />
<h1> Nyheter </h1> 
<section class="newProductsSection">

    <section class="newProductContainer">
    <input type="hidden" name="id" value="">
        <?php
        $list = $dbContext->getNewProducts();
        foreach ($list as $item) {
            if ($item) {
                echo "<section class='newProductContainer___item'>
              
                    ";
                productItem($item, '/new');
            
                echo "<p class='newProductDate'> $item->timeStamp </p></section>";
            }
        }
        ;
        ?>
    </section>
    </section>
     </article>

    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  
</body>
</html>