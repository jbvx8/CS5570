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
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="./prototype.css">
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
        
        <div class="container">
            <div class="jumbotron">
		<h1><span class="glyphicon glyphicon-shopping-cart"></span> Welcome to the Web Store!</h1>
		<p>What would you like to buy?</p>
                <form action="store.php">
               
                <?php
                $result= mysqli_query($con, "SELECT type FROM types");
                while ($row=  mysqli_fetch_array($result)) {
                    echo "<p><input type=\"checkbox\" name=\"type[]\" value=\"" . htmlentities($row["type"]) . "\" /> " . htmlentities($row["type"]) . "</p>";
                }
                mysqli_free_result($result);
                mysqli_close($con);
            ?>
            
                <button class="btn btn-default" type="submit">Shop</button>
                </form>
        
            </div>
        </div>
        
        

    </body>
</html>
