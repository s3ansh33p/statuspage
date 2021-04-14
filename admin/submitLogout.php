<?php
    include_once("../config.php");

    //Header Link Information for later
    include_once(GLOBAL_URL."/server/path.php");

    session_unset();
    session_destroy();
    //Go to homepage
    header('location: '.SITE_URL);
    exit;

    $conn->close();
?>







