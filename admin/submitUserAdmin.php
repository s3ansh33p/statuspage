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

    $id = mysqli_real_escape_string($conn, $_POST['selected-user']);

    if (isset($_POST['confirm-delete']) && isset($_POST['delete'])) {
        $sql = "DELETE FROM users WHERE id='$id'; ";
        $result = $conn->query($sql);
        if (!$result) {
            die('Could not query:' . mysqli_error($conn));
        }
        header('location: '.SITE_URL);
        exit;
    }

    $sub_1 = mysqli_real_escape_string($conn, $_POST['root-username']);
    $sub_2 = mysqli_real_escape_string($conn, $_POST['root-email']);
    $sub_3 = mysqli_real_escape_string($conn, $_POST['root-password']);

    if(!(!empty($sub_1) && !empty($sub_2))){
        header('location: '.SITE_URL);
        exit;
    };

    if (empty($sub_3)) {
        $sql = "UPDATE users SET username='$sub_1', email='$sub_2' WHERE id='$id'; ";
    } else {
        $sub_3 = password_hash($sub_3, PASSWORD_BCRYPT);
        $sql = "UPDATE users SET username='$sub_1', email='$sub_2', pass='$sub_3' WHERE id='$id'; ";
    }

    $result = $conn->query($sql);
    if (!$result) {
        die('Could not query:' . mysqli_error($conn));
    }

    header('location: '.SITE_URL);
    exit;

    $conn->close();
?>