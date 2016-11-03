<?php

session_start();
$page_title = "Shopping Cart";
include '../Includes/layout_header.php';


$db = StoreDB::getInstance();
$cart = $_SESSION['cart_products'];


if(count($cart) > 0){
    $subtotal = 0;
    $price = 0;
    $quantity = 0;
    $name = ''; ?>
    <table class= 'table table-hover table-responsive table-bordered' id='cartTable'>
        <tr>
            <th class='textAlignLeft'>Product Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total</th>
            <th></th>
        </tr>
    
    <?php foreach($cart as $PID => $value){
 
        $result = $db->get_cart_variables($PID);
        while($row = mysqli_fetch_array($result)) {
            $name = htmlentities($row["name"]);
            $price = htmlentities($row["price"]);
        }
    mysqli_free_result($result);

    $total = $price * (int)$value; ?>
      
        <tr>
            <td><?php echo $name; ?></td>
            <td><?php echo $price; ?></td>
            <td><?php echo $value; ?></td>
            <td><?php echo $total; ?></td>
            <td><form name='removeForm'>
                <input type='hidden' name='id' value='" . $PID . "'/>
                <button class='btnRemove btn-danger' type='submit' value='remove'>Remove</button></td>
                </form>
            </td>
        </tr>

    <?php $subtotal += $total;
    }  ?>
    

        <tr>
            <td><strong>Subtotal</strong></td>
            <td></td>
            <td></td>
            <td><strong><?php echo $subtotal; ?></strong></td>
        </tr>
    </table>
    
    <?php if (isset($_SESSION['username'])) { ?>
    <a href="checkout.php" class="btn btn-default">Checkout</a>
    <?php } else { ?>
    <button id='checkoutButton' class='btn btn-default' 
        onclick='this.style.display="none";showDiv(checkoutDiv.id)'>Checkout</button>
       
        <div id='checkoutDiv' style='display:none;'>
            <a href='checkout.php' class='btn btn-default'>Checkout as Guest</a>
            <a href='login.php' class='btn btn-default'>Login</a>
        </div>
    <?php }
 } else { ?>
    <div class='alert alert-danger'>
        <form action='store.php'>
        <button type='submit' class='close' aria-label='close'>&times;</button>
        Shopping cart is <strong>empty</strong>!
        </form>
    </div>    
<?php } ?>

<script src='../Scripts/store.js' type="text/javascript"></script>
<?php include '../Includes/layout_footer.php'; ?>

