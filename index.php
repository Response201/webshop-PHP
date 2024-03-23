<?php
// include --  OK även om filen inte finns
//include_once("Models/Products.php");
require_once("Models/Product.php");
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
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="/css/styles.css" rel="stylesheet" />
    </head>
    <body>
        <!-- Navigation-->

        <nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
      <ul class="navbar-nav mb-2 mb-lg-0">
        <li class="nav-item me-2">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item me-2">
          <a class="nav-link" href="#">Link</a>
        </li>
        <li class="nav-item dropdown me-2">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Produkter
          </a>
          <ul class="dropdown-menu mb-2">
            <li class='dropdown-item' href='#!'> Alla produkter </li>
            <li role="separator" class="dropdown-divider border --bs-secondary-color"></li>
        
            <?php
            foreach(getAllCategories() as $category){
              echo "<li><a class='dropdown-item' href='#!'>$category</a></li> ";   
            }
            ?>
          </ul>
        </li>
        <li class="nav-item me-2">
          <form class="d-flex">
            <button class="btn btn-outline-dark" type="submit">
              <i class="bi-cart-fill me-1"></i> Cart
              <span class="badge bg-dark text-white ms-1 rounded-pill">0</span>
            </button>
          </form>
        </li>

        <li class="nav-item dropdown me-2">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-person"></i> 
          </a>
          <ul class="dropdown-menu dropdown-menu-end " style="max-width:100px;">
           
            
            <li><a class="dropdown-item" href="#">Logga In</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">skapa konto</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>









        <!-- Header-->
        <header class="bg-dark py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="text-center text-white">
                    <?php
                    $hour = date('h');
                    if($hour >= 9){
                    ?>
                    <h1 class="display-4 fw-bolder">Super shoppen</h1>
                    <?php
                    }
                    ?> 
                    <p class="lead fw-normal text-white-50 mb-0">Handla massa onödigt hos oss!</p>
                </div>
            </div>
        </header>
        <!-- Section-->
        <section class="py-5">
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
                    $produkterna = getAllProducts();
                    foreach ($produkterna as $product) {
                        if($product->price > 20){
                            echo  "<tr><td>$product->title</td><td>$product->categoryName</td><td>$product->price</td><td>$product->stockLevel</td><td><a href='product.php?id=$product->id'>EDIT</a></td></tr>";
                        }else{
                            echo  "<tr class='table-info'><td>$product->title</td><td>$product->categoryName</td><td>$product->price</td><td>$product->stockLevel</td><td><a href='product.php?id=$product->id'>EDIT</a></td></tr>";                            
                        }
                    }
                    ?>
                </tbody>
            </table>
                            </div>
        </section>
        <!-- Footer-->
        <footer class="py-5 bg-dark">
            <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Your Website 2023</p></div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
