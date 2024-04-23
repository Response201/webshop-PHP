<?php 

function checkOutListItems(){
include_once ('Models/Database.php');
$dbContext = new DBContext();
$username = $dbContext->getUsersDatabase()->getAuth()->getEmail();

$list = $dbContext ->getCartDatabase()-> findCart($username);

for ($i = 0; $i < count($list); $i++) {
    $product = $dbContext->getProduct($list[$i]->productId);
   $quanti = intval($list[$i]->quantity);
    $listItem = $i +1;
      $value = $product->stockLevel;
$message ='';
      /* ADD */
$btnAdd ='<a href="?checkout"> <button type="submit" name="add" class="itemBtn checkOutBtn" >
<i class="bi bi-plus-lg"></i>
</button></a>';
if($value <= 0){
 $btnAdd ='<div class="itemBtn checkOutHollowBtn checkOutBtn" ><i class="bi bi-plus-lg "></i></div> '; 
 }
 if($value == 1){
  $message ='1 kvar!'; 
  }

      /* REMOVE */
      $btnRemove ='<a href="?checkout"> <button type="submit" name="remove" class="itemBtn checkOutBtn" >
      <i class="bi bi-dash-lg"></i>
      </button></a>';
      if( $quanti  <= 0){
        $btnRemove ='<div class="itemBtn checkOutHollowBtn checkOutBtn" ><i class="bi bi-dash-lg"></i></div> '; 
       }



       /* DELETE */



       $btnDelete ='<a href="?checkout"> <button type="submit" name="delete" class="itemBtn checkOutBtn" >
       <i class="bi bi-trash"></i>
       </button></a>';
     







    echo " <form method=\"POST\"><tr class='changeObjectItemContainer'>
    <th scope=\"row\" class=\"changeObjectItem\" >
    
    
      $listItem 
    </th>

    <td  class=\"changeObjectItem\">$product->title</td>
    <td class=\"changeObjectItem\"> $quanti</td>
    <td class=\"changeObjectItem\">
   
    <input name=\"id\" type=\"hidden\" class=\"form-control\" value=\"$product->id\" />
  
    $btnAdd
   <p class=\" changeObjectText \"> $message </p>
    </td>
    <td class=\"changeObjectItem\">$btnRemove </td>
    <td class=\"changeObjectItem\">$btnDelete   </td>
  </tr>
  
 
  
  </form>";



}
 }









?>