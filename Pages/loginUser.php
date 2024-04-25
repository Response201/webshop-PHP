<?php
ob_start();
require_once ('Models/Database.php');
$dbContext = new DBContext();
$dbContext->getAllCategories();
$message = $_GET['message'] ?? "";
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';


if (isset($_POST['login'])) {
    try {
        $dbContext->getUsersDatabase()->getAuth()->login($username, $password);
        header('Location: /');
        exit;
    } catch (Exception $e) {
        $message = "Gick inte att logga in";
    }
}

?>
<!DOCTYPE HTML>

<head>
 
<?php include_once ('Components/basicHeadItem.php');?>
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="/css/styles.css" rel="stylesheet" />
    <link href="/css/createUserForm.css" rel="stylesheet" />
</head>

<body>
    <?php

    include_once ('Components/navbar.php');
    require_once('Components/loginOrCreateFormItem.php');
    $login = loginOrCreateFormItem('login', $message);
  echo "$login";  
   
    ?>
   
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/activeBtns.js"></script>
</body>

</html>