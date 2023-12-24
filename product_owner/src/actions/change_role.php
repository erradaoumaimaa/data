<?php
// Include your database connection file
require_once "/xampp/htdocs/data/includes/config.php";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get user ID and new role from the form submission
    $userId = $_POST["user_id"];
    $newRole = $_POST["new_role"];

    // Update the user's role in the database
    $updateQuery = "UPDATE users SET role = '$newRole' WHERE id = $userId";
    $updateResult = mysqli_query($con, $updateQuery);

    // Check if the update was successful
    if ($updateResult) {
        echo "Role updated successfully.";
        header("Location: assign_sm.php");
        exit();
    } else {
        echo "Error updating role: " . mysqli_error($con);
    }
}

// Close the database connection
mysqli_close($con);
?>
