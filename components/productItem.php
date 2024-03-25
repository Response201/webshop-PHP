<?php
function productItem($item){
    if ($item !== null) {
        echo "<div class=\"card p-3 \">
        <div class=\"row g-0\">
          <a class=\"col-md-6\" href='product.php?id=$item->id'>
            <img src=\"$item->imgproduct\" class=\"img-fluid rounded-start\" alt=\"Product Image\">
          </a>
          <div class=\"col-md-6\">
            <div class=\"card-body\">
              <h5 class=\"card-title\"> $item->title</h5>
              <p class=\"card-text\">Price:  $item->price</p>
              <p class=\"card-text\">Category: $item->categoryName</p>
              <button class=\"btn btn-primary\">Add to Cart</button>
            </div>
          </div>
        </div>
      </div>
      ";
    } else {
        echo "Ingen produkt hittades.";
    }
};


