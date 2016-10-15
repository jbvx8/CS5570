<?php

session_start();
$page_title = "Shopping Cart";
include '../Includes/layout_header.php';
//include '../Includes/db.php';


$db = StoreDB::getInstance();

//$action = isset($_GET['action']) ? $_GET['action'] : "";
//$name = isset($_GET['name']) ? $_GET['name'] : "";
//$quantity = $isset($_GET['quantity']) ? $_GET['quantity'] : "1";
$cart = $_SESSION['cart_products'];


if(count($cart) > 0){
//    $PIDs = "";
//    $quantities = "";
    echo "Cart count: " . count($cart);
    $subtotal = 0;
    $price = 0;
    $quantity = 0;
    $name = '';
    echo "<table class= 'table table-hover table-responsive table-bordered'>
        <tr>
            <th class='textAlignLeft'>Product Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total</th>
        </tr>";
    
    foreach($cart as $PID => $value){
        
//        foreach($value as $key => $final_val) {
//            echo "KEY: " . $key . "<br>";
//            echo "VALUE: " . $final_val . "<br>";
//            if ($key == 'PID') {
                echo "PID: " . $PID;
                echo "quantity: " . $value;
                //$PIDS = $PIDs . $final_val . ",";
                $result = $db->get_cart_variables($PID);
                while($row = mysqli_fetch_array($result)) {
                    $name = htmlentities($row["name"]);
                    $price = htmlentities($row["price"]);
                }
                mysqli_free_result($result);
////            } else {
////                $quantity = $final_val;
////            }
//            
            $total = $price * (int)$value;

            
//            
        
        echo "<tr>
                <td>" . $name . "</td>
                <td>" . $price . "</td>
                <td>" . $value . "</td>
                <td>" . $total . "</td>
            </tr>";
        
        $subtotal += $total;
        //$PIDs = $PIDs . $PID . ",";
    }  
    
//    $PIDs = rtrim($PIDs, ',');
//    $quantities = rtrim($quantities, ',');
//    
//        
//    $result = $db->get_cart_variables($PIDs);
    
  
    
        
        
    
    //mysqli_free_result($result);
    
    echo "<tr>
            <td><strong>Subtotal</strong></td>
            <td></td>
            <td></td>
            <td><strong>" . $subtotal . "</strong></td>
        </tr>
    </table>";
    
    echo "<a href='#' class='btn btn-default'>Checkout</a>";
}
else {
    echo "<div class='alert alert-danger'>
        <form action='store.php'>
        <button type='submit' class='close' aria-label='close'>&times;</button>
        Shopping cart is <strong>empty</strong>!
        </form>";
    echo "</div>";    
}
include '../Includes/layout_footer.php';

