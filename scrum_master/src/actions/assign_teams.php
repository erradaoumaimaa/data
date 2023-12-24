<?php
// Include your database connection file
require_once "/xampp/htdocs/data/includes/config.php"; 
include('../../templates/header.php');

// Fetch projects from the database
$projectsQuery = "SELECT * FROM projects";
$projectsResult = mysqli_query($con, $projectsQuery);

// Fetch teams from the database
$teamsQuery = "SELECT * FROM teams";
$teamsResult = mysqli_query($con, $teamsQuery);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Assign Teams to Projects</title>
</head>

<body>
    <div class="container mx-auto mt-10">
        <h1 class="text-center text-2xl font-semibold mb-4">Assign Teams to Projects</h1>

        <form method="post" action="./process_assign_teams.php" class="space-y-4">
            <div>
                <label for="project_id" class="block text-sm font-medium text-gray-700">Select Project:</label>
                <select name="project_id" id="project_id" class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:border-blue-500" required>
                    <?php
                    // Display projects in the dropdown
                    while ($project = mysqli_fetch_assoc($projectsResult)) {
                        echo "<option value='{$project['id']}'>{$project['name']}</option>";
                    }

                    // Close the projects result set
                    mysqli_free_result($projectsResult);
                    ?>
                </select>
            </div>

            <div>
                <label for="team_id" class="block text-sm font-medium text-gray-700">Select Team:</label>
                <select name="team_id" id="team_id" class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:border-blue-500" required>
                    <?php
                    // Display teams in the dropdown
                    while ($team = mysqli_fetch_assoc($teamsResult)) {
                        echo "<option value='{$team['id']}'>{$team['name']}</option>";
                    }

                    // Close the teams result set
                    mysqli_free_result($teamsResult);
                    ?>
                </select>
            </div>

            <button type="submit" name="assign_teams" class="w-full text-white bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5">
                Assign Team
            </button>
        </form>
    </div>

    <script>
        // You may want to add any necessary JavaScript for interactivity here
    </script>

</body>
</html>
