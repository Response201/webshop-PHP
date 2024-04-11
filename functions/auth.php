<?php
    require 'vendor/autoload.php';
    require_once('Models/Database.php');


function test(){

    $dbContext = new DbContext();
    $message = "";
    $username = "";
   

    if(isset($_POST['create'])){
        $username = $_POST['username'];
        $password = $_POST['password']; 

    try{
        $userId = $dbContext->getUsersDatabase()->getAuth()->register($username, $password, $username, function ($selector, $token) {
            
           
            
            $mail = new PHPMailer\PHPMailer\PHPMailer(true);
$mail->isSMTP();
$mail->Host = 'smtp.ethereal.email';
$mail->SMTPAuth = true;
$mail->Username = 'edwina.berge18@ethereal.email';
$mail->Password = 'rfs8vBMAMfY8eRUwk2';
$mail->SMTPSecure = 'tls';
$mail->Port = 587;

            $mail->From = "solitaire@astoria.com"; 
            $mail->FromName = "Hello"; //To address and name 
            $mail->addAddress($_POST['username']); //Address to which recipient will reply 
            $mail->addReplyTo("noreply@ysuperdupershop.com", "No-Reply"); //CC and BCC 
            $mail->isHTML(true); 
            $mail->Subject = "Registrering"; 
            $url = 'http://localhost:8000/verify_email?selector=' . \urlencode($selector) . '&token=' . \urlencode($token);   
            
 
            $mail->Body = "<i>Hej, klicka på <a href='$url'>$url</a></i> för att verifiera ditt konto";
            $mail->send();

        });

         
       
       
        return 'Tack för din registerinbg, kolla mailet och verifiera ditt konto';
        exit;
}
    catch(Exception $e){
        throw $e;
        echo  $e->getMessage();
        return "Error";
        exit;
        
    }

 }




 }







