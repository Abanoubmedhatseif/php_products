<?php
require_once 'Product.php';

class Book extends Product {
    private $weight;

    public function __construct($id, $sku, $name, $price, $weight) {
        parent::__construct($id, $sku, $name, $price);
        $this->weight = $weight;
    }
        

    public function getWeight() {
        return $this->weight;
    }

    public function getType() {
        return 'Book';
    }

    public function getSpecificFields() {
        return "
            <label for='weight'>Weight (kg)</label>
            <input type='number' id='weight' name='weight' value='{$this->weight}' required>
        ";
    }
}
