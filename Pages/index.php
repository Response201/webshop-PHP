<?php
ob_start();
// include --  OK även om filen inte finns
//include_once("Models/Products.php");
include_once ("Models/Database.php");
include_once ('Components/productItem.php');
include_once ('functions/UpdateFunc.php');
$dbContext = new DBContext();
$q = "";
$id = $_POST['id'] ?? '';
$username = $dbContext->getUsersDatabase()->getAuth()->getEmail();
updateProduct("/");
if (isset($_POST['buy'])){
    $dbContext -> addCart($username,$id,1, 'add');
} 
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
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
    <link href="/css/index.css" rel="stylesheet" />
</head>
<body>
    <!-- Navigation-->
    <?php include_once ('Components/navbar.php'); ?>
    <!-- Header-->
    <header class="d-flex justify-content-center align-items-center  " style="min-height: 60vh; position: relative;">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white Header___text ">
                <h1 class="Header_h1 ">Solitaire Astoria</h1>
                <p>en stjärna i sitt eget universum av skönhet</p>
            </div>
        </div>
        <img src="./assets/images/header.png" class="Header___img" />
    </header>
    </div>
    <!-- Section Nyheter-->
    <section class="py-6 newProductContainer" id="startchange">
        <div class="newProductContainer___text">
            <h2 class="text___h2">Nyheter</h2>
            <a class="text___btn"> Handla nu </a>
        </div>
        <div class="newProductContainer___imgContainer">
            <img class="imgContainer___img" src="../assets/images/brushes.png" />
        </div>
    </section>
    <!-- sales -->
    <section class="py-6 lowStockLevelContainer">
    <input type="hidden" name="id" value="">
        <?php
        $list = $dbContext->getLowStockLevel();
        foreach ($list as $item) {
            if ($item) {
                echo "<section class='lowStockLevelContainer___item'>
                    <p class=\"lowStockLevelContainer___p\"> $item->stockLevel kvar! </p>
                    ";
                productItem($item, '/');
                echo "</section>";
            }
        }
        ;
        ?>
    </section>
    <!-- Footer-->
    <footer class="py-5 bg-dark">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright &copy; Your Website 2023</p>
        </div>
    </footer>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
</body>
</html>