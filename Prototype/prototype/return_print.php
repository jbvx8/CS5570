<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="../Styles/store.css">
    </head>
    <body class="left-pad-25">
        <?php
        $quantities = $_POST["returnQuantity"];
        $totalQuantity = 0;
        foreach ($quantities as $quantity) {
            $totalQuantity += $quantity;
        }
        if ($totalQuantity == 0) { ?>
            <div class='alert alert-danger alert-dismissible'>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close' onclick="history.go(-1);return false;">
                    <span aria-hidden='true'>OK</span>
                </button>
                <strong>No items selected!</strong>
            </div>
        <?php } else { ?>
        
        <h4>Print this page and enclose it with your return items.  Mail to: <br><br>
            Web Store Returns Processing <br>
            1234 Returns Street <br>
            Kansas City, MO 64111 <br><br>
            Your return will be processed immediately upon receipt. </h4>
        <?php
        echo "<h3>Order No: " . $_POST["returnOID"] . "</h3>
                <h3>Order Date: " . $_POST["date"] . "</h3>"; ?>
               
        <table class="table table-bordered table-width-custom">
            <tr>
                <th>Item #</th>
                <th>Item Name</th>
                <th>Price</th>
                <th>Return Quantity</th>
                <th>Total</th>
                <th>Reason</th>
            </tr>
            <?php
            include "../Includes/db.php";
            $db = StoreDB::getInstance();
            for ($i = 0; $i < count($_POST["returnPID"]); $i++) {
                if ($_POST["returnQuantity"][$i] > 0) {
                    echo "<tr><td>" . $_POST["returnPID"][$i] . "</td>"
                        . "<td>" . $_POST["returnName"][$i] . "</td>"
                        . "<td>" . $_POST["returnPrice"][$i] . "</td>"
                        . "<td>" . $_POST["returnQuantity"][$i] . "</td>"
                        . "<td>" . $_POST["returnPrice"][$i] *  $_POST["returnQuantity"][$i] . "</td>"
                        . "<td>" . $_POST["returnReason"][$i] . "</td></tr>";
                    $db->update_pending_returns($_POST["returnOID"], $_POST["returnPID"][$i], $_POST["returnQuantity"][$i]);
                }
            } ?>
        </table>
        <h3>Credit Card to return credit to:</h3>
        <h4><strong>This must be filled out accurately to receive credit.</strong></h4>
        <h4>If there are issues, we will contact you promptly at <strong><?php echo $_POST["email"]; ?></strong>.</h4>
        If this is not your correct email, please write your new email on this form or update your email in your account settings.
        <?php 
            $number = isset($_POST["inputCC"]) ? ($_POST["inputCC"]) : "";
            $name = isset($_POST["inputCardName"]) ? ($_POST["inputCardName"]) : "";
            $expiration = isset($_POST["inputCCExp"]) ? ($_POST["inputCCExp"]) : "";
            $cvv = isset($_POST["inputCVV"]) ? ($_POST["inputCVV"]) : "";
            
            echo "Card Name : " . $name . "<br>";
            echo "Card Number : " . $number . "<br>";
            echo "Card Expiration : " . $expiration . "<br>";
            echo "CVV : " . $cvv . "<br>";
        
        ?>
        <a href="user_orders.php" class="btn btn-default">Back</a>   
        <?php } ?>
    </body>
</html>