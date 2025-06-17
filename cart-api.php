<?php
// cart-api.php
require 'conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $productIds = $input['productIds'] ?? [];

    if (empty($productIds)) {
        echo json_encode(['success' => false, 'message' => 'No products provided.']);
        exit;
    }

    $placeholders = implode(',', array_fill(0, count($productIds), '?'));
    $stmt = $conn->prepare("SELECT id, product_name, price, image FROM products WHERE id IN ($placeholders)");
    $stmt->execute($productIds);
    $result = $stmt->get_result();

    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[$row['id']] = [
            'name' => $row['product_name'],
            'price' => $row['price'],
            'image' => $row['image']
        ];
    }

    echo json_encode(['success' => true, 'products' => $products]);
}
?>