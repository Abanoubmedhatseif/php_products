<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header('Content-Type: application/json');

require_once 'ProductManager.php';
require_once 'ProductFactory.php'; 

$productManager = new ProductManager();
$productFactory = new ProductFactory(); 

$data = [
    'type' => $_POST['type'],
    'sku' => $_POST['sku'],
    'name' => $_POST['name'],
    'price' => $_POST['price'],
];

$specificData = array_filter($_POST, function($key) {
    return !in_array($key, ['type', 'sku', 'name', 'price']);
}, ARRAY_FILTER_USE_KEY);

try {
    $product = $productFactory->createProduct(
        $data['type'], 
        $data['sku'], 
        $data['name'], 
        $data['price'], 
        $specificData
    );
    
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
