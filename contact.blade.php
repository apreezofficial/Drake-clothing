<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Draje</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-black text-white min-h-screen flex items-center justify-center p-6 transition-colors duration-300" id="body">

    <!-- Mode Toggle -->
    <button id="modeToggle" class="absolute top-5 right-5 bg-white text-black px-4 py-2 rounded-lg font-semibold hover:bg-gray-300 transition">Switch Mode</button>

    <!-- Contact Form -->
    <div class="bg-white text-black p-8 rounded-2xl shadow-lg w-full max-w-2xl transition-colors duration-300" id="formContainer">
        <h1 class="text-3xl font-bold mb-6 text-center">Contact Draje</h1>
        <form id="contactForm" class="space-y-5">

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
        // Mode Toggle
        const modeToggle = document.getElementById('modeToggle');
        const body = document.getElementById('body');
        const formContainer = document.getElementById('formContainer');

        modeToggle.addEventListener('click', () => {
            body.classList.toggle('bg-black');
            body.classList.toggle('bg-white');
            body.classList.toggle('text-white');
            body.classList.toggle('text-black');

            formContainer.classList.toggle('bg-white');
            formContainer.classList.toggle('bg-black');
            formContainer.classList.toggle('text-black');
            formContainer.classList.toggle('text-white');

            modeToggle.classList.toggle('bg-white');
            modeToggle.classList.toggle('bg-black');
            modeToggle.classList.toggle('text-white');
            modeToggle.classList.toggle('text-black');
        });

        // File to Base64
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

        // Form Submit with AJAX
        contactForm.addEventListener('submit', async function (e) {
            e.preventDefault();

            const name = document.getElementById('name').value.trim();
            const email = document.getElementById('email').value.trim();
            const message = document.getElementById('message').value.trim();
            const fileBase64 = document.getElementById('fileBase64').value;

            if (name === '' || email === '' || message === '') {
                alert('All fields are required!');
                return;
            }

            const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
            if (!emailPattern.test(email)) {
                alert('Please enter a valid email address!');
                return;
            }

            const formData = new FormData();
            formData.append('name', name);
            formData.append('email', email);
            formData.append('message', message);
            formData.append('file_base64', fileBase64);

            try {
                const response = await fetch('Ajax/contact.php', {
                    method: 'POST',
                    body: formData
                });

                const result = await response.text();
                alert(result);

                contactForm.reset();
            } catch (error) {
                alert('An error occurred. Please try again.');
            }
        });
    </script>

</body>
</html> 