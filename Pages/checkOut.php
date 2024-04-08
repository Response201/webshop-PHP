<?php
ob_start();
include_once ('Models/Database.php');
$dbContext = new DBContext();


 $customer = $dbContext->getUsersDatabase()->getAuth()->hasRole(\Delight\Auth\Role::CONSUMER) ? true : false;
      
    

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

<p> 
        <?php if($customer){

echo"Du är inloggad och kan handla";


        }else{


            echo"Du behöver logga in för att slutför ditt köp";


        } ?>

</p>
        
        </section>
    </article>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>