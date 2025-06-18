<?php
require 'conn.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);
    $fileData = htmlspecialchars($_POST['file_base64']);
    $createdAt = date('Y-m-d H:i:s');
    if (!empty($name) && !empty($email) && !empty($message)) {
        $stmt = $conn->prepare("INSERT INTO contacts (name, email, message, file_base64, created_at) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $email, $message, $fileData, $createdAt);
        if ($stmt->execute()) {
            echo "<script>alert('Message sent successfully!'); window.location.href='contact.php';</script>";
            exit();
        } else {
            echo "<script>alert('Error saving your message. Please try again.');</script>";
        }
    } else {
        echo "<script>alert('Please fill in all fields.');</script>";
    }
}
?>
<body class="bg-black text-white min-h-screen flex items-center justify-center p-6">

    <div class="bg-white text-black p-8 rounded-2xl shadow-lg w-full max-w-2xl">
        <h1 class="text-3xl font-bold mb-6 text-center">Contact Draje</h1>
        <form id="contactForm" method="POST" enctype="multipart/form-data" class="space-y-5">

            <div>
                <label class="block mb-1 font-semibold">Name</label>
                <input type="text" name="name" id="name" class="w-full p-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-black" required>
            </div>

            <div>
                <label class="block mb-1 font-semibold">Email</label>
                <input type="email" name="email" id="email" class="w-full p-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-black" required>
            </div>

            <div>
                <label class="block mb-1 font-semibold">Message</label>
                <textarea name="message" id="message" rows="4" class="w-full p-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-black" required></textarea>
            </div>

            <div>
                <label class="block mb-1 font-semibold">Attach a File (Optional)</label>
                <input type="file" id="fileInput" accept=".jpg,.png,.pdf,.docx" class="w-full p-3 border rounded-lg border-gray-300 focus:outline-none focus:ring-2 focus:ring-black">
                <input type="hidden" name="file_base64" id="fileBase64">
            </div>

            <button type="submit" class="w-full bg-black text-white py-3 rounded-lg font-semibold hover:bg-gray-800 transition">Send Message</button>
        </form>
    </div>

    <script>
        const contactForm = document.getElementById('contactForm');
        const fileInput = document.getElementById('fileInput');
        const fileBase64Input = document.getElementById('fileBase64');

        fileInput.addEventListener('change', function () {
            const file = fileInput.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    fileBase64Input.value = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });

        contactForm.addEventListener('submit', function (e) {
            const name = document.getElementById('name').value.trim();
            const email = document.getElementById('email').value.trim();
            const message = document.getElementById('message').value.trim();

            if (name === '' || email === '' || message === '') {
                e.preventDefault();
                alert('All fields are required!');
            }

            const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
            if (!emailPattern.test(email)) {
                e.preventDefault();
                alert('Please enter a valid email address!');
            }
        });
    </script>

</body>