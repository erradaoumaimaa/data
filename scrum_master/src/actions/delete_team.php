<?php
require_once "/xampp/htdocs/data/includes/config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the team ID from the POST data
    $teamId = $_POST["team_id"];

    // Perform the deletion in the database
    $deleteQuery = "DELETE FROM teams WHERE id = $teamId";
    $deleteResult = mysqli_query($con, $deleteQuery);

    // Check if the deletion was successful
    if ($deleteResult) {
        echo "Team deleted successfully!";
        header("Location: ../../index.php");
    } else {
        echo "Error deleting team: " . mysqli_error($con);
    }

    // Close the database connection
    mysqli_close($con);
} else {
    // If the request is not a POST request, redirect to an error page or the team list page
    header("Location: ../error.php");
    exit();
}
?>
