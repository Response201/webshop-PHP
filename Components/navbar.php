<!-- navbar.php -->
<?php

require_once ("Models/Database.php");

$per_page_record = $_GET['per_page_record'] ?? 6;
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
                        <li><a class='dropdown-item' href='category?category=all&name=Alla%20Produkter&per_page_record=<?php echo"$per_page_record"; ?>'>Alla produkter</a></li>
                        <li role="separator" class="dropdown-divider border --bs-secondary-color"></li>
                        <?php
                        foreach ($dbContext->getAllCategories() as $category) {
                            echo "<li><a class='dropdown-item' href='category?category=$category->id&name=$category->title&per_page_record=$per_page_record '>$category->title</a></li> ";
                        }
                        ?>
                    </ul>
                </li>

<?php 

if($dbContext->getUsersDatabase()->getAuth()->hasRole(\Delight\Auth\Role::CONSUMER)){
$count = 0;
$username = $dbContext->getUsersDatabase()->getAuth()->getEmail();

    $existingCart = $dbContext -> findCart($username);
foreach ($existingCart as $product){
   $count +=$product->quantity;
    }
    





echo '<li class="nav-item ">
<a href="checkout">
    <button class="btn text-dark border-dark  change" type="submit">
        <i class="bi-cart-fill text-dark change"></i> Cart
        <span class="badge bg-dark text-white ms-1 rounded-pill"> '; 
        
          echo " $count </span>
        </button>
    </a>
    </li     ";      
        


}









?>


              
                <li class="nav-item dropdown me-2">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="bi bi-person"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" style="max-width:100px;">



<?php 

$user  = $dbContext->getUsersDatabase()->getAuth()->isLoggedIn();
 $dbContext = new DBContext();

 if (isset($_POST['logOut'])) {
  
    try {
        $dbContext->getUsersDatabase()->getAuth()->logOut();
        $message = "logga ut";
        header('Location: /');
        exit;
    }
    catch(Exception $e) {
        $message = "Could not logout";
    }





}








if($user){
    echo'
    <form method="post" class="dropdownForm">
    <button  name="logOut" class="dropdown-item" name="logout">Logga Ut</button>
</form>
';

}else{
echo'
    <li><a class="dropdown-item" href="create?type=login">Logga In</a></li>
    <li>
        <hr class="dropdown-divider">
    </li>
    <li><a class="dropdown-item" href="/create?type=create">skapa konto</a></li>

';


}



?>



                        
                    </ul>
                </li>
            </ul>







        </div>
    </div>
</nav>