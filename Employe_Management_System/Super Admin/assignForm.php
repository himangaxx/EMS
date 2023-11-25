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
          <a href="emp.php">
            <h3>Employee</h3>
          </a>
          <a href="task.php">
            <h3>Task</h3>
          </a>
          <a href="activity.php">
            <h3>Activity</h3>
          </a>
          <a href="assignForm.php" class="active">
            <h3>Assign Task</h3>
          </a>

          <a href="report.php">
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
        <center><h1>Assign Task</h1></center>
        </div>

        <div class="recent-orders top-table">
          <div class="d-flex justify-content-center">
          <form id="activity-form" action="assign.php" method="POST">
        <center><h2>Assign tasks to employees</h2></center>
        <table class="form-table ds-remove">
        <tr>
                <td class="form-label">Employee</td>
                <td>
                    <select name="eid" id="eid" class="form-control" required>
                    <option value="" disabled selected hidden>Select employee</option>
                        <?php
                        // Populate the dropdown with Task IDs from the database
                        $sql = "SELECT Eid,name FROM employee";
                        $result = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='" . $row["Eid"] . "'>" . $row["name"] . "</option>";
                            }
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="form-label">Task</td>
                <td>
                    <select name="tid" id="tid" class="form-control" required>
                    <option value="" disabled selected hidden>Select task</option>
                        <?php
                        // Populate the dropdown with Task IDs from the database
                        $sql = "SELECT Tid,name FROM task";
                        $result = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='" . $row["Tid"] . "'>" . $row["name"] . "</option>";
                            }
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
            <td class="form-label"> Date Assigned </td>
            <td><input type="date" name="date" id="date" class="form-control" min="<?php echo date('Y-m-d'); ?>" required></td>
            </tr>
            <tr>
                <td class="form-label">Activity</td>
                <td>
                    <select name="aid" id="aid" class="form-control" required>
                    <option value="" disabled selected hidden>Select activity</option>
                        <?php
                        // Populate the dropdown with Task IDs from the database
                        $sql = "SELECT activityid,activity FROM taskactivities";
                        $result = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='" . $row["activityid"] . "'>" . $row["activity"] . "</option>";
                            }
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="form-label">remarks</td>
                <td><input type="text" name="remarks" class="form-control" placeholder="Add remarks"/></td>
            </tr>
        </table>
        <button type="submit" name="sub" id="sub" class="btn btn-primary">Submit</button>
    </form>
          </div>
        </div>
        <!-- End of Recent Orders -->
      </main>
      <!-- End of Main Content -->
      <div class="right-section">
        <div class="nav">
          <button id="menu-btn">
            <span class="material-icons-sharp"> menu </span>
          </button>
        </div>
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
    <script>
  // Function to populate the department dropdown based on the selected faculty
  function populateActivities() {
    var selectedTask = $('#tid').val();
    $.ajax({
      type: 'POST',
      url: 'get_activities.php', // Create a PHP script to handle the AJAX request
      data: { task_id: selectedTask },
      success: function(data) {
        $('#aid').html(data); // Populate the department dropdown with the response
      }
    });
  }

  // Attach the populateDepartments function to the onchange event of the Faculty dropdown
  $('#tid').on('change', populateActivities);
</script>
    <script src="index.js"></script>
  </body>
</html>
