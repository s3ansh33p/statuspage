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
$sql = "SELECT * FROM updates ORDER BY id DESC; ";

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