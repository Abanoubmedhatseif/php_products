<?php
require_once 'Product.php';

class DVD extends Product {
    private $size;

    public function __construct($sku, $name, $price, $size) {
        parent::__construct($sku, $name, $price);
        $this->size = $size;
    }

    public function getSpecificFields() {
        return "
            <label for='size'>Size (MB)</label>
            <input type='number' id='size' name='size' value='{$this->size}' required>
        ";
    }
}
