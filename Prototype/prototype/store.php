<!--<!DOCTYPE html>

To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.

<html>
    <head>
        <meta charset="UTF-8">
        <title>Store</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="../Styles/store.css">
    </head>
    <body>-->

<?php
session_start();

$page_title="Available Products";
include '../Includes/layout_header.php';

$action = isset($_GET['action']) ? $_GET['action'] : "";
$product_id = isset($_GET['product_id']) ? $_GET['product_id'] : "1";
$name = isset($_GET['name']) ? $_GET['name'] : "";
$quantity = isset($_GET['quantity']) ? $_GET['quantity'] : "";


if($action=='added'){
    echo "<div class='alert alert-info alert-dismissible'>";
        echo "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'>&times;</span>
            </button>
        <strong>{$name}</strong> was added to your cart!
    </div>";
}
 
if($action=='exists'){
    echo "<div class='alert alert-info alert-dismissible'>
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
        <span aria-hidden='true'>&times;</span>
        </button>
        <strong>{$name}</strong> already exists in your cart; {$quantity} more added!
    </div>";
}

  echo "<div class='container'>
        <div class='row'>";
            
            
            $db = StoreDB::getInstance();
            //$value = $_GET["type"];
            $types = $db->get_all_types();
            while ($r = mysqli_fetch_array($types)) {
                $type = htmlentities($r["type"]);
            

            //foreach ($value as $type) {
                //echo "<div class=\"row\">";
                echo "<h2>" . $type . "</h2>";
                
                $result = $db->get_products_by_type($type);
                while ($row = mysqli_fetch_array($result)) {
                    $name = htmlentities($row["name"]);
                    $PID = htmlentities($row["PID"]);
                    
                    echo "<div class='col-md-3'>
                        <div class='thumb'><img src=" . htmlentities($row["image"]) . "></div>      
                    
                            Title : " . $name;
                    //echo "<p>Description : " . htmlentities($row["description"]) . "</p>";

                    $attributes = $db->get_first_attributes_by_product_id($PID);
                    //$genre = 0;
                    while ($attributesRow = mysqli_fetch_array($attributes)) {
                        echo "<p>" . htmlentities(ucfirst($attributesRow["attribute"])) . " : " . htmlentities($attributesRow["value"]) . "</p>";                        
                    }
                    echo "<p>Price: " . htmlentities($row["price"]) . "</p>";
                    mysqli_free_result($attributes);
                    //echo "";
//                    echo "<a href='cart_session.php?id={$PID}&name={$name}' class='btn btn-primary'>
//                        <span class='glyphicon glyphicon-shopping-cart'></span> Add to cart
//                    </a>
//                    </div>";
                    echo "<form action='cart_session.php'>
                        <input type='text' name='quantity' placeholder='0' size='2' />
                        <input type='hidden' name='id' value='" . $PID . "'/>
                        <input type='hidden' name='name' value='" . $name . "'/>
                        <button type='submit' class='btn btn-primary'><span class='glyphicon glyphicon-shopping-cart'></span>
                        Add to cart</button>
                        </form></div>";
                }
                mysqli_free_result($result);
                
                echo "</div>";
            
            }
            mysqli_free_result($types);
            echo "</div>";

//        </div>
//    </body>
//</html>
