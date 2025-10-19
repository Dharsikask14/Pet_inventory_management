<?php
session_start();
// No login check needed for a contact page, assuming it's public.
// If it must be private, uncomment the following lines:
/*
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
*/
$page_title = "Contact Us";
require_once "header.php";

$feedback_msg = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Basic form handling demonstration
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);

    if (!empty($name) && !empty($email) && !empty($message) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Here you would typically send an email or save to a database.
        // For this example, we'll just show a success message.
        $feedback_msg = "Thank you for your message! We'll get back to you soon.";
    } else {
        $feedback_msg = "Please fill out all fields with valid information.";
    }
}
?>

<main class="flex-grow container mx-auto p-8">
    <div class="text-center mb-12">
        <h1 class="text-5xl font-extrabold text-white drop-shadow-lg">Get in Touch</h1>
        <p class="text-lg text-gray-200 mt-4">We'd love to hear from you. Send us a message or find us at our location.</p>
    </div>

    <div class="max-w-6xl mx-auto bg-white rounded-xl shadow-2xl overflow-hidden p-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            <!-- Contact Form -->
            <div>
                <h2 class="text-3xl font-bold text-gray-800 mb-6">Send a Message</h2>
                <?php if ($feedback_msg): ?>
                    <div class="mb-4 p-4 rounded-lg <?= strpos($feedback_msg, 'Thank you') !== false ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                        <?= htmlspecialchars($feedback_msg) ?>
                    </div>
                <?php endif; ?>
                <form action="contact.php" method="post" class="space-y-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                        <input type="text" id="name" name="name" required class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 hover:border-blue-500 transition-colors">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                        <input type="email" id="email" name="email" required class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 hover:border-blue-500 transition-colors">
                    </div>
                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700">Message</label>
                        <textarea id="message" name="message" rows="5" required class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 hover:border-blue-500 transition-colors"></textarea>
                    </div>
                    <div>
                        <button type="submit" class="w-full flex justify-center py-3 px-4 border-2 border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 hover:border-blue-300 transition-all">
                            Submit
                        </button>
                    </div>
                </form>
            </div>

            <!-- Contact Information -->
            <div class="flex flex-col justify-center">
                 <h2 class="text-3xl font-bold text-gray-800 mb-6">Contact Details</h2>
                 <div class="space-y-4 text-gray-600">
                    <p class="flex items-center">
                        <svg class="w-6 h-6 mr-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <span>123 Pet Lane, Animal City, 12345</span>
                    </p>
                    <p class="flex items-center">
                        <svg class="w-6 h-6 mr-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        <span>(123) 456-7890</span>
                    </p>
                    <p class="flex items-center">
                         <svg class="w-6 h-6 mr-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        <span>contact@petcare.com</span>
                    </p>
                 </div>
                 <div class="mt-8">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3153.238824840882!2d144.9615539153177!3d-37.81725097975195!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad642af0f11fd81%3A0x5045675218ce7e0!2sMelbourne%20VIC%2C%20Australia!5e0!3m2!1sen!2sus!4v1616111111111!5m2!1sen!2sus" width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy" class="rounded-lg"></iframe>
                 </div>
            </div>
        </div>
    </div>
</main>

<?php
require_once "footer.php";
?>

