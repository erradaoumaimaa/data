<?php
// Include your database connection file
require_once "/xampp/htdocs/data/includes/config.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_member'])) {
    // Get the selected user ID from the form
    $userId = $_POST['user_id'];

    // Get the team ID from the URL parameter
    $teamId = $_GET['team_id'];

    // Check if the user is already a member of the team
    $checkMemberQuery = "SELECT * FROM team_members WHERE team_id = ? AND user_id = ?";
    $stmt = $con->prepare($checkMemberQuery);

    if ($stmt) {
        $stmt->bind_param("ii", $teamId, $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<p class='text-red-500 text-center'>User is already a member of the team.</p>";
        } else {
            // Insert the selected user as a team member
            $insertMemberQuery = "INSERT INTO team_members (team_id, user_id, is_scrum_master) VALUES (?, ?, 0)";
            $stmt = $con->prepare($insertMemberQuery);

            if ($stmt) {
                $stmt->bind_param("ii", $teamId, $userId);
                $stmt->execute();
                echo "<p class='text-green-500 text-center'>User added to the team successfully!</p>";
                header("location:../../index.php");
            } else {
                echo "<p class='text-red-500 text-center'>Error adding user to the team: " . $con->error . "</p>";
            }
        }

        $stmt->close();
    } else {
        echo "<p class='text-red-500 text-center'>Error checking team membership: " . $con->error . "</p>";
    }
}

// Fetch team data from the database
$teamId = $_GET['team_id'];
$query = "SELECT * FROM teams WHERE id = ?";
$stmt = $con->prepare($query);

if ($stmt) {
    $stmt->bind_param("i", $teamId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $team = $result->fetch_assoc();
    } else {
        echo "<p class='text-red-500 text-center'>Team not found.</p>";
        exit();
    }

    $stmt->close();
} else {
    echo "<p class='text-red-500 text-center'>Error fetching team data: " . $con->error . "</p>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Add Team Members</title>
</head>

<body class="bg-gray-100 h-screen flex items-center justify-center">

    <div class="bg-white p-8 rounded w-96 shadow-md max-w-md rounded-2xl">

        <h1 class="text-2xl text-center mb-6">Add Team Members to Team: <?php echo $team['name']; ?></h1>

        <form method="post" action="add_members.php?team_id=<?php echo $teamId; ?>" class="space-y-4">
            <div class="mb-4">
                <label for="user_id" class="block text-sm font-medium text-gray-700">Select User:</label>
                <select name="user_id" id="user_id" class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:border-blue-500">
                    <?php
                    // Fetch users from the database
                    $usersQuery = "SELECT id, username FROM users";
                    $usersResult = mysqli_query($con, $usersQuery);

                    while ($user = mysqli_fetch_assoc($usersResult)) {
                        echo "<option value='{$user['id']}'>{$user['username']}</option>";
                    }

                    mysqli_free_result($usersResult);
                    ?>
                </select>
            </div>

            <button type="submit" name="add_member" class="w-full text-white bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5">Add Member</button>
        </form>
    </div>

</body>

</html>

<?php
// Close the database connection
$con->close();
?>
