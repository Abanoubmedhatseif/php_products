<?php
abstract class Product {
    protected $sku;
    protected $name;
    protected $price;

    public function __construct($sku, $name, $price) {
        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
    }

    public function getBasicFields() {
        return "
            <label for='sku'>SKU</label>
            <input type='text' id='sku' name='sku' value='{$this->sku}' required>

            <label for='name'>Name</label>
            <input type='text' id='name' name='name' value='{$this->name}' required>

            <label for='price'>Price</label>
            <input type='number' id='price' name='price' value='{$this->price}' required>
        ";
    }

    abstract public function getSpecificFields();
}
