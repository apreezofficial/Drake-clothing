<?php
require '../conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);
    $fileData = htmlspecialchars($_POST['file_base64']);
    $createdAt = date('Y-m-d H:i:s');

    if (!empty($name) && !empty($email) && !empty($message)) {
        $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, message, file_base64, submitted_at) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $email, $message, $fileData, $createdAt);

        if ($stmt->execute()) {
            echo 'Message sent successfully!';
        } else {
            echo 'Error saving your message. Please try again.';
        }
    } else {
        echo 'Please fill in all fields.';
    }
} else {
    echo 'Invalid request.';
}
?>