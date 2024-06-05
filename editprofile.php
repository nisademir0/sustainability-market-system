<?php

    require "db.php";

    extract($_GET);
    if($type=="market"){
        $user = getMarket($email);
    }
    if($type=="consumer"){
        $user = getConsumer($email);
    }

    $duplicate=false;

       
    if ( $_SERVER["REQUEST_METHOD"] === "POST") {
        extract($_POST);
        

        if($newemail != $email ){
            
            if (!filter_var($newemail, FILTER_VALIDATE_EMAIL)) {
                $error = "Invalid email format";
            }

            else {
                if($type=="market"){
                    $markets = getMarkets();
                    foreach($markets as $markett)
                    if($newemail == $markett["email"]){
                        $duplicate=true; 
                        $error = "This mail already exists. Please change mail address";
                    }    
                }
               
                else if($type=="consumer"){
                    $consumers = getConsumers();
                    foreach($consumers as $consumerr)
                    if($newemail == $consumerr["email"]){
                        $duplicate=true; 
                        $error = "This mail already exists. Please change mail address";
                    }   
                }
                
            }
            
        }
        if(!$duplicate && $error==""){

            try {
                if($pass!=""){
                    $hash = password_hash($pass, PASSWORD_BCRYPT) ; 
                    if($type=="market"){
                        $stmt = $db->prepare("UPDATE markets SET email = ? , password = ?, name = ?, city = ?, district = ?, address = ? WHERE email = ?") ;
                        $stmt->execute([$newemail, $hash, $fullname, $city, $district, $address, $email ]) ;

                        header("Location: market.php?editP=$newemail") ;
                        exit ; 
                    }
                    if($type=="consumer"){
                        $stmt = $db->prepare("UPDATE consumers SET email = ? , password = ?, name = ?, city = ?, district = ?, address = ? WHERE email = ?") ;
                        $stmt->execute([$newemail, $hash, $fullname, $city, $district, $address, $email ]) ;

                        header("Location: consumer.php?editP=$newemail") ;
                        exit ; 
                    }
                }


                if($pass==""){
                    if($type=="market"){
                        $stmt = $db->prepare("UPDATE markets SET email = ? , name = ?, city = ?, district = ?, address = ? WHERE email = ?") ;
                        $stmt->execute([$newemail, $fullname, $city, $district, $address, $email ]) ;

                        header("Location: market.php?editP=$newemail") ;
                        exit ; 
                    }
                    if($type=="consumer"){
                        $stmt = $db->prepare("UPDATE consumers SET email = ? , name = ?, city = ?, district = ?, address = ? WHERE email = ?") ;
                        $stmt->execute([$newemail, $fullname, $city, $district, $address, $email ]) ;

                        header("Location: consumer.php?editP=$newemail") ;
                        exit ; 
                    }
                }
                
                
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
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
<h1 class= "center">Update <?=strtoupper($type)?> Information</h1>
    <form action="" method="post">
        <table>
            <tr>
                <td><b>Email : </b></td> <td><input type="text" name="newemail" value="<?=$email ?>" required></td>
            </tr>
            <tr>
                <td><b>Password : </b></td> <td><input type="password" name="pass" value="<?= isset($pass) ? $pass : "" ?>"></td>
            </tr>
            <tr>
                <td><b>Fullname :</b></td> <td><input type="text" name="fullname" value="<?=$user["name"] ?>" required></td>
            </tr>
            <tr>
                <td><b>City :</b></td> <td><input type="text" name="city" value="<?= $user["city"]?>" required></td>
            </tr>
            <tr>
                <td><b>District : </b></td> <td><input type="text" name="district" value="<?= $user["district"] ?>" required></td>
            </tr>
            <tr>
                <td><b>Address :</b> </td> <td><input type="text" name="address" value="<?= $user["address"]?>" required></td>
            </tr>
            <tr>
                <td colspan="2" class="center"><button>Update</button></p>
            </tr>
        </table>
        <?= isset($error) ? "<p class='error'>$error</p>" : "" ?> 
        
    </form>
</body>
</html>