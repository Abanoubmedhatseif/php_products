<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <link rel="stylesheet" href="styles/products.css">
</head>
<body>
    <div class="button-container">
        <a href="add_product.php" class="button">ADD</a>
        <button id="delete-products" form="product-form" type="submit">MASS DELETE</button>
    </div>
    <h1>Product List</h1>
    <form id="product-form">
        <div id="product-cards">
            <?php

            require_once 'ProductManager.php';
            $productManager = new ProductManager();
            $result = $productManager->getAllProducts();

            if ($result['status'] == 'success') {
                foreach ($result['data'] as $product) {
                    if (is_object($product)) {
                        echo '<div class="product-card">';
                        echo '<input class="delete-checkbox" type="checkbox" name="product_ids[]" value="' . htmlspecialchars($product->getId()) . '">';
                        echo '<h2>' . htmlspecialchars($product->getName()) . '</h2>';
                        echo '<p>Price: $' . htmlspecialchars($product->getPrice()) . '</p>';
                        echo '<p>SKU: ' . htmlspecialchars($product->getSku()) . '</p>';
                        echo '<p>Type: ' . htmlspecialchars($product->getType()) . '</p>';
                        echo $product->getSpecificFields();
                        echo '</div>';
                    }
                }
            } else {
                echo '<p>' . htmlspecialchars($result['message']) . '</p>';
            }
            ?>
        </div>
    </form>
    <script>
    document.getElementById('product-form').addEventListener('submit', function(event) {
        event.preventDefault(); 

        let formData = new FormData(this);
        let productIds = [];
        formData.forEach((value, key) => {
            if (key === 'product_ids[]') {
                productIds.push(value);
            }
        });


        fetch('delete_products.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ product_ids: productIds })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                window.location.href = 'products.php';
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    });
    </script>
</body>
</html>
