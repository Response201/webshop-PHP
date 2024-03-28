<?php

require_once("Models/Database.php");

function paginationItem($category, $categoryName, $sort, $sortingType, $q) {
    echo '

    <section class="paginationItem___Container">
        <div class="paginationItem___BtnContainer" id="btnPages" >
        <button class="paginationItem___Btn"> <i class="bi bi-caret-left-fill paginationItem___icon "></i></button>


        <button class="paginationItem___Btn btnPages"> 1</button>

        <button class="paginationItem___Btn btnPages"> 2</button>


        <button class="paginationItem___Btn btnPages"> 3</button>


            
        <button class="paginationItem___Btn "><i class="bi bi-caret-right-fill paginationItem___icon "></i></i></button>
        </div>
    </section>
  
    ';
}
?>

<!-- <button class="paginationItem___Btn btnPages"> 1</button>

        <button class="paginationItem___Btn btnPages"> 2</button>


        <button class="paginationItem___Btn btnPages"> 3</button> -->