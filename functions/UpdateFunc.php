<?php
function updateProduct($link)
{
    include_once ('Models/Database.php');
    include_once ('components/productItem.php');
    require_once ("Utils/Validator.php");
    $dbContext = new DBContext();
    $id = $_POST['id'] ?? '';
    $product = $dbContext->getProduct($id);
    $v = new Validator($_POST);
    $successMessage = "";
    if (isset($_POST['changeProductBtn'])) {
        $product->title = $_POST['title'];
        $product->price = $_POST['price'];
        $product->stockLevel = $_POST['stockLevel'];
        $v->field('title')->required()->alpha([' '])->min_len(1)->max_len(50);
        $v->field('price')->required()->numeric()->min_val(1);
        $v->field('stockLevel')->required()->numeric()->min_val(1);
        if ($v->is_valid()) {
            $dbContext->updateProduct($product->id, $product->price,  $product->stockLevel);
            header("Location: $link");
            exit;
        } else {
            $successMessage = "Det uppstod ett fel vid uppdateringen av produkten.";
        }
    }
}
?>