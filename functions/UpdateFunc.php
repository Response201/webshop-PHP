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
    if (isset($_POST['submit'])) {
        $product->title = $_POST['title'];
        $product->price = $_POST['price'];
        $v->field('title')->required()->alpha([' '])->min_len(1)->max_len(50);
        $v->field('price')->required()->numeric()->min_val(1);
        if ($v->is_valid()) {
            $dbContext->updateProduct($product->id, $product->price);
            header("Location: $link "); // uppmaning Location = byt location till det jag säger
            exit;
        } else {
            $successMessage = "Det uppstod ett fel vid uppdateringen av produkten.";
        }
    }
}
?>