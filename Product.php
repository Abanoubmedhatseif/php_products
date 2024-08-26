<?php
abstract class Product {
    protected $id;
    protected $sku;
    protected $name;
    protected $price;


    public function __construct($id, $sku, $name, $price) {
        $this->id = $id;
        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
    }

    public function getId() {
        return $this->id;
    }

    public function getSku() {
        return $this->sku;
    }

    public function getName() {
        return $this->name;
    }

    public function getPrice() {
        return $this->price;
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
    abstract public function getType();
}
