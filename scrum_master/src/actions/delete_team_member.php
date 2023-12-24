<?php
// Include your database connection file
require_once "/xampp/htdocs/data/includes/config.php";

// Check if the user is a Scrum Master (you may have additional checks)
if ($_SESSION['user']['role'] !== 'scrum_master') {
    echo "Access denied. You are not a Scrum Master.";
    exit();
}

// Get team ID and user ID from the query parameters
$teamId = $_GET['team_id'];
$userId = $_GET['user_id'];

// Perform the deletion (you should add proper validation and error handling)
$deleteQuery = "DELETE FROM team_members WHERE team_id = ? AND user_id = ?";
$stmt = $con->prepare($deleteQuery);

if ($stmt) {
    $stmt->bind_param("ii", $teamId, $userId);
    $stmt->execute();
    echo "Team member deleted successfully!";
    header("Location: ../../index.php");
} else {
    echo "Error deleting team member: " . $con->error;
}

// Close the database connection
$con->close();
?>
