<?php
// Database Connection
require_once 'conn.php';

// Get All Collections that have at least one product
$collectionsQuery = "
    SELECT c.collection_id, c.name, COUNT(p.id) as product_count
    FROM collections c
    JOIN products p ON c.collection_id = p.collection_id
    GROUP BY c.collection_id
    HAVING product_count > 0
";
$collectionsResult = $conn->query($collectionsQuery);

// Fetch all products (for fast JS filtering)
$productsQuery = "SELECT * FROM products";
$productsResult = $conn->query($productsQuery);

$products = [];
if ($productsResult && $productsResult->num_rows > 0) {
    while ($row = $productsResult->fetch_assoc()) {
        $products[] = $row;
    }
}

// Get selected collection ID from URL if provided
$selectedId = isset($_GET['id']) ? intval($_GET['id']) : null;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Collections</title>
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
    <div class="max-w-7xl mx-auto">

        <h1 class="text-3xl font-bold mb-6 text-center">Collections</h1>

        <!-- Search Box -->
        <div class="mb-6">
            <input type="text" id="searchInput" placeholder="Search Collections..."
                class="w-full p-3 rounded-lg border border-gray-300 dark:border-gray-700 focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white">
        </div>

        <!-- Collections Grid -->
        <div id="collectionsGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            <?php if ($collectionsResult && $collectionsResult->num_rows > 0): ?>
                <?php while ($collection = $collectionsResult->fetch_assoc()): ?>
                    <div class="collection-card bg-white dark:bg-gray-800 p-4 rounded-lg shadow hover:scale-105 transform transition duration-300 cursor-pointer"
                        data-id="<?= $collection['collection_id'] ?>" data-name="<?= strtolower($collection['name']) ?>">
                        <h2 class="text-xl font-bold mb-2"><?= htmlspecialchars($collection['name']) ?></h2>
                        <p class="text-gray-500 dark:text-gray-400"><?= $collection['product_count'] ?> Products</p>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="col-span-4 text-center text-gray-500 dark:text-gray-400">No collections available.</p>
            <?php endif; ?>
        </div>

        <!-- Products Display -->
        <h2 class="text-2xl font-bold mb-4" id="productSectionTitle">Products</h2>
        <div id="productsGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Products will be dynamically inserted here -->
        </div>

    </div>

    <script>
        const allProducts = <?= json_encode($products) ?>;
        const selectedId = <?= $selectedId ?? 'null' ?>;

        const searchInput = document.getElementById('searchInput');
        const collectionCards = document.querySelectorAll('.collection-card');
        const productsGrid = document.getElementById('productsGrid');
        const productSectionTitle = document.getElementById('productSectionTitle');

        // Filter collections by search
        searchInput.addEventListener('input', () => {
            const searchValue = searchInput.value.toLowerCase();
            collectionCards.forEach(card => {
                const name = card.getAttribute('data-name');
                card.style.display = name.includes(searchValue) ? 'block' : 'none';
            });
        });

        // Display products for a specific collection
        function displayProductsByCollection(collectionId, collectionName = '') {
            productsGrid.innerHTML = '';
            const filteredProducts = allProducts.filter(product => product.collection_id == collectionId);

            if (filteredProducts.length === 0) {
                productsGrid.innerHTML = '<p class="text-gray-500 dark:text-gray-400 col-span-4 text-center">No products found in this collection.</p>';
                return;
            }

            productSectionTitle.innerText = `Products in Collection: ${collectionName}`;

            filteredProducts.forEach(product => {
                const productCard = document.createElement('div');
                productCard.className = 'bg-white dark:bg-gray-800 p-4 rounded-lg shadow hover:scale-105 transform transition duration-300';
                productCard.innerHTML = `
                    <img src="${product.image_url}" alt="${product.name}" class="w-full h-48 object-cover rounded-lg mb-3">
                    <h3 class="text-lg font-semibold mb-1">${product.name}</h3>
                    <p class="text-gray-500 dark:text-gray-400 mb-2">${product.category}</p>
                    <p class="text-black dark:text-white font-bold mb-3">$${parseFloat(product.price).toFixed(2)}</p>
                    <a href="product.php?id=${product.id}" class="inline-block bg-black dark:bg-white text-white dark:text-black px-4 py-2 rounded-full text-sm font-medium hover:bg-gray-800 dark:hover:bg-gray-300 transition duration-300">
                        View
                    </a>
                `;
                productsGrid.appendChild(productCard);
            });
        }

        // Click handler for each collection
        collectionCards.forEach(card => {
            card.addEventListener('click', () => {
                const collectionId = card.getAttribute('data-id');
                const collectionName = card.querySelector('h2').innerText;

                displayProductsByCollection(collectionId, collectionName);

                // Scroll to products section for mobile users
                productsGrid.scrollIntoView({ behavior: 'smooth' });
            });
        });

        // Auto-display products if ID is passed in URL
        if (selectedId !== null) {
            const selectedCard = document.querySelector(`.collection-card[data-id="${selectedId}"]`);
            if (selectedCard) {
                const collectionName = selectedCard.querySelector('h2').innerText;
                displayProductsByCollection(selectedId, collectionName);
            }
        }
    </script>

</body>

</html>