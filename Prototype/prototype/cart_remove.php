<?php

session_start();
$PID = isset($_POST['id']) ? htmlspecialchars($_POST['id']) : "";

if(isset($_POST['action'])) {
    remove_product($PID);
}

function remove_product($id) {
    foreach($_SESSION['cart_products'] as $PID => $value) {
        if ($PID == $id) {
            unset($_SESSION['cart_products'][$PID]);
            break;
        }
    }
}