<?php
session_start();
include "../Includes/db.php";

function verify_payment(){
    if (randBool()){
        return true;
    }
    throw new Exception("Credit card declined by bank. Try entering a new card.");  
  }


    // returns true or false randomly, with false returning 15% of the time.
    // adapted from http://stackoverflow.com/questions/445235/generating-random-results-by-weight-in-php
function randBool() {
    $weights = array(0 => 1, 1 => 99,);
    $rand = mt_rand(1, (int) array_sum($weights));

    foreach ($weights as $number => $weight) {
        $rand -= $weight;
            error_log("rand = " . $rand);
        if ($rand <= 0) {
            error_log("return = " . $number);
            return $number;
        }
    }   
} 



$first = isset($_POST['inputFirst']) ? $_POST['inputFirst'] : "";
$last = isset($_POST['inputLast']) ? $_POST['inputLast'] : "";
$address1 = isset($_POST['inputAddress1']) ? $_POST['inputAddress1'] : "";
$address2 = isset($_POST['inputAddress2']) ? $_POST['inputAddress2'] : "";
$city = isset($_POST['inputCity']) ? $_POST['inputCity'] : "";
$state = isset($_POST['inputState']) ? $_POST['inputState'] : "";
$zip = isset($_POST['inputZip']) ? $_POST['inputZip'] : "";
$phone = isset($_POST['inputPhone']) ? $_POST['inputPhone'] : "";
$email = isset($_POST['inputEmail']) ? $_POST['inputEmail'] : "";

$cardName = isset($_POST['inputCardName']) ? $_POST['inputCardName'] : "";
$cardNumber = isset($_POST['inputCC']) ? $_POST['inputCC'] : "";
$cardExp = isset($_POST['inputCCExp']) ? $_POST['inputCCExp'] : "";
$cardCCV = isset($_POST['inputCVV']) ? $_POST['inputCVV'] : "";

$subtotal = isset($_POST['subtotal']) ? $_POST['subtotal'] : 0;
$shipping = isset($_POST['shipping']) ? $_POST['shipping'] : 0;
$tax = isset($_POST['tax']) ? $_POST['tax'] : 0;
$total = isset($_POST['total']) ? $_POST['total'] : 0;


$db = StoreDB::getInstance();
//$verify = new Verification();

if (isset($_GET['action']) && $_GET['action'] == 'update') {
    try {
        $customer = ($_SESSION['customer']);
        $CID = $customer['CID'];
        $db->update_customer($CID, $first, $last, $address1, $address2, $city, $state, $zip, $phone, $email);
        $customer = $db->get_customer_from_username($_SESSION['username']);
        $_SESSION['customer'] = $customer;
        header("Location:user_edit.php?action=success");
    } catch (Exception $e) {
        header("Location: user_edit.php?action=exception&message=" . $e->getMessage());
    }
} else if (isset($_GET['action']) && $_GET['action'] == 'verifyPassword') {
    $password = isset($_POST['oldPassword']) ? htmlspecialchars($_POST['oldPassword']) : "";
    $username = $_SESSION['username'];
    if (!$db->verify_user($username, $password)) {
        header("Location: user_edit.php?action=exception&message=Incorrect Password. Try again.");
    } else {
        header("Location:user_edit.php?action=userVerified");
    }
    
}else if (isset($_GET['action']) && $_GET['action'] == 'processOrder') {
    try{
        $db->begin_transaction();
        if (!isset($_SESSION['username'])) {
            $custID = $db->insert_customer($last, $first, $address1, $address2, $city, $state, $zip, $phone, $email);
        } else {
            $custID = $db->get_customerID_from_username($_SESSION['username']);
            if (!$custID) {
                $custID = $db->insert_customer($last, $first, $address1, $address2, $city, $state, $zip, $phone, $email);
            }
        }
        $orderID = $db->insert_order($custID, $subtotal, $shipping, $tax, $total);
        $db->insert_order_products($orderID, $_SESSION['cart_products']);
        verify_payment();
        unset($_SESSION['cart_products']);
        $db->commit();
        header("Location: order_confirmation.php?order_id=" . $orderID);
    } catch (Exception $ex) {
        $db->rollback();
        header("Location: checkout.php?action=exception&message=" . $ex->getMessage());
    }
} ?>

