<?php
require_once ('Models/Product.php');
require_once ('Models/Category.php');
require_once ('Models/Cart.php');
require_once ('Models/UserDatabase.php');
require_once ('Models/CartDatabase.php');
class DBContext
{
    private $pdo;
    private $usersDatabase;

    function getUsersDatabase()
    {
        return $this->usersDatabase;
    }

    private $cartDatabase;
    function getCartDatabase()
    {
        return $this->cartDatabase;
    }
    

    function __construct()
    {
        $host = $_ENV['host'];
        $db = $_ENV['db'];
        $user = $_ENV['user'];
        $pass = $_ENV['pass'];
        $dsn = "mysql:host=$host;dbname=$db";
        $this->pdo = new PDO($dsn, $user, $pass);
        $this->usersDatabase = new UserDatabase($this->pdo);
        $this-> cartDatabase = new CartDatabase($this->pdo);
        $this->initIfNotInitialized();
        $this->seedfNotSeeded();
    }



    /* Kategorier */


    function getAllCategories()
    {
        return $this->pdo->query('SELECT * FROM category')->fetchAll(PDO::FETCH_CLASS, 'Category');
    }

    
    function getProductByCategory($categoryId)
    {
        if ($categoryId === 'all') {
            return $this->pdo->query('SELECT * FROM products')->fetchAll(PDO::FETCH_CLASS, 'Product');
        } else {
            $prep = $this->pdo->prepare("SELECT * FROM products WHERE categoryId = :categoryId");
            $prep->setFetchMode(PDO::FETCH_CLASS, 'Product');
            $prep->execute([':categoryId' => $categoryId]);
            return $prep->fetchAll();
        }
    }

    function getCategoryByTitle($title): Category|false
    {
        $prep = $this->pdo->prepare('SELECT * FROM category where title=:title  ');
        $prep->setFetchMode(PDO::FETCH_CLASS, 'Category');
        $prep->execute(['title' => $title]);
        return $prep->fetch();
    }





    /* Produkter */

    function getAllProducts()
    {
        return $this->pdo->query('SELECT * FROM products')->fetchAll(PDO::FETCH_CLASS, 'Product');
    }



    function getProduct($id)
    {
        $prep = $this->pdo->prepare('SELECT * FROM products where id=:id');
        $prep->setFetchMode(PDO::FETCH_CLASS, 'Product');
        $prep->execute(['id' => $id]);
        return $prep->fetch();
    }



    function getProductByTitle($title)
    {
        $prep = $this->pdo->prepare('SELECT * FROM products where title=:title');
        $prep->setFetchMode(PDO::FETCH_CLASS, 'Product');
        $prep->execute(['title' => $title]);
        return $prep->fetch();
    }



    function getLowStockLevel()
    {
        $sql = "WHERE stockLevel >= 1 ORDER BY stockLevel ASC LIMIT 0, 10";
        return $this->pdo->query("SELECT * FROM products $sql")->fetchAll(PDO::FETCH_CLASS, 'Product');
    }




    function getNewProducts()
    {

        $sql = "ORDER BY timestamp DESC LIMIT 0, 6";
        return $this->pdo->query("SELECT * FROM products $sql")->fetchAll(PDO::FETCH_CLASS, 'Product');
    }








    /* Validerar inkommande värde($sortCol) med inkommande array-värden(arrayOfValid). 
       Om ingen match finns så skickas default-värdet tillbaka ($default)  */
    function oneOf($sortCol, $arrayOfValid, $default)
    {
        foreach ($arrayOfValid as $a) {
            if (strcasecmp($a, $sortCol) == 0) {
                return $a;
            }
        }
        return $default;
    }


