<?php
    session_start();
    require "db.php" ;

    $type = $_GET["type"] ?? "market" ; 
    $register = $_GET["register"] ?? 0 ; 

    //login
    extract($_POST);

    //market
    if( $type == "market" && checkMarket($email, $pass, $user) ) {
        $_SESSION["user"] = $user ; 

        // echo '<pre>'; var_dump($user); echo '</pre>';
        header("Location: market.php") ;
        exit ;
    }
    //consumer
    else if( $type == "consumer" && checkConsumer($email, $pass, $user) ) {
        $_SESSION["user"] = $user ; 
        header("Location: consumer.php") ;
        exit ;
    }
    else { $login = false; }

    if($_SERVER["REQUEST_METHOD"] == "POST" ){
        
        //invalid or empty spaces
        if($login==false)
            $error= "Wrong email or password";
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "Invalid email format";
        }
        if($pass == "" || $email==""){
            $error = "Please do not leave any space empty";
        }
    } 
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login / Register</title>
    <style>
        .center{text-align: center;}
        p a {padding:20px; color: black; font-weight: bold;}
        .red{color: green;}
        td{padding:15px;}
        .error { color: red; font-style: italic; text-align:center;}
        td input:focus {
            border: none;
            outline: none;
            border:  2px solid green ; 
            background: lightgreen;
        }
        .register{font-weight:bold; color:green; padding-left:5px;}
        .border{border:1px solid black; padding:5px 10px; border-radius:3px;}
        table{border:2px solid green; border-radius:15px; padding:20px;margin: 0 auto;padding-top: 30px;}
        .successs{color: green; font-style: italic; text-align:center;}
    </style>

</head>
<body>
    <h1 class="center">Product Sustainability Program</h1>
    <h2 class="center" >Login</h2>
    <p class="center" >
        <a href="?type=market" <?= $type=="market" ?  "class='red'": "" ?>>Market</a>
        <a href="?type=consumer" <?= $type=="consumer" ?  "class='red'": "" ?>>Consumer</a>
    </p>
    <form action="?<?= isset($type) ? "type=$type" : "" ?>" method="post">
    
       <table>
         <tr>
            <td>Email :</td>
            <td><input type="text" name="email" value="<?= isset($email) ? $email : "" ?>" ></td>
         </tr>
         <tr>
            <td>Password : </td>
            <td><input type="password" name="pass" value="<?= isset($pass) ? $pass : "" ?>"></td>
         </tr>
         <tr>
            <td colspan="2" class="border">You don't have an account? <a href="register.php?<?="type=$type"?>" class="register">Register</a></td>
         </tr>
         <tr>
            <td colspan="2" class="center"><button >Login</button></td>
         </tr>
       </table>
    </form>

    <?php
        if($error!=""){
            echo "<p class='error'>$error</p>" ; 
        }
         
        if($register){
            echo "<p class='successs'>Register successfull</p>" ; 
        }
        
        if ( isset($_GET["error"])) {  
            echo "<p class='error'>You tried to access market.php/consumer.php directly</p>" ; 
        }
    ?>
</body>
</html>