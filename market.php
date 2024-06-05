<?php
  session_start() ;
  require "db.php" ;
  extract($_GET);

  
  if( !isAuthenticated()) {
      header("Location: index.php?error") ;
      exit ; 
  }
 
  $user = $_SESSION["user"] ;
  
  function isExpired($item){
    $now =  new DateTime() ;
    $now=$now->format("Y-m-d"); 
    if($now>$item["expDate"])
        return true;
  }
  
  //delete
  if ( $_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["delete"])) {
    $item = getItem($delete) ;
    if ( $item !== false) {
        $stmt = $db->prepare("DELETE FROM products where title = ?") ;
        $stmt->execute([$item["title"]]) ;
        $msg = "{$item["title"]} deleted" ;
    } else {
        $msg = "Don't play with URL params." ;
    }
  }
 
  if ( $_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["add"])) {
    $msg = "$add added" ; 
  }

  if ( $_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["edit"])) {
    $msg = "$edit edited" ; 
  }

  if ( $_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["editP"])) {
    $_SESSION["user"]["email"] = $editP;
    $user = $_SESSION["user"] ;
    $msg = "$editP edited" ; 
  }

  $items = getItems();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Market Interface</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <style>
        table{border-collapse:collapse; margin: 0 auto}
        td,th{border: 1px solid black; padding: 10px 15px; text-align:center;}
        .expired td{ font-style:italic; }
        .expired{ background-color: #FF6961}
        .notexpired{background-color:#77DD77}
        img{width:80px;}
        .btn { 
            color: black; 
            background: white ;
            padding: 5px 10px;
            border-radius:15px;
            cursor: pointer;
        }
        .padd{padding:5px}
        .small{border: 0px; padding:10px 0px; }
        .msg {
            animation: fadeOut 1s ease ;
            animation-delay: 2s ;
            animation-fill-mode: forwards;
            padding: 0.75rem 1.25rem;
            border:1px solid #c3e6cb;
            background: #d4edda ;
            border-radius: 0.25em;
            color: #155724;
            margin: 1rem 30px;
        }
        @keyframes fadeOut {
            0% {opacity: 1;}
            100% {opacity: 0;} 
        } 
        .center{text-align:center}
        .menu{
            display:flex;
            border:1px solid black;
            width:400px;
            margin:20px auto;
            background-color:rgb(110, 187, 255);
            border:1px solid black;
            border-radius: 15px;
        }
        .menu div{
            margin:10px;
            border:1px solid white;
            border-radius: 15px;
            padding:5px 15px;
        }
        .menu div:hover{
            background-color:white;
            cursor:pointer;
            border:1px solid black;
        }
        a{text-decoration:none; color:white;}
        .menu div:hover a{color:black}

    </style>
</head>
<body>

        <h1 class="center">Market Interface</h1>

        <div class="menu">
            <div><a href="editprofile.php?type=market&&email=<?=$user["email"]?>">Edit Profile <i class="fa-solid fa-pen"></i></a></div>
            <div><a href="addItem.php">Add Item <i class="fa-solid fa-circle-plus"></i></a></div>
            <div><a href="logout.php">Logout <i class="fa fa-door-open"></i></a></div>
        </div>

    <table>
        <tr>
            <th>Items</th>
            <th>Title</th>
            <th>Stock</th>
            <th>Normal Price</th>
            <th>Discounted Price</th>
            <th>Expire Date</th>
            <th>Expire Photo</th>
            <th>Status</th>
        </tr>
        <?php foreach( $items as $item) :?>
        <tr class="<?=isExpired($item)?"expired":"notexpired"?>">
            <td>
                <table class="small">
                    <tr><td class="small"><a class="btn" href="?delete=<?= $item["title"] ?>" title="Delete"><i class="fa-solid fa-trash-can"></i></a></td></tr>
                    <tr><td class="small"><a class="btn" href="editItem.php?title=<?= $item["title"] ?>" title="Edit"><i class="fa-solid fa-pen"></i></i></a></td></tr>
                </table>
            </td>
            
            <td><?=$item["title"]?></td>
            <td><?=$item["stock"]?></td>
            <td>$<?=$item["normalprice"]?></td>
            <td>$<?=$item["discPrice"]?></td>
            <td><?=$item["expDate"]?></td>
            <td><img src="img/<?=$item["expDatePhoto"]?>"></td>    
            <td><?=isExpired($item)?"Exprired":"Not Exprired"?></td> 
            
        </tr>
        <?php endforeach?>

    </table>

    <?= isset($msg) ? "<p class='msg'>$msg</p>" : "" ; ?> 
</body>
</html>
