<?php
require 'conn.php';
if (isset($_GET['id'])) {
    $productId = intval($_GET['id']);

    // Use mysqli_query directly
    $query = "SELECT * FROM products WHERE id = $productId";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);
    } else {
        echo "
        <!DOCTYPE html>
        <head>
              <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    </head>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const isDarkMode = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;

        Swal.fire({
            toast: true,
            position: 'top',
            icon: 'error',
            title: 'Product Not found',
            showConfirmButton: false,
            timer: 2500,
            timerProgressBar: true,
            background: isDarkMode ? '#1F2937' : '#FEE2E2', // Dark: gray-800, Light: red-100
            color: isDarkMode ? '#F3F4F6' : '#991B1B',       // Dark: gray-100, Light: red-800
            customClass: {
                popup: 'rounded-2xl px-4 py-3 md:px-6 md:py-4 shadow-lg text-sm md:text-base',
                timerProgressBar: 'bg-red-500'
            },
            didOpen: (toast) => {
                toast.style.width = '90%'; // Mobile width
                toast.style.maxWidth = '400px'; // Max width for larger screens
            }
        }).then(() => {
            window.location.href = 'index.php';
        });
    });
</script>";
        exit;
    }
} else {
    echo "        <!DOCTYPE html>
        <head>
              <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    </head>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const isDarkMode = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;

        Swal.fire({
            toast: true,
            position: 'top',
            icon: 'error',
            title: 'Invalid Product',
            showConfirmButton: false,
            timer: 2500,
            timerProgressBar: true,
            background: isDarkMode ? '#1F2937' : '#FEE2E2', // Dark: gray-800, Light: red-100
            color: isDarkMode ? '#F3F4F6' : '#991B1B',       // Dark: gray-100, Light: red-800
            customClass: {
                popup: 'rounded-2xl px-4 py-3 md:px-6 md:py-4 shadow-lg text-sm md:text-base',
                timerProgressBar: 'bg-red-500'
            },
            didOpen: (toast) => {
                toast.style.width = '90%'; // Mobile width
                toast.style.maxWidth = '400px'; // Max width for larger screens
            }
        }).then(() => {
            window.location.href = 'index.php';
        });
    });
</script>";
    exit;
}
error_reporting(1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
      <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drake Clothing Store | <?= htmlspecialchars($product['name']) ?></title>
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
            <img src="<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="w-full max-w-md rounded-2xl shadow-lg hover:scale-105 transition duration-500">
        </div>

        <!-- Product Details -->
        <div class="space-y-4">
            <h1 class="text-3xl font-bold text-black dark:text-white"><?= htmlspecialchars($product['name']) ?></h1>
            <p class="text-gray-500 dark:text-gray-400 text-lg"><?= htmlspecialchars($product['category']) ?></p>
            <p class="text-black dark:text-white text-2xl font-semibold">₦<?= number_format($product['price'], 2) ?></p>
            <p class="text-gray-600 dark:text-gray-300">
                <?= htmlspecialchars($product['description']) ?>
            </p>
<?php
$tags = json_decode($product['tags'], true);
?>
<div id="tag-selectors" class="space-y-4 mt-4">
    <?php foreach ($tags as $tagType => $tagOptions): ?>
        <div>
            <label class="block mb-2 font-semibold text-black dark:text-white"><?= ucfirst($tagType) ?> Available:</label>
            <select class="tag-select p-2 rounded border w-full dark:bg-gray-800 dark:text-white" data-tag-type="<?= htmlspecialchars($tagType) ?>">
                <option value="">Select <?= ucfirst($tagType) ?></option>
                <?php foreach ($tagOptions as $option): ?>
                    <option value="<?= htmlspecialchars($option) ?>"><?= htmlspecialchars($option) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    <?php endforeach; ?>
</div>
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
            quantityDisplay.textContent = cart[productId].quantity;
            cancelBtn.classList.remove('hidden');
        } else {
            quantityDisplay.textContent = '0';
            cancelBtn.classList.add('hidden');
        }
    }

    // Initialize display
    updateProductDisplay();

    const productId = "<?= $product['id'] ?>";
    const plusBtn = document.querySelector('.plus-btn');
    const minusBtn = document.querySelector('.minus-btn');
    const cancelBtn = document.querySelector('.cancel-btn');
    const cartBtn = document.querySelector('.cart-btn');

    // 🏷️ Handle Tag Selections
    let userOptions = {};
    const tagSelectors = document.querySelectorAll('.tag-select');
    tagSelectors.forEach(select => {
        select.addEventListener('change', () => {
            const tagType = select.getAttribute('data-tag-type');
            const selectedValue = select.value;

            userOptions[tagType] = selectedValue;
        });
    });

    // 🎯 Format User Message
    function formatUserMessage(options) {
        const messages = [];

        for (let [key, value] of Object.entries(options)) {
            if (value) {
                messages.push(`${key}-${value}`);
            }
        }

        return messages.join(' and ');
    }

    plusBtn.addEventListener('click', () => {
        cart[productId] = cart[productId] || {
            name: "<?= htmlspecialchars($product['name']) ?>",
            price: "<?= $product['price'] ?>",
            image: "<?= htmlspecialchars($product['image_url']) ?>",
            quantity: 0,
            options: {}
        };

        cart[productId].quantity += 1;

        // Save the latest selected options
        cart[productId].options = userOptions;

        saveCart();
        updateProductDisplay();
    });

    minusBtn.addEventListener('click', () => {
        if (cart[productId] && cart[productId].quantity > 1) {
            cart[productId].quantity -= 1;
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
        window.location.href = 'cart.php';
    });
});

</script>
</body>

</html>