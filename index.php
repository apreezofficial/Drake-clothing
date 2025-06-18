<?php
include 'conn.php';
?>
<!DOCTYPE html>
<html lang="en" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drake Clothing Store | Home</title>
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
    <style>
    /* Grid animation */
    @keyframes float-1 {
        0%, 100% { transform: translate(0, 0) rotate(0deg); }
        50% { transform: translate(10px, 15px) rotate(5deg); }
    }
    @keyframes float-2 {
        0%, 100% { transform: translate(0, 0) rotate(0deg); }
        50% { transform: translate(-15px, 10px) rotate(-3deg); }
    }
    @keyframes float-3 {
        0%, 100% { transform: translate(0, 0) rotate(0deg); }
        50% { transform: translate(5px, -10px) rotate(2deg); }
    }
    
    .animate-float-1 {
        animation: float-1 8s ease-in-out infinite;
    }
    .animate-float-2 {
        animation: float-2 10s ease-in-out infinite;
    }
    .animate-float-3 {
        animation: float-3 12s ease-in-out infinite;
    }
</style>
</head>
<body class="bg-drake-light dark:bg-drake-dark">
<?php include './includes/nav.php';?>
<div style="height:60px;"></div>
<!-- Hero Section -->
<section class="relative bg-white dark:bg-black min-h-[80vh] flex items-center overflow-hidden">
    <!-- Square grid background -->
    <div class="absolute inset-0 grid grid-cols-8 grid-rows-6 gap-px overflow-hidden opacity-10 dark:opacity-[0.08]">
        <!-- Generate grid cells -->
        <?php for ($i = 0; $i < 48; $i++): ?>
            <div class="bg-black dark:bg-white"></div>
        <?php endfor; ?>
    </div>
    <!-- Animated floating squares -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-1/4 left-1/4 w-16 h-16 border border-black dark:border-white opacity-20 animate-float-1"></div>
        <div class="absolute top-1/3 right-1/4 w-12 h-12 border border-black dark:border-white opacity-20 animate-float-2"></div>
        <div class="absolute bottom-1/4 right-1/3 w-10 h-10 border border-black dark:border-white opacity-20 animate-float-3"></div>
    </div>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full text-center relative z-10">
<div class="max-w-3xl mx-auto">
    <!-- Brand Mark -->
    <div class="mb-2">
        <span class="text-xs tracking-[0.5em] text-gray-500 dark:text-gray-400">EST. <?php echo date('Y');?></span>
    </div>
    <!-- Main Heading -->
    <h1 class="text-5xl sm:text-6xl lg:text-7xl font-bold text-black dark:text-white mb-4 leading-tight">
        <span class="block">DRESS YOUR</span>
        <span class="block">OWN RHYTHM</span>
    </h1>
    <!-- Subheading -->
    <div class="font-serif italic text-xl text-gray-600 dark:text-gray-300 mb-8">
        "Drake isn’t just fashion — it’s your statement."
    </div>
    <!-- Description -->
    <p class="text-lg text-gray-600 dark:text-gray-300 mb-10 max-w-2xl mx-auto leading-relaxed">
        Clean cuts. Bold fits. Drake is where comfort meets cool — crafted for those who wear their vibe.
    </p>
    <!-- CTA Buttons -->
    <div class="flex flex-col sm:flex-row justify-center gap-4 mb-12">
        <a href="shop.php" class="px-8 py-3 bg-black dark:bg-white text-white dark:text-black hover:bg-gray-800 dark:hover:bg-gray-200 transition-colors duration-300 text-sm uppercase tracking-wider font-medium">
            Shop New Drops
        </a>
        <a href="collections.php" class="px-8 py-3 border border-black dark:border-white text-black dark:text-white hover:bg-gray-100 dark:hover:bg-gray-900 transition-colors duration-300 text-sm uppercase tracking-wider font-medium">
            Browse Collections
        </a>
    </div>
    <!-- Additional Elements -->
    <div class="text-xs uppercase tracking-widest text-gray-400 dark:text-gray-500 space-y-2">
        <div class="flex items-center justify-center space-x-4">
            <span>Free Worldwide Shipping</span>
            <span class="w-1 h-1 bg-gray-400 dark:bg-gray-500 rounded-full"></span>
            <span>Ethical Materials</span>
            <span class="w-1 h-1 bg-gray-400 dark:bg-gray-500 rounded-full"></span>
            <span>Built to Last</span>
        </div>
        <div class="mt-4">
            <span>Drop Alert: Summer '24 Out Now</span>
        </div>
    </div>
