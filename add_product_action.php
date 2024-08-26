<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header('Content-Type: application/json');

Include_once 'ProductManager.php';
require_once 'Product.php';

// ProductFactory to create products dynamically based on type
class ProductFactory {
    public static function createProduct($data) {
        $className = $data['type'];
        if (!class_exists($className)) {
            throw new Exception("Invalid product type");
        }
        
        $params = array_values($data);
        $reflector = new ReflectionClass($className);
        return $reflector->newInstanceArgs($params);
    }
}

$productManager = new ProductManager();

$data = [
    'type' => $_POST['type'],
    'sku' => $_POST['sku'],
    'name' => $_POST['name'],
    'price' => $_POST['price'],
];

$specificData = array_filter($_POST, function($key) {
    return !in_array($key, ['type', 'sku', 'name', 'price']);
}, ARRAY_FILTER_USE_KEY);

$productData = array_merge($data, $specificData);

try {
    $product = ProductFactory::createProduct($productData);
    $response = $productManager->addProduct($product);

    if ($response['status'] === 'success') {
        header('Location: products.php');
        exit();
    } else {
        header('Location: add_product.php?error=' . urlencode($response['message']));
        exit();
    }
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    exit();
}

?>
