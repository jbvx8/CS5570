<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Store</title>
    </head>
    <body>
        <h1>Available Products</h1>
        <?php 
            $value = $_GET["type"];
        
            $con = mysqli_connect("localhost", "phpuser", "phpuserjb");
            if (!$con) {
                exit('Connect Error (' . mysqli_connect_errno() . ') '
                . mysqli_connect_error());
            }
            mysqli_set_charset($con, 'utf-8');

            mysqli_select_db($con, "ecommerce");
            
            foreach ($value as $type){
                echo "<p><h2>" . $type . "</h2></p>";
                $result = mysqli_query($con, "SELECT PID, name, image, description, price FROM products WHERE type=\"" . $type . "\"");
                
                while ($row = mysqli_fetch_array($result)){
                    echo "<p>Title : " . htmlentities($row["name"]) . "</p>";
                    echo "<p>Description : " . htmlentities($row["description"]) . "</p>";
                    echo "<p>Description : " . $row["description"] . "</p>";
                    $newResult = mysqli_query($con, "SELECT attribute, value FROM attributes WHERE product_id=\"" . htmlentities($row["PID"]) . "\"");
                    $genre = 0;
                    while ($newRow = mysqli_fetch_array($newResult)){    
                        if ($newRow["attribute"] == "genre") {
                            if ($genre > 0){
                                echo ", " . $newRow["value"];
                            } else {
                                echo "Genre : " . $newRow["value"];
                            }
                            $genre++;
                        } else {
                            echo "<p>" . htmlentities(ucfirst($newRow["attribute"])) . " : " . htmlentities($newRow["value"]) . "</p>";
                        }
                    }
                    echo "<p>Price: " . htmlentities($row["price"]) . "</p>";

                }   
            }
        ?>
      
    </body>
</html>
