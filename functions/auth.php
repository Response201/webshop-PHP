<?php
    require 'vendor/autoload.php';
    require_once('Models/Database.php');
    require_once ('functions/mailer.php');

function auth(){


    $dbContext = new DbContext();
    $username = "";


    if(isset($_POST['create'])){
        $username = $_POST['username'];
        $password = $_POST['password']; 

        try {
            $userId = $dbContext->getUsersDatabase()->getAuth()->register($username, $password, $username, function ($selector, $token) {
                $subject = "Registrering";
                $urlIn = 'http://localhost:8000/verify_email?selector=' . \urlencode($selector) . '&token=' . \urlencode($token);
                $body = "<i>Hej, klicka <a href='$urlIn'>här</a></i> för att verifiera ditt konto";
                mailer($selector, $token, $subject, $urlIn, $body);
            });

         
       
       
        return 'Tack för din registerinbg, kolla mailet och verifiera ditt konto';
     
}
    catch(Exception $e){
     
        return "Något gick fel";
      
        
    }

 }




 }







