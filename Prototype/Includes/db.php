<?php

class StoreDB extends mysqli {
    // single instance of self shared among all instances
    private static $instance = null;
    
    // db connection config variables
    private $user = "phpuser";
    private $pass = "phpuserjb";
    private $dbName = "ecommerce";
    private $dbHost = "localhost";
  
    
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
        $result = $this->query("SELECT DISTINCT type from products");
        $types = array();
        while ($row = mysqli_fetch_array($result)) {
            array_push($types, $row["type"]);
        }
        mysqli_free_result($result);
        return $types;
    }
    
    public function get_products_by_type($type) {
        return $this->query("SELECT PID, name, image, description, price FROM products WHERE type=\"" 
                . $type . "\"");
    }
    
    public function get_first_attributes_by_product_id($pid) {
        return $this->query("SELECT attribute, value FROM attributes WHERE product_id=\"" 
                . $pid . "\" AND level='1'");
    }
    
    public function get_second_attributes_by_product_id($pid) {
        return $this->query("SELECT attribute, value FROM attributes WHERE product_id=\"" 
                . $pid . "\" AND level='2'");
    }
    
    public function get_cart_variables($id) {
        return $this->query("SELECT PID, name, price FROM products WHERE PID =\"" 
                . $id . "\"");
    }
    
    public function insert_customer($last, $first, $address1, $address2, $city, $state, $zip, $phone, $email, $username) {
         if ($stmt=$this->prepare("INSERT INTO customers (last_name, first_name, address_line1, address_line2, city, state, zip, phone, email, user_name) VALUES (?,?,?,?,?,?,?,?,?,?)")) {
           $stmt->bind_param("ssssssssss", $last, $first, $address1, $address2, $city, $state, $zip, $phone, $email, $username );
            $stmt->execute();
            $stmt->close();
            
            return $this->insert_id;
        }
        throw new Exception("Could not insert customer. Try again or start over.");
        
    }
    
    public function insert_order($customer, $subtotal, $shipping, $tax, $total) {
        $date = date('Y-m-d H:i:s');
        if ($stmt=$this->prepare("INSERT INTO orders (customer, date, subtotal, shipping, tax, total) VALUES(?,?,?,?,?,?)")){
           $stmt->bind_param("isdddd", $customer,$date, $subtotal, $shipping, $tax, $total );
            $stmt->execute();
            $stmt->close();
            echo 'insert successful';
            return $this->insert_id;         
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
        $stmt=$this->prepare("INSERT INTO users (username, password) VALUES (?,?)");
           $stmt->bind_param("ss", $username, $password );
           $qwe= $stmt->execute();
            $stmt->close();
            return $qwe;
        return $this->query("INSERT INTO users (username, password) VALUES ('" . $username . "', '" . $password . "')");
    }
    
    public function verify_user($username, $password) {
        //$answer = $this->query("SELECT * FROM users WHERE username='" . $username . "' AND password='" . $password . "'");
        $stmt = $this->prepare("SELECT * FROM users WHERE username=? AND password=?" );
           $stmt->bind_param("ss", $username,$password);
            $stmt->execute();
            $result = $stmt->get_result(); //$result is of type mysqli_result
            $count = $result->num_rows; 
        
        $result = $this->query("SELECT * FROM users WHERE username='" . $username . "' AND password='" . $password . "'");
        if ($count > 0) {
           
             return true;
         }
         return false;
    }
    
    public function get_name_from_username($username) {
        return $this->query("SELECT first_name FROM customers WHERE user_name='" . $username . "'");
    }
    
    public function get_customerID_from_username($username) {
        $result = $this->query("SELECT CID FROM customers WHERE user_name='" . $username . "'");
        $count = mysqli_num_rows($result);
        if ($count > 0) {
            $row = mysqli_fetch_row($result);
            mysqli_free_result($result);
            return htmlentities($row[0]);
        }
        mysqli_free_result($result);
        return false;
    }
    
//    public function get_customer_from_username($username) {
//        return $this->query("SELECT * FROM customers WHERE user_name='" . $username . "'");
//    }
    
    public function get_customer_from_username($username) {
        $customer = array();
        $result = $this->query("SELECT * FROM customers WHERE user_name='" . $username . "'");
        if (mysqli_num_rows($result) == 0) {
            mysqli_free_result($result);
            return false;
        }
        while ($row = mysqli_fetch_array($result)) {
            $customer['CID'] = htmlspecialchars($row['CID']); 
            $customer['firstName'] = htmlspecialchars($row['first_name']);
            $customer['lastName'] = htmlspecialchars($row['last_name']);
            $customer['addressLine1'] = htmlspecialchars($row['address_line1']);
            $customer['addressLine2'] = htmlspecialchars($row['address_line2']);
            $customer['city'] = htmlspecialchars($row['city']);
            $customer['state'] = htmlspecialchars($row['state']);
            $customer['zip'] = htmlspecialchars($row['zip']);
            $customer['phone'] = htmlspecialchars($row['phone']);
            $customer['email'] = htmlspecialchars($row['email']);
        }
        mysqli_free_result($result);
        return $customer;       
    }
    
    public function get_customer_from_order($OID) {
        $customer = array();
        $result = $this->query("SELECT CID, first_name, last_name, address_line1, address_line2, city, state, zip, phone, email "
                . "FROM customers c INNER JOIN orders o "
                . "ON c.CID = o.customer WHERE o.OID ='" . $OID . "'");
         if (mysqli_num_rows($result) == 0) {
            mysqli_free_result($result);
            return false;
        }
        while ($row = mysqli_fetch_array($result)) {
            $customer['CID'] = htmlspecialchars($row['CID']); 
            $customer['firstName'] = htmlspecialchars($row['first_name']);
            $customer['lastName'] = htmlspecialchars($row['last_name']);
            $customer['addressLine1'] = htmlspecialchars($row['address_line1']);
            $customer['addressLine2'] = htmlspecialchars($row['address_line2']);
            $customer['city'] = htmlspecialchars($row['city']);
            $customer['state'] = htmlspecialchars($row['state']);
            $customer['zip'] = htmlspecialchars($row['zip']);
            $customer['phone'] = htmlspecialchars($row['phone']);
            $customer['email'] = htmlspecialchars($row['email']);
        }
        mysqli_free_result($result);
        return $customer;       
    }
    
    public function get_orders_by_customer($CID) {
        return $this->query("SELECT * FROM orders WHERE customer='" . $CID . "'");
    }
    
    public function get_products_by_order($OID) {
        return $this->query("SELECT * FROM order_products WHERE order_id='" . $OID . "'");
    }
    
    public function get_user_from_username($username) {
        $result = $this->query("SELECT * FROM users WHERE username='" . $username . "'");
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_array($result);
            foreach ($row as $key => $value) {
                $user[$key] = $value;
            }
            return $user;           
        }
        mysqli_free_result($result);
        return false;
    }
    
    public function update_customer($CID, $first, $last, $address1, $address2, $city, $state, $zip, $phone, $email) {
        $result = $this->query("UPDATE customers SET last_name='" . $last . "', first_name='" . $first . "', address_line1='"
                . $address1 . "', address_line2='" . $address2 . "', city='" . $city . "', state='" . $state . "', zip='" 
                . $zip . "', phone='" . $phone . "', email='" . $email . "' WHERE CID='" . $CID . "'");
                if(!$result) {
                    mysqli_free_result($result);
                    throw new Exception("Could not update customer. Try again.");
                }
    }
    
    public function update_pending_returns($OID, $PID, $quantity) {
        $query = "UPDATE order_products SET status='return_pending', quantity_returned='"
                . $quantity . "WHERE order_id='" . $OID . "' AND product_id='" . $PID . "'";
        $result = $this->query("UPDATE order_products SET status='return_pending', quantity_returned='"
                . $quantity . "' WHERE order_id='" . $OID . "' AND product_id='" . $PID . "'");
        return $result;
    }
    
    public function change_password($username, $password) {
        $result = $this->query("UPDATE users SET password='" . $password . "' WHERE username='" . $username . "'");
        if(!$result) {
            throw new Exception("Could not change password. Try again.");
        }
    }
}



?>

