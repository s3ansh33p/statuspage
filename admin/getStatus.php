<?php

include_once(GLOBAL_URL."/server/connect.php");
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }
  //echo "Connected successfully";

// Status
$sql = "SELECT * FROM statuses; ";

$result = $conn->query($sql);

if (!$result) {
    die('Could not query:' . mysqli_error($conn));
}
if ($result->num_rows > 0) {
    $services = [];
    while($row = $result->fetch_assoc()) {
        array_push($services,$row);
    }
};

// Updates
$date = date("j-m-y", strtotime(date('D'))-(86400*HOME_DATE_MAX));
$sql = "SELECT * FROM updates WHERE updateTime > '$date' ORDER BY id DESC; ";

$result = $conn->query($sql);

if (!$result) {
    die('Could not query:' . mysqli_error($conn));
}
if ($result->num_rows > 0) {
    $updates = [];
    while($row = $result->fetch_assoc()) {
        array_push($updates,$row);
    }
};

?>