<?php 
ob_start();
    require_once('Models/Database.php');
    require_once('functions/auth.php');
    require_once ("Utils/Validator.php");
    require_once('Components/loginOrCreateFormItem.php');
    $v = new Validator($_POST);
$dbContext = new DBContext();
$message = $_GET['message'] ?? "";
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$passwordAgain = $_POST['passwordAgain'] ?? '';


if(isset($_POST['create'])){
if($password !== $passwordAgain ){
$message = "Lösenorden matchar inte varandra";
}
else if(!$password || !$passwordAgain || !$username){
    $message = "Vänligen fyll i alla fält";
}else{

$v->field('username')->required()->email()->min_val(1)->max_len(100);;
$v->field('password')->required()->match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$/");
if ($v->is_valid()) {
    $message = auth();
    if($message === 'Tack för din registerinbg, kolla mailet och verifiera ditt konto'){
        $dbContext->getUsersDatabase()->makeConsumer($username); 
    }
}else {
    $message = "Det gick inte registrera kontot";
}}
}
?>



<!DOCTYPE HTML>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Shop Homepage - Start Bootstrap Template</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="/css/styles.css" rel="stylesheet" />
    <link href="/css/createUserForm.css" rel="stylesheet" />
</head>
<body>
    <?php
    $dbContext->getAllCategories();
    include_once ('Components/navbar.php');
    $createUser = loginOrCreateFormItem('createUser', $message);
    echo "$createUser"; 
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/activeBtns.js"></script>
</body>
</html>