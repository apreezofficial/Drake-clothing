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
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Order Tracker</title>
    <script src="/tailwind.js"></script>
    <link rel="stylesheet" href="includes/font-awesome/css/all.css">
    <script>
        tailwind.config = { darkMode: 'class' }
    </script>
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

    <div class="max-w-3xl w-full mx-auto bg-white dark:bg-black p-8 rounded-3xl shadow-2xl transition-all duration-500">
        <h1 class="text-4xl font-extrabold text-center text-black dark:text-white mb-8 tracking-wide">Order Tracking</h1>

        <div class="flex flex-col md:flex-row items-center gap-4 mb-8">
            <div class="flex items-center w-full">
                <span class="bg-gray-300 dark:bg-gray-700 px-5 py-3 rounded-l-full text-gray-700 dark:text-gray-300 text-lg select-none font-medium">DRK-</span>
                <input type="text" id="trackingInput" placeholder="Enter Tracking Number (e.g. 12345)"
                    class="w-full px-5 py-3 rounded-r-full border border-gray-300 focus:outline-none focus:ring-4 focus:ring-black dark:focus:ring-white dark:bg-gray-700 dark:text-white text-lg transition-all duration-300" required>
            </div>
            <button id="trackBtn" class="bg-black dark:bg-white text-white dark:text-black px-7 py-3 rounded-full hover:bg-gray-800 dark:hover:bg-gray-300 active:scale-95 transition-all duration-300 flex items-center gap-2">
                <i class="fas fa-search"></i> <span class="font-semibold">Track</span>
            </button>
        </div>

        <div id="result" class="text-center"></div>
    </div>
    <script>
        document.getElementById('trackBtn').addEventListener('click', function () {
            const idPart = document.getElementById('trackingInput').value.trim();
            const trackingID = `DRK-${idPart}`;

            if (idPart === '') {
                document.getElementById('result').innerHTML = `<p class="text-red-600 mb-4 text-lg">Please enter the tracking number.</p>`;
                return;
            }

            fetch('track.php', {
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
                        document.getElementById('result').innerHTML = `<p class="text-red-600 mb-4 text-lg">${data.message}</p>`;
                    }
                })
                .catch(error => {
                    document.getElementById('result').innerHTML = `<p class="text-red-600 mb-4 text-lg">An error occurred. Please try again later.</p>`;
                    console.error('Error:', error);
                });
        });

        function displayOrder(order) {
            const statusList = ['Pending', 'Approved', 'In Transit', 'Delivered'];
            const statusIcons = ['fas fa-clock', 'fas fa-check-circle', 'fas fa-truck', 'fas fa-box-open'];
            const currentStatusIndex = statusList.indexOf(order.order_status);

            let steps = statusList.map((status, index) => {
                let baseClass = 'flex flex-col items-center text-center flex-1 relative';
                let iconClass = index <= currentStatusIndex ? 'text-green-500' : 'text-gray-400 dark:text-gray-600';
                let pulseClass = index === currentStatusIndex ? 'animate-pulse' : '';
                return `
                    <div class="${baseClass}">
                        <i class="${statusIcons[index]} ${iconClass} ${pulseClass}" style="font-size: 2.5rem;"></i>
                        <span class="mt-2 text-sm md:text-base font-medium text-black dark:text-white">${status}</span>
                        ${index < statusList.length - 1 ? `<div class="absolute top-1/2 right-0 w-full h-1 bg-gray-300 dark:bg-gray-600 z-0" style="transform: translateY(-50%);"></div>` : ''}
                    </div>
                `;
            }).join('');

            let products = JSON.parse(order.batch);
         let productList = products.map((product, index) => `
    <div class="border border-gray-300 dark:border-gray-600 rounded-lg mb-4">
        <div class="flex justify-between items-center p-4 cursor-pointer toggle-details" data-index="${index}">
            <h3 class="font-semibold text-lg text-black dark:text-white">${product.name}</h3>
            <i class="fas fa-chevron-down transition-transform duration-300" id="arrow-${index}"></i>
        </div>
        <div class="hidden p-4 text-left text-gray-700 dark:text-gray-300" id="details-${index}">
            <p><strong>Price:</strong> ₦${product.price}</p>
            <p><strong>Quantity:</strong> ${product.quantity}</p>
        </div>
    </div>
`).join('');

            let totalPrice = products.reduce((sum, item) => sum + (parseFloat(item.product_price) * parseInt(item.product_quantity)), 0);

            document.getElementById('result').innerHTML = `
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-black dark:text-white mb-4">Order Details</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-left">
                        <p class="text-gray-700 dark:text-gray-300"><strong>Tracking ID:</strong> ${order.tracking_id}</p>
                        <p class="text-gray-700 dark:text-gray-300"><strong>Full Name:</strong> ${order.full_name}</p>
                        <p class="text-gray-700 dark:text-gray-300"><strong>Email:</strong> ${order.email}</p>
                        <p class="text-gray-700 dark:text-gray-300"><strong>Phone:</strong> ${order.phone}</p>
                        <p class="text-gray-700 dark:text-gray-300"><strong>Address:</strong> ${order.address}</p>
                        <p class="text-gray-700 dark:text-gray-300"><strong>Status:</strong> ${order.order_status}</p>
                        <p class="text-gray-700 dark:text-gray-300"><strong>Order Date:</strong> ${order.order_date}</p>
                        <p class="text-gray-700 dark:text-gray-300"><strong>Total Price Paid:</strong> ₦${parseFloat(order.total_price) + parseFloat(order.delivery_price)}</p>
                    </div>
                </div>

                <div class="flex items-center justify-between mb-8 relative">
                    ${steps}
                </div>

                <div>
                    <h3 class="text-xl font-bold text-black dark:text-white mb-4">Ordered Products</h3>
                    ${productList}
                </div>
            `;

            document.querySelectorAll('.toggle-details').forEach(item => {
                item.addEventListener('click', () => {
                    const index = item.getAttribute('data-index');
                    const details = document.getElementById(`details-${index}`);
                    const arrow = document.getElementById(`arrow-${index}`);
                    details.classList.toggle('hidden');
                    arrow.classList.toggle('rotate-180');
                });
            });
        }
    </script>
</body>
</html>