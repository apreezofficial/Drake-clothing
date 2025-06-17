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

</html>