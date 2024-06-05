<?php
      require_once './vendor/autoload.php' ;
      require_once './Mail.php' ;
      require "../db.php";

      session_start();  
      extract($_GET);


      if($_SERVER["REQUEST_METHOD"] != "POST"){
        $mailtosend = $_SESSION["user"]["email"] ;
        $subject =  "Verification Code";
        $random = rand(100000,999999);
        $message = "Your verification code is $random";
        $_SESSION["code"] = $random;

        try {
          Mail::send($mailtosend, $subject , $message) ;
          
        } catch( Exception $e) {
          $error = $e->getMessage() ; 
        }     
      }

      if($_SERVER["REQUEST_METHOD"] == "POST"){
        extract($_POST);
        if($code == $_SESSION["code"]){
          try {
            if($type=="market")
                 $sql = "insert into markets (email, password, name, city, district, address) values (?,?,?,?,?,?)" ;
            else
                 $sql = "insert into consumers (email, password, name, city, district, address) values (?,?,?,?,?,?)" ;
            $stmt = $db->prepare($sql) ;

            $stmt->execute([$_SESSION["user"]["email"], $_SESSION["user"]["password"], $_SESSION["user"]["name"], $_SESSION["user"]["city"], $_SESSION["user"]["district"], $_SESSION["user"]["address"]]) ;

            session_destroy() ;
            setcookie("PHPSESSID", "", 1 , "/") ;

            header("Location: ../index.php?register=1&&type=$type") ;
            exit ; 
          } catch( Exception $e) {
             $error = $e->getMessage() ; 
          } 
        }
        else{
            $error = "Verification code is wrong. Please try again.";
        }
      }
      
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Title of the document</title>
    <style>
      .error { color: red; font-style: italic; }
      button{margin:10px;}

    </style>
  </head>
  <body>
    <h1>Verification Code</h1>
    <p>Please enter the code in your email account.</p>
    <form action="" method="post">
      <input type="text" name="code">
      <button>Verify</button>
    </form>

    <?= isset($error) ? "<p class='error'>$error</p>" : "" ?> 
  </body>
</html>

