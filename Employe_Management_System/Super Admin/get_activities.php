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

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['task_id'])) {
    $selectedTaskId = $_POST['task_id'];

    // Prepare a parameterized statement to prevent SQL injection
    $sql = "SELECT * FROM taskactivities WHERE Tid = task_id";
    
    // Prepare and bind the statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $selectedTaskId);

    // Execute the statement
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    $departmentOptions = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // $activityid[] = $row["activityid"];
            $activity[] = $row["activity"];

        }
    }

    // Generate the HTML for department options
    $options = '';
    foreach ($activity as $option) {
        $options .= "<option value=\"$option\">$option</option>";
    }

    echo $options;
}

// Close the database connection
$conn->close();
?>
