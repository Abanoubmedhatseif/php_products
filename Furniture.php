<?php
require_once 'Product.php';

class Furniture extends Product {
    private $height;
    private $width;
    private $length;

    public function __construct($id, $sku, $name, $price, $height, $width, $length) {
        parent::__construct($id, $sku, $name, $price);
        $this->height = $height;
        $this->width = $width;
        $this->length = $length;
    }


    public function getHeight() {
        return $this->height;
    }

    public function getWidth() {
        return $this->width;
    }

    public function getLength() {
        return $this->length;
    }

    public function getType() {
        return 'Furniture';
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
