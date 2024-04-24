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
                $body = "<!DOCTYPE html><html xmlns=\"http://www.w3.org/1999/xhtml\"><head>
                
                
              

<meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\">
                <meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\"><meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0;\"><meta name=\"format-detection\" content=\"telephone=no\"/><style>body{margin:0;padding:0;min-width:100%;width:100%!important;height:100%!important}body,table,td,div,p,a{-webkit-font-smoothing:antialiased;text-size-adjust:100%;-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;line-height:100%}table,td{mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse!important;border-spacing:0}img{border:0;line-height:100%;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic}#outlook a{padding:0}.ReadMsgBody{width:100%}.ExternalClass{width:100%}.ExternalClass,.ExternalClass p,.ExternalClass span,.ExternalClass font,.ExternalClass td,.ExternalClass div{line-height:100%}@media all and(min-width:560px){.container{border-radius:8px;-webkit-border-radius:8px;-moz-border-radius:8px;-khtml-border-radius:8px}}a,a:hover{color:#127DB3}.footer a,.footer a:hover{color:#999999}</style></head><!-- BODY --><!-- Set message background color (twice) and text color (twice) --><body topmargin=\"0\" rightmargin=\"0\" bottommargin=\"0\" leftmargin=\"0\" marginwidth=\"0\" marginheight=\"0\" width=\"100%\" style=\"border-collapse:collapse;border-spacing:0;margin:0;padding:0;width:100%;height:100%;min-height:100vh;-webkit-font-smoothing:antialiased;text-size-adjust:100%;-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;line-height:100%;background-color:#F0F0F0;color:#000000;display:flex;justify-content:center;align-item:center;\" bgcolor=\"#F0F0F0\" text=\"#000000\"><table width=\"100%\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse:collapse;border-spacing:0;margin:0;padding:0;width:100%;\" class=\"background\"><tr><td align=\"center\" valign=\"top\" style=\"border-collapse:collapse;border-spacing:0;margin:0;padding:0;\" bgcolor=\"#F0F0F0\"><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\" width=\"560\" style=\"border-collapse:collapse;border-spacing:0;padding:0;width:inherit;max-width:560px;\" class=\"wrapper\"><tr><td align=\"center\" valign=\"top\" style=\"border-collapse:collapse;border-spacing:0;margin:0;padding:0;padding-left:6.25%;padding-right:6.25%;width:87.5%;padding-top:20px;padding-bottom:20px;\"><div style=\"display:none;visibility:hidden;overflow:hidden;opacity:0;font-size:1px;line-height:1px;height:0;max-height:0;max-width:0;color:#F0F0F0;\" class=\"preheader\">Available on&nbsp;GitHub and&nbsp;CodePen. Highly compatible. Designer friendly. More than 50%&nbsp;of&nbsp;total email opens occurred on&nbsp;a&nbsp;mobile device&nbsp;— a&nbsp;mobile-friendly design is&nbsp;a&nbsp;must for&nbsp;email campaigns.</div></td></tr></table><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\" bgcolor=\"#FFFFFF\" width=\"560\" style=\"border-collapse:collapse;border-spacing:0;padding:0;width:inherit;max-width:560px;\" class=\"container\"><tr><td align=\"center\" valign=\"top\" style=\"border-collapse:collapse;border-spacing:0;margin:0;padding:0;padding-left:6.25%;padding-right:6.25%;width:87.5%;font-size:24px;font-weight:bold;line-height:130%;padding-top:25px;color:#000000;font-family:sans-serif;\" class=\"header\">Welcome to Solitaire Astoria!</td></tr><tr><td align=\"center\" valign=\"top\" style=\"border-collapse:collapse;border-spacing:0;margin:0;padding:0;padding-top:20px;\" class=\"hero\"><a target=\"_blank\" style=\"text-decoration:none;\" ><img border=\"0\" vspace=\"0\" hspace=\"0\" src=\"https://i.ibb.co/C6SD9qk/background.png\" alt=\"Please enable images to view this content\" title=\"Hero Image\" width=\"560\" style=\"width:100%;max-width:560px;color:#000000;font-size:13px;margin:0;padding:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;border:none;display:block;\"/></a></td></tr><tr><td align=\"center\" valign=\"top\" style=\"border-collapse:collapse;border-spacing:0;margin:0;padding:0;padding-left:6.25%;padding-right:6.25%;width:87.5%;font-size:17px;font-weight:400;line-height:160%;padding-top:25px;color:#000000;font-family:sans-serif;\" class=\"paragraph\">As a customer at Solitaire Astoria, you are offered exclusive makeup products, carefully crafted to enhance your beauty. Explore our handpicked collection for an unparalleled feeling of glamour and self-confidence. Welcome to a world of refined beauty.</td></tr><tr><td align=\"center\" valign=\"top\" style=\"border-collapse:collapse;border-spacing:0;margin:0;padding:0;padding-bottom:5%;padding-left:6.25%;padding-right:6.25%;width:87.5%;padding-top:25px;padding-bottom:5px;\" class=\"button\"><a   style=\"text-decoration:underline;\"><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\" style=\"max-width:240px;min-width:120px;border-collapse:collapse;border-spacing:0;padding:0;\"><tr><td align=\"center\" valign=\"middle\" style=\"padding:12px 24px;margin:0;text-decoration:underline;border-collapse:collapse;border-spacing:0;border-radius:4px;-webkit-border-radius:4px;-moz-border-radius:4px;-khtml-border-radius:4px;\" bgcolor=\"#6100fda3;\"><a href=\"$urlIn\" style=\"text-decoration:underline;color:#FFFFFF;font-family:sans-serif;font-size:17px;font-weight:400;line-height:120%;margin-bottom:5%;\" >Activate account</a></td></tr></table></a></td></tr></table></td></tr></table></body></html>";
                mailer($selector, $token, $subject, $urlIn, $body);
            });
  
       
       
        return 'Tack för din registerinbg, kolla mailet och verifiera ditt konto';
     
}
    catch(Exception $e){
     

        return "Oj då! Något gick fel!";

      
        
    }

 }




 }







