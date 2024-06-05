<?php
    //todo -- fotoyu düzenleme
    
    require "db.php";

    $error = "";
    extract($_GET);
    $item = getItem($title);


    if ( $_SERVER["REQUEST_METHOD"] === "POST"){
        extract($_POST) ;

        $items = getItems();

        if($newtitle != $title){
            foreach($items as $itemm)
            if($newtitle == $itemm["title"]){
                $duplicate=true; 
                $error = "This item already exists. Please change the title";
            }
        }

        

        if(!$duplicate){
            try {
                $stmt = $db->prepare("UPDATE products SET title = ? , stock = ?, normalprice = ?, discPrice = ?, expDate = ? WHERE title = ?") ;
                $stmt->execute([$newtitle, $stock, $normalprice, $discPrice, $expDate, $title ]) ;
                header("Location: market.php?edit=$newtitle") ;
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit</title>
    <style>
        table{border:2px solid green; border-radius:15px; padding:20px;margin: 0 auto;padding-top: 30px;}
        td{padding:15px;}
        .btn, h1 {text-align:center}
        .error { color: red; font-style: italic; text-align:center;}
    </style>
</head>
<body>
<h1>Edit Item</h1>
    <form action="" method="post" >
        <table>
            <tr>
                <td>Title :</td>
                <td><input type="text" name="newtitle" value="<?= isset($newtitle) ? $newtitle : $title ?>" required></td>
            </tr>
            <tr>
                <td>Stock :</td>
                <td><input type="number" name="stock" value="<?= isset($item["stock"]) ? $item["stock"] : "" ?>" required></td>
            </tr>
            <tr>
                <td>Normal Price :</td>
                <td><input type="number" name="normalprice" value="<?= isset($item["normalprice"]) ? $item["normalprice"] : "" ?>" required></td>
            </tr>
            <tr>
                <td>Discounted Price :</td>
                <td><input type="number" name="discPrice" value="<?= isset($item["discPrice"]) ? $item["discPrice"] : "" ?>" required></td>
            </tr>
            <tr>
                <td>Expire Date :</td>
                <td><input type="date" name="expDate" value="<?= isset($item["expDate"]) ? $item["expDate"] : "" ?>" required></td>
            </tr>
            <tr>
                <td colspan="2" class="btn"><button>Edit Item</button></td>
            </tr>
        </table>
    </form>
    <?php 
        if($error!=""){
            echo "<p class='error'>$error</p>" ; 
        }
    ?>
</body>
</html>