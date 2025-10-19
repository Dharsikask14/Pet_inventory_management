<?php
$page_title = 'Home';
require_once 'header.php';
require_once 'db_connect.php';

// Check if the user is logged in, otherwise redirect to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
?>

<!-- Add custom font from Google Fonts -->
<style>
    @import url('https://fonts.googleapis.com/css2?family=Pacifico&display=swap');
    .username-font {
        font-family: 'Pacifico', cursive;
    }
</style>

<main class="container mx-auto px-6 py-8 flex-grow">
    
    <!-- Welcome message positioned below the header -->
    <h1 class="text-4xl font-bold text-white text-center mb-12 drop-shadow-lg">Welcome back, <span class="username-font"><?php echo htmlspecialchars($_SESSION["username"]); ?></span>!</h1>

    <div class="flex justify-center">
        
        <!-- Cards block, centered and responsive -->
        <div class="w-full md:w-2/3 lg:w-1/2 flex flex-col space-y-6">

            <!-- Card 1: Pet Management -->
            <a href="pets.php" class="block bg-white/80 backdrop-blur-sm rounded-lg shadow-lg p-6 transform transition-transform duration-300 hover:shadow-2xl hover:scale-105">
                <h3 class="text-xl font-bold text-blue-700 mb-2">Manage Your Pets</h3>
                <p class="text-gray-600">Add new pets, update their details, and keep track of their health records all in one place.</p>
            </a>
            
            <!-- Card 2: Our Products -->
            <a href="products.php" class="block bg-white/80 backdrop-blur-sm rounded-lg shadow-lg p-6 transform transition-transform duration-300 hover:shadow-2xl hover:scale-105">
                <h3 class="text-xl font-bold text-green-700 mb-2">Discover Products</h3>
                <p class="text-gray-600">Browse our curated selection of high-quality pet food, toys, and accessories.</p>
            </a>

            <!-- Card 3: Our Services -->
            <a href="services.php" class="block bg-white/80 backdrop-blur-sm rounded-lg shadow-lg p-6 transform transition-transform duration-300 hover:shadow-2xl hover:scale-105">
                <h3 class="text-xl font-bold text-purple-700 mb-2">Explore Services</h3>
                <p class="text-gray-600">Check out our grooming, walking, and vet visit packages, or create your own custom plan.</p>
            </a>

        </div>

    </div>
</main>

<?php
require_once 'footer.php';
?>

