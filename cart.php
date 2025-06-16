<!DOCTYPE html>
<html lang="en">

<head>
      <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drake Clothing Store - <?= htmlspecialchars($product['product_name']) ?></title>
    <script src="/tailwind.js"></script>
    <link rel="stylesheet" href="includes/font-awesome/css/all.css">
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        drake: {
                            light: '#ffffff',
                            dark: '#000000',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-drake-light dark:bg-drake-dark min-h-screen">
<?php include './includes/nav.php'; ?>
<div style="height: 60px;"></div>

<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold text-center text-black dark:text-white mb-8">Your Cart</h1>

    <div id="cart-container" class="space-y-6">
        <!-- Cart items will be injected here -->
    </div>

    <div class="flex justify-center mt-10">
        <a href="checkout.php" class="bg-black dark:bg-white text-white dark:text-black px-6 py-3 rounded-full hover:bg-gray-800 dark:hover:bg-gray-300 transition duration-300">Proceed to Checkout</a>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const cartContainer = document.getElementById('cart-container');
    const cart = JSON.parse(localStorage.getItem('cart')) || {};

    function formatOptions(options) {
        if (!options || typeof options !== 'object' || Object.keys(options).length === 0) {
            return 'None';
        }

        const formatted = Object.entries(options).map(([key, value]) => {
            return `${capitalize(key)}: ${capitalize(value)}`;
        });

        return formatted.join(' | ');
    }

    function capitalize(str) {
        return str.charAt(0).toUpperCase() + str.slice(1);
    }

    function displayCart() {
        cartContainer.innerHTML = '';

        if (Object.keys(cart).length === 0) {
            cartContainer.innerHTML = '<p class="text-center text-gray-600 dark:text-gray-300 text-lg">Your cart is empty 😢</p>';
            return;
        }

        Object.keys(cart).forEach(productId => {
            const item = cart[productId];
            const cartItem = document.createElement('div');
            cartItem.className = 'flex flex-col md:flex-row items-center justify-between bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-lg mb-4';

            cartItem.innerHTML = `
                <div class="flex items-center space-x-4">
                    <img src="${item.image}" alt="${item.name}" class="w-24 h-24 object-cover rounded-lg hover:scale-105 transition duration-300">
                    <div>
                        <h2 class="text-xl font-bold text-black dark:text-white">${item.name}</h2>
                        <p class="text-gray-600 dark:text-gray-400">Price: $${parseFloat(item.price).toFixed(2)}</p>
                        <p class="text-gray-600 dark:text-gray-400">Quantity: ${item.quantity}</p>
                        <p class="text-gray-600 dark:text-gray-400">Options: ${formatOptions(item.options)}</p>
                    </div>
                </div>
                <button class="remove-btn bg-red-600 text-white px-4 py-2 rounded-full hover:bg-red-700 transition duration-300 mt-4 md:mt-0" data-id="${productId}">Remove</button>
            `;

            cartContainer.appendChild(cartItem);
        });
    }

    cartContainer.addEventListener('click', (e) => {
        if (e.target.classList.contains('remove-btn')) {
            const id = e.target.getAttribute('data-id');
            delete cart[id];
            localStorage.setItem('cart', JSON.stringify(cart));
            displayCart();
        }
    });

    displayCart();
});
</script>

<?php include './includes/footer.php'; ?>
</body>
</html>