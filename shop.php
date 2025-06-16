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
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 p-4">
    <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="product-card group relative bg-white dark:bg-gray-900 rounded-2xl overflow-hidden shadow-xl hover:shadow-2xl transform hover:scale-[1.02] transition duration-500">
                <!-- Product Image -->
                <div class="aspect-square bg-gray-100 dark:bg-gray-800 overflow-hidden relative">
                    <?php if (!empty($row['image_url'])): ?>
                        <img src="<?= $row['image_url'] ?>" alt="<?= htmlspecialchars($row['product_name']) ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                    <?php else: ?>
                        <div class="w-full h-full flex items-center justify-center bg-gray-200 dark:bg-gray-700 transition-transform duration-700 group-hover:scale-110">
                            <span class="text-gray-400 dark:text-gray-500">Product Image</span>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Glass Overlay -->
                    <div class="absolute inset-0 bg-black/30 dark:bg-black/40 opacity-0 group-hover:opacity-100 backdrop-blur-sm transition duration-500 flex items-center justify-center">
                        <a href="product.php?id=<?= $row['id'] ?>" class="bg-white dark:bg-black text-black dark:text-white px-5 py-2 rounded-full text-sm font-semibold transform translate-y-10 group-hover:translate-y-0 transition duration-500 ease-in-out hover:bg-gray-200 dark:hover:bg-gray-800">
                            View Product
                        </a>
                    </div>
                </div>

                <!-- Product Details -->
                <div class="mt-4 px-4 pb-4 text-center">
                    <h3 class="text-lg font-bold text-black dark:text-white truncate">
                        <?= htmlspecialchars($row['product_name']) ?>
                    </h3>
                    <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">
                        <?= htmlspecialchars($row['category']) ?>
                    </p>
                    <p class="text-black dark:text-white font-semibold mt-2 text-lg">
                        $<?= number_format($row['price'], 2) ?>
                    </p>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p class="col-span-4 text-center text-gray-500 dark:text-gray-400">No products available.</p>
    <?php endif; ?>
</div>
</section>
<?php include './includes/footer.php';?>
</body>
</html>