    <?php
    class Product{
        public $id;
        public $title;
        public $price;
        public $stockLevel;
        public $categoryName;
        public $imgproduct;

        function __construct($id,$title,$price,$stockLevel, $categoryName,$imgproduct){
            $this->id = $id;
            $this->title = $title;
            $this->price = $price;
            $this->stockLevel = $stockLevel;
            $this->categoryName = $categoryName;
            $this->imgproduct = $imgproduct;
        }
    };




    $allaProdukter = [
        new Product(1, 'Chai', 18, 39, 'Beverages', 'https://images.unsplash.com/photo-1580910051074-3eb694886505'),
        new Product(2, 'Chang', 19, 17, 'Beverages', 'https://images.unsplash.com/photo-1580910051074-3eb694886505'),
        new Product(3, 'Aniseed Syrup', 10, 13, 'Condiments', 'https://images.unsplash.com/photo-1580910051074-3eb694886505'),
        new Product(4, 'Chef Antons Cajun Seasoning', 22, 53, 'Condiments', 'https://images.unsplash.com/photo-1580910051074-3eb694886505'),
        new Product(5, 'Chef Antons Gumbo Mix', 21, 0, 'Condiments', 'https://images.unsplash.com/photo-1580910051074-3eb694886505'),
        new Product(6, 'Grandmas Boysenberry Spread', 25, 120, 'Condiments', 'https://images.unsplash.com/photo-1580910051074-3eb694886505'),
        new Product(7, 'Uncle Bobs Organic Dried Pears', 30, 15, 'Produce', 'https://images.unsplash.com/photo-1580910051074-3eb694886505'),
        new Product(8, 'Northwoods Cranberry Sauce', 40, 6, 'Condiments', 'https://images.unsplash.com/photo-1580910051074-3eb694886505'),
        new Product(9, 'Mishi Kobe Niku', 97, 29, 'Meat/Poultry', 'https://images.unsplash.com/photo-1580910051074-3eb694886505'),
        new Product(10, 'Ikura', 31, 31, 'Seafood', 'https://images.unsplash.com/photo-1580910051074-3eb694886505'),
        new Product(11, 'Queso Cabrales', 21, 22, 'Dairy Products', 'https://images.unsplash.com/photo-1580910051074-3eb694886505'),
        new Product(12, 'Queso Manchego La Pastora', 38, 86, 'Dairy Products', 'https://images.unsplash.com/photo-1580910051074-3eb694886505'),
        new Product(13, 'Konbu', 6, 24, 'Seafood', 'https://images.unsplash.com/photo-1580910051074-3eb694886505'),
        new Product(14, 'Tofu', 22, 35, 'Produce', 'https://images.unsplash.com/photo-1580910051074-3eb694886505'),
        new Product(15, 'Genen Shouyu', 18, 39, 'Condiments', 'https://images.unsplash.com/photo-1580910051074-3eb694886505'),
        new Product(16, 'Pavlova', 12, 29, 'Confections', 'https://images.unsplash.com/photo-1580910051074-3eb694886505'),
        new Product(17, 'Alice Mutton', 39, 0, 'Meat/Poultry', 'https://images.unsplash.com/photo-1580910051074-3eb694886505'),
        new Product(18, 'Carnarvon Tigers', 231, 42, 'Seafood', 'https://images.unsplash.com/photo-1580910051074-3eb694886505'),
        new Product(19, 'Teatime Chocolate Biscuits', 213, 25, 'Confections', 'https://images.unsplash.com/photo-1580910051074-3eb694886505'),
        new Product(20, 'Sir Rodneys Marmalade', 81, 40, 'Confections', 'https://images.unsplash.com/photo-1580910051074-3eb694886505'),
    ];


    function getAllCategories(){
        $cats = [];
        foreach(getAllProducts() as $product){
            if(!in_array($product->categoryName,$cats)){
                $cats[] = $product->categoryName;
            }
        }
        return $cats;
    }


    function getAllProducts(){
        global $allaProdukter;
        return $allaProdukter;
    }



    function getProduct($incoming_product_id, $allaProdukter) {
        $filteredProduct = array_filter($allaProdukter, fn($item) => $item-> id === intval($incoming_product_id));
        return reset($filteredProduct); 
    }


    function getCategory($incoming_category, $allaProdukter) {
        if($incoming_category !== 'Alla produkter'){
        $filteredProduct = array_filter($allaProdukter, fn($item) => $item-> categoryName == $incoming_category);
        return $filteredProduct; }
        else{

    return $allaProdukter;

        }
    }


    ?>