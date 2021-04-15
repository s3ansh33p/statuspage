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

$pos = strpos($sub_1, '-');
$type = substr($sub_1,0,$pos);
$id = substr($sub_1,($pos+1));
$sub_time = date(DateTime::ISO8601);

if ($type == 'service') {

  if (isset($_POST['confirm-delete']) && isset($_POST['delete'])) {
      $sql = "DELETE FROM statuses WHERE id='$id'; ";
      $result = $conn->query($sql);
      if (!$result) {
          die('Could not query:' . mysqli_error($conn));
      }
      header('location: '.SITE_URL);
      exit;
  }

    $sub_2 = mysqli_real_escape_string($conn, $_POST['status']);
    $sub_3 = mysqli_real_escape_string($conn, $_POST['link']);
    $sub_4 = mysqli_real_escape_string($conn, $_POST['tag']);
    // Check if valid input
    if ($sub_2 == "1" || $sub_2 == "2" || $sub_2 == "3") {
        // Run update SQL
        $sql = "UPDATE statuses SET serviceState='$sub_2', serviceName='$sub_3', serviceTag='$sub_4', updateTime='$sub_time' WHERE id='$id'; ";

        $result = $conn->query($sql);
        if (!$result) {
        die('Could not query:' . mysqli_error($conn));
        }
        header('location: '.SITE_URL);
        exit;
    } else {
        $_SESSION["invalidInput"] = 1;
        header('location: '.SITE_URL);
        exit;
    }
} else {

  if (isset($_POST['confirm-delete']) && isset($_POST['delete'])) {
    $sql = "DELETE FROM updates WHERE id='$id'; ";
    $result = $conn->query($sql);
    if (!$result) {
        die('Could not query:' . mysqli_error($conn));
    }
    header('location: '.SITE_URL);
    exit;
}

    $sub_2 = mysqli_real_escape_string($conn, $_POST['service']);
    $sub_3 = mysqli_real_escape_string($conn, $_POST['title']);
    $sub_4 = mysqli_real_escape_string($conn, $_POST['description']);
    $sql = "UPDATE updates SET serviceId='$sub_2', updateTitle='$sub_3', updateDescription='$sub_4' WHERE id='$id'; ";

        $result = $conn->query($sql);
        if (!$result) {
        die('Could not query:' . mysqli_error($conn));
        }
        header('location: '.SITE_URL);
        exit;
}

$conn->close();
?>