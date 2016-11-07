<?php

session_start();

$page_title = "Returns";
$OID = isset($_GET["OID"]) ? htmlspecialchars($_GET["OID"]) : "";
$date = isset($_GET["date"]) ? htmlspecialchars($_GET["date"]) : "";

include "../Includes/layout_header.php"; 

$db = StoreDB::getInstance();
if (isset($_SESSION["customer"])) {
    $customer = $_SESSION["customer"];
} else {
    $customer = $db->get_customer_from_order($OID);
}
$orderProducts = $db->get_products_by_order($OID); ?>

<form method="post" action="return_print.php">
<table class='table table-hover table-responsive table-striped'>
    <tr>
        <th class='textAlignLeft'>Product Name</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Total</th>
        <th>Return Quantity</th>
        <th>Reason</th>
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
            <td><select class="form-control auto-input" name="returnQuantity[]">
                    <option selected value="0">0</option>
                    <?php for($i = 1; $i <= $quantity; $i++) { ?>
                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                <?php } ?>
                </select></td>
            <td><input type="text" class="form-control" name="returnReason[]" placeholder="Enter a reason so we can better serve you."</td>               
        </tr> 
        <input type="hidden" name="returnPID[]" value="<?php echo $PID; ?>">
        <input type="hidden" name="returnName[]" value="<?php echo $prodName; ?>">
        <input type="hidden" name="returnPrice[]" value="<?php echo $price; ?>">
        <input type="hidden" name="returnQuantity[]" value="<?php echo $quantity; ?>">
        <?php }
        mysqli_free_result($productVariables);
    }
    mysqli_free_result($orderProducts); ?>
        
</table>
    <input type="hidden" name="returnOID" value="<?php echo $OID; ?>">
    <input type="hidden" name="date" value="<?php echo $date; ?>">
    
    <div class="bottom-pad-50 top-pad-50">
          <h3>Credit Card to Receive Credit</h3>
          <p>You may enter this here or fill it out manually on the printed form. </p>
          <div class="form-group">
              <div class="col-md-8">
                <label for="inputCardName">Name on Card</label>
                <input type="text" class="form-control" id="inputCardName" name="inputCardName" placeholder="Bob Dole">
              </div>
          </div>

          <div class="form-group">      
              <div class="col-md-4">
                <label for="inputCC">Credit Card Number</label>
                <input type="text" class="form-control" id="inputCC" name="inputCC" pattern="[0-9]{16}" title="Not a valid credit card number">
              </div>
              <div class="col-md-2">
                <label for="inputCCExp">Expiration Date</label>
                <input type="text" class="form-control" id="inputCCExp" name="inputCCExp" placeholder="MMYY" pattern="[0-9]{4}" title="Format must be MMYY">
              </div>
              <div class="col-md-2">
                <label for="inputCVV">Security Code</label>
                <input type="text" class="form-control" id="inputCVV" name="inputCVV" pattern="[0-9]{3}" title="Not a valid CVV">
              </div>
          </div>
    <input type="hidden" name="email" value="<?php echo $customer['email']; ?>">
    <button type="submit" class="btn btn-primary">Submit Return</button>
</form>





