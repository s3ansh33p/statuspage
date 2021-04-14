<?php
  include_once("../config.php");
  if(empty($_SESSION["id"])) {
    header('location: '.SITE_URL);
    exit;
  };
include_once(GLOBAL_URL."/server/connect.php");
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }
  //echo "Connected successfully";

$sub_1 = mysqli_real_escape_string($conn, $_POST['edit-section']);

$sub_time = date(DateTime::ISO8601);
if ($sub_1 == 'service') {
    $sub_2 = mysqli_real_escape_string($conn, $_POST['link']);
    $sub_3 = mysqli_real_escape_string($conn, $_POST['status']);
    $sub_4 = mysqli_real_escape_string($conn, $_POST['tag']);
    $sql = "INSERT INTO statuses (serviceName, serviceState, serviceTag, updateTime) VALUES ('$sub_2', '$sub_3', '$sub_4', '$sub_time')";
    $result = $conn->query($sql);
    if (!$result) {
    die('Could not query:' . mysqli_error($conn));
    }
    header('location: '.SITE_URL);
    exit;
} else {
    // Update
    $sub_2 = mysqli_real_escape_string($conn, $_POST['service']);
    $sub_3 = mysqli_real_escape_string($conn, $_POST['title']);
    $sub_4 = mysqli_real_escape_string($conn, $_POST['description']);
    $sql = "INSERT INTO updates (serviceId, updateTitle, updateDescription, updateTime) VALUES ('$sub_2', '$sub_3', '$sub_4', '$sub_time')";
    $result = $conn->query($sql);
    if (!$result) {
    die('Could not query:' . mysqli_error($conn));
    }
    header('location: '.SITE_URL);
    exit;
}

$conn->close();
?>