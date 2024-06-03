<?php
require 'vendor/autoload.php';
require_once ('Models/Database.php');

class CartDatabase {
    private $pdo;
  

    function __construct($pdo) {
        $this->pdo = $pdo;
     
    }






    


/* Cart - lägga till-, ta bort antal eller "radera" produkt från cart*/

function findCart($username)
{
    $prep = $this->pdo->prepare('SELECT * FROM cart where username=:username');
    $prep->setFetchMode(PDO::FETCH_CLASS, 'Cart');
    $prep->execute(['username' => $username]);
    return $prep->fetchAll();
}







    /* Total price */


    function totalPrice($username){
        $database = new DBContext();
          $list = $this-> findCart($username);
    $total = 0;
    if($list >= 1)
            foreach ($list as $item) {
                $product = $database->getProduct($item->productId);
                $total += $product->price * $item->quantity;

                }

       return $total;
          
        }






function addCart($username, $productId, $quantity, $action)
{
    $database = new DBContext();
    $existInCartItem = $this->findCartByUserAndProduct($username, $productId);
    $run = true;
    $productitem = $database->getProduct($productId);




    /* Add or remove from cart */
    if ($productId && $username) {
        if ($existInCartItem && $productitem) {
            $newquantity = $existInCartItem->quantity;
            $price = $productitem->price;
            $newValue = null;

            if ($run && $action === 'add' || $action === 'remove') {
                if ($action === 'add' && $productitem->stockLevel >= 1) {
                    $newquantity = $existInCartItem->quantity + 1;
                    $newValue = $productitem->stockLevel - 1;
                }
                if ($action === 'remove' && $existInCartItem->quantity >= 1) {
                    $newquantity = $existInCartItem->quantity - 1;
                    $newValue = $productitem->stockLevel + 1;
                }
                if ($newValue !== null) {
                    $database->updateProduct($productId, $price, $newValue);
                    $sql = "UPDATE cart SET quantity = :quantity WHERE productId = :productId AND username = :username";
                    $prep = $this->pdo->prepare($sql);
                    $prep->execute(["username" => $username, "productId" => $productId, "quantity" => $newquantity]);
                }
                $run = false;
            }


            /* Delete from cart */ 
            else if ($run && $action === 'delete') {
                $newValue = $productitem->stockLevel + $existInCartItem->quantity;
                $sql = "DELETE FROM cart WHERE productId = :productId AND username = :username";
                $prep = $this->pdo->prepare($sql);
                $prep->execute(["username" => $username, "productId" => $productId]);
                $database->updateProduct($productId, $price, $newValue);
                $run = false;
            }
        }


        /* Lägger till en ny produkt i cart */
        if ($run && !$existInCartItem) {
           
            $run = false;
            $newValue = $productitem->stockLevel - 1;
            $price = $productitem->price;
            $database->updateProduct($productId, $price, $newValue);
            $this->createCartData($username, $productId, 1);
        }
    }
}


/* Skapa cart + skicka tillbaka existerande cart  */



function findCartByUserAndProduct($username, $productId)
{
    $productId = intval($productId);
    $sql = "SELECT * FROM cart where username=:username AND productId=:productId";
    $prep = $this->pdo->prepare($sql);
    $prep->setFetchMode(PDO::FETCH_CLASS, 'Cart');
    $prep->execute(['username' => $username, 'productId' => $productId]);
    return $prep->fetch();
}



function createCartData($username, $productId, $quantity)
{
    $existingCart = $this->findCartByUserAndProduct($username, $productId);
    if (!$existingCart) {
        return $this->addNewCart($username, $productId, $quantity);
    } else {
        return;
    }
}



function addNewCart($username, $productId, $quantity = 1)
{

    $prep = $this->pdo->prepare('INSERT INTO cart (username, productId, quantity) VALUES(:username, :productId, :quantity)');
    $prep->execute(['username' => $username, 'productId' => $productId, 'quantity' => $quantity]);
    return $this->pdo->lastInsertId();
}












    
    function setupCart(){
        $sql = 'CREATE TABLE IF NOT EXISTS `cart` (
            `username` varchar(100) NOT NULL,
            `productId` INT NOT NULL,
            `quantity` INT NULL,
            PRIMARY KEY (`username`, `productId`)
        )';
        $this->pdo->exec($sql);
    }
    
}
?>