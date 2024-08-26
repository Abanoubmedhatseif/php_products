<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Product</title>
    <link rel="stylesheet" href="styles/add_product.css">
</head>
<body>
    <div class="header-buttons">
        <button type="button" onclick="validateForm()" class="button save-button">Save</button>
        <a href="products.php" class="button cancel-button">Cancel</a>
    </div>
    
    <h1>Add New Product</h1>
    <form id="product_form" method="post" action="add_product_action.php">
        <label for="sku">SKU:</label>
        <input type="text" id="sku" name="sku" required>
        <div id="sku-error" class="error-message" style="color: red;"></div>

        <label for="name">Product Name:</label>
        <input type="text" id="name" name="name" required>
        <div id="name-error" class="error-message" style="color: red;"></div>
        
        <label for="price">Price:</label>
        <input type="number" id="price" name="price" step="0.01" required>
        <div id="price-error" class="error-message" style="color: red;"></div>

        <label for="type">Type:</label>
        <select id="productType" name="type" required>
            <option value="" disabled selected>Select a type</option>
            <option value="Book">Book</option>
            <option value="DVD">DVD</option>
            <option value="Furniture">Furniture</option>
        </select>
        <div id="type-error" class="error-message" style="color: red;"></div>
        
        <div id="product-specific-fields"></div>
    </form>

    <script>
        function getQueryParams() {
            const params = {};
            window.location.search.substring(1).split('&').forEach(function(part) {
                const item = part.split('=');
                params[decodeURIComponent(item[0])] = decodeURIComponent(item[1]);
            });
            return params;
        }

        function displayError() {
            const params = getQueryParams();
            if (params.error) {
                document.getElementById('sku-error').innerText = 'SKU already exists';
            }
        }

        displayError();

        const productTypeConfig = {
            'Book': {
                fields: '<label for="weight">Weight (kg)</label><input type="number" id="weight" name="weight" step="0.01" required><div id="weight-error" class="error-message" style="color: red;"></div>',
                validate: () => document.getElementById('weight')?.value.trim() !== ''
            },
            'DVD': {
                fields: '<label for="size">Size (MB)</label><input type="number" id="size" name="size" required><div id="size-error" class="error-message" style="color: red;"></div>',
                validate: () => document.getElementById('size')?.value.trim() !== ''
            },
            'Furniture': {
                fields: '<label for="length">Length (cm)</label><input type="number" id="length" name="length" required><div id="length-error" class="error-message" style="color: red;"></div>' +
                        '<label for="width">Width (cm)</label><input type="number" id="width" name="width" required><div id="width-error" class="error-message" style="color: red;"></div>' +
                        '<label for="height">Height (cm)</label><input type="number" id="height" name="height" required><div id="height-error" class="error-message" style="color: red;"></div>',
                validate: () => 
                    document.getElementById('length')?.value.trim() !== '' &&
                    document.getElementById('width')?.value.trim() !== '' &&
                    document.getElementById('height')?.value.trim() !== ''
            }
        };

        document.getElementById('productType').addEventListener('change', function() {
            const type = this.value;
            const config = productTypeConfig[type];
            const fieldsContainer = document.getElementById('product-specific-fields');
            fieldsContainer.innerHTML = config ? config.fields : '';
        });

        function validateForm() {
            const form = document.getElementById('product_form');
            const sku = document.getElementById('sku').value.trim();
            const name = document.getElementById('name').value.trim();
            const price = document.getElementById('price').value.trim();
            const type = document.getElementById('productType').value;
            const fieldsContainer = document.getElementById('product-specific-fields');
            let isValid = true;

            document.querySelectorAll('.error-message').forEach(el => el.innerText = '');

            if (!sku) {
                document.getElementById('sku-error').innerText = 'Please provide the SKU.';
                isValid = false;
            }
            if (!name) {
                document.getElementById('name-error').innerText = 'Please provide the product name.';
                isValid = false;
            }
            if (!price) {
                document.getElementById('price-error').innerText = 'Please provide the price.';
                isValid = false;
            }
            if (!type) {
                document.getElementById('type-error').innerText = 'Please select a product type.';
                isValid = false;
            }

            const config = productTypeConfig[type];
            if (config) {
                isValid = config.validate();
                if (!isValid) {
                    const specificFields = fieldsContainer.querySelectorAll('input');
                    specificFields.forEach(field => {
                        if (!field.value.trim()) {
                            document.getElementById(`${field.id}-error`).innerText = `Please provide the ${field.previousElementSibling.innerText.toLowerCase()}.`;
                        }
                    });
                }
            }

            if (isValid) {
                form.submit();
            }
        }
    </script>
</body>
</html>
