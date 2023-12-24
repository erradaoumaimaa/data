<?php
// Include your database connection file
require_once "/xampp/htdocs/data/includes/config.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['assign_teams'])) {
    // Get the project ID and team ID from the form
    $projectId = $_POST['project_id'];
    $teamId = $_POST['team_id'];

    // Update the project with the selected team
    $updateProjectQuery = "UPDATE projects SET team_id = ? WHERE id = ?";
    $stmt = $con->prepare($updateProjectQuery);

    if ($stmt) {
        $stmt->bind_param("ii", $teamId, $projectId);
        $stmt->execute();

        echo "<p class='text-green-500 text-center'>Team assigned to the project successfully!</p>";
        header("location: ../../index.php");
    } else {
        echo "<p class='text-red-500 text-center'>Error assigning team to project: " . $con->error . "</p>";
    }

    $stmt->close();
}

// Close the database connection
$con->close();
?>
