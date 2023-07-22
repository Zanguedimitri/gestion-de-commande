<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';


function forgot_password_reset($email, $token, $userid){
    try {
    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    //Server settings
    
    $mail->isSMTP();
    $mail->Host = 'sandbox.smtp.mailtrap.io';
    $mail->SMTPAuth = true;
    $mail->Port = 2525;
    $mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
    $mail->Username = '2396254ca0e530';
    $mail->Password = 'ec7901aef0ced5';

    //Recipients
    $mail->setFrom('dimitrizangue1@gmail.com', 'Reset your password');
    $mail->addAddress($email, $token);     //Add a recipient
  

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Notification';
    $mail->Body    =     "<h2>Bonjour</h2>
                            <h3>Vous recevrez cet email suite à une demande de changement de mot de passe
                                depuis votre compte du mini projet
                            </h3>
     
                    <a href='https://localhost/mini_projet/login.php?email=".$email."&token=".$token."&user=".$userid."'>Merci de cliquer ici</a>";


    $mail->send();
    return 'Message has been sent';
} catch (Exception $e) {
    return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
}