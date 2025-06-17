<?php
require './conn.php';

$trackingID = '';
$product = null;
$error = '';

if (isset($_GET['tracking_id'])) {
    $trackingID = strtoupper(trim($_GET['tracking_id']));

    // Validate tracking ID prefix
    if (strpos($trackingID, 'DRK-') === 0) {
        $stmt = $conn->prepare("SELECT * FROM orders WHERE tracking_id = ?");
        $stmt->bind_param("s", $trackingID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $product = $result->fetch_assoc();
        } else {
            $error = "Tracking ID not found.";
        }
    } else {
        $error = "Invalid Tracking ID. It should start with 'DRK-'.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Your Order - Drake Clothing Store</title>
    <script src="/tailwind.js"></script>
    <link rel="stylesheet" href="includes/font-awesome/css/all.css">
</head>
<body class="bg-drake-light dark:bg-drake-dark min-h-screen flex items-center justify-center p-4">
    <div class="max-w-xl w-full bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg">
        <h1 class="text-3xl font-bold text-center text-black dark:text-white mb-6">Track Your Order</h1>

        <form action="track.php" method="GET" class="flex flex-col md:flex-row items-center gap-4 mb-6">
            <input type="text" name="tracking_id" placeholder="Enter Tracking ID (e.g. DRK-12345)"
                value="<?= htmlspecialchars($trackingID) ?>"
                class="w-full px-4 py-3 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white dark:bg-gray-700 dark:text-white" required>
            <button type="submit" class="bg-black dark:bg-white text-white dark:text-black px-6 py-3 rounded-full hover:bg-gray-800 dark:hover:bg-gray-300 transition duration-300">
                <i class="fas fa-search mr-2"></i> Search
            </button>
        </form>

        <?php if ($error): ?>
            <p class="text-center text-red-600 mb-4"><?= htmlspecialchars($error) ?></p>
        <?php elseif ($product): ?>
            <div class="text-center">
                <h2 class="text-2xl font-bold text-black dark:text-white mb-2"><?= htmlspecialchars($product['product_name']) ?></h2>
                <p class="text-gray-600 dark:text-gray-400 mb-1">Tracking ID: <?= htmlspecialchars($product['tracking_id']) ?></p>
                <p class="text-gray-600 dark:text-gray-400 mb-1">Order Status: <?= htmlspecialchars($product['order_status']) ?></p>
                <p class="text-gray-600 dark:text-gray-400 mb-1">Quantity: <?= htmlspecialchars($product['quantity']) ?></p>
                <p class="text-gray-600 dark:text-gray-400 mb-4">Ordered On: <?= htmlspecialchars($product['order_date']) ?></p>
                <img src="<?= htmlspecialchars($product['product_image']) ?>" alt="<?= htmlspecialchars($product['product_name']) ?>" class="mx-auto w-48 h-48 object-cover rounded-lg hover:scale-105 transition duration-300">
            </div>
        <?php endif; ?>
    </div>
</body>
</html>