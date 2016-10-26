<?php

class StoreDB extends mysqli {
    // single instance of self shared among all instances
    private static $instance = null;
    
    // db connection config variables
    private $user = "phpuser";
    private $pass = "phpuserjb";
    private $dbName = "ecommerce";
    private $dbHost = "localhost";
    private $con = null;
    
    // static method that must return an instance of the object if the object does
    // not already exist.
    public static function getInstance() {
        if (!self::$instance instanceof self) {
            self::$instance = new self;
        }
        return self::$instance;
    }
    
    // further enforcing singleton pattern
    public function __clone() {
        trigger_error('Clone is not allowed.', E_USER_ERROR);
    }
    
    public function __wakeup() {
        trigger_error('Deserializaing is not allowed.', E_USER_ERROR);
    }
    
    // constructor needs to be public because class extends mysqli?
    public function __construct() {
        parent::__construct($this->dbHost, $this->user, $this->pass, $this->dbName);
        if (mysqli_connect_error()) {
            exit('Connect Error (' . mysqli_connect_errno() . ') '
                    . mysqli_connect_error());
        }
        parent::set_charset('utf-8');
    }
    
    // returns all possible types of products from types table
    // returns null if none
    public function get_all_types() {
        return $this->query("SELECT type from types");
    }
    
    public function get_products_by_type($type) {
        return $this->query("SELECT PID, name, image, description, price FROM products WHERE type=\"" 
                . $type . "\"");
    }
    
    public function get_first_attributes_by_product_id($pid) {
        return $this->query("SELECT attribute, value FROM attributes WHERE product_id=\"" 
                . $pid . "\" AND level='1'");
    }
    
    public function get_cart_variables($id) {
        return $this->query("SELECT PID, name, price FROM products WHERE PID =\"" 
                . $id . "\"");
    }
    
    public function insert_customer($last, $first, $address1, $address2, $city, $state, $zip, $phone, $email) {
        if ($this->query("INSERT INTO customers (last_name, first_name, address_line1, address_line2, city, state, zip, phone, email)
          VALUES('" . $last . "', '" . $first . "', '" . $address1 . "', '" . $address2 . "', '" 
                . $city . "', '" . $state . "', '" . $zip . "', '" . $phone . "', '" . $email . "')")) {
            return mysqli_insert_id($this);
        }
        throw new Exception("Could not insert customer. Try again or start over.");
        
    }
    
    public function insert_order($customer, $subtotal, $shipping, $tax, $total) {
        $date = date('Y-m-d H:i:s');
        if ($this->query("INSERT INTO orders (customer, date, subtotal, shipping, tax, total) VALUES('" . $customer . "', '" . $date . "', '"
                . $subtotal . "', '" . $shipping . "', '" . $tax . "', '" . $total . "')")){
            return mysqli_insert_id($this);         
        }
        throw new Exception("Could not insert order. Try again or start over.");
    }
    
    public function insert_order_products($orderID, $products) {
        foreach ($products as $key => $value) {
            if (!$this->query("INSERT INTO order_products(order_id, product_id, product_quantity) VALUES('" . $orderID . "', '"
                    . $key . "', '" . $value . "')")) {
                throw new Exception("Could not insert products. Try again or start over.");
            }
        }
        return true;
    }
    
    public function insert_user($username, $password) {
        return $this->query("INSERT INTO users (username, password) VALUES ('" . $username . "', '" . $password . "')");
    }
    
    public function verify_user($username, $password) {
        //$answer = $this->query("SELECT * FROM users WHERE username='" . $username . "' AND password='" . $password . "'");
         $result = $this->query("SELECT * FROM users WHERE username='" . $username . "' AND password='" . $password . "'");
         if (mysqli_num_rows($result) > 0) {
             return true;
         }
         return false;
    }
    
    public function get_name_from_username($username) {
        return $this->query("SELECT first_name FROM customers WHERE user_name='" . $username . "'");
    }
}



?>

