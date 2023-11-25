<?php
  $servername = "localhost";
  $username = "root";
  $password = "";
  $database = "Project";
  
  $conn = mysqli_connect($servername, $username, $password, $database);
  
  // Check connection
  if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
  }

  $email=$_POST['email'];
  $pass=$_POST['pass'];

  $sql="SELECT * FROM employee WHERE email='$email'";
  $result=mysqli_query($conn,$sql);
  $row = mysqli_fetch_assoc($result);

  if($email==$row['email'] && $pass==$row['password']){
    //start the session
    session_start();

    //set session variables
    $_SESSION['Eid']=$row['Eid'];
    $_SESSION['Name']=$row['Name'];
    $_SESSION['UserType']=$row['userType'];

    
      if($row['userType']=="Super Admin"){
        header("location:../Super Admin/emp.php");
      }elseif($row['userType']=="Admin"){
        header("location:../Admin/task.php");
      }elseif($row['userType']=="Client"){
        header("location:../Client/home.php");
      }else{
        echo '<script>alert(Undefined user type. Please contact your supervisor.);</script>';
      }
    

    
  }else{
    echo'<div id="notification" style="display: none;">
        <center>Login Failed! <br>Username or Password is incorrect</center>
      </div>';
      echo "<script>
      // Function to display the notification and redirect
      function displayNotificationAndRedirect() {
        // Display the notification
        var notification = document.getElementById('notification');
        notification.style.display = 'block';
    
        // Redirect to the login form
        setTimeout(function() {
          window.location.href = 'login-form.html'; 
        }, 2000); // 2000 milliseconds (2 seconds)
      }
    
      // Call the function when the page loads
      window.onload = displayNotificationAndRedirect;
    </script>";
  }

  
?>