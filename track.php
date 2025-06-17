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

<div class="max-w-2xl mx-auto w-full bg-white dark:bg-black p-8 rounded-3xl shadow-2xl transition-all duration-500 mt-10">
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

    <div class="flex justify-center mt-8">
        <button id="downloadBtn" class="bg-green-600 text-white px-6 py-3 rounded-full hover:bg-green-700 transition duration-300 hidden">
            <i class="fas fa-download"></i> Download as PDF
        </button>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<script>
    document.getElementById('trackBtn').addEventListener('click', function () {
        const idPart = document.getElementById('trackingInput').value.trim();
        const trackingID = `DRK-${idPart}`;

        if (idPart === '') {
            document.getElementById('result').innerHTML = `<p class="text-red-600 mb-4 text-lg">Please enter the tracking number.</p>`;
            document.getElementById('downloadBtn').classList.add('hidden');
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
                    document.getElementById('downloadBtn').classList.remove('hidden');
                } else {
                    document.getElementById('result').innerHTML = `<p class="text-red-600 mb-4 text-lg">${data.message}</p>`;
                    document.getElementById('downloadBtn').classList.add('hidden');
                }
            });
    });

    function displayOrder(order) {
        const statusList = ['Pending', 'Approved', 'In Transit', 'Delivered'];
        const currentStatusIndex = statusList.indexOf(order.order_status);

        let steps = statusList.map((status, index) => {
            let baseClass = 'flex-1 py-2 rounded-full text-white text-center text-sm md:text-base font-medium transition-all duration-300';
            let activeClass = index <= currentStatusIndex ? 'bg-gradient-to-r from-green-500 to-green-700 shadow-md scale-105' : 'bg-gray-300 dark:bg-gray-600';
            return `<div class="${baseClass} ${activeClass}">${status}</div>`;
        }).join('<div class="flex-1 border-t-4 border-gray-300 dark:border-gray-600 mx-2"></div>');

        document.getElementById('result').innerHTML = `
            <div id="orderDetails" class="mb-8 p-6 bg-gray-100 dark:bg-gray-800 rounded-xl shadow-lg">
                <h2 class="text-2xl font-bold text-black dark:text-white mb-4">Order Details</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-left text-gray-700 dark:text-gray-300">
                    <p><strong>Tracking ID:</strong> ${order.tracking_id}</p>
                    <p><strong>Full Name:</strong> ${order.full_name}</p>
                    <p><strong>Email:</strong> ${order.email}</p>
                    <p><strong>Phone:</strong> ${order.phone}</p>
                    <p><strong>Status:</strong> ${order.order_status}</p>
                    <p><strong>Date:</strong> ${order.order_date}</p>
                </div>
            </div>

            <div class="flex items-center justify-between mb-4 animate-pulse">
                ${steps}
            </div>
        `;
    }

    document.getElementById('downloadBtn').addEventListener('click', function () {
        const element = document.getElementById('orderDetails');
        const opt = {
            margin: 0.5,
            filename: 'order_details.pdf',
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 2 },
            jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
        };
        html2pdf().set(opt).from(element).save();
    });
</script>

<?php include './includes/footer.php'; ?>
</body>
</html>