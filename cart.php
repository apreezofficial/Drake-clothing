<?php
require 'conn.php';

// Fetch product prices from the database
$stmt = $conn->prepare("SELECT id, name, price FROM products");
$stmt->execute();
$result = $stmt->get_result();

$productPrices = [];
while ($row = $result->fetch_assoc()) {
    $productPrices[$row['id']] = [
        'name' => $row['name'],
        'price' => $row['price']
    ];
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $address = htmlspecialchars($_POST['address']);
    $phone = htmlspecialchars($_POST['phone']);
    $cartData = json_decode($_POST['cartData'], true);

    $deliveryPrice = 4000;
    $totalPrice = $deliveryPrice;

    // Fetch product prices from DB
    $productPrices = [];
    $result = $conn->query("SELECT id, price FROM products");
    while ($row = $result->fetch_assoc()) {
        $productPrices[$row['id']] = $row['price'];
    }

    // Validate cart items and calculate total price
    foreach ($cartData as $item) {
        $productId = $item['id'];
        $quantity = intval($item['quantity']);

        if (!isset($productPrices[$productId])) {
            echo "<script>alert('Invalid product detected!'); window.location.href = 'cart.php';</script>";
            exit();
        }

        $realPrice = floatval($productPrices[$productId]);
        $totalPrice += $realPrice * $quantity;
    }

    $batchData = json_encode($cartData);

    // Insert order to get auto-increment ID
    $stmt = $conn->prepare("INSERT INTO orders (tracking_id, phone, full_name, email, address, batch, delivery_price, total_price) VALUES (1, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssid", $phone, $name, $email, $address, $batchData, $deliveryPrice, $totalPrice);

    if ($stmt->execute()) {
        $orderId = $stmt->insert_id; // Get the inserted row ID

        // Generate Tracking ID: {rowId}{random_number}{random_letter}{random_number}
        $randomNum1 = rand(10, 99);
        $randomLetter = chr(rand(65, 90)); // A-Z
        $randomNum2 = rand(10, 99);
        $trackingId = "DRK-{$orderId}{$randomNum1}{$randomLetter}{$randomNum2}";

        // Update order with tracking ID
        $updateStmt = $conn->prepare("UPDATE orders SET tracking_id = ? WHERE id = ?");
        $updateStmt->bind_param("si", $trackingId, $orderId);
        $updateStmt->execute();

        echo "<script>
                localStorage.removeItem('cart');
                alert('Order placed successfully!\\nTracking ID: {$trackingId}');
                window.location.href = 'index.php';
              </script>";
        exit();
    } else {
        echo "<script>alert('Failed to place order!'); window.location.href = 'cart.php';</script>";
    }
}
?>

<script>
    const realPrices = <?php echo json_encode($productPrices); ?>;
</script>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drake Clothing Store - Cart</title>
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

    <div id="cart-container" class="space-y-6"></div>

    <div class="flex justify-center mt-10">
        <button id="checkout-btn" class="bg-black dark:bg-white text-white dark:text-black px-6 py-3 rounded-full hover:bg-gray-800 dark:hover:bg-gray-300 transition duration-300">Proceed to Checkout</button>
    </div>

    <div id="checkout-form" class="hidden mt-10 max-w-lg mx-auto bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-lg">
        <h2 class="text-2xl font-bold mb-6 text-black dark:text-white">Checkout</h2>
        <form method="POST" id="orderForm">
            <div class="mb-4">
                <label class="block text-black dark:text-white mb-2" for="name">Name</label>
                <input class="w-full p-3 rounded-lg bg-gray-100 dark:bg-gray-700 dark:text-white" type="text" name="name" id="name" required>
            </div>
            <div class="mb-4">
                <label class="block text-black dark:text-white mb-2" for="email">Email</label>
                <input class="w-full p-3 rounded-lg bg-gray-100 dark:bg-gray-700 dark:text-white" type="email" name="email" id="email" required>
            </div>
                      <div class="mb-4">
                <label class="block text-black dark:text-white mb-2" for="phone">Name</label>
                <input class="w-full p-3 rounded-lg bg-gray-100 dark:bg-gray-700 dark:text-white" type="text" name="phone" id="phone" required>
            </div>
            <div class="mb-4">
                <label class="block text-black dark:text-white mb-2" for="address">Address</label>
                <textarea class="w-full p-3 rounded-lg bg-gray-100 dark:bg-gray-700 dark:text-white" name="address" id="address" required></textarea>
            </div>
            <input type="hidden" name="cartData" id="cartData">
            <button type="submit" class="bg-green-600 text-white px-6 py-3 rounded-full hover:bg-green-700 transition duration-300">Place Order</button>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const cartContainer = document.getElementById('cart-container');
    const checkoutBtn = document.getElementById('checkout-btn');
    const checkoutForm = document.getElementById('checkout-form');
    const cartDataInput = document.getElementById('cartData');

    let cart = JSON.parse(localStorage.getItem('cart')) || {};

    function formatOptions(options) {
        if (!options || typeof options !== 'object' || Object.keys(options).length === 0) {
            return 'None';
        }
        return Object.entries(options).map(([key, value]) => `${capitalize(key)}: ${capitalize(value)}`).join(' | ');
    }

    function capitalize(str) {
        return str.charAt(0).toUpperCase() + str.slice(1);
    }

    function displayCart() {
        cartContainer.innerHTML = '';
        if (Object.keys(cart).length === 0) {
            cartContainer.innerHTML = '<p class="text-center text-gray-600 dark:text-gray-300 text-lg">Your cart is empty 😢</p>';
            checkoutBtn.classList.add('hidden');
            return;
        }

        Object.keys(cart).forEach(productId => {
            const item = cart[productId];
            const realPrice = realPrices[productId] ? parseFloat(realPrices[productId].price).toFixed(2) : '0.00';
            item.price = realPrice; // Force update cart price to real price

            const cartItem = document.createElement('div');
            cartItem.className = 'flex flex-col md:flex-row items-center justify-between bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-lg mb-4';

            cartItem.innerHTML = `
                <div class="flex items-center space-x-4">
                    <img src="${item.image}" alt="${item.name}" class="w-24 h-24 object-cover rounded-lg hover:scale-105 transition duration-300">
                    <div>
                        <h2 class="text-xl font-bold text-black dark:text-white">${item.name}</h2>
                        <p class="text-gray-600 dark:text-gray-400">Price: ₦${realPrice}</p>
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

    checkoutBtn.addEventListener('click', () => {
        checkoutForm.classList.remove('hidden');
        checkoutBtn.classList.add('hidden');

        const cartArray = Object.keys(cart).map(productId => {
            return {
                id: productId,
                name: cart[productId].name,
                price: cart[productId].price,
                quantity: cart[productId].quantity,
                options: cart[productId].options,
                image: cart[productId].image
            };
        });
        cartDataInput.value = JSON.stringify(cartArray);
    });

    displayCart();
});
</script>

<?php include './includes/footer.php'; ?>
</body>
</html>