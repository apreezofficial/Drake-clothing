<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check current theme - default to light
$currentTheme = $_SESSION['theme'] ?? 'light';
?>

<!DOCTYPE html>
<html lang="en" class="<?php echo $currentTheme === 'dark' ? 'dark' : ''; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drake Clothing Store</title>
    <script src="/tailwind.js"></script>
    <link rel="stylesheet" href="includes/font-awesome/css/all.css">
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
<body class="bg-drake-light dark:bg-drake-dark transition-colors duration-300">
<?php include './includes/nav.php';?>
    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });

        // Theme toggle
        document.getElementById('theme-toggle').addEventListener('click', function() {
            const html = document.documentElement;
            const isDark = html.classList.contains('dark');
            
            // Toggle the class
            html.classList.toggle('dark');
            
            // Update icon
            const icon = this.querySelector('i');
            if (isDark) {
                icon.classList.remove('fa-sun');
                icon.classList.add('fa-moon');
            } else {
                icon.classList.remove('fa-moon');
                icon.classList.add('fa-sun');
            }
            
            // Send request to save theme preference
            fetch('/theme-toggle.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ theme: isDark ? 'light' : 'dark' })
            });
        });
    </script>
</body>
</html>