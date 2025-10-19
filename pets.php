<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
require_once "db_connect.php";
$page_title = "Pet Management";
require_once "header.php";

$user_id = $_SESSION['id'];
$pets = [];
$error_msg = $success_msg = "";
$editing_pet_id = null;

// Check for success messages from redirects
if (isset($_GET['add_success'])) {
    $success_msg = "Pet added successfully.";
}
if (isset($_GET['update_success'])) {
    $success_msg = "Pet updated successfully.";
}
if (isset($_GET['delete_success'])) {
    $success_msg = "Pet removed successfully.";
}

// Check if we are in edit mode from URL
if (isset($_GET['edit_id'])) {
    $editing_pet_id = (int)$_GET['edit_id'];
}

// Handle form submissions for add/edit/delete
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Add new pet
    if (isset($_POST['add_pet'])) {
        $pet_name = trim($_POST['pet_name']);
        $pet_type = trim($_POST['pet_type']);
        $age = trim($_POST['age']);
        if (!empty($pet_name) && !empty($pet_type) && !empty($age)) {
            $sql = "INSERT INTO pets (user_id, pet_name, pet_type, age) VALUES (?, ?, ?, ?)";
            if ($stmt = $mysqli->prepare($sql)) {
                $stmt->bind_param("issi", $user_id, $pet_name, $pet_type, $age);
                if ($stmt->execute()) {
                    header("location: pets.php?add_success=1");
                    exit;
                } else {
                    $error_msg = "Error: Could not add pet.";
                }
                $stmt->close();
            }
        } else {
            $error_msg = "Name, type, and age are required.";
        }
    }
    
    // Update existing pet
    if (isset($_POST['update_pet'])) {
        $pet_id = $_POST['pet_id'];
        $pet_name = trim($_POST['pet_name']);
        $pet_type = trim($_POST['pet_type']);
        $age = trim($_POST['age']);
        if (!empty($pet_name) && !empty($pet_type) && !empty($age)) {
            $sql = "UPDATE pets SET pet_name = ?, pet_type = ?, age = ? WHERE id = ? AND user_id = ?";
            if ($stmt = $mysqli->prepare($sql)) {
                $stmt->bind_param("ssiii", $pet_name, $pet_type, $age, $pet_id, $user_id);
                if ($stmt->execute()) {
                    header("location: pets.php?update_success=1");
                    exit;
                } else {
                    $error_msg = "Error: Could not update pet.";
                }
                $stmt->close();
            }
        } else {
            $error_msg = "Name, type, and age are required for an update.";
        }
    }

    // Delete pet
    if (isset($_POST['delete_pet'])) {
        $pet_id = $_POST['pet_id'];
        $sql = "DELETE FROM pets WHERE id = ? AND user_id = ?";
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("ii", $pet_id, $user_id);
            if ($stmt->execute()) {
                header("location: pets.php?delete_success=1");
                exit;
            } else {
                $error_msg = "Error: Could not remove pet.";
            }
            $stmt->close();
        }
    }
}

// Fetch user's pets
$sql = "SELECT id, pet_name, pet_type, age FROM pets WHERE user_id = ?";
if ($stmt = $mysqli->prepare($sql)) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $pets[] = $row;
        }
    }
    $stmt->close();
}

$mysqli->close();
?>

<main class="flex-grow container mx-auto p-8">
    <div class="p-10 rounded-xl w-full">
        <h1 class="text-5xl font-bold text-white drop-shadow-md mb-8 text-center">Manage Your Pets</h1>

        <div class="max-w-5xl mx-auto">
            <?php if ($error_msg): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline"><?= htmlspecialchars($error_msg) ?></span>
                </div>
            <?php endif; ?>
            <?php if ($success_msg): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline"><?= htmlspecialchars($success_msg) ?></span>
                </div>
            <?php endif; ?>

            <!-- Add Pet Form -->
            <div class="mb-8 p-6 bg-gray-50 rounded-lg shadow-lg">
                <h2 class="text-2xl font-semibold text-gray-700 mb-4">Add a New Pet</h2>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <input type="text" name="pet_name" placeholder="Pet's Name" class="p-2 border rounded-md" required>
                        <input type="text" name="pet_type" placeholder="Type (e.g., Dog, Cat)" class="p-2 border rounded-md" required>
                        <input type="number" name="age" placeholder="Age" class="p-2 border rounded-md" required>
                    </div>
                    <button type="submit" name="add_pet" class="mt-4 bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg transition-colors">
                        Add Pet
                    </button>
                </form>
            </div>

            <!-- Pet List -->
            <div>
                <h2 class="text-2xl font-semibold text-gray-700 mb-4">Your Pets</h2>
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <table class="min-w-full leading-normal">
                        <thead>
                            <tr>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Name</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Type</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Age</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($pets)): ?>
                                <tr>
                                    <td colspan="4" class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center">You haven't added any pets yet.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($pets as $pet): ?>
                                    <?php if ($editing_pet_id === (int)$pet['id']): ?>
                                        <!-- Edit Form Row -->
                                        <tr>
                                            <td colspan="4" class="p-4 bg-gray-50">
                                                <form action="pets.php" method="post">
                                                    <input type="hidden" name="pet_id" value="<?= $pet['id'] ?>">
                                                    <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 items-center">
                                                        <input type="text" name="pet_name" value="<?= htmlspecialchars($pet['pet_name']) ?>" class="p-2 border rounded-md" required>
                                                        <input type="text" name="pet_type" value="<?= htmlspecialchars($pet['pet_type']) ?>" class="p-2 border rounded-md" required>
                                                        <input type="number" name="age" value="<?= htmlspecialchars($pet['age']) ?>" class="p-2 border rounded-md" required>
                                                        <div class="flex space-x-2">
                                                            <button type="submit" name="update_pet" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-lg">Save</button>
                                                            <a href="pets.php" class="bg-gray-400 hover:bg-gray-500 text-white font-bold py-2 px-4 rounded-lg">Cancel</a>
                                                        </div>
                                                    </div>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php else: ?>
                                        <!-- Display Row -->
                                        <tr>
                                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?= htmlspecialchars($pet['pet_name']) ?></td>
                                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?= htmlspecialchars($pet['pet_type']) ?></td>
                                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm"><?= htmlspecialchars($pet['age']) ?></td>
                                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                <div class="flex items-center space-x-4">
                                                    <a href="pets.php?edit_id=<?= $pet['id'] ?>" class="text-blue-600 hover:text-blue-900">Edit</a>
                                                    <form action="pets.php" method="post" onsubmit="return confirm('Are you sure you want to delete this pet?');">
                                                        <input type="hidden" name="pet_id" value="<?= $pet['id'] ?>">
                                                        <button type="submit" name="delete_pet" class="text-red-600 hover:text-red-900">Delete</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<?php
require_once "footer.php";
?>

