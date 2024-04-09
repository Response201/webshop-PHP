<?php
function productItem($item)
{
  require_once ("Models/Database.php");
  require_once ("Utils/Validator.php");
$dbContext = new DBContext();
  $category = $_POST['category'] ?? 'Meat/Poultry';
  $categoryName = $_POST['name'] ?? '';
  $sort = $_POST['sorting'] ?? '';
  $sortingType = $_POST['sortingType'] ?? 'title';
  $q = $_POST['q'] ?? "";
  $page = isset($_POST['page']) ? $_POST['page'] : 1;
  $change = $_POST['change'] ?? false;
  $id = $_POST['id'] ?? '';
  $admin = $dbContext->getUsersDatabase()->getAuth()->hasRole(\Delight\Auth\Role::ADMIN) ? true : false;



if($admin){ 
    if ($change && $item->id === $id) {
      $icon = '
      <div >
      <h5 class="itemTitle">' . $item->title . ' </h5>
              <input type="hidden" name="title" class="form-control"  class="itemTitle" style="width:100%" value="' . $item->title . '" />
              <input name="price"class="card-text" class="form-control" style="width:100%" value="' . $item->price . '" />
              <input name="id" type="hidden" class="form-control" value="' . $item->id . '" />
              <input type="hidden" name="q" class="form-control" value="' . $q . '" />
              <input type="hidden" name="category" class="form-control" value="' . $category . '" />
              <input type="hidden" name="sorting" class="form-control" value="' . $sort . '" />
              <input type="hidden" name="name" class="form-control" value="' . $categoryName . '" />
              <input type="hidden" name="sortingType" class="form-control" value="' . $sortingType . '" />
              <input type="hidden" name="page" class="form-control" value="' . $page . '" />
              <input type="hidden" name="change"  class="form-control" value="' . !$change . '" />
          </div
         ';
      $button = '<div class="btnContainer">
      <button type="submit" name="submit" class="itemBtn" ><i class="bi bi-plus-lg"></i></button>
</div>';
    } else {
      $icon = '
          <div >
          <h5 class="itemTitle">' . $item->title . '</h5>
          <p class="card-text">' . $item->price . ' kr</p>
              <input name="title" class="itemTitle" type="hidden" value="' . $item->title . '" />
              <input name="price" class="itemTitle" type="hidden" value="' . $item->price . '" />
              <input name="id" type="hidden" value="' . $item->id . '" />
              <input type="hidden" name="q" value="' . $q . '" />
              <input type="hidden" name="category" value="' . $category . '" />
              <input type="hidden" name="sorting" value="' . $sort . '" />
              <input type="hidden" name="name" value="' . $categoryName . '" />
              <input type="hidden" name="sortingType" value="' . $sortingType . '" />
              <input type="hidden" name="page" value="' . $page . '" />
              <input type="hidden" name="change" value="' . !$change . '" />
          </div>
         ';
         if ($change && $id){
         $button = '<div class="btnContainer">
         </div>';}else if (!$change && $id){ 
          $button = '<div class="btnContainer">
          <button class="itemBtn"><i class=" bi bi-pen-fill "></i></button>
          </div>';
         }else{
          $button = '<div class="btnContainer">
          <button class="itemBtn"><i class=" bi bi-pen-fill "></i></button>
          </div>';
         }
  }
} else {
    $icon = '
        <div>
            <h5 class="itemTitle">' . $item->title . '</h5>
            <p class="card-text">' . $item->price . ' kr</p>
        </div>
       ';
       $button = ' <div class="btnContainer">
    <button class="itemBtn" ><i class="bi-cart-fill"></i></button>
</div>';
  }
  if ($item !== null) {
    echo "<div class=\"p-3 item\">
            <div class=\"row\">
                <a class=\"col-12 rounded\" href='product?id=$item->id' style=\"height: 60%;\">
                    <img src=\"$item->img\" class=\"rounded img-fluid\" alt=\"Product Image\" style=\"height: 50%;\">
                </a> 
                <form class=\"d-flex justify-content-between\" method=\"POST\" style=\"margin-top: 1rem; height:30%; width:100%\">
                    $icon
                    $button
                </form>
            </div>
        </div>";
  } else {
    echo "Ingen produkt hittades.";
  }
}
?>