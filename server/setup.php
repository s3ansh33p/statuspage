<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php include_once("../config.php");
      $title = 'Setup';
      include_once(GLOBAL_URL."/components/header.php");
    ?>
</head>
<style>
  body {
    text-align: center;
    padding: 40px 0;
    background: #EBF0F5;
  }
    h1 {
      color: #88B04B;
      font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
      font-weight: 900;
      font-size: 40px;
      margin-bottom: 10px;
    }
    p {
      color: #404F5E;
      font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
      font-size:20px;
      margin: 0;
    }
  i {
    color: #9ABC66;
    font-size: 100px;
    line-height: 200px;
    margin-left:-15px;
  }
  .card {
    background: white;
    padding: 60px;
    border-radius: 4px;
    box-shadow: 0 2px 3px #C8D0D8;
    display: inline-block;
    margin: 0 auto;
  }
  .inner-card {
    border-radius:200px;
    height:200px;
    width:200px;
    background: #F8FAF5;
    margin: 0 auto;
  }
</style>
<body class="center">

<?php

  $sql = "";

  // Database
  $sql .= "CREATE DATABASE IF NOT EXISTS ".DB_NAME."; USE ".DB_NAME."; ";

  // Users
  $sql .= "CREATE TABLE IF NOT EXISTS users (
      id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      username text NOT NULL,
      email text NOT NULL,
      pass text NOT NULL,
      registered timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP()
    ); ";

  // Insert User(s)
  $date = date("d/m/Y");
  $sql .="INSERT IGNORE INTO users (id, username, email, pass, registered) VALUES
  (1, 'root', 'postmaster@localhost', '$2y$10$9nVnTvkoSPaiXCF34yhl4uraFVCOJlwM.PtVdQH2xEezOB846kzT.', now()); ";
  // User: root, Pass: 528491

  // Status
  $sql .= "CREATE TABLE IF NOT EXISTS statuses (
    id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    serviceName text NOT NULL,
    serviceState int(1) NOT NULL DEFAULT 1, -- 1,2,3 Operational, Minor, Offline 
    serviceTag text NOT NULL,
    updateTime timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP() -- ISO String
  ); ";

  // Updates
  $sql .= "CREATE TABLE IF NOT EXISTS updates (
    id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    serviceId int(11) NOT NULL DEFAULT 1,
    updateTitle text,
    updateDescription text,
    updateTime timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP() -- ISO String
  ); ";

  // Test Connection
  $conn = @mysqli_connect(DB_HOST, DB_USER, DB_PASS, '');
  if (!$conn) {
    die('<div class="card"><div class="inner-card"><i class="checkmark" style="color: red">✗</i></div><h1 style="color: red">Error</h1><p>'.mysqli_connect_error()).'</p></div>';
  }

  // Run SQL
  if (mysqli_multi_query($conn, $sql)) {
    echo '<div class="card"><div class="inner-card"><i class="checkmark">✓</i></div><h1>Success</h1><p>Database setup completed for<br/>'.SRV_NAME.'<br><br>Go to <a href="'.SITE_URL.'/admin">Login</a></p></div>';
  } else {
    echo '<div class="card"><div class="inner-card"><i class="checkmark" style="color: red">✗</i></div><h1 style="color: red">Error</h1><p>Database setup failed for<br/>'.SRV_NAME.'</p></div>';
  }

  // Close Connection
  $conn->close();

?>

</body>
</html>