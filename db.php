<?php

const DSN = "mysql:host=localhost;dbname=test;charset=utf8mb4" ;
const USER = "root" ;
const PASSWORD = "root" ;

try {
   $db = new PDO(DSN, USER, PASSWORD) ; 
} catch(PDOException $e) {
     echo "Set username and password in 'db.php' appropriately" ;
     exit ;
}

function checkMarket($email, $pass, &$user) {
    global $db ;

    $stmt = $db->prepare("select * from markets where email=?") ;
    $stmt->execute([$email]) ;
    $user = $stmt->fetch() ;
    if ( $user) {
        return password_verify($pass, $user["password"]) ;
    }
    return false ;
}

function checkConsumer($email, $pass, &$user) {
    global $db ;

    $stmt = $db->prepare("select * from consumers where email=?") ;
    $stmt->execute([$email]) ;
    $user = $stmt->fetch() ;
    if ( $user) {
        return password_verify($pass, $user["password"]) ;
    }
    return false ;
}

function isAuthenticated() {
    return isset($_SESSION["user"]) ;
}

function getItems(){
    global $db ;
    session_start();
    $id=$_SESSION["user"]["id"];
    $rs = $db->query("select * from products where marketid=$id") ->fetchAll(PDO::FETCH_ASSOC) ; 

    if(!empty($rs))
        return $rs;

    else return 0;
}

function getNotExpItems(){
    global $db ;
    session_start();
    $user = $_SESSION["user"];
    $city = $user["city"];
    $district = $user["district"];

    $sql = "SELECT p.*, m.name, m.city, m.district 
            FROM markets m
            INNER JOIN products p ON p.marketid = m.id 
            WHERE m.city = '$city' and p.expDate>date(NOW())
            ORDER BY CASE WHEN m.district = '$district' THEN 0 ELSE 1 END";
    return $rs = $db->query($sql) ->fetchAll() ; 
}

function searchNotExpItems($search){
    global $db ;
    session_start();
    $user = $_SESSION["user"];
    $city = $user["city"];
    $district = $user["district"];

    $sql = "SELECT p.*, m.name, m.city, m.district 
            FROM markets m
            INNER JOIN products p ON p.marketid = m.id 
            WHERE m.city = '$city' and p.expDate>date(NOW()) and p.title LIKE '%$search%'
            ORDER BY CASE WHEN m.district = '$district' THEN 0 ELSE 1 END";
    return $rs = $db->query($sql) ->fetchAll() ; 
}




function getMarkets(){
    global $db ;
    return $rs = $db->query("select * from markets") ->fetchAll() ; 
}

function getConsumers(){
    global $db ;
    return $rs = $db->query("select * from consumers") ->fetchAll() ; 
}

function getItem($title){
    global $db ;
    $stmt = $db->prepare("SELECT * FROM products where title = ?") ;
    $stmt->execute([$title]) ;
    return $stmt->fetch() ;
}

function getMarket($email){
    global $db ;
    $stmt = $db->prepare("SELECT * FROM markets where email = ?") ;
    $stmt->execute([$email]) ;
    return $stmt->fetch() ;
}

function getConsumer($email){
    global $db ;
    $stmt = $db->prepare("SELECT * FROM consumers where email = ?") ;
    $stmt->execute([$email]) ;
    return $stmt->fetch() ;
}

//managing cart----------------------
function addToCart($title, $quantity = 1) {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    global $db;
    $stmt = $db->prepare( "SELECT * FROM products WHERE title = ?");
    $stmt->execute([$title]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if the product exists
    if ($product) {
        $index = -1;
        foreach ($_SESSION['cart'] as $key => $item) {
            if ($item['title'] === $title) {
                $index = $key;
                break;
            }
        }

        // If the product exists in the cart, update the quantity
        if ($index !== -1) {
            $_SESSION['cart'][$index]['quantity'] += $quantity;
        } else {
            // Otherwise, add the product to the cart with the specified quantity
            $product['quantity'] = $quantity;
            $_SESSION['cart'][] = $product;
        }
    }
}

function removeFromCart($title, $quantity = 1) {
    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['title'] === $title) {
            if ($quantity >= $item['quantity']) {
                unset($_SESSION['cart'][$key]);
            } else {
                $_SESSION['cart'][$key]['quantity'] -= $quantity;
            }
            return;
        }
    }
}

function calcTotalCartwDisc() {
    $total = 0;
    foreach ($_SESSION['cart'] as $item) {
        $total += $item['discPrice']* $item['quantity'];
    }
    return $total;
}

function calcTotalCart() {
    $total = 0;
    foreach ($_SESSION['cart'] as $item) {
        $total += $item['normalprice'] * $item['quantity'];
    }
    return $total;
}

function getQuantity($productId) {
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            if ($item['title'] === $productId) {
                return $item['quantity'];
            }
        }
    }
    return 0;
}

function purchase() {
    unset($_SESSION['cart']);
}

