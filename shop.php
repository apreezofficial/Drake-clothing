<?php
include 'conn.php';
?>
<!DOCTYPE html>
<html lang="en" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drake Clothing Store - Shop</title>
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
            <div class="product-card group relative">
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
    <h3 class="text-lg font-medium text-black dark:text-white">
        <?= htmlspecialchars($row['product_name']) ?>
    </h3>
    <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">
        <?= htmlspecialchars($row['category']) ?>
    </p>
    <p class="text-black dark:text-white font-medium mt-2">
        $<?= number_format($row['price'], 2) ?>
    </p>

    <!-- View Button -->
    <a href="product.php?id=<?= $row['id'] ?>" class="inline-block mt-3 bg-black dark:bg-white text-white dark:text-black px-4 py-2 rounded-full text-sm font-medium hover:bg-gray-800 dark:hover:bg-gray-300 transition duration-300">
        View
    </a>
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