</div>
</div>
</section>
<!-- Featured Collections -->
<section class="py-20 bg-white dark:bg-black">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center mb-16">
            <h2 class="text-3xl sm:text-4xl font-bold text-black dark:text-white mb-4">CURATED COLLECTIONS</h2>
            <p class="max-w-2xl mx-auto text-gray-600 dark:text-gray-300">
                Explore our signature lines—where craftsmanship meets contemporary design.
            </p>
        </div>
<?php
// Fetch collections from DB
$sql_c = "SELECT * FROM collections ORDER BY created_at DESC";
$result = $conn->query($sql_c);
?>
<!-- Collection Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
    <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="group relative overflow-hidden">
                <div class="aspect-square bg-gray-100 dark:bg-gray-900 flex items-center justify-center">
                    <?php if (!empty($row['image_url'])): ?>
                        <img src="<?= $row['image_url'] ?>" alt="<?= htmlspecialchars($row['name']) ?>" class="w-full h-full object-cover">
                    <?php else: ?>
                        <span class="text-gray-400 dark:text-gray-600"><?= strtoupper(htmlspecialchars($row['name'])) ?></span>
                    <?php endif; ?>
                </div>
                <div class="mt-4">
                    <h3 class="text-lg font-medium text-black dark:text-white"><?= htmlspecialchars($row['name']) ?></h3>
                    <p class="mt-1 text-gray-600 dark:text-gray-300 text-sm">
                        <?= htmlspecialchars($row['description']) ?>
                    </p>
                    <a href="collections.php?id=<?= $row['collection_id'] ?>" class="mt-3 inline-block text-sm font-medium text-black dark:text-white border-b border-transparent hover:border-black dark:hover:border-white transition-all duration-300">
                        Discover Now →
                    </a>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p class="text-center col-span-3 text-gray-500 dark:text-gray-400">No collections available at the moment.</p>
    <?php endif; ?>
</div> 
        <!-- View All CTA -->
        <div class="text-center mt-16">
            <a href="collections.php" class="px-8 py-3 border border-black dark:border-white text-black dark:text-white hover:bg-gray-100 dark:hover:bg-gray-900 transition-colors duration-300 text-sm uppercase tracking-wider">
                View All Collections
            </a>
        </div>
    </div>
</section>
<!-- Best Sellers Section -->
<section class="py-20 bg-gray-50 dark:bg-gray-900 border-t border-gray-200 dark:border-gray-800">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Section Header -->
    <div class="text-center mb-16">
      <span class="text-xs uppercase tracking-widest text-gray-500 dark:text-gray-400 mb-2 block">Most Coveted</span>
      <h2 class="text-3xl sm:text-4xl font-bold text-black dark:text-white mb-4">BEST SELLERS</h2>
      <div class="w-20 h-px bg-black dark:bg-white mx-auto"></div>
    </div>
    <?php
// Fetch products from DB
$sql = "SELECT * FROM products ORDER BY created_at DESC LIMIT 3"; 
$result = $conn->query($sql);
?>
<!-- Product Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 p-4">
    <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="product-card group relative bg-white dark:bg-gray-900 rounded-2xl overflow-hidden shadow-xl hover:shadow-2xl transform hover:scale-[1.02] transition duration-500">
                <!-- Product Image -->
                <div class="aspect-square bg-gray-100 dark:bg-gray-800 overflow-hidden relative">
                    <?php if (!empty($row['image_url'])): ?>
                        <img src="<?= $row['image_url'] ?>" alt="<?= htmlspecialchars($row['product_name']) ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                    <?php else: ?>
                        <div class="w-full h-full flex items-center justify-center bg-gray-200 dark:bg-gray-700 transition-transform duration-700 group-hover:scale-110">
                            <span class="text-gray-400 dark:text-gray-500">Product Image</span>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Glass Overlay -->
                    <div class="absolute inset-0 bg-black/30 dark:bg-black/40 opacity-0 group-hover:opacity-100 backdrop-blur-sm transition duration-500 flex items-center justify-center">
                        <a href="product.php?id=<?= $row['id'] ?>" class="bg-white dark:bg-black text-black dark:text-white px-5 py-2 rounded-full text-sm font-semibold transform translate-y-10 group-hover:translate-y-0 transition duration-500 ease-in-out hover:bg-gray-200 dark:hover:bg-gray-800">
                            View Product
                        </a>
                    </div>
                </div>
                <!-- Product Details -->
                <div class="mt-4 px-4 pb-4 text-center">
                    <h3 class="text-lg font-bold text-black dark:text-white truncate">
                        <?= htmlspecialchars($row['product_name']) ?>
                    </h3>
                    <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">
                        <?= htmlspecialchars($row['category']) ?>
                    </p>
                    <p class="text-black dark:text-white font-semibold mt-2 text-lg">
                        ₦<?= number_format($row['price'], 2) ?>
                    </p>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p class="col-span-4 text-center text-gray-500 dark:text-gray-400">No products available.</p>
    <?php endif; ?>
