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
      <span class="text-xs uppercase tracking-widest text-gray-500 dark:text-gray-400 mb-2 block">Most Coveted</span>
      <h2 class="text-3xl sm:text-4xl font-bold text-black dark:text-white mb-4">BEST SELLERS</h2>
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
                <!-- Quick add to cart (appears on hover) -->
                <form method="POST" action="add_to_cart.php">
                    <input type="hidden" name="product_id" value="<?= $row['id'] ?>">
                    <button type="submit" class="absolute bottom-20 right-4 bg-black dark:bg-white text-white dark:text-black px-3 py-2 text-xs uppercase tracking-wider opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        Quick Add
                    </button>
                </form>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p class="col-span-4 text-center text-gray-500 dark:text-gray-400">No products available.</p>
    <?php endif; ?>
</div>

    <!-- View All Button -->
    <div class="text-center mt-16">
      <a href="/shop" class="inline-block border-b border-black dark:border-white text-black dark:text-white pb-1 font-medium uppercase tracking-wider text-sm hover:opacity-80 transition-opacity">
        View All Products →
      </a>
    </div>
  </div>
</section>
<?php include './includes/footer.php';?>
</body>
</html>