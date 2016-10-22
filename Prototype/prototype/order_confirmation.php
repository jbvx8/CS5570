<?php
$orderID = isset($_GET["order_id"]) ? $_GET["order_id"] : "";
$page_title = "Order Confirmation";
include "../Includes/layout_header.php";
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
       <div class="container">
            <div class="jumbotron top-pad-100">
		<h1><span class="glyphicon glyphicon-ok"></span> Thank you!</h1>
                <h3>Your order has been processed.  Your order number is <?php echo $orderID?>. It is on its way! </h3>
                <a href="store.php" class="btn btn-primary btn-lg btn-block top-pad-50">Continue shopping</a>
        
            </div>
        </div>
    </body>
</html>
