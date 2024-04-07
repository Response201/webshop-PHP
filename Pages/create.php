<?php 
ob_start();
    require 'vendor/autoload.php';
    require_once('Models/Database.php');



$dbContext = new DBContext();
$message = "";
$username = "";
$password= "";
$type = $_GET['type'] ?? "";
$username = $_POST['username'] ?? '';
$password = $_POST['password']?? '';

if ($type === 'login') {

    $dbContext = new DbContext();
  
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
   
        try{
           // Hejsan123#
 
     $dbContext->getUsersDatabase()->getAuth()->login($username, $password);
         
            header('Location: /');
            exit;
        }
        catch(Exception $e){
            $message = "Could not login";
    
        }}



} else {

    try{
     

        $dbContext-> getUsersDatabase()->createUser($username, $password);
         header('Location: /');
         exit;
     }
     catch(Exception $e){
         $message = "Could not login";
 
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




    ?>
    <article class="createUserFormContainer">




        <img src="./assets/images/background.png" class="background___img" />

        <form class="createUserForm" method="POST">
            <p>
            <?php echo " $message"; ?>
            </p>
            <section class="createInputContainer">
                <label class="createInput">Användarnamn: </label>
                <input name="username" class="createInput" />
                <label class="createInput">Lösenord: </label>
                <input name="password" class="createInput" type="password" />

            </section>
            <section class="createBtnContainer">
                <button type="submit" class="createBtn"> <?php  if($type === 'login'){echo "Logga in";}else{echo "Skapa konto";}    ?> </i></button>
            </section>

        </form>





    </article>





    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/activeBtns.js"></script>
</body>

</html>