<?php

if(empty($_SESSION["id"])) {
    header('location: '.SITE_URL);
    exit;
};
if ($_SESSION["username"] != ADMIN_USER) {
    header('location: '.SITE_URL);
    exit;
}

include_once(GLOBAL_URL."/server/connect.php");
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }
  //echo "Connected successfully";

// Status
$sql = "SELECT id, username, email FROM users; ";

$result = $conn->query($sql);

if (!$result) {
    die('Could not query:' . mysqli_error($conn));
}
if ($result->num_rows > 0) {
    $users = [];
    while($row = $result->fetch_assoc()) {
        array_push($users,$row);
    }
};

$conn->close();
?>