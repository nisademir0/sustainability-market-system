<?php
    session_start() ;
    require "db.php" ;
    extract($_GET);
   
     
    if( !isAuthenticated()) {
        header("Location: index.php?error") ;
        exit ; 
    }
    
    $user = $_SESSION["user"] ;
    

    if($_SERVER["REQUEST_METHOD"] == "GET" && isset($search)&&$search!="" || $_SERVER["REQUEST_METHOD"] == "POST"){
        extract($_POST);
        $items = searchNotExpItems($search);    
    }
    else{
        $items = getNotExpItems();
    }


    //paging
    $page = $_GET["page"] ?? 1 ; 
    $size = count($items) ; 
    const PAGESIZE = 4 ; 
    $totalPages = ceil($size/PAGESIZE) ;
    $start = ($page - 1) * PAGESIZE ; 
    $end = $start + PAGESIZE ; 
    $end = $end > $size ? $size : $end ; 

    if(isset($add)){
        addToCart($add);
        // echo '<pre>'.print_r($_SESSION['cart'], true).'</pre>';
    }
    if(isset($remove)){
        removeFromCart($remove);
    }
     
    if(isset($complete)){
        
        $tot = calcTotalCartwDisc();
        purchase();
        $msg = "Purchase is complete. Your total is \$ $tot ";
    }

    if ( $_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["editP"])) {
        $_SESSION["user"]["email"] = $editP;
        $user = $_SESSION["user"] ;
        $msg = "$editP edited" ; 
      }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consumer Interface</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <style>
        table{border-collapse:collapse; margin: 0 auto}
        td,th{border: 1px solid black; padding: 10px 15px; text-align:center;}
        img{width:80px;}      
        .center{text-align:center}
        .menu{
            display:flex;
            border:1px solid black;
            width:270px;
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
        .menu a{text-decoration:none; color:white;}
        .menu div:hover a{color:black}
        .search{
            border:1px solid black; 
            border-radius:10px;
            padding-left:10px;
            font-size:20px           
        }
        .searchdiv{
            margin:20px auto;
            text-align:center;
        }
        .btn{
            border-radius:15px;
            font-size: 20px;
            border-width: 1px;
            padding:5px 8px;
        }
        .paging{text-align:center; margin:10px;}
        a{
            text-decoration:none;
            color:black;
        }
        .underline{text-decoration:underline;}
        .cart{
            display:flex;
            border:1px solid black;
            width:410px;
            margin:20px auto;
            background-color: orange;
            border:1px solid black;
            border-radius: 15px;
        }
        .cart div{
            margin:10px;
            border:1px solid black;
            border-radius: 15px;
            padding:5px 15px;
            width:150px;
            background-color:white;

        }
   
        .cross{text-decoration: line-through;}
        .small td{padding:5px; border:0px;}
        .numbertext{
            width:25px;
            text-align:center;
        }
        .purchase{text-align:center;}
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
    </style>
</head>
<body>
    <h1 class="center">Consumer Interface</h1>

        <div class="menu">
            <div><a href="editprofile.php?type=consumer&&email=<?=$user["email"]?>">Edit Profile <i class="fa-solid fa-pen"></i></a></div>
            <div><a href="logout.php">Logout <i class="fa fa-door-open"></i></a></div>
        </div>

        <form action="?"  method="post">
            <div class="searchdiv">
                <input type="text" placeholder="Search Item" name="search" class="search" <?=isset($search)? "value='$search'": ""?>> 
                <button class="btn"><i class="fas fa-search"></i></button>
            </div>
        </form>
        


        <table>
        <tr>
            <th></th>
            <th>Title</th>
            <th>Stock</th>
            <th>Normal Price</th>
            <th>Discounted Price</th>
            <th>Expire Date</th>
            <th>Expire Photo</th>
            <th>Market Info</th>
        </tr>
        <?php for ( $i= $start; $i < $end ; $i++) :
            $item = $items[$i];
        ?>
        <tr>
            <td>
                <table class="small">
                    <tr>
                        <td><a href="?add=<?=$item["title"]?>&&page=<?=$page?>&&search=<?=$search?>"><i class="fa-solid fa-basket-shopping"></i></a></td>
                    </tr>
                    <tr>
                        <td><input type="text" class="numbertext" readonly value=<?= getQuantity($item["title"])?>></td>
                    </tr>
                    <tr>
                        <td><a href="?remove=<?=$item["title"]?>&&page=<?=$page?>&&search=<?=$search?>"><i class="fa-solid fa-minus"></i></a></td>
                    </tr>
                </table>
            </td>
            <td><?=$item["title"]?></td>
            <td><?=$item["stock"]?></td>
            <td>$<?=$item["normalprice"]?></td>
            <td>$<?=$item["discPrice"]?></td>
            <td><?=$item["expDate"]?></td>
            <td><img src="img/<?=$item["expDatePhoto"]?>"></td> 
            <td><?= "{$item['name']}\n{$item['city']}\n{$item['district']}";?></td> 
            
        </tr>
        <?php endfor?>

    </table>


    <div class="paging">
      [
       <?php
         for ( $i=1; $i<= $totalPages; $i++) {
            if($i == $page)
                echo "<a href='?search=$search&&page=$i' class='underline'>$i</a> " ;
            else 
                echo "<a href='?search=$search&&page=$i'>$i</a> " ;
         }
       ?>
      ]
    </div>
         
    <div class="cart">
        <div><p>Total : <span class="cross">$<?=calcTotalCart()?></span> $<?=calcTotalCartwDisc()?></p></div>
        <div class="purchase"><p><a href="?complete">Purchase</a></p></div>
    </div>

    <?= isset($msg) ? "<p class='msg'>$msg</p>" : "" ; ?> 


</body>
</html>