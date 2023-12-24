<?php
// Include your database connection file
require_once "/xampp/htdocs/data/includes/config.php"; 
include "/xampp/htdocs/data/product_owner/templates/header.php";

// Check if the project ID is provided in the URL
if (isset($_GET['id'])) {
    $projectId = $_GET['id'];

    // Fetch project data from the database for the specified ID, including Scrum Master's email
    // $query = "SELECT projects.*, users.email AS scrum_master_email FROM projects JOIN users ON projects.scrum_master_id = users.id WHERE projects.id = ?";
    // Fetch project data from the database for the specified ID
    $query = "SELECT * FROM projects WHERE id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $projectId);
    $stmt->execute();
    $result = $stmt->get_result();
    $projectData = $result->fetch_assoc();
    $stmt->close();


    // Format dates to match HTML5 date input format (YYYY-MM-DD)
    $projectData['date_start'] = date('Y-m-d', strtotime($projectData['date_start']));
    $projectData['date_end'] = date('Y-m-d', strtotime($projectData['date_end']));
} else {
    // Handle error if project ID is not provided
    echo "Error: Project ID not provided.";
    exit();
}
?>

<div class="container mx-auto mt-10">
    <h1 class="text-center text-2xl font-semibold mb-4">Edit Project: <?php echo $projectData['name']; ?></h1>

    <form action="./processupdate_project.php" method="POST" class="max-w-md mx-auto bg-white p-8 border rounded-md shadow-md">

        <!-- Add form fields with existing project data -->
        <input type="hidden" name="project_id" value="<?php echo $projectId; ?>">

        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Project Name:</label>
            <input type="text" id="name" name="name" class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:border-blue-500" value="<?php echo $projectData['name']; ?>" required>
        </div>

        <div class="mb-4">
            <label for="description" class="block text-sm font-medium text-gray-700">Description:</label>
            <textarea id="description" name="description" class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:border-blue-500" required><?php echo $projectData['description']; ?></textarea>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div class="mb-4">
                <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date:</label>
                <input type="date" id="start_date" name="start_date" class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:border-blue-500" value="<?php echo $projectData['date_start']; ?>" required>
            </div>

            <div class="mb-4">
                <label for="end_date" class="block text-sm font-medium text-gray-700">End Date:</label>
                <input type="date" id="end_date" name="end_date" class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:border-blue-500" value="<?php echo $projectData['date_end']; ?>" required>
            </div>
        </div>

        <div class="mb-4">
            <label for="status" class="block text-sm font-medium text-gray-700">Status:</label>
            <input type="text" id="status" name="status" class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:border-blue-500" value="<?php echo $projectData['status']; ?>" required>
        </div>

        <div class="mb-4">
            <label for="scrum_master_id" class="block text-sm font-medium text-gray-700">Scrum Master's :</label>
            <input type="text" id="scrum_master_id" name="scrum_master_id" class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:border-blue-500" value="<?php echo $projectData['scrum_master_id']; ?>" required>
        </div>

        <!-- Add other form fields based on your table structure -->

        <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:border-blue-300">Save Changes</button>
    </form>
</div>
