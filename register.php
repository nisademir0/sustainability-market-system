<?php
  session_start();  

  $type = $_GET["type"];
  if($type!="market"&&$type!="consumer"){
    echo "Don't play with URL parameters";
    exit;
  }

  if (!empty($_POST)) {
    extract($_POST) ; 
    require "db.php" ;

    if($email=="" || $pass=="" || $fullname=="" || $city=="" || $district=="" || $address=="" )
        $error = "Please fill every value" ;
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format";
    }
    else{
        try {
            session_start();  
            
            $hash = password_hash($pass, PASSWORD_BCRYPT) ; 
            $user = array("email"=>$email, "password"=>$hash, "name"=>$fullname, "city"=>$city, "district"=>$district, "address"=>$address);
            
            $_SESSION["user"] = $user ; 

            header("Location: ./mail/verification.php?type=$type") ; 
            exit ; 
         } catch( Exception $e) {
             $error = $e->getMessage() ; 
        }
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        .center{text-align: center;}
        table{margin: 0 auto;padding-top: 30px;}
        td{padding:15px;}
        .error { color: red; font-style: italic; text-align:center;}
        td input:focus {
            border: none;
            outline: none;
            border:  2px solid green ; 
            background: lightgreen;
        }
        table{border:2px solid green; padding:20px; border-collapse:collapse}
        td{border:2px solid green;}
    </style>
</head>
<body>
    <h1 class= "center">Register as a New <?=strtoupper($type)?></h1>
    <form action="" method="post">
        <table>
            <tr>
                <td><b>Email : </b></td> <td><input type="text" name="email" value="<?= $email ?? ''?>"></td>
            </tr>
            <tr>
                <td><b>Password : </b></td> <td><input type="password" name="pass" value="<?= $pass ?? ''?>"></td>
            </tr>
            <tr>
                <td><b><?=$type=="consumer"? "Fullname : ": "Market Name : "; ?></b></td> <td><input type="text" name="fullname" value="<?= $fullname ?? ''?>"></td>
            </tr>
            <tr>
                <td><b>City :</b></td> <td><input type="text" name="city" value="<?= $city ?? ''?>"></td>
            </tr>
            <tr>
                <td><b>District : </b></td> <td><input type="text" name="district" value="<?= $district ?? ''?>"></td>
            </tr>
            <tr>
                <td><b>Address :</b> </td> <td><input type="text" name="address" value="<?= $address ?? ''?>"></td>
            </tr>
            <tr>
                <td colspan="2" class="center"><button>Register</button></p>
            </tr>
        </table>
        <?= isset($error) ? "<p class='error'>$error</p>" : "" ?> 
        
    </form>
</body>
</html>