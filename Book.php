<?php
require_once 'Product.php';

class Book extends Product {
    private $weight;

    public function __construct($sku, $name, $price, $weight) {
        parent::__construct($sku, $name, $price);
        $this->weight = $weight;
    }

    public function getSpecificFields() {
        return "
            <label for='weight'>Weight (kg)</label>
            <input type='number' id='weight' name='weight' value='{$this->weight}' required>
        ";
    }
}
