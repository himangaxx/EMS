<?php
  session_start();

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
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp"
      rel="stylesheet"
    />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />

    <link rel="stylesheet" href="style.css" />
    <title>Project</title>

  </head>

  <body>

    <div class="container">
      <!-- Sidebar Section -->
      <aside>
      <h1 class="Logo"><span class="yellow">E</span>.<span class="yellow">M</span>.<span class="yellow">S</span>.</h1>

        <div class="toggle">
          <div class="close" id="close-btn">
            <span class="material-icons-sharp"> close </span>
          </div>
        </div>
        <div class="sidebar">
        
          <a href="task.php" >
            <h3>Task</h3>
          </a>
          <a href="activity.php">
            <h3>Activity</h3>
          </a>
          <a href="assignForm.php">
            <h3>Assign Task</h3>
          </a>
          <a href="report.php" class="active">
            <h3>Report</h3>
          </a>

          <a href="../Login/logout.php">
            <h3>Logout</h3>
          </a>
        </div>
      </aside>
      <!-- End of Sidebar Section -->

      <!-- Main Content -->
      <main>
        <div class="recent-orders red">
          <center><h1>Report</h1></center>
          </div>

        <div class="recent-orders top-table">
          <div class="d-flex justify-content-center">
          <table class="table ds-remove">
                    <thead class="mx-auto">
                        <tr>
                            <th>Employee</th>
                            <th>Task</th>
                            <th>Activity</th>
                            <th>Date</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody id="activity-table-body" class="mx-auto">
                    <?php
                      $Eid=$_SESSION['Eid'];
                      $sql="SELECT employee.Name AS eName, task.Name AS tName,taskactivities.activity AS tActivity,assign.dateassign AS aDate,assign.remarks AS aRemarks, assign.Eid AS aEid FROM employee,task,assign,taskactivities WHERE task.Tid=assign.Tid AND taskactivities.activityid=assign.activityid AND employee.Eid=assign.Eid";
                      $result = mysqli_query($conn, $sql);
                      if ($result->num_rows > 0) {
                          while ($row = $result->fetch_assoc()) {
                              echo "<tr>";
                              echo "<td>" . $row["eName"] . "</td>";
                              echo "<td>" . $row["tName"] . "</td>";
                              echo "<td>" . $row["tActivity"] . "</td>";
                              echo "<td>" . $row["aDate"] . "</td>";
                              echo "<td>" . $row["aRemarks"] . "</td>";                    
                              echo "</tr>";
                          }
                      } else {
                          echo "<tr><td colspan='5'>No Assignments found</td></tr>";
                      }
                      ?>
                    </tbody>
                </table>
          </div>
        </div>
      </main>
      
      <!-- End of Main Content -->
      <div class="right-section">
        <div class="nav">
          <button id="menu-btn">
            <span class="material-icons-sharp"> menu </span>
          </button>
        </div>
        <!-- End of Nav -->
    </div>

    <script>
      // Function to get the value of a query parameter by name
      function getQueryParam(name) {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(name);
      }

      // Get the message query parameter
      const message = getQueryParam("message");

      // Display the alert if a message is present
      if (message) {
        alert(message);
      }
    </script>
    <script src="index.js"></script>
    <?php mysqli_close($conn);?>
  </body>
</html>
