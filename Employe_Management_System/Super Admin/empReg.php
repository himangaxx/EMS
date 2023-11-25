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

  $conn = mysqli_connect($servername,$username,$password,$database);

  // Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

  $eid=$_POST["eid"];
  $tele=$_POST["tele"];
  $name=$_POST["name"];
  $email=$_POST["email"];
  $password=$_POST["password"];
  $des=$_POST["des"];
  $userT=$_POST["userT"];

  
  // Check if the email already exists in the database
  $checkEmailQuery = "SELECT * FROM employee WHERE email = '$email'";
  $result = mysqli_query($conn, $checkEmailQuery);

  if (mysqli_num_rows($result) > 0) {
      // Email already exists, display an error message
      header("Location: emp.php?message=Email is already registered. Please choose a different email.");
      exit;
  } else {
      // Email is unique, proceed with the insertion
      $insertQuery = "INSERT INTO employee VALUES ('$eid', '$tele', '$name', '$email', '$password', '$des', '$userT')";

      if (mysqli_query($conn, $insertQuery)) {
          // Employee added successfully, redirect to a success page
          header("Location: emp.php?message=Employee added successfully.");
          exit;
      } else {
          // Error occurred while adding the employee, redirect to an error page
          header("Location: emp.php?message=Error adding the employee. Please try again later.");
          exit;
      }
  } 


mysqli_close($conn);
?>