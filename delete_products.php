<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header('Content-Type: application/json');

require_once 'ProductManager.php';

$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid JSON']);
    exit;
}

$product_ids = $data['product_ids'] ?? [];

if (empty($product_ids) || !is_array($product_ids)) {
    exit;
}

$productManager = new ProductManager();
$response = $productManager->deleteProducts($product_ids);

if ($response['status'] === 'success') {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to delete products']);
}
?>
