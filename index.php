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


<?php include './includes/footer.php';?>
</body>
</html>