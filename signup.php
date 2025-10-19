<?php
require_once "db_connect.php";

$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter a username.";
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))) {
        $username_err = "Username can only contain letters, numbers, and underscores.";
    } else {
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("s", $param_username);
            $param_username = trim($_POST["username"]);
            
            if ($stmt->execute()) {
                $stmt->store_result();
                
                if ($stmt->num_rows == 1) {
                    $username_err = "This username is already taken.";
                } else {
                    $username = trim($_POST["username"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
            $stmt->close();
        }
    }
    
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must have at least 6 characters.";
    } else {
        $password = trim($_POST["password"]);
    }
    
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }
    
    if (empty($username_err) && empty($password_err) && empty($confirm_password_err)) {
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
         
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("ss", $param_username, $param_password);
            
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT);
            
            if ($stmt->execute()) {
                header("location: login.php");
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
            $stmt->close();
        }
    }
    $mysqli->close();
}
$page_title = "Sign Up";
require_once "header.php";
?>

<main class="flex-grow container mx-auto flex items-center justify-center p-8">
    <div class="max-w-md w-full bg-white rounded-xl shadow-2xl p-8">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-6">Sign Up</h2>
        <p class="text-center text-gray-600 mb-6">Please fill this form to create an account.</p>
        <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="space-y-6">
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" id="username" name="username" class="mt-1 block w-full px-3 py-2 bg-white border <?= (!empty($username_err)) ? 'border-red-500' : 'border-gray-300'; ?> rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" value="<?= htmlspecialchars($username); ?>">
                <span class="text-red-500 text-xs italic"><?= $username_err; ?></span>
            </div>    
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="password" name="password" class="mt-1 block w-full px-3 py-2 bg-white border <?= (!empty($password_err)) ? 'border-red-500' : 'border-gray-300'; ?> rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" value="<?= htmlspecialchars($password); ?>">
                <span class="text-red-500 text-xs italic"><?= $password_err; ?></span>
            </div>
            <div>
                <label for="confirm_password" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" class="mt-1 block w-full px-3 py-2 bg-white border <?= (!empty($confirm_password_err)) ? 'border-red-500' : 'border-gray-300'; ?> rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" value="<?= htmlspecialchars($confirm_password); ?>">
                <span class="text-red-500 text-xs italic"><?= $confirm_password_err; ?></span>
            </div>
            <div>
                <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Sign Up
                </button>
            </div>
            <p class="text-center text-sm text-gray-600">
                Already have an account? <a href="login.php" class="font-medium text-blue-600 hover:text-blue-500">Login here</a>.
            </p>
        </form>
    </div>
</main>

<?php
require_once "footer.php";
?>

