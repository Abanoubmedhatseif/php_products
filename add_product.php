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
                fields: [
                    { id: 'weight', label: 'Weight (kg)', type: 'number', step: '0.01' }
                ],
                validate: () => checkFields(['weight'])
            },
            'DVD': {
                fields: [
                    { id: 'size', label: 'Size (MB)', type: 'number' }
                ],
                validate: () => checkFields(['size'])
            },
            'Furniture': {
                fields: [
                    { id: 'length', label: 'Length (cm)', type: 'number' },
                    { id: 'width', label: 'Width (cm)', type: 'number' },
                    { id: 'height', label: 'Height (cm)', type: 'number' }
                ],
                validate: () => checkFields(['length', 'width', 'height'])
            }
        };

        function renderFields(type) {
            const config = productTypeConfig[type];
            const fieldsContainer = document.getElementById('product-specific-fields');
            if (!config) return;

            fieldsContainer.innerHTML = config.fields.map(field => `
                <label for="${field.id}">${field.label}</label>
                <input type="${field.type}" id="${field.id}" name="${field.id}" ${field.step ? `step="${field.step}"` : ''} required>
                <div id="${field.id}-error" class="error-message" style="color: red;"></div>
            `).join('');
        }

        document.getElementById('productType').addEventListener('change', function() {
            renderFields(this.value);
        });

        function checkFields(fields) {
            let isValid = true;
            fields.forEach(field => {
                const fieldValue = document.getElementById(field)?.value.trim();
                if (!fieldValue) {
                    document.getElementById(`${field}-error`).innerText = `Please provide the ${field}.`;
                    isValid = false;
                }
            });
            return isValid;
        }

        function validateForm() {
            const form = document.getElementById('product_form');
            const requiredFields = ['sku', 'name', 'price'];
            let isValid = true;

            document.querySelectorAll('.error-message').forEach(el => el.innerText = '');

            requiredFields.forEach(field => {
                if (!document.getElementById(field).value.trim()) {
                    document.getElementById(`${field}-error`).innerText = `Please provide the ${field}.`;
                    isValid = false;
                }
            });

            const type = document.getElementById('productType').value;
            if (!type) {
                document.getElementById('type-error').innerText = 'Please select a product type.';
                isValid = false;
            } else {
                const config = productTypeConfig[type];
                if (config) {
                    isValid = config.validate() && isValid;
                }
            }

            if (isValid) {
                form.submit();
            }
        }
    </script>
</body>
</html>
