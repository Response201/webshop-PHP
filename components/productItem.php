<?php
function productItem($item)
{

$admin=false;
if($admin){
  $icon= " <button class=\"itemBtn \"><i class=\" bi bi-pen-fill \"></i></button> "; 
}else{
  $icon=" <button class=\"itemBtn \"><i class=\" bi-cart-fill \"></i></button> ";
};

  if ($item !== null) 
    echo "<div class=\"card p-3 item \">
        <div class=\"row  \" >
          <a class=\" col-12     rounded \" href='product?id=$item->id'>
             <img src=\"$item->img\" class=\" rounded  img-fluid \" alt=\"Product Image\">
          </a> 
          <div class=\" d-flex  justify-content-between   \" style=\" margin-top: 1rem; \">
         
          <div>
              <h5 class=\"card-title\"> $item->title</h5>
              <p class=\"card-text\">  $item->price kr</p>
              </div>
              <div class=\"  btnContainer  \">
              
              $icon
              
            
              
              </div>
          </div>
        </div>
      </div>
      ";
   else {
    echo "Ingen produkt hittades.";
  }
}
;


