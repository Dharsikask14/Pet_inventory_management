<?php
session_start();

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: home.php");
    exit;
}

require_once "db_connect.php";

$username = $password = "";
$username_err = $password_err = $login_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter username.";
    } else {
        $username = trim($_POST["username"]);
    }
    
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }
    
    if (empty($username_err) && empty($password_err)) {
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("s", $param_username);
            $param_username = $username;
            
            if ($stmt->execute()) {
                $stmt->store_result();
                
                if ($stmt->num_rows == 1) {
                    $stmt->bind_result($id, $username, $hashed_password);
                    if ($stmt->fetch()) {
                        if (password_verify($password, $hashed_password)) {
                            session_start();
                            
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;
                            
                            header("location: home.php");
                        } else {
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else {
                    $login_err = "Invalid username or password.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
            $stmt->close();
        }
    }
    $mysqli->close();
}
$page_title = "Login";
require_once "header.php";
?>

<main class="flex-grow container mx-auto flex items-center justify-center p-8">
    <div class="max-w-md w-full bg-white rounded-xl shadow-2xl p-8">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-6">Login</h2>
        <p class="text-center text-gray-600 mb-6">Please fill in your credentials to login.</p>

        <?php 
        if(!empty($login_err)){
            echo '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">' . $login_err . '</div>';
        }        
        ?>

        <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="space-y-6">
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" id="username" name="username" class="mt-1 block w-full px-3 py-2 bg-white border <?= (!empty($username_err)) ? 'border-red-500' : 'border-gray-300'; ?> rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" value="<?= htmlspecialchars($username); ?>">
                <span class="text-red-500 text-xs italic"><?= $username_err; ?></span>
            </div>    
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="password" name="password" class="mt-1 block w-full px-3 py-2 bg-white border <?= (!empty($password_err)) ? 'border-red-500' : 'border-gray-300'; ?> rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                <span class="text-red-500 text-xs italic"><?= $password_err; ?></span>
            </div>
            <div>
                <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Login
                </button>
            </div>
            <p class="text-center text-sm text-gray-600">
                Don't have an account? <a href="signup.php" class="font-medium text-blue-600 hover:text-blue-500">Sign up now</a>.
            </p>
        </form>
    </div>
</main>

<?php
require_once "footer.php";
?>

