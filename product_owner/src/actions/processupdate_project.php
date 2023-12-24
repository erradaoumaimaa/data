<?php
// Include your database connection file
require_once "/xampp/htdocs/data/includes/config.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   // Get form data
   $projectId = $_POST["project_id"];
   $name = $_POST["name"];
   $description = $_POST["description"];
   $startDate = $_POST["start_date"];
   $endDate = $_POST["end_date"];
   $status = $_POST["status"];
   
   // Check if $_POST["scrum_master_id"] is set
   $scrumMasterid = isset($_POST["scrum_master_id"]) ? $_POST["scrum_master_id"] : null;

   // Update project data in the database
   $query = "UPDATE projects SET 
               name = ?,
               description = ?,
               date_end = ?,
               status = ?,
               scrum_master_id = ?
             WHERE id = ?";
   $stmt = $con->prepare($query);

   if ($stmt) {
      // Adjust the number of 's' in the bind_param based on the number of parameters
      $stmt->bind_param("sssssi", $name, $description, $endDate, $status, $scrumMasterid, $projectId);
      $stmt->execute();
      $stmt->close();

      // Redirect to the projects page or show a success message
      header("Location: /data/product_owner/src/index.php");
      exit();
   } else {
      // Handle the error
      echo "Error: " . $con->error;
   }

   // Close the database connection
   $con->close();
}
?>
