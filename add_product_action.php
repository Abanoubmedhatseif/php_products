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

$productManager = new ProductManager();

$data = [
    'type' => $_POST['type'],
    'name' => $_POST['name'],
    'price' => $_POST['price'],
    'sku' => $_POST['sku'],
];

if ($data['type'] === 'Book') {
    $data['weight'] = $_POST['weight'];
    // Corrected parameter order: id, sku, name, price, weight
    $product = new Book(null, $data['sku'], $data['name'], $data['price'], $data['weight']);
} elseif ($data['type'] === 'DVD') {
    $data['size'] = $_POST['size'];
    // Corrected parameter order: id, sku, name, price, size
    $product = new DVD(null, $data['sku'], $data['name'], $data['price'], $data['size']);
} elseif ($data['type'] === 'Furniture') {
    $data['length'] = $_POST['length'];
    $data['width'] = $_POST['width'];
    $data['height'] = $_POST['height'];
    // Corrected parameter order: id, sku, name, price, length, width, height
    $product = new Furniture(null, $data['sku'], $data['name'], $data['price'], $data['length'], $data['width'], $data['height']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid product type']);
    exit;
}

$response = $productManager->addProduct($product);

if ($response['status'] === 'success') {
    header('Location: products.php');
    exit();
} else {
    header('Location: add_product.php?error=' . urlencode($response['message']));
    exit();
}

?>