<?php
    include_once("../config.php");
    if(empty($_SESSION["id"])) {
        header('location: '.SITE_URL);
        exit;
    };
    include_once(GLOBAL_URL."/server/connect.php");

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sub_1 = mysqli_real_escape_string($conn, $_POST['username']);
    $sub_2 = mysqli_real_escape_string($conn, $_POST['email']);
    $sub_3 = mysqli_real_escape_string($conn, $_POST['password']);
    $id = mysqli_real_escape_string($conn, $_POST['userid']);

    if(!(!empty($sub_1) && !empty($sub_2))){
        header('location: '.SITE_URL);
        exit;
    };

    if (empty($sub_3)) {
        $sql = "UPDATE users SET username='$sub_1', email='$sub_2' WHERE username='$id'; ";
    } else {
        $sub_3 = password_hash($sub_3, PASSWORD_BCRYPT);
        $sql = "UPDATE users SET username='$sub_1', email='$sub_2', pass='$sub_3' WHERE username='$id'; ";
    }

    $result = $conn->query($sql);
    if (!$result) {
        die('Could not query:' . mysqli_error($conn));
    }

    header('location: '.SITE_URL);
    exit;

    $conn->close();
?>