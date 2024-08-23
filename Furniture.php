<?php
require_once 'Product.php';

class Furniture extends Product {
    private $height;
    private $width;
    private $length;

    public function __construct($sku, $name, $price, $height, $width, $length) {
        parent::__construct($sku, $name, $price);
        $this->height = $height;
        $this->width = $width;
        $this->length = $length;
    }

    public function getSpecificFields() {
        return "
            <label for='height'>Height (cm)</label>
            <input type='number' id='height' name='height' value='{$this->height}' required>

            <label for='width'>Width (cm)</label>
            <input type='number' id='width' name='width' value='{$this->width}' required>

            <label for='length'>Length (cm)</label>
            <input type='number' id='length' name='length' value='{$this->length}' required>
        ";
    }
}
