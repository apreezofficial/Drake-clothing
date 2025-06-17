<?php
require 'conn.php';

if (!isset($_GET['tracking_id'])) {
    echo "Invalid Request!";
    exit();
}

$trackingId = $_GET['tracking_id'];

// Fetch order details
$stmt = $conn->prepare("SELECT * FROM orders WHERE tracking_id = ?");
$stmt->bind_param("s", $trackingId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Order not found!";
    exit();
}

$order = $result->fetch_assoc();
$cartItems = json_decode($order['batch'], true);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Payment - APStore</title>
    <script src="https://js.paystack.co/v1/inline.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="bg-white shadow-lg rounded-2xl p-6 max-w-2xl w-full">
        <h1 class="text-2xl font-bold text-center mb-6 text-blue-600">Order Payment</h1>

        <div class="mb-4">
            <p class="text-gray-700"><span class="font-semibold">Tracking ID:</span> <?php echo htmlspecialchars($order['tracking_id']); ?></p>
            <p class="text-gray-700"><span class="font-semibold">Customer:</span> <?php echo htmlspecialchars($order['full_name']); ?></p>
            <p class="text-gray-700"><span class="font-semibold">Email:</span> <?php echo htmlspecialchars($order['email']); ?></p>
            <p class="text-gray-700"><span class="font-semibold">Phone:</span> <?php echo htmlspecialchars($order['phone']); ?></p>
            <p class="text-gray-700"><span class="font-semibold">Address:</span> <?php echo htmlspecialchars($order['address']); ?></p>
        </div>

        <h2 class="text-xl font-semibold mb-4 text-gray-800">Order Details</h2>

        <div class="space-y-4 max-h-64 overflow-y-auto">
            <?php foreach ($cartItems as $item): ?>
                <div class="flex items-center justify-between border-b pb-2">
                    <div>
                        <p class="font-medium text-gray-900"><?php echo htmlspecialchars($item['name']); ?></p>
                        <p class="text-sm text-gray-600">Quantity: <?php echo intval($item['quantity']); ?></p>
                    </div>
                    <p class="font-semibold text-green-600">₦<?php echo number_format($item['price'], 2); ?></p>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="mt-6 text-lg">
            <p class="flex justify-between"><span>Delivery Fee:</span> <span class="font-semibold text-blue-600">₦<?php echo number_format($order['delivery_price'], 2); ?></span></p>
            <p class="flex justify-between"><span>Total Price:</span> <span class="font-semibold text-green-600">₦<?php echo number_format($order['total_price'], 2); ?></span></p>
        </div>

        <button onclick="payWithPaystack()" class="w-full mt-6 bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-semibold">Proceed to Payment</button>
    </div>

    <script>
        function payWithPaystack() {
            let handler = PaystackPop.setup({
                key: 'YOUR_PUBLIC_KEY', // Replace with your Paystack public key
                email: '<?php echo $order['email']; ?>',
                amount: <?php echo ($order['total_price'] * 100); ?>, // Paystack uses kobo
                currency: 'NGN',
                ref: '<?php echo $order['tracking_id']; ?>',
                callback: function(response) {
                    // Payment was successful
                    fetch('update_order_status.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({
                            tracking_id: '<?php echo $order['tracking_id']; ?>',
                            status: 'processing'
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            alert('Payment successful! Your order is now processing.');
                            window.location.href = 'index.php';
                        } else {
                            alert('Payment successful, but failed to update order status.');
                        }
                    })
                    .catch(err => {
                        alert('Payment was successful, but an error occurred while updating the order.');
                    });
                },
                onClose: function() {
                    alert('Transaction cancelled.');
                }
            });
            handler.openIframe();
        }
    </script>

</body>
</html>