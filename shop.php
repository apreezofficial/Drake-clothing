<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'conn.php';
?>

<!DOCTYPE html>
<html lang="en" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drake Clothing Store</title>
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
<!-- Best Sellers Section -->
<section class="py-20 bg-gray-50 dark:bg-gray-900 border-t border-gray-200 dark:border-gray-800">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Section Header -->
    <div class="text-center mb-16">
  <span class="text-xs uppercase tracking-widest text-gray-500 dark:text-gray-400 mb-2 block">Curated Styles</span>
  <h2 class="text-3xl sm:text-4xl font-bold text-black dark:text-white mb-4">Explore Our Latest Collections</h2>
  <div class="w-20 h-px bg-black dark:bg-white mx-auto"></div>
</div>
    <?php

// Fetch products from DB
$sql = "SELECT * FROM products ORDER BY created_at DESC"; 
$result = $conn->query($sql);
?>

<!-- Product Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
    <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="group relative">
                <div class="aspect-square bg-gray-100 dark:bg-gray-800 overflow-hidden">
                    <?php if (!empty($row['image_url'])): ?>
                        <img src="<?= $row['image_url'] ?>" alt="<?= htmlspecialchars($row['product_name']) ?>" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                    <?php else: ?>
                        <div class="w-full h-full flex items-center justify-center bg-gray-200 dark:bg-gray-700 transition-transform duration-500 group-hover:scale-105">
                            <span class="text-gray-400 dark:text-gray-500">Product Image</span>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="mt-4">
                    <h3 class="text-lg font-medium text-black dark:text-white"><?= htmlspecialchars($row['product_name']) ?></h3>
                    <p class="text-gray-500 dark:text-gray-400 text-sm mt-1"><?= htmlspecialchars($row['category']) ?></p>
                    <p class="text-black dark:text-white font-medium mt-2">$<?= number_format($row['price'], 2) ?></p>
                </div>
<!-- Cart Action Area -->
<div class="cart-action absolute bottom-20 right-4 flex items-center space-x-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300" data-product-id="<?= $row['id'] ?>">

    <!-- Minus Button -->
    <button class="minus-btn bg-black dark:bg-white text-white dark:text-black p-2 rounded-full flex items-center justify-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4" />
        </svg>
    </button>

    <!-- Quantity Display -->
    <span class="quantity text-black dark:text-white font-bold">0</span>

    <!-- Plus Button -->
    <button class="plus-btn bg-black dark:bg-white text-white dark:text-black p-2 rounded-full flex items-center justify-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
        </svg>
    </button>

    <!-- Cart Icon -->
    <button class="cart-btn bg-black dark:bg-white text-white dark:text-black p-2 rounded-full flex items-center justify-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 4h12M9 21h0M15 21h0" />
        </svg>
    </button>

    <!-- Cancel Button -->
    <button class="cancel-btn hidden bg-red-600 text-white p-2 rounded-full flex items-center justify-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>

</div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p class="col-span-4 text-center text-gray-500 dark:text-gray-400">No products available.</p>
    <?php endif; ?>
</div>
  </div>
</section>
<?php include './includes/footer.php';?>
</body>
</html>