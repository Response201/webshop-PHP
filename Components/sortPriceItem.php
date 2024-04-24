<?php
function sortPriceItem($category, $categoryName, $sortingType, $sort, $q, $page, $per_page_record)
{
    echo ' 
            <a class="categoryBtnSortIcon">
            <i class=" bi bi-currency-dollar"></i> </a> 
            <a class="categoryBtnSort" href="?category=' . $category . '&name=' . $categoryName . '&sortingType=price&sorting=ASC&q=' . $q . '&page=' . $page . '&per_page_record=' . $per_page_record . '">
            <i class="sortBtn bi bi-caret-down-fill"></i></a>
            <a class="categoryBtnSort" href="?category=' . $category . '&name=' . $categoryName . '&sortingType=price&sorting=DESC&q=' . $q . '&page=' . $page . '&per_page_record=' . $per_page_record . '">
            <i class="sortBtn bi bi-caret-up-fill"></i>
        </a>
      ';
}
?>