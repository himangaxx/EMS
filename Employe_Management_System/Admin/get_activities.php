<?php
// get_activities.php

$servername = "localhost";
$username = "root";
$password = "";
$database = "Project";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_GET['tid'])) {
    $tid = $_GET['tid'];

    $sql = "SELECT activityid, activity FROM taskactivities WHERE tid = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $tid);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $activities = array();

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $activities[] = $row;
        }
    }

    echo json_encode($activities);
} else {
    echo json_encode(array());
}

mysqli_close($conn);
?>
