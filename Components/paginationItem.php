<?php
require_once ("Models/Database.php");
function paginationItem()
{
    $dbContext = new DBContext();
    $category = $_GET['category'];
    $categoryName = $_GET['name'];
    $sort = $_GET['sorting'] ?? '';
    $sortingType = $_GET['sortingType'] ?? 'title';
    $q = $_GET['q'] ?? "";
    $page = $_GET['page'] ?? 1;
    $countPages =  $dbContext->getProductByCategorySort($category, $categoryName, $sortingType, $sort, $q, $page);
    if ($countPages['num_pages'] > $page) {
        $nextPage = $page + 1;
    } else {
        $nextPage = $page;
    }
    if ($page <= 1) {
        $prevPage = 1;
    } else {
        $prevPage = $page - 1;
    }
    echo "
    <section  class=\"paginationItem___Container\">
        <div class=\"paginationItem___BtnContainer\" id=\"btnPagesContainer\" >
            <a class=\"paginationItem___Btn\" href=\"?category=$category&name=$categoryName&sortingType=$sortingType&sorting=$sort&q=$q&page=$prevPage\" > <i class=\"bi bi-caret-left-fill paginationItem___icon \"></i></a>
";
    for ($i = 1; $i <= $countPages['num_pages']; $i++) {
        if ($i == $page) {
            echo "<a class=\"paginationItem___Btn btnPages-active\" > $i</a>";
        } else {
            echo "<a class=\"paginationItem___Btn btnPages\"  href=\"?category=$category&name=$categoryName&sortingType=$sortingType&sorting=$sort&q=$q&page=$i\">$i</a>";
        }
    }
    echo "
            <a class=\"paginationItem___Btn\"  href=\"?category=$category&name=$categoryName&sortingType=$sortingType&sorting=$sort&q=$q&page=$nextPage\" > <i class=\"bi bi-caret-right-fill paginationItem___icon \"></i></a>
        </div>
    </section>
";
}
?>