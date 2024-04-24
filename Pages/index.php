<?php
ob_start();
// include --  OK även om filen inte finns
//include_once("Models/Products.php");
include_once ("Models/Database.php");
include_once ("Models/CartDatabase.php");
include_once ('Components/productItem.php');
include_once ('functions/UpdateFunc.php');
$dbContext = new DBContext();
$q = "";
$id = $_POST['id'] ?? '';
$username = $dbContext->getUsersDatabase()->getAuth()->getEmail();
updateProduct("/");
if (isset($_POST['buy'])){
    $dbContext -> getCartDatabase()-> addCart($username,$id,1, 'add');
} 
    ?>
<!DOCTYPE html>
<html lang="en">
<head>


<?php include_once ('Components/basicHeadItem.php');?>
    
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
            <a class="text___btn" href="/new"> Handla nu </a>
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
    <footer >
        <div class="container">
            <p class="m-0 text-center text-dark">Copyright &copy; Solitaire Astoria 2024</p>
        </div>
        <img src="./assets/images/background.png" class="background___img" />
    </footer>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
</body>
</html>