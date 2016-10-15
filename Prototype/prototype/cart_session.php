<?php

session_start();

// get product info
error_log("cart session");
$PID = isset($_GET['id']) ? $_GET['id'] : "";
$name = isset($_GET['name']) ? $_GET['name'] : "";
$quantity = isset($_GET['quantity']) ? $_GET['quantity'] : "1";

 //check first if the cart array has been created, if not, create one
if(!isset($_SESSION['cart_products'])) {
    $_SESSION['cart_products'] = array();
}

if(array_key_exists($PID, $_SESSION['cart_products'])) {
    $_SESSION['cart_products'][$PID] += $quantity;
    header('Location: store.php?action=exists&id=' . $PID . '&name=' . $name . '&quantity=' . $quantity);
} else {
    $_SESSION['cart_products'][$PID] = $quantity;
    header('Location: store.php?action=added&id=' . $PID . '&name=' . $name . '&quantity=' . $quantity);
}

function array_key_exists_multi($key, $arr) {
//    $result = array_key_exists($key, $arr);
//    if ($result) return $result;
//    foreach($arr as $value) {
//        if(is_array($value)) {
//            $result = array_key_exists_multi($key, $value);
//        }
//        if ($result) return $result;
//    }
//    return $result;
    foreach($arr as $value){
        if ($value['PID'] == $key) {
            return true;
        }       
    } 
    return false;
}
?>