</div>
    <!-- View All Button -->
    <div class="text-center mt-16">
      <a href="shop.php" class="inline-block border-b border-black dark:border-white text-black dark:text-white pb-1 font-medium uppercase tracking-wider text-sm hover:opacity-80 transition-opacity">
        View All Products →
      </a>
    </div>
  </div>
</section>
<!-- Editorial Lookbook Section -->
<section class="py-20 bg-white dark:bg-black border-t border-gray-200 dark:border-gray-800">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Section Header -->
    <div class="text-center mb-16">
      <span class="text-xs uppercase tracking-widest text-gray-500 dark:text-gray-400 mb-2 block">The Drake Journal</span>
      <h2 class="text-3xl sm:text-4xl font-bold text-black dark:text-white mb-4">SPRING EDITORIAL</h2>
      <p class="text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
        Discover the art of intentional dressing through our seasonal narratives
      </p>
    </div>
<?php
// Fetch all editorials
$sql = "SELECT * FROM editorials ORDER BY id ASC";
$result = $conn->query($sql);
// Separate feature and secondary stories
$featureStory = null;
$secondaryStories = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if ($row['type'] === 'feature' && $featureStory === null) {
            $featureStory = $row;
        } else {
            $secondaryStories[] = $row;
        }
    }
}
?>
<!-- Secondary Stories -->
<div class="grid grid-cols-1 gap-8 sm:grid-cols-2">
    <?php foreach ($secondaryStories as $story): ?>
    <div class="group relative aspect-square bg-gray-100 dark:bg-gray-900 overflow-hidden">
        <div class="absolute inset-0 bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
            <img src="<?php echo $story['image_url']; ?>" alt="<?php echo $story['title']; ?>" class="w-full h-full object-cover">
        </div>
        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent flex items-end p-4 sm:p-6">
            <div>
                <?php if (!empty($story['subtitle'])): ?>
                    <span class="text-xs text-white/80 mb-1 block"><?php echo $story['subtitle']; ?></span>
                <?php endif; ?>
                <h3 class="text-lg font-bold text-white mb-1 sm:mb-2"><?php echo $story['title']; ?></h3>
                <a href="#" class="text-white/80 border-b border-white/30 pb-1 text-xs uppercase tracking-wider hover:border-white transition-colors">
                    <?php echo ($story['type'] == 'series') ? 'Watch Now' : 'Explore'; ?>
                </a>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
  </div>
