<?php

session_start();
$page_title = "Customer Orders";
include '../Includes/layout_header.php';

$db = StoreDB::getInstance();

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    header("Location: store.php");
}

$CID = $db->get_customerID_from_username($username);
$result = $db->get_orders_by_customer($CID);
$collapseID = 1;
while ($row = mysqli_fetch_array($result)) {
    $OID = $row['OID'];
    $date = date('F j, Y', strtotime($row['date']));
    $subtotal = $row['subtotal'];
    $shipping = $row['shipping'];
    $tax = $row['tax'];
    $total = $row['total'];
    $orderProducts = $db->get_products_by_order($OID); ?>
    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingOne">
      <h4 class="panel-title">
        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#<?php echo $collapseID; ?>" aria-expanded="false" aria-controls="collapseOne">
            <div class="order-head table-bordered">
                <span class="title"><h3>Order No. <?php echo $OID; ?></h3></span>  
                <span class="date"><h3>Date Ordered: <?php echo $date; ?></h3></span>
            </div>
        </a>
      </h4>
    </div>
    <div id="<?php echo $collapseID; ?>" class="panel-collapse collapse" aria-expanded="false" role="tabpanel" aria-labelledby="headingOne">
      <div class="panel-body">
        <table class='table table-hover table-responsive table-striped table-bordered'>
            <tr>
                <th class='textAlignLeft'>Product Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
            </tr>
        <?php while ($productRow = mysqli_fetch_array($orderProducts)) {
            $PID = $productRow['product_id'];
            $quantity = $productRow['product_quantity'];
            $productVariables = $db->get_cart_variables($PID);
            while ($variableRow = mysqli_fetch_array($productVariables)) {
                $prodName = $variableRow['name'];
                $price = $variableRow['price']; ?>
            <tr>
                <td><?php echo $prodName; ?></td>
                <td><?php echo $price; ?></td>
                <td><?php echo $quantity; ?></td>
                <td><?php echo $quantity * $price; ?></td>
            </tr>      
            <?php }
            mysqli_free_result($productVariables);
        }
        mysqli_free_result($orderProducts); ?>
            <tr>
                <td colspan="3"><strong>Subtotal</strong></td>
                <td><strong><?php echo $subtotal; ?></strong></td>
            </tr>
            <tr>
                <td colspan="3">Tax</td>
                <td><?php echo $tax; ?></td>
            </tr>
            <tr>
                <td colspan="3">Shipping</td>
                <td><?php echo $shipping; ?></td>
            </tr>
            <tr class="order-head">
                <td colspan="3"><strong>Total</strong></td>
                <td><strong><?php echo $total; ?></strong></td>
            </tr>
        </table>
    <a href="return_form.php?OID=<?php echo $OID; ?>&date=<?php echo $date; ?>" class="btn btn-primary">Make a return</a>
    </div>
    </div>
  </div>
<?php
  $collapseID++;
}
mysqli_free_result($result); 

include "../Includes/layout_footer.php";
