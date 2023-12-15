<?php
require_once "./includes/config.php";

// Assume $userId is the ID of the logged-in user
$userId = 1; // Replace with the actual user ID

// Query to check if the user is part of any team or project
$query = "
    SELECT COUNT(*) AS count
    FROM team_members
    WHERE user_id = ?
";
$stmt = $con->prepare($query);

if ($stmt) {
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    // Display the message based on the query result
    if ($count == 0) {
        $message = "You are not part of any team or project.";
    } else {
        $message = "You are part of a team or project. Display team or project information here.";
    }
} else {
    $message = "Error executing the query.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Add your head content here -->
</head>
<body>
    <div>
        <h2>Membership Status</h2>
        <p><?php echo $message; ?></p>
    </div>
    <!-- Add the rest of your HTML content here -->
</body>
</html>
