<?php
require_once 'Book.php';
require_once 'DVD.php';
require_once 'Furniture.php';

class ProductFactory {
    public static function createProduct($type, $sku, $name, $price, $additionalAttributes) {
        switch ($type) {
            case 'Book':
                return new Book($sku, $name, $price, $additionalAttributes['weight']);
            case 'DVD':
                return new DVD($sku, $name, $price, $additionalAttributes['size']);
            case 'Furniture':
                return new Furniture($sku, $name, $price, $additionalAttributes['height'], $additionalAttributes['width'], $additionalAttributes['length']);
            default:
                throw new Exception("Invalid product type");
        }
    }
}
