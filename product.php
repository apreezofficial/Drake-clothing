<?php
require 'conn.php'; // make sure this has $conn

if (isset($_GET['id'])) {
    $productId = intval($_GET['id']);

    // Use mysqli_query directly
    $query = "SELECT * FROM products WHERE id = $productId";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);
    } else {
        echo "Product not found.";
        exit;
    }
} else {
    echo "Invalid product.";
    exit;
}
error_reporting(1);
?>
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

<body class="bg-drake-light dark:bg-drake-dark">
<?php include './includes/nav.php';?>
<div style="height:60px;"></div>
   <!-- Product Display -->
    <div class="container mx-auto p-4 grid grid-cols-1 md:grid-cols-2 gap-8 items-center">

        <!-- Product Image -->
        <div class="flex justify-center">
            <img src="<?= htmlspecialchars($product['product_image']) ?>" alt="<?= htmlspecialchars($product['product_name']) ?>" class="w-full max-w-md rounded-2xl shadow-lg hover:scale-105 transition duration-500">
        </div>

        <!-- Product Details -->
        <div class="space-y-4">

            <h1 class="text-3xl font-bold text-black dark:text-white"><?= htmlspecialchars($product['product_name']) ?></h1>
            <p class="text-gray-500 dark:text-gray-400 text-lg"><?= htmlspecialchars($product['category']) ?></p>
            <p class="text-black dark:text-white text-2xl font-semibold">$<?= number_format($product['price'], 2) ?></p>
            <p class="text-gray-600 dark:text-gray-300">
                <?= htmlspecialchars($product['description']) ?>
            </p>




<div class="cart-action flex items-center space-x-3 mt-6" data-product-id="<?= $product['id'] ?>">

    <!-- Minus Button -->
    <button class="minus-btn bg-black dark:bg-white text-white dark:text-black p-3 rounded-full flex items-center justify-center hover:bg-gray-800 dark:hover:bg-gray-300 transition duration-300">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4" />
        </svg>
    </button>

    <!-- Quantity Display -->
    <span class="quantity text-lg font-bold text-black dark:text-white">0</span>

    <!-- Plus Button -->
    <button class="plus-btn bg-black dark:bg-white text-white dark:text-black p-3 rounded-full flex items-center justify-center hover:bg-gray-800 dark:hover:bg-gray-300 transition duration-300">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
        </svg>
    </button>

    <!-- Cart Icon -->
    <button class="cart-btn bg-black dark:bg-white text-white dark:text-black p-3 rounded-full flex items-center justify-center hover:bg-gray-800 dark:hover:bg-gray-300 transition duration-300">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 4h12M9 21h0M15 21h0" />
        </svg>
    </button>

    <!-- Cancel Button -->
    <button class="cancel-btn hidden bg-red-600 text-white p-3 rounded-full flex items-center justify-center hover:bg-red-700 transition duration-300">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>

</div>
        </div>
    </div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    let cart = JSON.parse(localStorage.getItem('cart')) || {};

    function saveCart() {
        localStorage.setItem('cart', JSON.stringify(cart));
    }

    function updateProductDisplay() {
        const quantityDisplay = document.querySelector('.quantity');
        const cancelBtn = document.querySelector('.cancel-btn');
        const productId = "<?= $product['id'] ?>";

        if (cart[productId]) {
            quantityDisplay.textContent = cart[productId];
            cancelBtn.classList.remove('hidden');
        } else {
            quantityDisplay.textContent = '0';
            cancelBtn.classList.add('hidden');
        }
    }

    // Elements for this single product page
    const productId = "<?= $product['id'] ?>";
    const plusBtn = document.querySelector('.plus-btn');
    const minusBtn = document.querySelector('.minus-btn');
    const cancelBtn = document.querySelector('.cancel-btn');
    const cartBtn = document.querySelector('.cart-btn');

    // Initialize display
    updateProductDisplay();

    plusBtn.addEventListener('click', () => {
        cart[productId] = (cart[productId] || 0) + 1;
        saveCart();
        updateProductDisplay();
    });

    minusBtn.addEventListener('click', () => {
        if (cart[productId] > 1) {
            cart[productId] -= 1;
        } else {
            delete cart[productId];
        }
        saveCart();
        updateProductDisplay();
    });

    cancelBtn.addEventListener('click', () => {
        delete cart[productId];
        saveCart();
        updateProductDisplay();
    });

    cartBtn.addEventListener('click', () => {
        // Optional: Redirect to cart page or open modal
        window.location.href = 'cart.php'; // You can customize this
    });
});
</script>

</body>

</html>