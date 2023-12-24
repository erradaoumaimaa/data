<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Update Team</title>
</head>

<body class="bg-gray-100 h-screen flex items-center justify-center">

    <div class="bg-white p-8 rounded w-96 shadow-md max-w-md rounded-2xl">

        <h2 class="text-2xl text-center mb-6">Update Team</h2>

        <?php
        // Include your database connection file
        require_once "/xampp/htdocs/data/includes/config.php";

        // Check if the team ID is provided in the URL
        if (isset($_GET['id'])) {
            $teamId = $_GET['id'];

            // Fetch team data from the database
            $query = "SELECT * FROM teams WHERE id = $teamId";
            $result = mysqli_query($con, $query);

            // Check if the team exists
            if ($row = mysqli_fetch_assoc($result)) {
                $teamName = $row['name'];
                $teamDescription = $row['description'];

                // Process form submission for updating team details
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $newTeamName = $_POST['team_name'];
                    $newTeamDescription = $_POST['team_description'];

                    // Update team details in the database
                    $updateQuery = "UPDATE teams SET name = '$newTeamName', description = '$newTeamDescription' WHERE id = $teamId";
                    $updateResult = mysqli_query($con, $updateQuery);

                    if ($updateResult) {
                        echo "<p class='text-green-500'>Team details updated successfully!</p>";
                        header("Location: ../../index.php");
                    } else {
                        echo "<p class='text-red-500'>Error updating team details: " . mysqli_error($con) . "</p>";
                    }
                }
            } else {
                echo "<p class='text-red-500'>Team not found!</p>";
            }

            // Close the database connection
            mysqli_close($con);
        } else {
            echo "<p class='text-red-500'>Team ID not provided in the URL.</p>";
        }
        ?>

        <form method="post" class="space-y-4">
            <div>
                <label for="team_name" class="block text-sm font-medium text-gray-700">Team Name:</label>
                <input type="text" id="team_name" name="team_name" class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:border-blue-500" value="<?php echo $teamName; ?>" required>
            </div>

            <div>
                <label for="team_description" class="block text-sm font-medium text-gray-700">Description:</label>
                <textarea id="team_description" name="team_description" class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:border-blue-500" rows="4" required><?php echo $teamDescription; ?></textarea>
            </div>

            <button type="submit" name="update_team" class="w-full text-white bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2">Update Team</button>

        </form>
    </div>

</body>

</html>
