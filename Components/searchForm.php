<?php

require_once("Models/Database.php");

function searchForm($category, $categoryName, $sort, $sortingType, $q) {
    echo '
    <form class="d-flex search" method="GET">
        <div class="input-group" style="max-width: 150px;">
            <input type="text" name="q" class="form-control" value="' . $q . '" onchange="this.form.submit()" />
            <input type="hidden" name="category" class="form-control" value="' . $category . '" />
            <input type="hidden" name="sorting" class="form-control" value="' . $sort . '" />
            <input type="hidden" name="name" class="form-control" value="' . $categoryName . '" />
            <input type="hidden" name="sortingType" class="form-control" value="' . $sortingType . '" />
            <button class="btn btn-outline-dark" type="submit">
                <i class="bi bi-search"></i>
            </button>
        </div>
    </form>';
}
?>
