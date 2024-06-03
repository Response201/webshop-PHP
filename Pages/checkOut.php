<?php
ob_start();
include_once ('Models/Database.php');
include_once ('Components/checkOutListItems.php');
include_once ('Components/checkOutTotalPriceListItem.php');
$dbContext = new DBContext();
$username = $dbContext->getUsersDatabase()->getAuth()->getEmail();
$customer = $dbContext->getUsersDatabase()->getAuth()->hasRole(\Delight\Auth\Role::CONSUMER) ? true : false;
$id = $_POST['id'] ?? '';

if (isset($_POST['add'])){

    $dbContext ->getCartDatabase()-> addCart($username,$id,1,'add');
   
} 
if (isset($_POST['remove'])){
 
  $dbContext ->getCartDatabase()-> addCart($username,$id,1,'remove');
 
}
if (isset($_POST['delete'])){

  $dbContext ->getCartDatabase()-> addCart($username,$id,1,'delete');

}
?>
<html>
<head>
<?php include_once ('Components/basicHeadItem.php');?>
    
    <link href="/css/styles.css" rel="stylesheet" />
</head>
<body>
    <article class="checkOutContainer">
        <?php include_once ('Components/navbar.php'); ?>
<p> 
        <?php if($customer){
$list = $dbContext ->getCartDatabase()-> findCart($username);
$listCount = count($list);
$total=0;


if( 1 <= $listCount ){

  $total =  $dbContext ->getCartDatabase()->totalPrice($username);








echo ' 
<p>'; $total; echo'</p>
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
checkOutTotalPriceListItem($total);
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