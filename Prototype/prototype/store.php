

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
    <div class='container bottom-pad-50'>
        <div class="dropdown">
          <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
            Choose Department
            <span class="caret"></span>
          </button>
          <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
              <?php 
              $db = StoreDB::getInstance();
              $listTypes = $db->get_all_types();
              foreach($listTypes as $value) {
                echo "<li><a href='?action=" . $value . "'>" . $value . "</li>";
              }

              ?>
              <li><a href="?">Show all</a></li>
          </ul>
        </div>
        
        <?php               
            
            $types = array();
            if (isset($_GET["action"])) {
                array_push($types, $_GET["action"]);
            } else {
                $types = $listTypes;
            }
        
            
            foreach ($types as $type) {
                echo "<h2>" . $type . "</h2>";
                
                $result = $db->get_products_by_type($type);
                while ($row = mysqli_fetch_array($result)) {
                    $name = htmlentities($row["name"]);
                    $PID = htmlentities($row["PID"]);
                    $description = htmlentities($row["description"]);
                    
                    echo "<div class='col-md-3 bottom-pad-50'>
                        <div class='thumb'><img src=" . htmlentities($row["image"]) . "></div>      
                    
                            Title : " . $name;
                    $attributes = $db->get_first_attributes_by_product_id($PID);
                    while ($attributesRow = mysqli_fetch_array($attributes)) {
                        echo "<p>" . htmlentities(ucfirst($attributesRow["attribute"])) . " : " . htmlentities($attributesRow["value"]) . "</p>";                        
                    }
                    echo "<p>Price: " . htmlentities($row["price"]) . "<span>"; ?>
                    
            
                    <a class = "relative left-pad-25" data-toggle="popover" data-trigger="hover" data-html="true" data-content="<?php 
                        $seconds = $db->get_second_attributes_by_product_id($PID);
                        $genre = 0;
                        while ($secondsRow = mysqli_fetch_array($seconds)) {
                            if ($secondsRow["attribute"] == "genre") {
                                if ($genre > 0) {
                                    echo ", " . $secondsRow["value"];
                                } else {
                                    echo "<br />Genre : " . $secondsRow["value"];
                                }
                                $genre++;
                            } else {
                                echo "<br />" . htmlentities(ucfirst($secondsRow["attribute"])) . " : " . htmlentities($secondsRow["value"]);
                            }
                        }
                        echo "<br />Description : " . $description;
                        ?>">info</a> <?php echo "</span></p>"; ?>
       
                    <form action='cart_session.php'>
                        <input type='text' name='quantity' placeholder='0' size='2' pattern="[1-9]{1}[0-9]{0,1}" required title='Values 1-99 only' />
                        <input type='hidden' name='id' value='<?php echo $PID ?>'/>
                        <input type='hidden' name='name' value='<?php echo $name ?>'/>
                        <button type='submit' class='btn btn-primary'><span class='glyphicon glyphicon-shopping-cart'></span>
                        Add to cart</button>
                    </form>
                </div>
                <?php }
                mysqli_free_result($attributes); 
                mysqli_free_result($seconds);
                mysqli_free_result($result);
                
                
            
            }
            echo "</div>";

            ?>