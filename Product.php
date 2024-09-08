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

    abstract public function getSpecificFields();
    abstract public function getType();
}


?>