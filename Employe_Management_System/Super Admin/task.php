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
          <a href="task.php" class="active">
            <h3>Task</h3>
          </a>
          <a href="activity.php">
            <h3>Activity</h3>
          </a>
          <a href="assignForm.php">
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
          <center><h1>Task</h1></center>
          </div>

        <div class="recent-orders top-table">
          <div class="d-flex justify-content-center">
            <form action="taskReg.php" method="post">
              <h2 class="text-center">Add new task</h2>
              <div class="mb-3">
                <label for="tid" class="form-label">Tid</label>
                <?php
                  $sql = "SELECT MAX(Tid) AS MID FROM task";
                  $result = mysqli_query($conn, $sql);
                  $row = mysqli_fetch_assoc($result);
                  $nextID = $row['MID']+1;
                  echo '<input
                  type="number"
                  class="form-control"
                  id="tid"
                  name="tid"
                  value="'.$nextID.'"
                  required
                  />';
                  ?>
                
              </div>
              <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input
                  type="text"
                  class="form-control"
                  id="name"
                  name="name"
                  placeholder="Enter task name here"
                  required
                />
              </div>
              <div class="mb-3">
                <label for="sdate" class="form-label">Started Date</label>
                <input
                  type="date"
                  class="form-control"
                  id="sdate"
                  name="sdate"
                  placeholder="Select started date"
                  min="<?php echo date('Y-m-d'); ?>"
                  required
                />
              </div>
              <div class="mb-3">
                <label for="edate" class="form-label">End Date</label>
                <input
                  type="date"
                  class="form-control"
                  id="edate"
                  name="edate"
                  min="<?php echo date('Y-m-d'); ?>"
                  placeholder="Select end date"
                  required
                />
              </div>
              <div class="mb-3">
                <label for="nature" class="form-label">Nature</label>
                <input
                  type="text"
                  class="form-control"
                  id="nature"
                  name="nature"
                  placeholder="Enter nature here"
                  required
                />
              </div>
              <center>
                <button type="submit" class="btn btn-primary">Submit</button>
              </center>
            </form>
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
  </body>
</html>
