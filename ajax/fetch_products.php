<?php
require '../conn.php';

$result = $conn->query("SELECT * FROM products ORDER BY created_at DESC");
$products = [];

while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}

echo json_encode($products);
?>