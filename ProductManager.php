<?php
require_once 'Database.php';
require_once 'Product.php';

class ProductManager {
    private $database;

    public function __construct() {
        $this->database = new Database('sql204.infinityfree.com', 'if0_36961745', 'CRVm5rDQF81fuBx', 'if0_36961745_products_data');

        // $this->database = new Database('localhost', 'root', 'abanoub', 'php_task_scandiweb');
    }

    public function addProduct(Product $product) {
        try {
            $this->database->saveProduct($product);
            return ['status' => 'success', 'message' => 'Product added successfully.'];
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => 'Failed to add product: ' . $e->getMessage()];
        }
    }

    

    public function getProduct($id) {
        try {
            $data = $this->database->getProduct($id);
            if ($data) {
                return ['status' => 'success', 'data' => $data];
            } else {
                return ['status' => 'error', 'message' => 'Product not found'];
            }
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => 'Failed to retrieve product: ' . $e->getMessage()];
        }
    }


    public function getAllProducts() {
        try {
            $products = $this->database->getAllProducts();
            if ($products) {
                return ['status' => 'success', 'data' => $products];
            } else {
                return ['status' => 'error', 'message' => 'No products found'];
            }
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => 'Failed to retrieve products: ' . $e->getMessage()];
        }
    }
    

    public function deleteProducts(array $ids) {
    // Convert all IDs to integers
    $ids = array_map('intval', $ids);

    // Check if there are valid IDs to delete
    if (!empty($ids)) {;
        try {
            $this->database->deleteProducts($ids);
            return ['status' => 'success', 'message' => 'Products deleted successfully.'];
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => 'Failed to delete products: ' . $e->getMessage()];
        }
    } else {
        return false;
    }
}

}
?>
