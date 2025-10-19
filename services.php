<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
require_once "db_connect.php";
$page_title = "Our Services";
require_once "header.php";

$user_id = $_SESSION['id'];
$custom_services = [];
$error_msg = $success_msg = "";
$editing_service_id = null;

// Handle Redirect Messages
if (isset($_GET['success'])) {
    $success_msg = "Service action completed successfully.";
}

// Check for edit mode
if (isset($_GET['edit_id'])) {
    $editing_service_id = (int)$_GET['edit_id'];
}

// Handle POST requests for CRUD operations
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Add new service
    if (isset($_POST['add_service'])) {
        $service_name = trim($_POST['service_name']);
        $description = trim($_POST['service_description']);
        $price = trim($_POST['service_price']);
        if (!empty($service_name) && !empty($description) && !empty($price)) {
            $sql = "INSERT INTO custom_services (user_id, service_name, description, price) VALUES (?, ?, ?, ?)";
            if ($stmt = $mysqli->prepare($sql)) {
                $stmt->bind_param("issd", $user_id, $service_name, $description, $price);
                if ($stmt->execute()) {
                    header("location: services.php?success=1");
                    exit;
                } else {
                    $error_msg = "Error: Could not create the service.";
                }
                $stmt->close();
            }
        } else {
            $error_msg = "All fields are required to add a service.";
        }
    }

    // Update service
    if (isset($_POST['update_service'])) {
        $service_id = $_POST['service_id'];
        $service_name = trim($_POST['service_name']);
        $description = trim($_POST['service_description']);
        $price = trim($_POST['service_price']);
        if (!empty($service_name) && !empty($description) && !empty($price)) {
            $sql = "UPDATE custom_services SET service_name = ?, description = ?, price = ? WHERE id = ? AND user_id = ?";
            if ($stmt = $mysqli->prepare($sql)) {
                $stmt->bind_param("ssdii", $service_name, $description, $price, $service_id, $user_id);
                if ($stmt->execute()) {
                    header("location: services.php?success=1");
                    exit;
                } else {
                    $error_msg = "Error: Could not update the service.";
                }
                $stmt->close();
            }
        } else {
            $error_msg = "All fields are required to update a service.";
        }
    }

    // Delete service
    if (isset($_POST['delete_service'])) {
        $service_id = $_POST['service_id'];
        $sql = "DELETE FROM custom_services WHERE id = ? AND user_id = ?";
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("ii", $service_id, $user_id);
            if ($stmt->execute()) {
                header("location: services.php?success=1");
                exit;
            } else {
                $error_msg = "Error: Could not delete the service.";
            }
            $stmt->close();
        }
    }
}

// Fetch user's custom services
$sql = "SELECT id, service_name, description, price FROM custom_services WHERE user_id = ?";
if ($stmt = $mysqli->prepare($sql)) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $custom_services[] = $row;
        }
    }
    $stmt->close();
}
$mysqli->close();
?>

