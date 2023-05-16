<?php

    spl_autoload_register(function($class) {
        include_once $class . ".inc.php";
    });

    class CartInfo {
        private $itemName;
        private $itemPrice;
        private $itemAmount;
        private $itemTotalPrice;

        public function __construct($itemName, $itemPrice, $itemAmount, $itemTotalPrice) {
            $this->itemName;
            $this->itemPrice;
            $this->itemAmount;
            $this->itemTotalPrice;
        }

        public function __set($name, $value) {
            $this->$name = $value;
        }

        public function __get($name) {
            return $this->$name;
        }
    }
?>