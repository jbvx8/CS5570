<?php
include "../Includes/db.php";

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
$cardCCV = isset($_POST['inputCCV']) ? $_POST['inputCCV'] : "";

$db = StoreDB::getInstance();

$db->insert_customer($last, $first, $address1, $address2, $city, $state, $zip, $phone, $email);




function verify_payment(){
    
}