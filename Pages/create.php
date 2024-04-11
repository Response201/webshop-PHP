<?php 
ob_start();
    require_once('Models/Database.php');
    require_once('functions/auth.php');
    require_once ("Utils/Validator.php");
    $v = new Validator($_POST);
$dbContext = new DBContext();
$message = "";
$username = "";
$password= "";
$type = $_GET['type'] ?? "";
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$passwordAgain = $_POST['passwordAgain'] ?? '';
if ($type === 'login') {
    $dbContext = new DbContext();
    if (isset($_POST['login'])){
        try{
           // Hejsan123#
     $dbContext->getUsersDatabase()->getAuth()->login($username, $password);
            header('Location: /');
            exit;
        }
        catch(Exception $e){
            $message = "Could not login";
        }}
 }
if(isset($_POST['create'])){
if($password !== $passwordAgain ){
$message = "password not match";
}
else if(!$password || !$passwordAgain || !$username){
    $message = "empty fields";
}
$v->field('username')->required()->email()->min_val(1)->max_len(100);;
if ($v->is_valid()) {
    $message = test();
    if($message === 'Tack för din registerinbg, kolla mailet och verifiera ditt konto'){
        $dbContext->getUsersDatabase()->makeConsumer($username); 
    }
}else {
    $message = "Could not create account";
}
}
?>
<!DOCTYPE HTML>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
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
    if($type === 'login'){
        $btn = '<button type="submit" name="login" class="createBtn">Logga in</button>
        ';
    } if($type === 'create'){
        $btn = '<button type="submit" name="create" class="createBtn">Skapa konto</button>
        ';
    }
    ?>
    <article class="createUserFormContainer">
        <img src="./assets/images/background.png" class="background___img" />
        <form class="createUserForm" method="POST">
            <section class="createInputContainer">
                <label class="createInput">Användarnamn: </label>
                <input name="username" class="createInput" />
                <label class="createInput">Lösenord: </label>
                <input name="password" class="createInput" type="password" />
                <?php   if( $type === 'create'){ 
                    echo "  
                <label class=\"createInput\">Lösenord: </label>
                <input name=\"passwordAgain\" class=\"createInput\" type=\"password\" />";
            } 
                ?>
                <p class="createUserMessage">
            <?php echo " $message"; ?>
            </p>
            </section>
            <section class="createBtnContainer">
            <?php echo "$btn"; ?>
            </section>
        </form>
    </article>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/activeBtns.js"></script>
</body>
</html>