<?php
// Include configuration and connect to the database
require_once "/xampp/htdocs/data/includes/config.php";

// Check if a session is not already active
if (session_status() == PHP_SESSION_NONE) {
    // Start the session
    session_start();
}

// Check if the user is logged in
if (isset($_SESSION['user'])) {
    // Fetch user data
    $userId = $_SESSION['user']['id'];
    $userRole = $_SESSION['user']['role'];
    $username = $_SESSION['user']['username'];

    ?>
    <!DOCTYPE html>
    <html lang="en">
    
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
        <script src="./js/main.js" defer></script>
        <title>User Dashboard</title>
    </head>
    
    <body class="bg-gray-100 h-screen flex items-center justify-center">
    
        <div class="bg-white p-8 rounded w-96 shadow-md max-w-md rounded-2xl">
    
            <h2 class="text-2xl text-center mb-6">Hello, <?php echo $username; ?>!</h2>
          
            <?php
            // Display user's teams
            $teamQuery = "SELECT teams.*, team_members.is_scrum_master FROM teams 
                          JOIN team_members ON teams.id = team_members.team_id
                          WHERE team_members.user_id = $userId";
            $teamResult = mysqli_query($con, $teamQuery);
    
            if (mysqli_num_rows($teamResult) > 0) {
                echo "<h3 class='text-xl font-semibold mb-4'>Your Teams:</h3>";
                // Loop through the team data and display information for each team
                while ($teamRow = mysqli_fetch_assoc($teamResult)) {
                    echo "<div class='bg-white p-4 rounded-lg shadow-md flex flex-col justify-between w-full'>";
                  // Display team information
                echo "<p>Team Name: {$teamRow['name']}</p>";
                // echo "<p>Scrum Master: " . ($teamRow['is_scrum_master'] ? 'Yes' : 'No') . "</p>";
                echo "<p>Description: {$teamRow['description']}</p>";
                echo "<p>Creation Date: " . date('d M Y', strtotime($teamRow['created_at'])) . "</p>";
            
                    echo "</div>";
                }
            } else {
                echo "<p class='text-center text-gray-600 mb-4'>You are not a member of any teams.</p>";
            }
    
            // Display user's projects
            $projectQuery = "SELECT projects.* FROM projects 
                             JOIN team_members ON projects.team_id = team_members.team_id
                             WHERE team_members.user_id = $userId";
            $projectResult = mysqli_query($con, $projectQuery);
    
            if (mysqli_num_rows($projectResult) > 0) {
                echo "<h3 class='text-xl font-semibold mb-1'>Your Projects:</h3>";
                // Loop through the project data and display information for each project
                while ($projectRow = mysqli_fetch_assoc($projectResult)) {
                    echo "<div class='bg-white p-4 rounded-lg shadow-md flex flex-col justify-between w-full'>";
                  // Display project information
                    echo "<p>Project Name: {$projectRow['name']}</p>";
                    echo "<p>Description: {$projectRow['description']}</p>";
                    echo "<p>Start Date: " . date('d M Y', strtotime($projectRow['date_start'])) . "</p>";
                    echo "<p>End Date: " . date('d M Y', strtotime($projectRow['date_end'])) . "</p>";
                  
                    echo "</div>";
                }
            } else {
                echo "<p class='text-center text-gray-600 mb-4'>You are not associated with any projects.</p>";
            }
    
            // Close result sets
            mysqli_free_result($teamResult);
            mysqli_free_result($projectResult);
    
            // Close the database connection
            mysqli_close($con);
            ?>
        </div>
    
    </body>
    
    </html>
    <?php
} else {
    echo "<p class='text-center text-red-600 mb-4'>You are not logged in.</p>";
}
?>
