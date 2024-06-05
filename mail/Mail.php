<?php
//
// UPDATE Username and Password fields in "config.php"
//
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once './vendor/autoload.php' ;


const EMAIL = 'youremail' ;
const PASS = 'yourpassword' ;
const FULLNAME = 'Varification Service' ;


class Mail {
    public static function send($to, $subject, $message) {
    $mail = new PHPMailer(true) ;
    try {
        //SMTP Server settings
        $mail->isSMTP();                                            
        $mail->Host       = 'asmtp.bilkent.edu.tr';                     
        $mail->SMTPAuth   = true;                                   
        $mail->Username   =  EMAIL;                                       
        $mail->Password   =  PASS ;                     
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587; 
    
        $mail->setFrom(EMAIL, FULLNAME);
        $mail->addAddress($to, $to);     //Add a recipient
        

        //Content
        $mail->isHTML(true);  //Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $message;
    
        $mail->send();
        // echo 'Verificaiton code has been sent';
    } catch (Exception $e) {
        echo "<p>Verificaiton code could not be sent. Mailer Error: {$mail->ErrorInfo}</p>";
    }
   }
}