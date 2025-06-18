
    <!-- Notification Toast -->
    <div id="toast" class="fixed top-4 right-4 z-50 hidden">
        <div class="px-6 py-4 rounded-lg shadow-lg bg-white dark:bg-gray-800 text-black dark:text-white border-l-4 border-green-500 flex items-center">
            <svg class="w-6 h-6 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <span id="toast-message"></span>
        </div>
    </div>

    <!-- Contact Form -->
    <div class="min-h-screen flex items-center justify-center p-4 bg-black text-white">
    <div class="bg-white dark:bg-gray-900 text-black dark:text-white p-6 md:p-8 rounded-2xl shadow-lg w-full max-w-2xl transition-colors duration-300 border border-gray-200 dark:border-gray-700" id="formContainer">
        <h1 class="text-3xl font-bold mb-6 text-center">Contact Draje</h1>

        <form id="contactForm" class="space-y-4">
            <div>
                <label class="block mb-2 font-medium">Name</label>
                <input type="text" name="name" id="name" class="w-full p-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white bg-white dark:bg-gray-800 transition">
                <p id="name-error" class="text-red-500 text-sm mt-1 hidden"></p>
            </div>

            <div>
                <label class="block mb-2 font-medium">Email</label>
                <input type="text" name="email" id="email" class="w-full p-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white bg-white dark:bg-gray-800 transition">
                <p id="email-error" class="text-red-500 text-sm mt-1 hidden"></p>
            </div>

            <div>
                <label class="block mb-2 font-medium">Message</label>
                <textarea name="message" id="message" rows="4" class="w-full p-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white bg-white dark:bg-gray-800 transition"></textarea>
                <p id="message-error" class="text-red-500 text-sm mt-1 hidden"></p>
            </div>

            <div>
                <label class="block mb-2 font-medium">Attach a File (Optional)</label>
                <input type="file" id="fileInput" accept=".jpg,.png,.pdf,.docx" class="w-full p-3 border rounded-lg border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-black dark:focus:ring-white bg-white dark:bg-gray-800 transition">
                <input type="hidden" name="file_base64" id="fileBase64">
                <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Max size: 5MB (JPG, PNG, PDF, DOCX)</p>
            </div>

            <button type="submit" id="submitButton" class="w-full bg-black dark:bg-white dark:text-black text-white py-3 px-4 rounded-lg font-semibold hover:bg-gray-800 dark:hover:bg-gray-200 transition relative overflow-hidden">
                <span id="buttonText">Send Message</span>
                <div id="loadingStripes" class="absolute inset-0 bg-gradient-to-r from-transparent via-white/30 to-transparent opacity-0 animate-[stripe_1s_linear_infinite]"></div>
            </button>
        </form>
    </div>
</div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const contactForm = document.getElementById('contactForm');
            const fileInput = document.getElementById('fileInput');
            const fileBase64Input = document.getElementById('fileBase64');
            const submitButton = document.getElementById('submitButton');
            const buttonText = document.getElementById('buttonText');
            const loadingStripes = document.getElementById('loadingStripes');
            const toast = document.getElementById('toast');
            const toastMessage = document.getElementById('toast-message');

            // Show toast notification
            function showToast(message, isSuccess = true) {
                toastMessage.textContent = message;
                const borderColor = isSuccess ? 'border-green-500' : 'border-red-500';
                toast.className = `fixed top-4 right-4 z-50 px-6 py-4 rounded-lg shadow-lg bg-white dark:bg-gray-800 text-black dark:text-white border-l-4 ${borderColor} flex items-center transform transition-all duration-300 translate-x-0`;
                toast.classList.remove('hidden');
                
                setTimeout(() => {
                    toast.classList.add('translate-x-full');
                    setTimeout(() => toast.classList.add('hidden'), 300);
                }, 30000);
            }

            // Validate email
            function validateEmail(email) {
                const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return re.test(email);
            }

            // Show error message
            function showError(field, message) {
                const errorElement = document.getElementById(`${field}-error`);
                errorElement.textContent = message;
                errorElement.classList.remove('hidden');
                document.getElementById(field).classList.add('border-red-500');
            }

            // Clear error
            function clearError(field) {
                const errorElement = document.getElementById(`${field}-error`);
                errorElement.classList.add('hidden');
                document.getElementById(field).classList.remove('border-red-500');
            }

            // File input handler
            fileInput.addEventListener('change', function() {
                const file = fileInput.files[0];
                if (file) {
                    // Check file size (5MB max)
                    if (file.size > 5 * 1024 * 1024) {
                        showToast('File size exceeds 5MB limit', false);
                        fileInput.value = '';
                        return;
                    }
                    
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        fileBase64Input.value = e.target.result;
                    }
                    reader.readAsDataURL(file);
                }
            });

            // Form submission
            contactForm.addEventListener('submit', async function(e) {
                e.preventDefault();

                // Clear previous errors
                clearError('name');
                clearError('email');
                clearError('message');

                // Get form values
                const name = document.getElementById('name').value.trim();
                const email = document.getElementById('email').value.trim();
                const message = document.getElementById('message').value.trim();
                const fileBase64 = document.getElementById('fileBase64').value;

                // Validation
                let isValid = true;
                
                if (name === '') {
                    showError('name', 'Name is required');
                    isValid = false;
                }
                
                if (email === '') {
                    showError('email', 'Email is required');
                    isValid = false;
                } else if (!validateEmail(email)) {
                    showError('email', 'Please enter a valid email');
                    isValid = false;
                }
                
                if (message === '') {
                    showError('message', 'Message is required');
                    isValid = false;
                }
                
                if (!isValid) return;

                // Show loading state
                submitButton.disabled = true;
                buttonText.textContent = 'Sending...';
                loadingStripes.classList.remove('opacity-0');
                loadingStripes.style.animationDuration = '200ms';

                try {
                    const formData = new FormData();
                    formData.append('name', name);
                    formData.append('email', email);
                    formData.append('message', message);
                    formData.append('file_base64', fileBase64);
                    const response = await fetch('ajax/contact.php', {
                        method: 'POST',
                        body: formData
                    });

                    const result = await response.text();

                    // Show success message
                    showToast(result || 'Message sent successfully!');
                    contactForm.reset();
                    
                } catch (error) {
                    showToast('An error occurred. Please try again.', false);
                    console.error('Error:', error);
                } finally {
                    // Reset button state
                    submitButton.disabled = false;
                    buttonText.textContent = 'Send Message';
                    loadingStripes.classList.add('opacity-0');
                }
            });
        });
    </script>

    <style>
        @keyframes stripe {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }
        
        .animate-\[stripe_1s_linear_infinite\] {
            animation: stripe 1s linear infinite;
        }
    </style>
