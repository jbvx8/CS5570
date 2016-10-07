<?php

session_start();
$page_title = "Shopping Cart";
include '../Includes/layout_header.php';
//include '../Includes/db.php';


$db = StoreDB::getInstance();

$action = isset($_GET['action']) ? $_GET['action'] : "";
$name = isset($_GET['name']) ? $_GET['name'] : "";


if(count($_SESSION['cart_products']) > 0){
    $PIDs = "";
    
    foreach($_SESSION['cart_products'] as $PID=>$value){
        $PIDs = $PIDs . $PID . ",";
    }
    $PIDs = rtrim($PIDs, ',');
    echo "<table class= 'table table-hover table-responsive table-bordered'>";
        echo "<tr>";
            echo "<th class='textAlignLeft'>Product Name</th>";
            echo "<th>Price</th>";
        echo "</tr>";
        
    $result = $db->get_cart_variables($PIDs);
    
    $total = 0;
    while($row = mysqli_fetch_array($result)) {
        $name = htmlentities($row["name"]);
        $price = htmlentities($row["price"]);
        
        echo "<tr>";
            echo "<td>" . $name . "</td>";
            echo "<td>" . $price . "</td>";
        echo "</tr>";
        
        $total += $price;
    }
    mysqli_free_result($result);
    
    echo "<tr>
            <td><strong>Total</strong></td>
            <td><strong>" . $total . "</strong></td>
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

