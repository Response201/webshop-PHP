<?php
// include --  OK även om filen inte finns
//include_once("Models/Products.php");
require_once ("Models/Database.php");

$dbContext = new DBContext();
?>

<!DOCTYPE html>
<html lang="en">

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
    <!-- Navigation-->

    <?php include_once ('Components/navbar.php'); ?>


    <!-- Header-->
    <header class="d-flex justify-content-center align-items-center bg-dark"
        style="min-height: 60vh; position: relative;">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center ">
                <?php
                $hour = date('h');
                if ($hour >= 9) {
                    ?>
                    <h1 class="display-4 fw-bolder">Super shoppen</h1>
                    <?php
                }
                ?>
                <p class="lead fw-normal ">Handla massa onödigt hos oss!</p>
            </div>
        </div>
        <div id="startchange" style="  position:absolute; bottom: 0;  ">
    </header>


    </div>



    <!-- Section-->
    <section class="py-6 ">
        <div class="container px-4 px-lg-5 mt-5">
            <div class="d-flex justify-content-end">


                <form class="d-flex">
                    <div class="input-group" style="max-width: 150px;">
                        <input class="form-control" type="search" placeholder="Sök" aria-label="Search">
                        <button class="btn btn-outline-dark" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock level</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    <!-- Loopa alla produkter och SKAPA tr taggar -->
                    <?php

                    foreach ($dbContext->getAllProducts() as $product) {
                        if ($product->price > 20) {
                            echo "<tr><td>$product->title</td><td>$product->price</td><td>$product->stockLevel</td><td><a href='product.php?id=$product->id'>EDIT</a></td></tr>";
                        } else {
                            echo "<tr class='table-info'><td>$product->title</td><td>$product->price</td><td>$product->stockLevel</td><td><a href='product.php?id=$product->id'>EDIT</a></td></tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
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