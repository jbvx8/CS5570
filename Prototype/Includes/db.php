<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

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
}



?>

