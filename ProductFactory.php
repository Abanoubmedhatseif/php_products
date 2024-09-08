<?php
require_once 'Book.php';
require_once 'DVD.php';
require_once 'Furniture.php';

class ProductFactory {
    private $typeToConstructor;

    public function __construct() {
        $this->typeToConstructor = [
            'Book' => 'createBook',
            'DVD' => 'createDVD',
            'Furniture' => 'createFurniture',
        ];
    }

    public function createProduct($type, $sku, $name, $price, $additionalAttributes) {
        if (!class_exists($type)) {
            throw new InvalidArgumentException("Class $type does not exist");
        }

        if (!array_key_exists($type, $this->typeToConstructor)) {
            throw new InvalidArgumentException("Invalid product type: $type");
        }

        $method = $this->typeToConstructor[$type];
        return $this->$method($sku, $name, $price, $additionalAttributes);
    }

    private function createBook($sku, $name, $price, $additionalAttributes) {
        return new Book(null, $sku, $name, $price, $additionalAttributes['weight']);
    }

    private function createDVD($sku, $name, $price, $additionalAttributes) {
        return new DVD(null, $sku, $name, $price, $additionalAttributes['size']);
    }

    private function createFurniture($sku, $name, $price, $additionalAttributes) {
        return new Furniture(null, $sku, $name, $price, $additionalAttributes['height'], $additionalAttributes['width'], $additionalAttributes['length']);
    }
}
?>
