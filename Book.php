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
            <p>Weight: $this->weight kg </p>
        ";
    }
}
