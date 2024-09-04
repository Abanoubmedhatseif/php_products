<?php
require_once 'Book.php';
require_once 'DVD.php';
require_once 'Furniture.php';

class ProductFactory {
    private $typeToConstructor;

    public function __construct() {
        $this->typeToConstructor = [
            'Book' => [$this, 'createBook'],
            'DVD' => [$this, 'createDVD'],
            'Furniture' => [$this, 'createFurniture'],
        ];
    }

    public function createProduct($type, $sku, $name, $price, $additionalAttributes) {
        if (!array_key_exists($type, $this->typeToConstructor)) {
            throw new InvalidArgumentException("Invalid product type: $type");
        }

        $constructor = $this->typeToConstructor[$type];
        return $constructor($sku, $name, $price, $additionalAttributes);
    }

    private function createBook($sku, $name, $price, $additionalAttributes) {
        return new Book($sku, $name, $price, $additionalAttributes['weight']);
    }

    private function createDVD($sku, $name, $price, $additionalAttributes) {
        return new DVD($sku, $name, $price, $additionalAttributes['size']);
    }

    private function createFurniture($sku, $name, $price, $additionalAttributes) {
        return new Furniture($sku, $name, $price, $additionalAttributes['height'], $additionalAttributes['width'], $additionalAttributes['length']);
    }
}
?>
