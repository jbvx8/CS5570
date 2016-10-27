<?php

session_start();
$page_title = "Customer Orders";
include '../Includes/layout_header.php';

$db = StoreDB::getInstance();

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
}

$CID = $db->get_customer_from_username($username);
$result = $db->get_orders_by_customer($CID);
while ($row = mysqli_fetch_array($result)) {
    $OID = $row['OID'];
    $date = $row['date'];
    $subtotal = $row['subtotal'];
    $shipping = $row['shipping'];
    $tax = $row['tax'];
    $total = $row['total'];
    $orderProducts = $db->get_products_by_order($OID); ?>
    <h3>Order No. <?php echo $OID; ?>  Date Ordered <?php echo $date; ?></h3>
    <table class='table table-hover table-responsive table-bordered'>
        <tr>
            <th class='textAlignLeft'>Product Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total</th>
            <th></th>
        </tr>
    <?php //while ($productRow = mysqli_fetch_array($orderProducts)) {
//        $PID = $productRow['product_id'];
//        $quantity = $productRow['product_quantity'];
//        $productVariables = $db->get_cart_variables($PID);
//        while ($variableRow = mysqli_fetch_array($productVariables)) {
//            $prodName = $row['name'];
//            $price = $row['price']; ?>

    
</table>
            
        //<?php }
//        mysqli_free_result($productVariables);
//    }
//    mysqli_free_result($orderProducts);    
//}
//mysqli_free_result($result); ?>