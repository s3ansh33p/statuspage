<?php
include_once("../config.php");
include_once(GLOBAL_URL."/server/connect.php");
//error_reporting(E_ALL ^ E_NOTICE);  
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }
  //echo "Connected successfully";

$sub_1 = mysqli_real_escape_string($conn, $_POST['email']);
$sub_2 = mysqli_real_escape_string($conn, $_POST['password']);

//Check if passwords match
$sql = "SELECT username, email, pass FROM users WHERE email='$sub_1' LIMIT 1";

$result = $conn->query($sql);
if (!$result) {
  die('Could not query:' . mysqli_error($conn));
}

if ($result->num_rows > 0) {
  // output data of each row

    while($row = $result->fetch_assoc()) {
        //Get hash of last (will be 1)
        $hashed = $row["pass"];
        $username = $row["username"];
        $email = $row["email"];
    }
    //Validate password
    if (password_verify($sub_2, $hashed)) {
      //echo 'Password is valid!';
      $seed = str_split(ENCRYPTION_CHARS);
                shuffle($seed);
                $rand = '';
                foreach (array_rand($seed, ENCRYPTION_LEVEL) as $k) $rand .= $seed[$k];
      $sessionId = base64_encode($rand);
      
      //Get in seconds for timeout reasons (new Date ($start) for JS Date)
      $start = time();
      //Add vars to current session
      $_SESSION["username"] = $username;
      $_SESSION["email"] = $email;
      $_SESSION["id"] = $sessionId;
      $_SESSION['started'] = $start;

      if ($conn->query($sql) === TRUE) {
        //Dev testing
        //echo "New record created successfully";
      } else {
        //TODO provide error msg - IE JS Function
        echo "Error: " . $sql .   "<br>" . $conn->error;
      }
      //echo $sql;
      //Need to update the header locations
      header('location: '.SITE_URL);
      exit;
    } else {
        //Link to sign in attempts?
        //echo 'Invalid password.';
        $_SESSION["loginError"] = 1;
        header('location: '.SITE_URL.'/admin');
        exit;
    }

    
} else {
  //echo "0 results | invalid username";
  $_SESSION["loginError"] = 1;
  header('location: '.SITE_URL.'/admin');
  exit;
}

$conn->close();
?>