<?php

session_start();

  
  // If the session is not active, redirect to the login page
  if (!isset($_SESSION['Eid'])) {
    header("Location: ../Login/login-form.html"); // Change "login.php" to the actual login page URL
    exit; // Ensure no further code execution
}

$servername = "localhost";
$username = "root";
$password = "";
$database = "Project";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["addedActivities"])) {
        // Get the addedActivities array from the POST data
        $addedActivities = $_POST["addedActivities"];

        // Get the last activityId from the database
        $sql = "SELECT MAX(activityId) AS maxActivityId FROM taskactivities";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $lastActivityId = $row["maxActivityId"];

        // Initialize a variable to track insertion success
        $insertSuccess = true;

        // Start with the next activityId
        $nextActivityId = $lastActivityId + 1;

        foreach ($addedActivities as $data) {
            $tid = $data["tid"];
            $activity = $data["activity"];

            // Insert data into the database using the nextActivityId
            $sql = "INSERT INTO taskactivities (activityId, Tid, activity) VALUES ('$nextActivityId', '$tid', '$activity')";
            if (!mysqli_query($conn, $sql)) {
                $insertSuccess = false;
                echo "Error inserting data: " . mysqli_error($conn);
                break; // Exit the loop on the first error
            }

            // Increment the nextActivityId for the next activity
            $nextActivityId++;
        }

        // Send a JSON response indicating success or failure
        if ($insertSuccess) {
            echo json_encode(["status" => "success"]);
        } else {
            echo json_encode(["status" => "error"]);
        }
    }
}

mysqli_close($conn);
?>