    function getProductByCategorySort($categoryId, $categoryName, $sortingType, $sort, $q,  $page = 1, $per_page_record = 6)
    {


        /* get values to int - secure issu */
        $pageInt = intval($page) ?? 1;
        $per_page_record_int = intval($per_page_record) ?? 6;

        /* check if value is DESC' - else defualt ASC */
        $sortOrder = $sort == 'DESC' ? 'DESC' : 'ASC';

        /* check if value is title or price' - else defualt title */
        $sortCol = $this->oneOf($sortingType, ["title", "price"], 'title');


        $start_from = ($pageInt - 1) * $per_page_record_int;


        $sql = "SELECT * FROM products WHERE categoryId = :categoryId";
        $paramsArray[":categoryId"] = $categoryId;

        if ($categoryId === 'all') {
            $sql = "SELECT * FROM products ";
            $paramsArray = [];
            if ($q) {
                $sql = "SELECT * FROM products WHERE title LIKE :q";
                $paramsArray[":q"] = '%' . $q . '%';
            }
        } 
        
        else if ($categoryId !== 'all') {
            if ($q) {
                $sql .= " AND title LIKE :q";
                $paramsArray[":q"] = '%' . $q . '%';
            }
        }





        $sql .= " ORDER BY  $sortCol $sortOrder ";
        $sqlCount = str_replace("SELECT * FROM ", "SELECT CEIL(COUNT(*)/$per_page_record_int) FROM ", $sql);
        $prep2 = $this->pdo->prepare($sqlCount);
        $prep2->execute($paramsArray);
        $num_pages = $prep2->fetchColumn();


        $sql .= " LIMIT $start_from, $per_page_record_int";
        $prep = $this->pdo->prepare($sql);
        $prep->setFetchMode(PDO::FETCH_CLASS, 'Product');
        $prep->execute($paramsArray);
        $list = $prep->fetchAll();
        $arr = ["data" => $list, "num_pages" => $num_pages];
        return $arr;
    }





