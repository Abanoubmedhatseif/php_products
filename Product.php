<?php
abstract class Product {
    protected $id;
    protected $name;
    protected $price;
    protected $type;
    protected $sku;

    public function __construct($id, $name, $price, $type, $sku) {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->type = $type;
        $this->sku = $sku;
    }

    abstract public function save($database);
    abstract public function display();
    
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getType() {
        return $this->type;
    }

    public function getSku() {
        return $this->sku;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function setSku($sku) {
        $this->sku = $sku;
    }
}

class Book extends Product {
    private $weight;

    public function __construct($id, $name, $price, $type, $sku, $weight) {
        parent::__construct($id, $name, $price, $type, $sku);
        $this->weight = $weight;
    }

    public function save($database) {
        $database->saveProduct($this);
    }

    public function display() {
        return "Book: {$this->name}, SKU: {$this->sku}, Price: {$this->price}, Weight: {$this->weight}kg";
    }

    public function getWeight() {
        return $this->weight;
    }

    public function setWeight($weight) {
        $this->weight = $weight;
    }
}

class DVD extends Product {
    private $size;

    public function __construct($id, $name, $price, $type, $sku, $size) {
        parent::__construct($id, $name, $price, $type, $sku);
        $this->size = $size;
    }

    public function save($database) {
        $database->saveProduct($this);
    }

    public function display() {
        return "DVD: {$this->name}, SKU: {$this->sku}, Price: {$this->price}, Size: {$this->size}MB";
    }

    public function getSize() {
        return $this->size;
    }

    public function setSize($size) {
        $this->size = $size;
    }
}

class Furniture extends Product {
    private $length;
    private $width;
    private $height;

    public function __construct($id, $name, $price, $type, $sku, $length, $width, $height) {
        parent::__construct($id, $name, $price, $type, $sku);
        $this->length = $length;
        $this->width = $width;
        $this->height = $height;
    }

    public function save($database) {
        $database->saveProduct($this);
    }

    public function display() {
        return "Furniture: {$this->name}, SKU: {$this->sku}, Price: {$this->price}, Dimensions: {$this->length}x{$this->width}x{$this->height} cm";
    }

    public function getLength() {
        return $this->length;
    }

    public function setLength($length) {
        $this->length = $length;
    }

    public function getWidth() {
        return $this->width;
    }

    public function setWidth($width) {
        $this->width = $width;
    }

    public function getHeight() {
        return $this->height;
    }

    public function setHeight($height) {
        $this->height = $height;
    }
}
?>
