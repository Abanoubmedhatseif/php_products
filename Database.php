<?php
require_once 'Product.php';
require_once 'Book.php';
require_once 'DVD.php';
require_once 'Furniture.php';

class Database {
    private $connection;

    public function __construct($host, $user, $password, $database) {
        $this->connection = new mysqli($host, $user, $password, $database);
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    public function saveProduct(Product $product) {
        $type = $product->getType();
        $name = $product->getName();
        $price = $product->getPrice();
        $sku = $product->getSku();
    
        // Set default values to null
        $weight = $size = $length = $width = $height = null;
    
        if ($type === 'Book') {
            $weight = $product->getWeight();
        } elseif ($type === 'DVD') {
            $size = $product->getSize();
        } elseif ($type === 'Furniture') {
            $length = $product->getLength();
            $width = $product->getWidth();
            $height = $product->getHeight();
        }
    
        // Check if SKU already exists
        $stmt = $this->connection->prepare("SELECT id FROM products WHERE sku = ?");
        if (!$stmt) {
            die("Prepare failed: " . $this->connection->error);
        }

        $stmt->bind_param("s", $sku);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            throw new Exception('SKU already exists in the database.');
        }
        $stmt->close();
    
        // Insert new product
        $stmt = $this->connection->prepare(
            "INSERT INTO products (name, price, type, sku, weight, size, length, width, height) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );
    
        if (!$stmt) {
            throw new Exception('Prepare failed: ' . $this->connection->error);
        }
    
        // Bind parameters to the SQL statement
        $stmt->bind_param(
            "sdsssdddd",
            $name,
            $price,
            $type,
            $sku,
            $weight,
            $size,
            $length,
            $width,
            $height
        );
        
        if (!$stmt->execute()) {
            throw new Exception('Execute failed: ' . $stmt->error);
        }
    
        $stmt->close();
    }
    
    public function getProduct($id) {
        $stmt = $this->connection->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        $stmt->close();
        return $data;
    }

    public function getAllProducts() {
        $result = $this->connection->query("SELECT * FROM products");
        $products = [];
    
        while ($row = $result->fetch_assoc()) {
            switch ($row['type']) {
                case 'Book':
                    $products[] = new Book($row['id'], $row['sku'], $row['name'], $row['price'], $row['weight']);
                    break;
                case 'DVD':
                    $products[] = new DVD($row['id'], $row['sku'], $row['name'], $row['price'], $row['size']);
                    break;
                case 'Furniture':
                    $products[] = new Furniture($row['id'], $row['sku'], $row['name'], $row['price'], $row['height'], $row['width'], $row['length']);
                    break;
            }
        }
    
        return $products;
    }
    
    
    public function deleteProducts(array $ids) {
        if (empty($ids)) {
            throw new Exception('No IDs provided for deletion');
        }
    
        $idList = implode(',', array_map('intval', $ids));
    
        $query = "DELETE FROM products WHERE id IN ($idList)";
    
        if ($this->connection->query($query) === FALSE) {
            throw new Exception('Error executing query: ' . $this->connection->error);
        }
    
        $affectedRows = $this->connection->affected_rows;
        if ($affectedRows === 0) {
            throw new Exception('No products were deleted. IDs may not exist.');
        }
    }
    
}
?>
