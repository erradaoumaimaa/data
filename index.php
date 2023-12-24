<?php
// Include configuration and connect to the database
require_once "./includes/config.php";

// Check if a session is not already active
if (session_status() == PHP_SESSION_NONE) {
    // Start the session
    session_start();
}
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Query to check user credentials
    $query = "SELECT id, password, role, username FROM users WHERE email = ?";
    $stmt = $con->prepare($query);

    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($userId, $hashedPassword, $role, $username);
        $stmt->fetch();
        $stmt->close();

        // Verify password
        if (password_verify($password, $hashedPassword)) {
            // Set user information in session
            $_SESSION['user'] = [
                'id' => $userId,
                'username' => $username,
                'role' => $role,
            ];

            // Redirect based on the user's role
            if ($role === 'scrum_master') {
                header("Location: ./scrum_master/index.php");
                exit();
            } elseif ($role === 'product_owner') {
                header("Location: ./product_owner/src/index.php");
                exit();
            } elseif ($role === 'user') {
                header("Location: ./membre/src/index.php");
                exit();
            } else {
                // Handle unknown role or other cases
                // You can redirect to a generic dashboard or display an error message
                header("Location: generic_dashboard.php");
                exit();
            }
        } else {
            // Incorrect password
            echo "<p class='text-red-500 text-center'>Incorrect email or password.</p>";
        }
    } else {
        // Handle database connection error
        echo "<p class='text-red-500 text-center'>Error: " . $con->error . "</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="./js/main.js" defer></script>
    <title>Sign In</title>
</head>
<body class="bg-gray-100 h-screen flex items-center justify-center">

    <div class="bg-white p-8 rounded w-96 shadow-md max-w-md rounded-2xl">

        <h2 class="text-2xl text-center mb-6">Sign In</h2>
      
        <form name="signInForm" action="index.php" method="POST" onsubmit="return validateForm();">   
            <!--Email input-->    
            <div class="mb-4">  
                <input type="email" id="email" name="email" placeholder="Email" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:border-blue-500 drop-shadow-lg" required>
            </div>
            <!--Password input-->   
            <div class="mb-6">
                <label for="password" class="sr-only">Password</label>
                <input type="password" id="password" name="password" placeholder="Password" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:border-blue-500 drop-shadow-lg" required>
            </div>

            <button type="submit" class="w-full bg-red-500 text-white py-2 rounded-2xl hover:bg-blue-600 focus:outline-none focus:ring focus:border-blue-300">Get started</button>
            <p class="mt-4 text-gray-600 text-xs text-center">Don't have an account? <a href="./SignUp.php" class="text-blue-500 hover:underline">Sign up here</a>.</p>
        </form>

    </div>

</body>
</html>
