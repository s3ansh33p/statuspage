<?php
    include_once("../config.php");
    if(empty($_SESSION["id"])) {
        header('location: '.SITE_URL);
        exit;
    };
    if ($_SESSION["username"] != ADMIN_USER) {
        header('location: '.SITE_URL);
        exit;
    }
    include_once(GLOBAL_URL."/server/connect.php");

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sub_1 = mysqli_real_escape_string($conn, $_POST['username']);
    $sub_2 = mysqli_real_escape_string($conn, $_POST['email']);
    $sub_3 = password_hash(mysqli_real_escape_string($conn, $_POST["password"]), PASSWORD_BCRYPT);

    if(!(!empty($sub_1) && !empty($sub_2) && !empty($sub_3))){
        header('location: '.SITE_URL);
        exit;
    };

    $sql = "INSERT IGNORE INTO users (username, email, pass, registered) VALUES
    ('$sub_1', '$sub_2', '$sub_3', now()); ";

    $result = $conn->query($sql);
    if (!$result) {
        die('Could not query:' . mysqli_error($conn));
    }

    header('location: '.SITE_URL);
    exit;

    $conn->close();
?>