<main class="flex-grow container mx-auto p-8">
    <div class="text-center mb-12">
        <h1 class="text-5xl font-extrabold text-white drop-shadow-lg">Our Service Plans</h1>
        <p class="text-lg text-gray-200 mt-4">Choose a plan that fits your needs or create your own.</p>
    </div>

    <?php if ($error_msg): ?>
        <div class="max-w-4xl mx-auto bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline"><?= htmlspecialchars($error_msg) ?></span>
        </div>
    <?php endif; ?>
    <?php if ($success_msg): ?>
        <div class="max-w-4xl mx-auto bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline"><?= htmlspecialchars($success_msg) ?></span>
        </div>
    <?php endif; ?>

    <!-- Predefined Service Tiers -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto mb-12">
        <!-- Business Plan -->
        <div class="bg-white rounded-lg shadow-xl p-6 border-2 border-transparent hover:border-blue-500 transition-all duration-300 flex flex-col">
            <h3 class="text-2xl font-bold text-gray-800 mb-4 text-center">Business</h3>
            <ul class="text-gray-600 space-y-2 flex-grow">
                <li><span class="text-green-500 mr-2">&#10003;</span>5 Dog Walks</li>
                <li><span class="text-green-500 mr-2">&#10003;</span>3 Vet Visits</li>
                <li><span class="text-green-500 mr-2">&#10003;</span>3 Pet Spa Sessions</li>
                <li><span class="text-green-500 mr-2">&#10003;</span>Free Support</li>
            </ul>
        </div>
        <!-- Personal Plan -->
        <div class="bg-white rounded-lg shadow-xl p-6 border-2 border-transparent hover:border-blue-500 transition-all duration-300 flex flex-col">
            <h3 class="text-2xl font-bold text-gray-800 mb-4 text-center">Personal</h3>
            <ul class="text-gray-600 space-y-2 flex-grow">
                <li><span class="text-green-500 mr-2">&#10003;</span>5 Dog Walks</li>
                <li><span class="text-green-500 mr-2">&#10003;</span>3 Vet Visits</li>
                <li><span class="text-green-500 mr-2">&#10003;</span>3 Pet Spa Sessions</li>
                <li><span class="text-green-500 mr-2">&#10003;</span>Free Support</li>
            </ul>
        </div>
        <!-- Ultimate Plan -->
        <div class="bg-white rounded-lg shadow-xl p-6 border-2 border-transparent hover:border-blue-500 transition-all duration-300 flex flex-col">
            <h3 class="text-2xl font-bold text-gray-800 mb-4 text-center">Ultimate</h3>
            <ul class="text-gray-600 space-y-2 flex-grow">
                <li><span class="text-green-500 mr-2">&#10003;</span>5 Dog Walks</li>
                <li><span class="text-green-500 mr-2">&#10003;</span>3 Vet Visits</li>
                <li><span class="text-green-500 mr-2">&#10003;</span>3 Pet Spa Sessions</li>
                <li><span class="text-green-500 mr-2">&#10003;</span>Free Support</li>
            </ul>
        </div>
    </div>

    <!-- Custom Services Section -->
    <div class="max-w-6xl mx-auto">
        <h2 class="text-4xl font-bold text-white text-center mb-8 drop-shadow-md">Customize Your Services</h2>

        <!-- Add/Edit Form -->
        <div class="bg-gray-50 rounded-lg shadow-lg p-6 mb-8">
            <h3 class="text-2xl font-semibold text-gray-700 mb-4">
                <?= $editing_service_id ? 'Update Service' : 'Add a New Custom Service' ?>
            </h3>
            <form action="services.php" method="post">
                <?php if ($editing_service_id): ?>
                    <input type="hidden" name="service_id" value="<?= $editing_service_id ?>">
                <?php endif; ?>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <input type="text" name="service_name" placeholder="Service Name" class="p-2 border rounded-md" required value="<?= $editing_service_id ? htmlspecialchars(array_values(array_filter($custom_services, fn($s) => $s['id'] == $editing_service_id))[0]['service_name']) : '' ?>">
                    <input type="text" name="service_description" placeholder="Description" class="p-2 border rounded-md" required value="<?= $editing_service_id ? htmlspecialchars(array_values(array_filter($custom_services, fn($s) => $s['id'] == $editing_service_id))[0]['description']) : '' ?>">
                    <input type="number" step="0.01" name="service_price" placeholder="Price ($)" class="p-2 border rounded-md" required value="<?= $editing_service_id ? htmlspecialchars(array_values(array_filter($custom_services, fn($s) => $s['id'] == $editing_service_id))[0]['price']) : '' ?>">
                </div>
                <?php if ($editing_service_id): ?>
                    <button type="submit" name="update_service" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-lg">Update Service</button>
                    <a href="services.php" class="bg-gray-400 hover:bg-gray-500 text-white font-bold py-2 px-4 rounded-lg">Cancel Edit</a>
                <?php else: ?>
                    <button type="submit" name="add_service" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg">Add Service</button>
                <?php endif; ?>
            </form>
        </div>

        <!-- Custom Services List -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php if (empty($custom_services)): ?>
                <div class="col-span-full text-center text-gray-200 p-6 bg-white bg-opacity-20 rounded-lg">You have not created any custom services yet.</div>
            <?php else: ?>
                <?php foreach ($custom_services as $service): ?>
                    <div class="bg-white rounded-lg shadow-xl p-6 border-2 border-transparent hover:border-blue-500 transition-all duration-300 flex flex-col justify-between">
                        <div>
                            <h4 class="text-xl font-bold text-gray-800"><?= htmlspecialchars($service['service_name']) ?></h4>
                            <p class="text-gray-600 my-2"><?= htmlspecialchars($service['description']) ?></p>
                            <p class="text-lg font-semibold text-gray-800">$<?= htmlspecialchars(number_format($service['price'], 2)) ?></p>
                        </div>
                        <div class="flex items-center justify-end space-x-4 mt-4">
                            <a href="services.php?edit_id=<?= $service['id'] ?>" class="text-blue-600 hover:text-blue-900 font-medium">Edit</a>
                            <form action="services.php" method="post" onsubmit="return confirm('Are you sure you want to delete this service?');">
                                <input type="hidden" name="service_id" value="<?= $service['id'] ?>">
                                <button type="submit" name="delete_service" class="text-red-600 hover:text-red-900 font-medium">Delete</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php
require_once "footer.php";
?>

