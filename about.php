<?php
$page_title = "About Us";
require_once "header.php";
?>

<main class="flex-grow container mx-auto p-8 flex items-center justify-center">
    <div class="bg-white bg-opacity-80 p-10 rounded-xl shadow-2xl max-w-5xl w-full text-center">
        
        <h1 class="text-5xl font-bold text-gray-800 mb-6">About <span class="text-blue-500">PetCare</span></h1>
        
        <p class="text-lg text-gray-600 mb-12">
            Welcome to PetCare, your all-in-one solution for managing your pet's life. We are passionate about animals and dedicated to making pet ownership simpler and more joyful.
        </p>

        <div class="grid md:grid-cols-3 gap-8 text-left">
            <!-- Card 1: Our Mission -->
            <div class="bg-teal-50 p-6 rounded-lg shadow-lg transition-all duration-300 transform hover:scale-105 hover:shadow-xl cursor-pointer border-2 border-transparent hover:border-blue-500">
                <h3 class="text-2xl font-semibold text-teal-800 mb-3">Our Mission</h3>
                <p class="text-gray-700">
                    To provide pet owners with the tools and resources they need to give their pets the happiest, healthiest lives possible.
                </p>
            </div>

            <!-- Card 2: Our Vision -->
            <div class="bg-teal-50 p-6 rounded-lg shadow-lg transition-all duration-300 transform hover:scale-105 hover:shadow-xl cursor-pointer border-2 border-transparent hover:border-blue-500">
                <h3 class="text-2xl font-semibold text-teal-800 mb-3">Our Vision</h3>
                <p class="text-gray-700">
                    To create a world where every pet is well-cared for, and every owner feels confident and supported in their pet parenting journey.
                </p>
            </div>

            <!-- Card 3: Our Team -->
            <div class="bg-teal-50 p-6 rounded-lg shadow-lg transition-all duration-300 transform hover:scale-105 hover:shadow-xl cursor-pointer border-2 border-transparent hover:border-blue-500">
                <h3 class="text-2xl font-semibold text-teal-800 mb-3">Our Team</h3>
                <p class="text-gray-700">
                    We are a group of veterinary professionals, tech enthusiasts, and, most importantly, pet lovers, united by our shared passion.
                </p>
            </div>
        </div>

    </div>
</main>

<?php
require_once "footer.php";
?>

