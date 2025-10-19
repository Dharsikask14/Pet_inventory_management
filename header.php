<?php
// Start the session if it's not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? htmlspecialchars($page_title) . ' - PetCare' : 'PetCare'; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            /* Image from a royalty-free source */
            background-image: url('image2.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            /* Add padding to the body to prevent content from being hidden by fixed header/footer */
            padding-top: 4.5rem; /* Adjust based on header height */
            padding-bottom: 4.5rem; /* Adjust based on footer height */
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
    </style>
</head>
<body class="bg-gray-100">

    <!-- Header is now fixed to the top -->
    <header class="bg-blue-100 p-4 shadow-md fixed top-0 left-0 right-0 z-50">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <!-- Image Logo -->
                <img src="logo.png" alt="PetCare Logo" class="h-12 w-12">
                <a href="home.php" class="text-2xl font-bold text-blue-600">PetCare</a>
            </div>
            <nav class="space-x-4">
                <?php if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true): ?>
                    <a href="home.php" class="text-gray-700 hover:text-blue-600">Home</a>
                    <a href="about.php" class="text-gray-700 hover:text-blue-600">About</a>
                    <a href="products.php" class="text-gray-700 hover:text-blue-600">Products</a>
                    <a href="pets.php" class="text-gray-700 hover:text-blue-600">Pets</a>
                    <a href="services.php" class="text-gray-700 hover:text-blue-600">Services</a>
                    <a href="contact.php" class="text-gray-700 hover:text-blue-600">Contact</a>
                    <a href="logout.php" class="bg-red-500 text-white px-3 py-2 rounded-md hover:bg-red-600">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="text-gray-700 hover:text-blue-600">Login</a>
                    <a href="signup.php" class="bg-blue-500 text-white px-3 py-2 rounded-md hover:bg-blue-600">Sign Up</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>

