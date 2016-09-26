<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Web Store</title>
    </head>
    <body>      
        <?php
            $con = mysqli_connect("localhost", "phpuser", "phpuserjb");
            if (!$con) {
                exit('Connect Error (' . mysqli_connect_errno() . ') '
                . mysqli_connect_error());
            }
            mysqli_set_charset($con, 'utf-8');

            mysqli_select_db($con, "ecommerce");
        ?>
        
        <h1>Welcome to the Web Store!</h1>
        
        <form name="store" action="store.php">
            What would you like to buy?
            
            <?php
                $result= mysqli_query($con, "SELECT type FROM types");
                while ($row=  mysqli_fetch_array($result)) {
                    echo "<p><input type=\"checkbox\" name=\"type[]\" value=\"" . htmlentities($row["type"]) . "\" />" . htmlentities($row["type"]) . "</p>";
                }
                mysqli_free_result($result);
                mysqli_close($con);
            ?>
            
            <input type="submit" value="Shop" name="shopButton" />
        </form>
        
        

    </body>
</html>
