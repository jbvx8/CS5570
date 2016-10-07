<?php

session_start();

// get product info

$PID = isset($_GET['id']) ? $_GET['id'] : "";
$name = isset($_GET['name']) ? $_GET['name'] : "";
$quantity = isset($_GET['quantity']) ? $_GET['quantity'] : "";

// check first if the cart array has been created, if not, create one
//if(!isset($_SESSION['cart_products'])) {
//    $_SESSION['cart_products'] = array();
//}

    $_SESSION['cart_products'][$PID]=$name;
    header('Location: store.php?action=added&id=' . $PID . '&name=' . $name);

?>



