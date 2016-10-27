

<?php
session_start();

$page_title="Available Products";
include '../Includes/layout_header.php';

$action = isset($_GET['action']) ? $_GET['action'] : "";
$product_id = isset($_GET['product_id']) ? $_GET['product_id'] : "1";
$name = isset($_GET['name']) ? $_GET['name'] : "";
$quantity = isset($_GET['quantity']) ? $_GET['quantity'] : "";


if($action=='added'){ ?>
    <div class='alert alert-info alert-dismissible'>
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'>&times;</span>
         </button>
        <strong><?php echo $name; ?></strong> was added to your cart!
    </div>
<?php }
 
if($action=='exists'){ ?>
    <div class='alert alert-info alert-dismissible'>
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
        <span aria-hidden='true'>&times;</span>
        </button>
        <strong><?php echo $name; ?></strong> already exists in your cart; <?php echo $quantity; ?> more added!
    </div>
<?php } ?>
    <div class='container'>
        <div class='row'>
        <?php               
            $db = StoreDB::getInstance();
            $types = $db->get_all_types();
            while ($r = mysqli_fetch_array($types)) {
                $type = htmlentities($r["type"]);
                echo "<h2>" . $type . "</h2>";
                
                $result = $db->get_products_by_type($type);
                while ($row = mysqli_fetch_array($result)) {
                    $name = htmlentities($row["name"]);
                    $PID = htmlentities($row["PID"]);
                    
                    echo "<div class='col-md-3'>
                        <div class='thumb'><img src=" . htmlentities($row["image"]) . "></div>      
                    
                            Title : " . $name;
                    $attributes = $db->get_first_attributes_by_product_id($PID);
                    while ($attributesRow = mysqli_fetch_array($attributes)) {
                        echo "<p>" . htmlentities(ucfirst($attributesRow["attribute"])) . " : " . htmlentities($attributesRow["value"]) . "</p>";                        
                    }
                    echo "<p>Price: " . htmlentities($row["price"]) . "</p>";
                    mysqli_free_result($attributes); ?>
                    
                    <form action='cart_session.php'>
                        <input type='text' name='quantity' placeholder='0' size='2' />
                        <input type='hidden' name='id' value='<?php echo $PID ?>'/>
                        <input type='hidden' name='name' value='<?php echo $name ?>'/>
                        <button type='submit' class='btn btn-primary'><span class='glyphicon glyphicon-shopping-cart'></span>
                        Add to cart</button>
                    </form>
                </div>
                <?php }
                mysqli_free_result($result);
                
                echo "</div>";
            
            }
            mysqli_free_result($types);
            echo "</div>";

            ?>