    function updateProduct($id, $price, $stockLevel)
    {
        $id = intval($id);
        $prep = $this->pdo->prepare("UPDATE products
        SET 
            price = :price,
            stockLevel =:stockLevel
        WHERE id = :id
        ");
        $prep->execute(["id" => $id, "price" => $price, "stockLevel" => $stockLevel]);
        if ($prep->rowCount() > 0) {
            return $prep->rowCount() > 0;
        } else {
            return "Det gick inte uppdatera produkten";
        }
    }





/* Skapa produkt */

    function createIfNotExisting($title, $price, $stockLevel, $categoryName, $timeStamp, $img)
    {
        $existing = $this->getProductByTitle($title);
        if ($existing && !empty($existing->id)) {
            return;
        }
        ;
        return $this->addProduct($title, $price, $stockLevel, $categoryName,$timeStamp, $img);
    }



    function addCategory($title)
    {
        $prep = $this->pdo->prepare('INSERT INTO category (title) VALUES(:title )');
        $prep->execute(['title' => $title]);
        return $this->pdo->lastInsertId();
    }



    function addProduct($title, $price, $stockLevel, $categoryName, $timeStamp, $img)
    {
        $category = $this->getCategoryByTitle($categoryName);
        if ($category == false) {
            $this->addCategory($categoryName);
            $category = $this->getCategoryByTitle($categoryName);
        }
      
        
        $prep = $this->pdo->prepare('INSERT INTO products (title, price, stockLevel, categoryId, timeStamp, img) VALUES(:title, :price, :stockLevel, :categoryId, :timeStamp, :img )');
        $prep->execute(['title' => $title, 'price' => $price, 'stockLevel' => $stockLevel, 'categoryId' => $category->id, 'timeStamp'=> $timeStamp, 'img' => $img]);
        return $this->pdo->lastInsertId();
    }

















/* Skapa nya produkter */


    function seedfNotSeeded()
    {
        static $seeded = false;
        if ($seeded)
            return;

            $this->createIfNotExisting('Divine Volume Elixir', 199, 3, 'Mascara','2024-03-10', '.\assets\images\mascara\mascara1.png');
            $this->createIfNotExisting('Ethereal Palette of Enchantment', 159, 4, 'Ögonskugga', '2024-03-10', '.\assets\images\eyeshadow\9.png');
            $this->createIfNotExisting('Radiant Skin Essence', 1399, 21, 'Hudvård', '2024-04-20', '.\assets\images\skincare\1.png');
            $this->createIfNotExisting('Divine Beauty Kit', 2200, 4, 'Verktyg', '2024-03-15', '.\assets\images\item\1.png');
            $this->createIfNotExisting('Ethereal Liquid Veil', 249, 5, 'Foundation', '2024-03-20', '.\assets\images\foundation\1.png');
            $this->createIfNotExisting('Luxurious Lengthening Elixir', 489, 9, 'Mascara', '2024-03-25', '.\assets\images\mascara\2.png');
            $this->createIfNotExisting('Opulent Sapphire Palette', 289, 2, 'Ögonskugga', '2024-04-02', '.\assets\images\eyeshadow\2.png');
            $this->createIfNotExisting('Divine Peach Essence', 1299, 7, 'Hudvård', '2024-03-17', '.\assets\images\skincare\2.png');
            $this->createIfNotExisting('Royal Brush Set', 899, 15, 'Verktyg', '2024-04-10', '.\assets\images\item\2.png');
            $this->createIfNotExisting('Radiant Powder Veil', 650, 13, 'Foundation', '2024-03-18', '.\assets\images\foundation\2.png');
            $this->createIfNotExisting('Ethereal Curling Elixir', 275, 39, 'Mascara', '2024-03-12', '.\assets\images\mascara\4.png');
            $this->createIfNotExisting('Opulent Sunset Palette', 289, 6, 'Ögonskugga', '2024-03-13', '.\assets\images\eyeshadow\4.png');
            $this->createIfNotExisting('Divine Berry Essence', 1259, 35, 'Hudvård', '2024-03-14', '.\assets\images\skincare\3.png');
            $this->createIfNotExisting('Luxe Blending Set', 229, 21, 'Verktyg', '2024-03-16', '.\assets\images\item\3.png');
            $this->createIfNotExisting('Pearl Beauty', 759, 7, 'Foundation', '2024-03-19', '.\assets\images\foundation\3.png');
            $this->createIfNotExisting('Aqua Shield Mascara', 186, 9, 'Mascara', '2024-03-21', '.\assets\images\mascara\3.png');
            $this->createIfNotExisting('Regal Dream Palette', 129, 12, 'Ögonskugga', '2024-03-22', '.\assets\images\eyeshadow\1.png');
            $this->createIfNotExisting('Opulent Baroque Essence', 1596, 35, 'Hudvård', '2024-03-23', '.\assets\images\skincare\4.png');
            $this->createIfNotExisting('Divine Brow Mastery Kit', 495, 15, 'Verktyg', '2024-03-24', '.\assets\images\item\4.png');
            $this->createIfNotExisting('Luxe Tinted Veil', 325, 18, 'Foundation', '2024-03-26', '.\assets\images\foundation\4.png');
            $this->createIfNotExisting('Supreme Volume Elixir', 318, 39, 'Mascara', '2024-03-27', '.\assets\images\mascara\5.png');
            $this->createIfNotExisting('Opulent Diamond Palette', 220, 7, 'Ögonskugga', '2024-03-28', '.\assets\images\eyeshadow\7.png');
            $this->createIfNotExisting('Divine Hyper Essence', 2955, 35, 'Hudvård', '2024-03-29', '.\assets\images\skincare\5.png');
            $this->createIfNotExisting('Royal Precision Tool', 228, 8, 'Verktyg', '2024-03-30', '.\assets\images\item\5.png');
            $this->createIfNotExisting('Velvet Matte Mastery', 685, 10, 'Foundation', '2024-03-31', '.\assets\images\foundation\5.png');
            $this->createIfNotExisting('Ethereal Curl Enhance Elixir', 283, 9, 'Mascara', '2024-04-01', '.\assets\images\mascara\6.png');
            $this->createIfNotExisting('Royal Sapphire Palette', 145, 16, 'Ögonskugga', '2024-04-03', '.\assets\images\eyeshadow\8.png');
            $this->createIfNotExisting('Opulent Crimson Essence', 1523, 15, 'Hudvård', '2024-04-04', '.\assets\images\skincare\6.png');
            $this->createIfNotExisting('Luxe Vanity Mirror', 875, 15, 'Verktyg', '2024-04-05', '.\assets\images\item\6.png');
            $this->createIfNotExisting('Divine Coverage Foundation', 643, 14, 'Foundation', '2024-04-06', '.\assets\images\foundation\6.png');
            $this->createIfNotExisting('Luminous Lash Mastery', 262, 9, 'Mascara', '2024-04-07', '.\assets\images\mascara\7.png');
            $this->createIfNotExisting('Opulent Rose Shimmer Essence', 202, 12, 'Ögonskugga', '2024-04-08', '.\assets\images\eyeshadow\6.png');
            $this->createIfNotExisting('Majestic Mega Glow Elixir', 1695, 15, 'Hudvård', '2024-04-09', '.\assets\images\skincare\7.png');
            $this->createIfNotExisting('Royal Silver Mirror', 875, 11, 'Verktyg', '2024-04-11', '.\assets\images\item\7.png');
            $this->createIfNotExisting('Dewy Beauty Foundation', 755, 7, 'Foundation', '2024-04-12', '.\assets\images\foundation\7.png');
            $this->createIfNotExisting('Divine Volume Enhance Elixir', 555, 9, 'Mascara', '2024-04-13', '.\assets\images\mascara\9.png');
            $this->createIfNotExisting('Lush Lime Eye Palette', 205, 12, 'Ögonskugga', '2024-04-14', '.\assets\images\eyeshadow\3.png');
            $this->createIfNotExisting('Berry Essence Wow', 1589, 15, 'Hudvård', '2024-04-15', '.\assets\images\skincare\8.png');
            $this->createIfNotExisting('Luxurious Makeup Brushes', 899, 5, 'Verktyg', '2024-04-16', '.\assets\images\item\8.png');
            $this->createIfNotExisting('Radiant Glow Foundation', 955, 7, 'Foundation', '2024-04-17', '.\assets\images\foundation\8.png');
            $this->createIfNotExisting('Opulent Fiber Elixir', 459, 9, 'Mascara', '2024-04-18', '.\assets\images\mascara\8.png');
            $this->createIfNotExisting('Misty Beauty Eyeshadow', 159, 11, 'Ögonskugga', '2024-04-19', '.\assets\images\eyeshadow\5.png');
            $this->createIfNotExisting('Golden Essence Lux', 15994, 15, 'Hudvård', '2024-04-21', '.\assets\images\skincare\10.png');
            $this->createIfNotExisting('Royal Blending Sponge', 220, 10, 'Verktyg', '2024-04-22', '.\assets\images\item\9.png');
            $this->createIfNotExisting('Velvet Matte Finish Foundation', 550, 8, 'Foundation', '2024-04-23', '.\assets\images\foundation\9.png');
            $this->createIfNotExisting('Zoriar Elixir', 1450, 15, 'Hudvård', '2024-04-24', '.\assets\images\skincare\11.png');
            $this->createIfNotExisting('Lush Elegance', 1500, 5, 'Hudvård', '2024-04-25', '.\assets\images\skincare\12.png');
            
        
        $seeded = true;
    }


 


    /*  tabeller */
    function initIfNotInitialized()
    {
        static $initialized = false;
        if ($initialized)
            return;
        $sql = 'CREATE TABLE IF NOT EXISTS `category` (
            `id` INT AUTO_INCREMENT NOT NULL,
            `title` varchar(200) NOT NULL,
            PRIMARY KEY (`id`)
        )';
        $this->pdo->exec($sql);
        $sql = 'CREATE TABLE IF NOT EXISTS `products` (
            `id` INT AUTO_INCREMENT NOT NULL,
            `title` varchar(200) NOT NULL,
            `price` INT,
            `stockLevel` INT,
            `categoryId` INT NOT NULL,
            `timeStamp` varchar(20) NOT NULL,
            `img` varchar(200) NOT NULL,
            PRIMARY KEY (`id`),
            FOREIGN KEY (`categoryId`) REFERENCES `category`(`id`)
        )';
        $this->pdo->exec($sql);
        $this->usersDatabase->setupUsers();
        $this->usersDatabase->seedUsers();
        $this->cartDatabase->setupCart();
        $initialized = true;
    }
}
?>