</section>
<!-- Testimonials Section -->
<section class="py-24 bg-white dark:bg-black border-t border-gray-200 dark:border-gray-800">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Section Header -->
    <div class="text-center mb-16">
      <span class="text-xs uppercase tracking-widest text-gray-500 dark:text-gray-400 mb-2 block">Client Voices</span>
      <h2 class="text-3xl sm:text-4xl font-bold text-black dark:text-white mb-4">WORTH WEARING</h2>
      <div class="w-20 h-px bg-black dark:bg-white mx-auto"></div>
    </div>
    <!-- Testimonial Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12">
      <!-- Testimonial 1 -->
      <div class="relative">
        <div class="absolute -top-6 -left-6 text-7xl text-gray-100 dark:text-gray-900 font-serif">"</div>
        <blockquote class="relative z-10 pt-8">
          <p class="text-lg text-gray-600 dark:text-gray-300 mb-6">
            The cashmere knitwear exceeded all expectations. Six months of heavy wear and it still looks brand new. This is why I keep coming back to Drake.
          </p>
          <footer class="flex items-center">
            <div class="w-12 h-12 rounded-full bg-gray-200 dark:bg-gray-800 mr-4 overflow-hidden">
              <div class="w-full h-full flex items-center justify-center text-gray-400">JP</div>
            </div>
            <div>
              <div class="font-medium text-black dark:text-white">James P.</div>
              <div class="text-sm text-gray-500 dark:text-gray-400">Verified Customer</div>
            </div>
          </footer>
        </blockquote>
      </div>

      <!-- Testimonial 2 -->
      <div class="relative">
        <div class="absolute -top-6 -left-6 text-7xl text-gray-100 dark:text-gray-900 font-serif">"</div>
        <blockquote class="relative z-10 pt-8">
          <p class="text-lg text-gray-600 dark:text-gray-300 mb-6">
            I've never owned a blazer that fits so perfectly off the rack. The tailoring details make all the difference. Worth every penny.
          </p>
          <footer class="flex items-center">
            <div class="w-12 h-12 rounded-full bg-gray-200 dark:bg-gray-800 mr-4 overflow-hidden">
              <div class="w-full h-full flex items-center justify-center text-gray-400">SR</div>
            </div>
            <div>
              <div class="font-medium text-black dark:text-white">Sarah R.</div>
              <div class="text-sm text-gray-500 dark:text-gray-400">Since 2022</div>
            </div>
          </footer>
        </blockquote>
      </div>

      <!-- Testimonial 3 -->
      <div class="relative">
        <div class="absolute -top-6 -left-6 text-7xl text-gray-100 dark:text-gray-900 font-serif">"</div>
        <blockquote class="relative z-10 pt-8">
          <p class="text-lg text-gray-600 dark:text-gray-300 mb-6">
            Their minimalist approach means everything pairs perfectly. I've halved my wardrobe but doubled my outfit options since switching to Drake.
          </p>
          <footer class="flex items-center">
            <div class="w-12 h-12 rounded-full bg-gray-200 dark:bg-gray-800 mr-4 overflow-hidden">
              <div class="w-full h-full flex items-center justify-center text-gray-400">ML</div>
            </div>
            <div>
              <div class="font-medium text-black dark:text-white">Michael L.</div>
              <div class="text-sm text-gray-500 dark:text-gray-400">Style Advisor</div>
            </div>
          </footer>
        </blockquote>
      </div>
    </div>
  </div>
</section>
<?php include 'contact.php';?>  
<!-- Newsletter Section -->
<section class="py-24 bg-gray-50 dark:bg-gray-900 border-t border-gray-200 dark:border-gray-800">
  <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
    <!-- Envelope Icon -->
    <div class="mx-auto w-16 h-16 bg-black dark:bg-white text-white dark:text-black flex items-center justify-center mb-8">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
      </svg>
    </div>

    <!-- Heading -->
    <h2 class="text-3xl sm:text-4xl font-bold text-black dark:text-white mb-4">Stay Connected</h2>
    
    <!-- Subheading -->
    <p class="text-gray-600 dark:text-gray-300 max-w-2xl mx-auto mb-10">
      Subscribe for exclusive early access to new collections, private events, and 10% off your first order.
    </p>

<!-- Signup Form -->
<form id="subscribeForm" class="max-w-md mx-auto">
  <div class="flex flex-col sm:flex-row gap-4">
    <input 
      type="email" 
      id="emailInput"
      placeholder="Your email address" 
      class="flex-1 px-4 py-3 border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-black dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-black dark:focus:ring-white"
    >
    <button 
      type="submit" 
      class="px-6 py-3 bg-black dark:bg-white text-white dark:text-black hover:bg-gray-800 dark:hover:bg-gray-200 transition-colors duration-300 uppercase tracking-wider text-sm font-medium"
    >
      Subscribe
    </button>
  </div>
</form>
<script>
document.getElementById('subscribeForm').addEventListener('submit', function(e) {
    e.preventDefault(); // Prevent default form submission

    const emailInput = document.getElementById('emailInput');
    const email = emailInput.value.trim();
    const messageDiv = document.getElementById('subscribeMessage');

    // Clear previous messages
    messageDiv.textContent = '';
    messageDiv.className = 'mt-4 text-center text-sm font-medium';

    // Prepare AJAX request
    fetch('ajax/subscribe.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `email=${encodeURIComponent(email)}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            messageDiv.textContent = data.message;
            messageDiv.classList.add('text-green-600');
            emailInput.value = ''; // Clear input on success
        } else {
            messageDiv.textContent = data.message;
            messageDiv.classList.add('text-red-600');
        }
    })
    .catch(error => {
        messageDiv.textContent = 'Something went wrong. Please try again.';
        messageDiv.classList.add('text-red-600');
        console.error('Error:', error);
    });
});
</script>
<!-- Feedback Message -->
<div id="subscribeMessage" class="mt-4 text-center text-sm font-medium"></div>

    <!-- Privacy Note -->
    <p class="text-xs text-gray-400 dark:text-gray-500 mt-6">
      We respect your privacy. Unsubscribe at any time.
    </p>
  </div>
</section>
<?php include './includes/footer.php';?>
</body>
</html>