<?php
$page_title = "Our Products";
require_once "header.php";

// Sample product data - in a real application, this would come from a database
$products = [
    [
        'name' => 'Premium Dog Food',
        'image' => 'dogfood.jpg',
        'description' => 'Nutrient-rich, all-natural dry food for dogs of all ages. Made with real chicken and vegetables.',
        'price' => '$59.99'
    ],
    [
        'name' => 'Interactive Cat Toy',
        'image' => 'cattoy.jpg',
        'description' => 'Engage your cat\'s hunting instincts with this automated laser pointer and feather wand.',
        'price' => '$24.99'
    ],
    [
        'name' => 'Cozy Pet Bed',
        'image' => 'petbed.jpg',
        'description' => 'Ultra-soft, machine-washable bed for the perfect nap. Available in multiple sizes.',
        'price' => '$45.00'
    ],
    [
        'name' => 'Durable Chew Bone',
        'image' => 'chewbone.webp',
        'description' => 'A long-lasting nylon bone designed to promote healthy chewing habits and clean teeth.',
        'price' => '$12.50'
    ],
    [
        'name' => 'Gourmet Cat Treats',
        'image' => 'cattreat.jpg',
        'description' => 'Delicious and healthy salmon-flavored treats that your feline friend will love.',
        'price' => '$8.99'
    ],
    [
        'name' => 'Heavy-Duty Leash',
        'image' => 'leash.webp',
        'description' => 'A strong, reflective leash for safe and secure walks, day or night. For medium to large dogs.',
        'price' => '$19.99'
    ]
];
?>

<main class="flex-grow container mx-auto p-8">
    <div class="p-10 rounded-xl w-full">
        
        <h1 class="text-5xl font-bold text-white drop-shadow-md mb-4 text-center">Our Products</h1>
        <p class="text-lg text-white drop-shadow-md mb-12 text-center">
            High-quality supplies to keep your pets happy and healthy.
        </p>

        <!-- Wrapper to constrain width -->
        <div class="max-w-6xl mx-auto">
            <!-- Products Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                
                <?php foreach ($products as $product): ?>
                <div class="bg-white rounded-lg shadow-lg overflow-hidden flex flex-col transition-all duration-300 ease-in-out transform hover:scale-105 hover:shadow-2xl border-2 border-transparent hover:border-blue-500">
                    <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="w-full h-45 object-cover">
                    <div class="p-4 flex flex-col flex-grow">
                        <h3 class="text-base font-semibold text-gray-800 mb-1"><?= htmlspecialchars($product['name']) ?></h3>
                        <p class="text-gray-600 text-xs mb-2 flex-grow">
                            <?= htmlspecialchars($product['description']) ?>
                        </p>
                        <div class="flex justify-between items-center mt-auto">
                            <span class="text-lg font-bold text-blue-600"><?= htmlspecialchars($product['price']) ?></span>
                            <button class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-1 px-2 rounded-lg transition-colors text-xs">
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>

            </div>
        </div>

    </div>
</main>

<?php
require_once "footer.php";
?>

