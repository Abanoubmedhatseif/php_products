<?php
require_once 'Product.php';

class DVD extends Product {
    private $size;

    public function __construct($id, $sku, $name, $price, $size) {
        parent::__construct($id, $sku, $name, $price);
        $this->size = $size;
    }

    public function getSize() {
        return $this->size;
    }
    
    public function getType() {
        return 'DVD';
    }

    public function getSpecificFields() {
        return "
            <p>Size: $this->size MB</p>
        ";
    }
}
