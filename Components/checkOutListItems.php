<?php 

function checkOutListItems(){
include_once ('Models/Database.php');
$dbContext = new DBContext();
$username = $dbContext->getUsersDatabase()->getAuth()->getEmail();

$list = $dbContext -> findCart($username);

for ($i = 0; $i < count($list); $i++) {
    $product = $dbContext->getProduct($list[$i]->productId);
   $quanti = intval($list[$i]->quantity);
    $listItem = $i +1;
      $value = $product->stockLevel;

      /* ADD */
$btnAdd ='<a href="?checkout"> <button type="submit" name="add" class="itemBtn" >
<i class="bi bi-plus-lg"></i>
</button></a>';
if($value <= 0){
 $btnAdd ='<button class="itemBtn checkOutHollowBtn" ><i class="bi bi-plus-lg "></i></button> '; 
 }


      /* REMOVE */
      $btnRemove ='<a href="?checkout"> <button type="submit" name="remove" class="itemBtn" >
      <i class="bi bi-dash-lg"></i>
      </button></a>';
      if( $quanti  <= 0){
        $btnRemove ='<button class="itemBtn checkOutHollowBtn" ><i class="bi bi-dash-lg"></i></button> '; 
       }



       /* DELETE */



       $btnDelete ='<a href="?checkout"> <button type="submit" name="delete" class="itemBtn" >
       <i class="bi bi-dash-lg"></i>
       </button></a>';
     







    echo " <form method=\"POST\"><tr>
    <th scope=\"row\">
    
    
      $listItem 
    </th>
    <td></td>
    <td>$product->title</td>
    <td> $quanti</td>
    <td>
   
    <input name=\"id\" type=\"hidden\" class=\"form-control\" value=\"$product->id\" />
  
    $btnAdd
   
    </td>
    <td>$btnRemove </td>
    <td>$btnDelete   <p>$value  </p></td>
  </tr>
  
 
  
  </form>";



}
 }









?>