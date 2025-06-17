<?php
include 'conn.php';

// Handle AJAX Request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $trackingID = strtoupper(trim($_POST['tracking_id']));
    $response = ['success' => false, 'message' => 'Order not found.'];

    if (strpos($trackingID, 'DRK-') === 0) {
        $stmt = $conn->prepare("SELECT * FROM orders WHERE tracking_id = ?");
        $stmt->bind_param("s", $trackingID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $order = $result->fetch_assoc();
            $response = ['success' => true, 'order' => $order];
        } else {
            $response['message'] = "Order with Tracking ID <strong>{$trackingID}</strong> not found.";
        }
    } else {
        $response['message'] = "Invalid Tracking ID. It must start with 'DRK-'.";
    }

    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Track Your Order - Drake Clothing Store</title>
    <script src="/tailwind.js"></script>
    <link rel="stylesheet" href="includes/font-awesome/css/all.css">
    <script>
        tailwind.config = { darkMode: 'class' }
    </script>
</head>
<body class="bg-gray-100 dark:bg-gray-900 min-h-screen flex items-center justify-center p-4">

<div class="max-w-xl w-full bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg">
    <h1 class="text-3xl font-bold text-center text-black dark:text-white mb-6">Track Your Order</h1>

    <div class="flex flex-col md:flex-row items-center gap-4 mb-6">
        <div class="flex items-center w-full">
            <span class="bg-gray-200 dark:bg-gray-700 px-4 py-3 rounded-l-full text-gray-600 dark:text-gray-400 select-none">DRK-</span>
            <input type="text" id="trackingInput" placeholder="Enter Batch ID (e.g. 12345)"
                   class="w-full px-4 py-3 rounded-r-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white dark:bg-gray-700 dark:text-white" required>
        </div>
        <button id="trackBtn" class="bg-black dark:bg-white text-white dark:text-black px-6 py-3 rounded-full hover:bg-gray-800 dark:hover:bg-gray-300 transition duration-300">
            <i class="fas fa-search mr-2"></i> Search
        </button>
    </div>

    <div id="result" class="text-center"></div>
</div>

<script>
    document.getElementById('trackBtn').addEventListener('click', function () {
        const idPart = document.getElementById('trackingInput').value.trim();
        const trackingID = `DRK-${idPart}`;

        if (idPart === '') {
            document.getElementById('result').innerHTML = `<p class="text-red-600 mb-4">Please enter the tracking ID.</p>`;
            return;
        }

        fetch('order-tracker.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `tracking_id=${encodeURIComponent(trackingID)}`
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const order = data.order;
                    displayOrder(order);
                } else {
                    document.getElementById('result').innerHTML = `<p class="text-red-600 mb-4">${data.message}</p>`;
                }
            });
    });

    function displayOrder(order) {
        const statusList = ['Pending', 'Approved', 'In Transit', 'Delivered'];
        const currentStatusIndex = statusList.indexOf(order.order_status);

        let steps = statusList.map((status, index) => {
            let baseClass = 'flex-1 px-4 py-2 rounded-full text-white text-center';
            let activeClass = index <= currentStatusIndex ? 'bg-green-600' : 'bg-gray-300 dark:bg-gray-600';
            return `<div class="${baseClass} ${activeClass}">${status}</div>`;
        }).join('<div class="flex-1 border-t-4 border-gray-300 dark:border-gray-600 mx-2"></div>');

        document.getElementById('result').innerHTML = `
            <div class="mb-6">
                <h2 class="text-xl font-bold text-black dark:text-white mb-2">Order Details</h2>
                <p class="text-gray-700 dark:text-gray-300 mb-1"><strong>Tracking ID:</strong> ${order.tracking_id}</p>
                <p class="text-gray-700 dark:text-gray-300 mb-1"><strong>Batch:</strong> ${order.product_name}</p>
                <p class="text-gray-700 dark:text-gray-300 mb-1"><strong>Quantity:</strong> ${order.quantity}</p>
                <p class="text-gray-700 dark:text-gray-300 mb-1"><strong>Status:</strong> ${order.order_status}</p>
            </div>

            <div class="flex items-center justify-between mb-4">
                ${steps}
            </div>
        `;
    }
</script>

</body>
</html>