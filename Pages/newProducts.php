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
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1 />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Fahkwang:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;1,200;1,300;1,400;1,500;1,600;1,700&family=Hind+Siliguri:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <title>Shop Homepage - Start Bootstrap Template</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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