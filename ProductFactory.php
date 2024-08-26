<?php
require_once 'Book.php';
require_once 'DVD.php';
require_once 'Furniture.php';

class ProductFactory {
    private static $typeToConstructor = [
        'Book' => 'createBook',
        'DVD' => 'createDVD',
        'Furniture' => 'createFurniture',
    ];

    public static function createProduct($type, $sku, $name, $price, $additionalAttributes) {
        $constructor = self::$typeToConstructor[$type];
        return self::$constructor($sku, $name, $price, $additionalAttributes);
    }

    private static function createBook($sku, $name, $price, $additionalAttributes) {
        return new Book($sku, $name, $price, $additionalAttributes['weight']);
    }

    private static function createDVD($sku, $name, $price, $additionalAttributes) {
        return new DVD($sku, $name, $price, $additionalAttributes['size']);
    }

    private static function createFurniture($sku, $name, $price, $additionalAttributes) {
        return new Furniture($sku, $name, $price, $additionalAttributes['height'], $additionalAttributes['width'], $additionalAttributes['length']);
    }
}
?>
