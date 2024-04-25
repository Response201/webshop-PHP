<?php
function sortAlpaAndPageDropDown($category, $categoryName, $sortingType, $sort, $q, $page, $per_page_record)
{
    echo ' 
            <a class="categoryBtnSort" href="?category=' . $category . '&name=' . $categoryName . '&sortingType=title&sorting=ASC&q=' . $q . '&page=' . $page . '&per_page_record=' . $per_page_record . '">
                <i class="sortBtn bi bi-sort-alpha-down"></i>
            </a>
            <a class="categoryBtnSort" href="?category=' . $category . '&name=' . $categoryName . '&sortingType=title&sorting=DESC&q=' . $q . '&page=' . $page . '&per_page_record=' . $per_page_record . '">
                <i class="sortBtn bi bi-sort-alpha-up"></i>
            </a>
            <li class="categoryBtnSort dropdown me-2 nav-item CategoryDropDown">
                <a class="dropdown-toggle categoryLink" data-bs-toggle="dropdown" aria-expanded="false">
                    ' . $per_page_record . '
                </a>
                <ul class="dropdown-menu mb-2">
                    <li><a class=\'dropdown-item\' href=\'?category=' . $category . '&name=' . $categoryName . '&sortingType=' . $sortingType . '&sorting=' . $sort . '&q=' . $q . '&page=1&per_page_record=6\'>6</a></li> 
                    <li><a class=\'dropdown-item\' href=\'?category=' . $category . '&name=' . $categoryName . '&sortingType=' . $sortingType . '&sorting=' . $sort . '&q=' . $q . '&page=1&per_page_record=9\'>9</a></li>
                    <li><a class=\'dropdown-item\' href=\'?category=' . $category . '&name=' . $categoryName . '&sortingType=' . $sortingType . '&sorting=' . $sort . '&q=' . $q . '&page=1&per_page_record=12\'>12</a></li>
                </ul>
            </li>
      ';
}
?>