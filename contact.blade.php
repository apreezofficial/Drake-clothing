<body class="bg-black text-white min-h-screen flex items-center justify-center p-6 transition-colors duration-300" id="body">
    <!-- Contact Form -->
    <div class="bg-white dark:bg-black text-black dark:text-white p-8 rounded-2xl shadow-lg w-full max-w-2xl transition-colors duration-300" id="formContainer">
        <h1 class="text-3xl font-bold mb-6 text-center">Contact Draje</h1>

        <form id="contactForm" class="space-y-5">

            <div>
                <label class="block mb-1 font-semibold">Name</label>
                <input type="text" name="name" id="name" class="w-full p-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white">
            </div>

            <div>
                <label class="block mb-1 font-semibold">Email</label>
                <input type="text" name="email" id="email" class="w-full p-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white">
            </div>

            <div>
                <label class="block mb-1 font-semibold">Message</label>
                <textarea name="message" id="message" rows="4" class="w-full p-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white"></textarea>
            </div>

            <div>
                <label class="block mb-1 font-semibold">Attach a File (Optional)</label>
                <input type="file" id="fileInput" accept=".jpg,.png,.pdf,.docx" class="w-full p-3 border rounded-lg border-gray-300 focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white">
                <input type="hidden" name="file_base64" id="fileBase64">
            </div>

            <!-- Progress Bar -->
            <div class="w-full bg-gray-300 rounded-full h-2.5 dark:bg-gray-700 hidden" id="progressContainer">
                <div class="bg-black dark:bg-white h-2.5 rounded-full progressBar" id="progressBar" style="width: 0%;"></div>
            </div>

            <button type="submit" class="w-full bg-black dark:bg-white dark:text-black text-white py-3 rounded-lg font-semibold hover:bg-gray-800 dark:hover:bg-gray-200 transition">Send Message</button>
        </form>
    </div>

    <script>
        const contactForm = document.getElementById('contactForm');
        const fileInput = document.getElementById('fileInput');
        const fileBase64Input = document.getElementById('fileBase64');
        const progressContainer = document.getElementById('progressContainer');
        const progressBar = document.getElementById('progressBar');

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
            e.preventDefault();

            const name = document.getElementById('name').value.trim();
            const email = document.getElementById('email').value.trim();
            const message = document.getElementById('message').value.trim();
            const fileBase64 = document.getElementById('fileBase64').value;

            // Pure JS Validation
            if (name === '' || email === '' || message === '') {
                alert('All fields are required!');
                return;
            }

            const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
            if (!emailPattern.test(email)) {
                alert('Please enter a valid email address!');
                return;
            }

            // Show Progress Bar
            progressContainer.classList.remove('hidden');
            progressBar.style.width = '0%';

            let progress = 0;
            const progressInterval = setInterval(() => {
                if (progress >= 90) {
                    clearInterval(progressInterval);
                } else {
                    progress += 10;
                    progressBar.style.width = `${progress}%`;
                }
            }, 100);

            const formData = new FormData();
            formData.append('name', name);
            formData.append('email', email);
            formData.append('message', message);
            formData.append('file_base64', fileBase64);

            fetch('Ajax/contact.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.text())
                .then(result => {
                    clearInterval(progressInterval);
                    progressBar.style.width = '100%';

                    setTimeout(() => {
                        alert(result);
                        contactForm.reset();
                        progressBar.style.width = '0%';
                        progressContainer.classList.add('hidden');
                    }, 500);
                })
                .catch(error => {
                    clearInterval(progressInterval);
                    progressBar.style.width = '0%';
                    progressContainer.classList.add('hidden');
                    alert('An error occurred. Please try again.');
                });
        });
    </script>
</body>