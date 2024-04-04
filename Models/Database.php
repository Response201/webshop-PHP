<?php
require_once ('Models/Product.php');
require_once ('Models/Category.php');
class DBContext
{

    private $pdo;


    function __construct()
    {
        $host = $_ENV['host'];
        $db = $_ENV['db'];
        $user = $_ENV['user'];
        $pass = $_ENV['pass'];
        $dsn = "mysql:host=$host;dbname=$db";
        $this->pdo = new PDO($dsn, $user, $pass);
        $this->initIfNotInitialized();
        $this->seedfNotSeeded();
    }

    function getAllCategories()
    {
        return $this->pdo->query('SELECT * FROM category')->fetchAll(PDO::FETCH_CLASS, 'Category');
    }
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
    function getProductByCategorySort($categoryId, $categoryName, $sortingType, $sort, $q, $page)
    {
        /* skapa filtrering */
        $per_page_record = 6;
        $start_from = ($page - 1) * $per_page_record;
        $sql = "ORDER BY $sortingType $sort";
        if ($q && $categoryId === 'all') {
            $sql = "WHERE title LIKE '%" . $q . "%' ORDER BY $sortingType " . $sort;
        }
        if ($q && $categoryId !== 'all') {
            $sql = "AND title LIKE '%" . $q . "%' ORDER BY $sortingType " . $sort;
        }
        /* anrop */
        /* alla produkter */
        if ($categoryId === 'all') {
            return $this->pdo->query("SELECT * FROM products $sql LIMIT $start_from, $per_page_record ")->fetchAll(PDO::FETCH_CLASS, 'Product');
        } else {
            /* efter kategori */
            $prep = $this->pdo->prepare("SELECT * FROM products WHERE categoryId = :categoryId  $sql LIMIT $start_from, $per_page_record ");
            $prep->setFetchMode(PDO::FETCH_CLASS, 'Product');
            $prep->execute([':categoryId' => $categoryId]);
            return $prep->fetchAll();
        }
    }
    function getPages($categoryId, $categoryName, $sortingType, $sort, $q, $page)
    {
        $sql = "ORDER BY $sortingType $sort";
        if ($q && $categoryId === 'all') {
            $sql = "WHERE title LIKE '%" . $q . "%' ORDER BY $sortingType " . $sort;
        }
        if ($q && $categoryId !== 'all') {
            $sql = "AND title LIKE '%" . $q . "%' ORDER BY $sortingType " . $sort;
        }
        /* anrop */
        /* alla produkter */
        if ($categoryId === 'all') {
            return $this->pdo->query("SELECT * FROM products $sql ")->fetchAll(PDO::FETCH_CLASS, 'Product');
        } else {
            /* efter kategori */
            $prep = $this->pdo->prepare("SELECT * FROM products WHERE categoryId = :categoryId  $sql");
            $prep->setFetchMode(PDO::FETCH_CLASS, 'Product');
            $prep->execute([':categoryId' => $categoryId]);
            return $prep->fetchAll();
        }
    }
    /* Tar ut alla produkter som tillhör en och samma kategori */
    function getCategoryByTitlessss($title, $pages): Category|false
    {
        $per_page_record = 6;
        $start_from = ($page - 1) * $per_page_record;
        $prep = $this->pdo->prepare('SELECT * FROM category where title=:title LIMIT $start_from $per_page_record');
        $prep->setFetchMode(PDO::FETCH_CLASS, 'Category');
        $prep->execute(['title' => $title]);
        return $prep->fetch();
    }
    function getLowStockLevel()
    {
        $sql = "WHERE stockLevel >= 1 ORDER BY stockLevel ASC LIMIT 0, 10";
        return $this->pdo->query("SELECT * FROM products $sql  ")->fetchAll(PDO::FETCH_CLASS, 'Product');
    }
    function updateProduct($id, $price)
    {
        $id = intval($id);
        $prep = $this->pdo->prepare("UPDATE products
        SET 
            price = :price
        WHERE id = :id
        ");
        $prep->execute(["id" => $id, "price" => $price]);
        if ($prep->rowCount() > 0) {
            return $prep->rowCount() > 0;
        } else {
            return "fel";
        }
    }
    function getCategoryByTitle($title): Category|false
    {
        $prep = $this->pdo->prepare('SELECT * FROM category where title=:title  ');
        $prep->setFetchMode(PDO::FETCH_CLASS, 'Category');
        $prep->execute(['title' => $title]);
        return $prep->fetch();
    }











    function seedfNotSeeded()
    {
        static $seeded = false;
        if ($seeded)
            return;
        $this->createIfNotExisting('Volume Boost', 18, 39, 'Mascara', '.\assets\images\mascara\mascara1.png');
        $this->createIfNotExisting('Smoothie Palette', 20, 42, 'Ögonskugga', '.\assets\images\eyeshadow\9.png');
        $this->createIfNotExisting('Rose Blush', 15, 35, 'Hudvård', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Eyelash Curler', 22, 45, 'Verktyg', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Liquid Foundation', 25, 50, 'Foundation', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Lengthening Mascara', 18, 39, 'Mascara', '.\assets\images\mascara\2.png');
        $this->createIfNotExisting('blue Palette', 20, 42, 'Ögonskugga', '.\assets\images\eyeshadow\2.png');
        $this->createIfNotExisting('Peach Flush', 15, 35, 'Hudvård', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Makeup Brushes Set', 22, 45, 'Verktyg', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Powder Foundation', 25, 50, 'Foundation', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');

        $this->createIfNotExisting('Curling Mascara', 18, 39, 'Mascara', '.\assets\images\mascara\4.png');
        $this->createIfNotExisting('Yellow Sunset Palette', 20, 15, 'Ögonskugga', '.\assets\images\eyeshadow\4.png');
        $this->createIfNotExisting('Berry Tint', 15, 35, 'Hudvård', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Blending Sponge', 22, 45, 'Verktyg', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('BB Cream', 25, 50, 'Foundation', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');

        $this->createIfNotExisting('Waterproof Mascara', 18, 39, 'Mascara', '.\assets\images\mascara\3.png');
        $this->createIfNotExisting('Purple dream', 20, 42, 'Ögonskugga', '.\assets\images\eyeshadow\1.png');
        $this->createIfNotExisting('Highlighter Palette', 15, 35, 'Hudvård', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Brow Shaping Kit', 22, 45, 'Verktyg', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Tinted Moisturizer', 25, 50, 'Foundation', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');

        $this->createIfNotExisting('Volume Supreme', 18, 39, 'Mascara', '.\assets\images\mascara\5.png');
        $this->createIfNotExisting('Pink Shimmer Palette', 20, 42, 'Ögonskugga', '.\assets\images\eyeshadow\7.png');
        $this->createIfNotExisting('Golden Bronze', 15, 35, 'Hudvård', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Precision Applicator', 22, 45, 'Verktyg', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Matte Perfection', 25, 50, 'Foundation', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');

        $this->createIfNotExisting('Curl Enhance Mascara', 18, 39, 'Mascara', '.\assets\images\mascara\6.png');
        $this->createIfNotExisting('Sapphire Sky Palette', 20, 42, 'Ögonskugga', '.\assets\images\eyeshadow\8.png');
        $this->createIfNotExisting('Crimson Flush Blush', 15, 35, 'Hudvård', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Eyebrow Tweezers', 22, 45, 'Verktyg', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Buildable Coverage Foundation', 25, 50, 'Foundation', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');

        $this->createIfNotExisting('Lash Boost Mascara', 18, 39, 'Mascara', '.\assets\images\mascara\7.png');
        $this->createIfNotExisting('Rose Shimmer Shadow', 20, 42, 'Ögonskugga', '.\assets\images\eyeshadow\6.png');
        $this->createIfNotExisting('Peachy Glow Blush', 15, 35, 'Hudvård', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Brow Shaping Kit', 22, 45, 'Verktyg', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Dewy Finish Foundation', 25, 50, 'Foundation', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');

        $this->createIfNotExisting('Volume Mascara', 18, 39, 'Mascara', '.\assets\images\mascara\9.png');
        $this->createIfNotExisting('Lime Eye Palette', 20, 42, 'Ögonskugga', '.\assets\images\eyeshadow\3.png');
        $this->createIfNotExisting('Berry Blush', 15, 35, 'Hudvård', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Makeup Brushes Set', 22, 45, 'Verktyg', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Radiant Glow Foundation', 25, 50, 'Foundation', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');

        $this->createIfNotExisting('Fiber Mascara', 18, 39, 'Mascara', '.\assets\images\mascara\8.png');
        $this->createIfNotExisting('Misty Eyeshadow', 20, 42, 'Ögonskugga', '.\assets\images\eyeshadow\5.png');
        $this->createIfNotExisting('Golden Blush', 15, 35, 'Hudvård', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Blending Brush Set', 22, 45, 'Verktyg', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Matte Finish Foundation', 25, 50, 'Foundation', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Berry', 450, 35, 'Hudvård', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Sonic', 150, 13, 'Hudvård', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('lush', 1500, 5, 'Hudvård', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');


        $seeded = true;
    }
    function createIfNotExisting($title, $price, $stockLevel, $categoryName, $img)
    {
        $existing = $this->getProductByTitle($title);
        if ($existing && !empty($existing->id)) {
            return;
        }
        ;
        return $this->addProduct($title, $price, $stockLevel, $categoryName, $img);
    }
    function addCategory($title)
    {
        $prep = $this->pdo->prepare('INSERT INTO category (title) VALUES(:title )');
        $prep->execute(['title' => $title]);
        return $this->pdo->lastInsertId();
    }
    function addProduct($title, $price, $stockLevel, $categoryName, $img)
    {
        $category = $this->getCategoryByTitle($categoryName);
        if ($category == false) {
            $this->addCategory($categoryName);
            $category = $this->getCategoryByTitle($categoryName);
        }
        //insert plus get new id 
        // return id             
        $prep = $this->pdo->prepare('INSERT INTO products (title, price, stockLevel, categoryId, img) VALUES(:title, :price, :stockLevel, :categoryId, :img )');
        $prep->execute(['title' => $title, 'price' => $price, 'stockLevel' => $stockLevel, 'categoryId' => $category->id, 'img' => $img]);
        return $this->pdo->lastInsertId();
    }







    /* Skapa user */


    function createIfNotExistingUser($username, $password)
    {
        $existing = $this->getProductByTitle($username);
        if ($existing) {
            return;
        }
        ;
        return $this->addUser($username, $password);
    }

    function addUser($username, $password)
    {


        $prep = $this->pdo->prepare('INSERT INTO products (username, password) VALUES(:username, :password,  )');
        $prep->execute(['username' => $username, 'password' => $password]);
        return $this->pdo->lastInsertId();
    }











    /* skapa databas */
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
            `img` varchar(200) NOT NULL,
            PRIMARY KEY (`id`),
            FOREIGN KEY (`categoryId`) REFERENCES `category`(`id`)
        )';
        $this->pdo->exec($sql);

        $sql = 'CREATE TABLE IF NOT EXISTS `orders` (
            `orderId` INT AUTO_INCREMENT PRIMARY KEY,
            `orderDate` DATE NOT NULL
        )';
        $this->pdo->exec($sql);

        $sql = 'CREATE TABLE IF NOT EXISTS `order_products` (
            `orderId` INT NOT NULL,
            `productId` INT NOT NULL,
            `quantity` INT NOT NULL,
            PRIMARY KEY (`orderId`, `productId`),
            FOREIGN KEY (`orderId`) REFERENCES `orders`(`orderId`),
            FOREIGN KEY (`productId`) REFERENCES `products`(`id`)
        )';
        $this->pdo->exec($sql);


        /* 
                $sql = 'CREATE TABLE IF NOT EXISTS `user_order` (
                    `orderId` INT NOT NULL,
                    `username` varchar(50) NOT NULL,
                    FOREIGN KEY (`orderId`) REFERENCES `orders`(`orderId`),
                    FOREIGN KEY (`username`) REFERENCES `users`(`username`)
                )';
                $this->pdo->exec($sql); */

        $initialized = true;
    }
}






?>