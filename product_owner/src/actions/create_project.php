<?php
require_once "/xampp/htdocs/data/includes/config.php"; // Include your database connection file
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = $_POST["name"];
    $description = $_POST["description"];
    $endDate = $_POST["end_date"];
    $status = $_POST["status"];
    $scrumMasterEmail = $_POST["scrum_master"];

    // Get the Scrum Master's user ID based on their email
    $scrumMasterQuery = "SELECT id FROM users WHERE email = ?";
    $scrumMasterStmt = $con->prepare($scrumMasterQuery);

    if ($scrumMasterStmt) {
        $scrumMasterStmt->bind_param("s", $scrumMasterEmail);
        $scrumMasterStmt->execute();
        $scrumMasterStmt->bind_result($scrumMasterId);
        $scrumMasterStmt->fetch();
        $scrumMasterStmt->close();


        // Insert project data into the database
        $insertQuery = "INSERT INTO projects (name, description, date_start, date_end, status, product_owner_id, scrum_master_id) 
                        VALUES (?, ?, NOW(), ?, ?, ?, ?)";
        $insertStmt = $con->prepare($insertQuery);

        if ($insertStmt) {
            // Assuming you have a variable for the Product Owner's user ID, replace $productOwnerId with your actual variable
            $productOwnerId = 10; // Replace this with the actual Product Owner's user ID
            $insertStmt->bind_param("ssssii", $name, $description, $endDate, $status, $productOwnerId, $scrumMasterId);
            $insertStmt->execute();
            $insertStmt->close();

            // Redirect to the projects page or show a success message
            header("Location: /data/product_owner/src/index.php");
            exit();
        } else {
            // Handle the error
            echo "Error: " . $con->error;
        }
    } else {
        // Handle the error
        echo "Error: " . $con->error;
    }

    // Close the database connection
    $con->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Create Project</title>
</head>

<body class="bg-gray-100 h-screen flex items-center justify-center">

    <div class="bg-white p-8 rounded w-96 shadow-md max-w-md rounded-2xl">

        <h2 class="text-2xl text-center mb-6">Create Project</h2>

        <form action="create_project.php" method="POST" class="space-y-4">

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Project Name:</label>
                <input type="text" id="name" name="name" class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:border-blue-500" required>
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Description:</label>
                <textarea id="description" name="description" class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:border-blue-500" required></textarea>
            </div>
            <div>
                <label for="end_date" class="block text-sm font-medium text-gray-700">Deadline:</label>
                <input type="date" id="end_date" name="end_date" class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:border-blue-500" required>
            </div>

            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Status:</label>
                <input type="text" id="status" name="status" class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:border-blue-500" required>
            </div>

            <div>
                <label for="scrum_master" class="block text-sm font-medium text-gray-700">Scrum Master:</label>
                <select id="scrum_master" name="scrum_master" class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:border-blue-500" required>
                    <?php
                    $query = "SELECT email FROM users WHERE role = 'scrum_master'";
                    $result = mysqli_query($con, $query);

                    if ($result) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<option value='{$row['email']}'>{$row['email']}</option>";
                        }
                    } else {
                        // Handle query error
                        echo 'Error executing query: ' . mysqli_error($con);
                    }

                    // Close the database connection if needed
                    mysqli_close($con);
                    ?>
                </select>
            </div>

            <button type="submit" class="w-full text-white bg-yellow-400 hover:bg-yellow-500 focus:outline-none focus:ring-4 focus:ring-yellow-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:focus:ring-yellow-900">Create Project</button>

        </form>
    </div>

</body>

</html>
