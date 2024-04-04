<?php
require_once ('Models/Product.php');
require_once ('Models/Category.php');
class DBContext{ 

private $pdo;

    
function __construct() {    
    $host = $_ENV['host'];
    $db   = $_ENV['db'];
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
    function updateProduct($id,  $price)
    {
        $id = intval($id);
        $prep = $this->pdo->prepare("UPDATE products
        SET 
            price = :price
        WHERE id = :id
        ");
        $prep->execute(["id" => $id, "price" => $price]);
        if($prep->rowCount() > 0){return $prep->rowCount() > 0;}else{return "fel";}
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
        $this->createIfNotExisting('Chai', 18, 39, 'Beverages', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Chang', 19, 17, 'Beverages', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Aniseed Syrup', 10, 13, 'Condiments', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Chef Antons Cajun Seasoning', 22, 53, 'Condiments', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Chef Antons Gumbo Mix', 21, 0, 'Condiments', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Grandmas Boysenberry Spread', 25, 120, 'Condiments', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Uncle Bobs Organic Dried Pears', 30, 15, 'Produce', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Northwoods Cranberry Sauce', 40, 6, 'Condiments', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Mishi Kobe Niku', 97, 29, 'Meat/Poultry', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Ikura', 31, 31, 'Seafood', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Queso Cabrales', 21, 22, 'Dairy Products', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Queso Manchego La Pastora', 38, 86, 'Dairy Products', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Konbu', 6, 24, 'Seafood', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Tofu', 22, 35, 'Produce', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Genen Shouyu', 18, 39, 'Condiments', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Pavlova', 12, 29, 'Confections', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Alice Mutton', 39, 0, 'Meat/Poultry', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Carnarvon Tigers', 231, 42, 'Seafood', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Teatime Chocolate Biscuits', 213, 25, 'Confections', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Sir Rodneys Marmalade', 81, 40, 'Confections', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Sir Rodneys Scones', 10, 3, 'Confections', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Gustafs Knäckebröd', 21, 104, 'Grains/Cereals', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Tunnbröd', 9, 61, 'Grains/Cereals', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Guaraná Fantástica', 231, 20, 'Beverages', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('NuNuCa Nuß-Nougat-Creme', 14, 76, 'Confections', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Gumbär Gummibärchen', 312, 15, 'Confections', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Schoggi Schokolade', 213, 49, 'Confections', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Rössle Sauerkraut', 132, 26, 'Produce', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Thüringer Rostbratwurst', 231, 0, 'Meat/Poultry', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Nord-Ost Matjeshering', 321, 10, 'Seafood', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Gorgonzola Telino', 321, 0, 'Dairy Products', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Mascarpone Fabioli', 32, 9, 'Dairy Products', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Geitost', 12, 112, 'Dairy Products', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Sasquatch Ale', 14, 111, 'Beverages', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Steeleye Stout', 18, 20, 'Beverages', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Inlagd Sill', 19, 112, 'Seafood', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Gravad lax', 26, 11, 'Seafood', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Côte de Blaye', 1, 17, 'Beverages', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Chartreuse verte', 18, 69, 'Beverages', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Boston Crab Meat', 2, 123, 'Seafood', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Jacks New England Clam Chowder', 2, 85, 'Seafood', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Singaporean Hokkien Fried Mee', 14, 26, 'Grains/Cereals', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Ipoh Coffee', 46, 17, 'Beverages', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Gula Malacca', 2, 27, 'Condiments', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Rogede sild', 3, 5, 'Seafood', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Spegesild', 12, 95, 'Seafood', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Zaanse koeken', 4, 36, 'Confections', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Chocolade', 6, 15, 'Confections', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Maxilaku', 5, 10, 'Confections', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Valkoinen suklaa', 1, 65, 'Confections', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Manjimup Dried Apples', 53, 20, 'Produce', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Filo Mix', 7, 38, 'Grains/Cereals', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Perth Pasties', 4, 0, 'Meat/Poultry', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Tourtière', 7, 21, 'Meat/Poultry', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Pâté chinois', 24, 115, 'Meat/Poultry', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Gnocchi di nonna Alice', 38, 21, 'Grains/Cereals', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Ravioli Angelo', 7, 36, 'Grains/Cereals', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Escargots de Bourgogne', 7, 62, 'Seafood', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Raclette Courdavault', 55, 79, 'Dairy Products', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Camembert Pierrot', 34, 19, 'Dairy Products', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Sirop dérable', 7, 113, 'Condiments', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Tarte au sucre', 7, 17, 'Confections', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Vegie-spread', 7, 24, 'Condiments', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Wimmers gute Semmelknödel', 7, 22, 'Grains/Cereals', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Louisiana Fiery Hot Pepper Sauce', 7, 76, 'Condiments', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Louisiana Hot Spiced Okra', 17, 4, 'Condiments', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Laughing Lumberjack Lager', 14, 52, 'Beverages', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Scottish Longbreads', 8, 6, 'Confections', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Gudbrandsdalsost', 8, 26, 'Dairy Products', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Outback Lager', 15, 15, 'Beverages', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Flotemysost', 8, 26, 'Dairy Products', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Mozzarella di Giovanni', 8, 14, 'Dairy Products', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Röd Kaviar', 15, 101, 'Seafood', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Longlife Tofu', 10, 4, 'Produce', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Rhönbräu Klosterbier', 9, 125, 'Beverages', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Lakkalikööri', 9, 57, 'Beverages', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Original Frankfurter grüne Soße', 13, 32, 'Condiments', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
        $this->createIfNotExisting('Tidningen Buster', 13, 32, 'Tidningar', 'https://images.unsplash.com/photo-1598908314766-3e3ce9bd2f48');
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