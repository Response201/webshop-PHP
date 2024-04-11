<?php
ob_start();
include_once ('Models/Database.php');
include_once ('Components/checkOutListItems.php');
$dbContext = new DBContext();
$username = $dbContext->getUsersDatabase()->getAuth()->getEmail();
$customer = $dbContext->getUsersDatabase()->getAuth()->hasRole(\Delight\Auth\Role::CONSUMER) ? true : false;
$id = $_POST['id'] ?? '';






if (isset($_POST['add'])){

    $dbContext -> addCart($username,$id,1,'add');
} 


if (isset($_POST['remove'])){

  $dbContext -> addCart($username,$id,1,'remove');
}



if (isset($_POST['delete'])){

  $dbContext -> addCart($username,$id,1,'delete');
}
    

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
    <article class="checkOutContainer">




        <?php include_once ('Components/navbar.php'); ?>

<p> 
        <?php if($customer){




$list = $dbContext -> findCart($username);

$listCount = count($list);

if( 1 <= $listCount ){
echo ' 

<table class="checkOutTabel">
  <thead>
    <tr class="headerTable">
      <th scope="col">#</th>
      <th scope="col">Vara</th>
      <th scope="col">Antal</th>
      <th scope="col">Lägg till</th>
      <th scope="col">Tabort</th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody >';

checkOutListItems();

  echo ' 
  </tbody>
</table>

';}else{


  echo"Du är inloggad och kan handla";

}


        }else{


            echo"Du behöver logga in för att slutför ditt köp";


        } ?>

</p>
        
        </section>
    </article>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>