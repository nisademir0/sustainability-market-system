<?php
//todo sticky file, geri tuşları
  session_start();  
  $marketid = $_SESSION["user"]["id"];

  $upload_max_filesize = ini_get("upload_max_filesize");
  $post_max_size = ini_get("post_max_size") ;

  $error = "" ;

  if($_SERVER["REQUEST_METHOD"] == "POST"){
    extract($_POST);
    require "db.php" ;
    require "upload.php" ;

    $duplicate=false;
    //looking for duplicate titles
    $items = getItems();
    if($items!=0)
        foreach($items as $item)
            if($title == $item["title"])
                $duplicate=true; 
    
        

    if($title=="" || $stock=="" || $normalprice=="" || $discPrice=="" || $expDate=="" ) 
        $error = "Please do not leave any space empty";

    else if($duplicate){
        $error = "This item already exists. Please change the title";
    }
    else{
        try {
            $photo = new Upload("expDatePhoto", "img") ;
            $sql = "insert into products (marketid, title, stock, normalprice, discPrice, expDate, expDatePhoto) VALUES (?,?,?,?,?,?,?)" ;
            $stmt = $db->prepare($sql) ;
            $stmt->execute([$marketid, $title, $stock, $normalprice, $discPrice, $expDate, $photo->file]) ;
            header("Location: market.php?add=$title") ;
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
    <title>Add Product</title>
    <style>
        table{border:2px solid green; border-radius:15px; padding:20px;margin: 0 auto;padding-top: 30px;}
        td{padding:15px;}
        .btn, h1 {text-align:center}
        .error { color: red; font-style: italic; text-align:center;}
    </style>
</head>
<body>
    <h1>Add Item</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <table>
            <tr>
                <td>Title :</td>
                <td><input type="text" name="title" value="<?= isset($title) ? $title : "" ?>" ></td>
            </tr>
            <tr>
                <td>Stock :</td>
                <td><input type="number" name="stock" value="<?= isset($stock) ? $stock : "" ?>" ></td>
            </tr>
            <tr>
                <td>Normal Price :</td>
                <td><input type="number" name="normalprice" value="<?= isset($normalprice) ? $normalprice : "" ?>" ></td>
            </tr>
            <tr>
                <td>Discounted Price :</td>
                <td><input type="number" name="discPrice" value="<?= isset($discPrice) ? $discPrice : "" ?>" ></td>
            </tr>
            <tr>
                <td>Expire Date :</td>
                <td><input type="date" name="expDate" value="<?= isset($expDate) ? $expDate : "" ?>" ></td>
            </tr>
            <tr>
                <td>Expire Date Photo :</td>
                <td><input type="file" name="expDatePhoto" value="<?= isset($expDatePhoto->file) ? $expDatePhoto->file : "" ?>" ></td>
            </tr>
            <tr>
                <td colspan="2" class="btn"><button>Add Item</button></td>
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