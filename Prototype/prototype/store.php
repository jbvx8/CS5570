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
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="../Styles/store.css">
    </head>
    <body>
        <h1 class="left-justify">Available Products</h1>
        <div class="container left-justify narrow">
            <?php
            require_once '../Includes/db.php';
            $db = StoreDB::getInstance();
            $value = $_GET["type"];

            foreach ($value as $type) {
                //echo "<div class=\"row\">";
                echo "<p><h2>" . $type . "</h2></p>";

                $result = $db->get_products_by_type($type);
                while ($row = mysqli_fetch_array($result)) {
                    echo "<div class=\"thumb\"><img src=" . htmlentities($row["image"]) . "></div>";
                    echo "Title : " . htmlentities($row["name"]);
                    echo "<p>Description : " . htmlentities($row["description"]) . "</p>";

                    $attributes = $db->get_attributes_by_product_id(htmlentities($row["PID"]));
                    $genre = 0;
                    while ($attributesRow = mysqli_fetch_array($attributes)) {
                        if ($attributesRow["attribute"] == "genre") {
                            if ($genre > 0) {
                                echo ", " . $attributesRow["value"];
                            } else {
                                echo "Genre : " . $attributesRow["value"];
                            }
                            $genre++;
                        } else {
                            echo "<p>" . htmlentities(ucfirst($attributesRow["attribute"])) . " : " . htmlentities($attributesRow["value"]) . "</p>";
                        }
                    }
                    echo "<p>Price: " . htmlentities($row["price"]) . "</p>";
                    mysqli_free_result($attributes);
                }
                mysqli_free_result($result);
                //echo "</div>";
            }
            ?>

        </div>
    </body>
</html>
