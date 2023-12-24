<?php
// Include your configuration and database connection
require_once "../../../includes/config.php";

// Start the session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is authenticated and has the 'user' key in the session
if (isset($_SESSION['user'])) {
    // Extract user information from the session
    $user = $_SESSION['user'];

    // Check if the user is a Scrum Master
    if ($user['role'] === 'scrum_master') {

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create_team'])) {
            // Handle team creation
            $teamName = $_POST['team_name'];
            $description = $_POST['description'];

            // Insert new team into the database
            $insertTeamQuery = "INSERT INTO teams (name, description, created_at,scrum_master_id) VALUES (?,?,NOW(), ?)";
            $stmt = $con->prepare($insertTeamQuery);

            if ($stmt) {
                $stmt->bind_param("ssi", $teamName, $description, $user['id']);
                $stmt->execute();
                $teamId = $stmt->insert_id; // Get the last inserted team ID
                $stmt->close();

                // Insert Scrum Master into team_members pivot table
                $insertScrumMasterQuery = "INSERT INTO team_members (team_id, user_id, is_scrum_master) VALUES (?, ?, 1)";
                $stmt = $con->prepare($insertScrumMasterQuery);

                if ($stmt) {
                    $stmt->bind_param("ii", $teamId, $user['id']);
                    $stmt->execute();
                    $stmt->close();
                    echo "<p class='text-green-500 text-center'>Team created successfully!</p>";
                    header("Location: ../../index.php");
                    exit();
                } else {
                    echo "<p class='text-red-500 text-center'>Error: " . $con->error . "</p>";
                }
            } else {
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
            <title>Create Team</title>
        </head>

        <body class="bg-gray-100 h-screen flex items-center justify-center">

            <div class="bg-white p-8 rounded w-96 shadow-md max-w-md rounded-2xl">

                <h2 class="text-2xl text-center mb-6">Create Team</h2>

                <form method="post" class="space-y-4">
                    <div>
                        <label for="team_name" class="block text-sm font-medium text-gray-700">Team Name:</label>
                        <input type="text" id="team_name" name="team_name" class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:border-blue-500" required>
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Description:</label>
                        <textarea id="description" name="description" class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:border-blue-500" required></textarea>
                    </div>

                    <!-- Scrum Master will be added automatically -->

                    <button type="submit" name="create_team" class="w-full text-white bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2">Create Team</button>

                </form>
            </div>

        </body>

        </html>

    <?php
    } else {
        echo "<p class='text-red-500 text-center'>Access denied. You are not a Scrum Master.</p>";
    }
} else {
    echo "<p class='text-red-500 text-center'>Access denied. You are not authenticated.</p>";
}

// Close the database connection
$con->close();
?>
