<!-- navbar.php -->
<?php
// include --  OK även om filen inte finns
//include_once("Models/Products.php");
require_once ("Models/Database.php");
?>
<nav class="navbar navbar-default navbar-expand-lg text-white fixed-top" role="navigation">
    <div class="container-fluid">
        <button class="navbar-toggler  text-dark border-dark" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation">
            <span role="button"><i class="fa fa-bars" aria-hidden="true"></i></span>

        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
            <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item me-2">
                    <a class="nav-link active" aria-current="page" href="/">Home</a>
                </li>
                <li class="nav-item me-2">
                    <a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item dropdown me-2">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Produkter
                    </a>
                    <ul class="dropdown-menu mb-2">
                        <li><a class='dropdown-item' href='category?category=all&name=Alla%20Produkter'>Alla produkter</a></li>
                        <li role="separator" class="dropdown-divider border --bs-secondary-color"></li>
                        <?php

                        foreach ($dbContext->getAllCategories() as $category) {
                            echo "<li><a class='dropdown-item' href='category?category=$category->id&name=$category->title'>$category->title</a></li> ";
                        }
                        ?>

                    </ul>
                </li>
                <li class="nav-item ">
                    <form class="">
                        <button class="btn text-dark border-dark  change" type="submit">
                            <i class="bi-cart-fill text-dark change"></i> Cart
                            <span class="badge bg-dark text-white ms-1 rounded-pill">0</span>
                        </button>
                    </form>
                </li>
                <li class="nav-item dropdown me-2">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="bi bi-person"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" style="max-width:100px;">
                        <li><a class="dropdown-item" href="#">Logga In</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#">skapa konto</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>