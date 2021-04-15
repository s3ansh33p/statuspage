<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php include_once("config.php");
      $title = 'Home';
      include_once(GLOBAL_URL."/components/header.php");
    ?>
</head>
<body>
  <?php
    if(!empty($_SESSION["id"])) {
      echo '<nav class="navbar navbar-light bg-dark align-items-center justify-content-between fixed-top">';
        echo '<a href="'.SITE_URL.'" class="mr-2">
          <img src="'.SITE_URL.'/assets/images/logo.png" width="30" height="30" class="d-inline-block align-top" alt="">
        </a>
        <p class="text-white m-0 mr-auto"><span class="mobile-hide">Welcome, </span><strong';
        if ($_SESSION['username'] == ADMIN_USER) {
          echo ' class="mobile-hide"';
        };
        echo '>'.$_SESSION["username"].'
          </strong></p></span>';
        if ($_SESSION["username"] == ADMIN_USER) {
          echo '<button class="btn btn-danger p-1 mr-2" data-toggle="modal" data-target="#rootModal">
          User Management
          </button>';
          echo '<button class="btn btn-danger p-1 mr-2" data-toggle="modal" data-target="#regModal">
          Add User
          </button>';
        }
        if ($_SESSION['username'] != ADMIN_USER) {
          echo '<button class="btn btn-danger p-1 mr-2" data-toggle="modal" data-target="#userModal">
          Edit User
          </button>';
        };
        echo '<button class="btn btn-danger p-1" onclick="logout();">
          Logout
        </button></span><script>function logout() {
          window.location.href = "'.SITE_URL.'/admin/submitLogout.php";
      }</script>
    </nav><br><br>';
    }

    function edit() {
      if(!empty($_SESSION["id"])){
        echo ' <a class="edit" data-toggle="modal" data-target="#editModal" onclick="edit(this);"><img src="'.SITE_URL.'/assets/images/svg/pencil.svg"></a>';
      };
    };

    function add() {
      if(!empty($_SESSION["id"])){
        echo '<a class="edit" data-toggle="modal" data-target="#addModal" onclick="add(this);"><img src="'.SITE_URL.'/assets/images/svg/plus.svg"></a>';
      };
    };

    include_once(GLOBAL_URL."/admin/getStatus.php");
    if(!empty($_SESSION["id"])){
      if (isset($services)) {
        echo '<script>let services = '.json_encode($services).'</script>';
      };
    };
    // $services, $header, $updates from database
  ?>
  <div class="jumbotron jumbotron-fluid">
    <div class="container">
      <div class="d-flex">
        <img class="jumbo-img mr-2 mobile-hide" src="<?=SITE_URL."/assets/images/logo.png";?>">     
        <h1><?=SRV_NAME;?> Status Page</h1>
      </div>
      <p><?=SRV_DESC;?></p>
    </div>
  </div>

<div class="container">
  <?php
    if(isset($services)) {
      $all = true;
      $off = true;
      for ($i = 0; $i < sizeof($services); $i++) {
        if ($services[$i]['serviceState'] != '1') {
          $all = false;
        };
        if ($services[$i]['serviceState'] != '3') {
          $off = false;
        };
      }
      if ($all) {
        echo '<div class="alert alert-success">
        All systems operational 
        </div>';
      } else if ($off) {
        echo '<div class="alert alert-danger">
        All systems offline
      </div>';
      } else {
        echo '<div class="alert alert-warning">
        Some systems operational
      </div>
    ';
      };
    } else {
      echo '<div class="alert alert-danger">
        No services in database
      </div>';
    }
  ?>

  <h6 class="py-2 mb-0">Services <?=add();?></h6>
  <ul class="list-group">
    <?php
    if(isset($services)) {
      $serviceLookup = [];
      for ($i = 0; $i < sizeof($services); $i++) {
        array_push($serviceLookup,$services[$i]['id']);
        echo '<li class="list-group-item d-flex align-items-center" id="service-'.$services[$i]['id'].'">
        <span class="badge badge-dark">'.$services[$i]['serviceTag'].'</span>
        <a href="'.$services[$i]['serviceName'].'" target="_blank" class="ml-1 mr-auto overflow-text">'.$services[$i]['serviceName'].'</a>';
        if ($services[$i]['serviceState'] == '1') {
          echo '<div class="text-success mobile-hide">Operational</div>
          <div class="blob green"></div>';
        } else if ($services[$i]['serviceState'] == '2') {
          echo '<div class="text-warning mobile-hide">Minor Outage</div>
          <div class="blob yellow"></div>';
        } else {
          echo '<div class="text-danger mobile-hide">Critical Outage</div>
          <div class="blob red"></div>';
        }
        edit();
        echo '</li>';
      }
    }
    ?>
  </ul>

  <div class="my-3 pt-3 bg-white rounded box-shadow">
    <h6 class="border-bottom border-gray pb-2 mb-0">Updates <?=add();?></h6>

    <?php
      for ($i=0; $i < HOME_DATE_MAX; $i++) {
        echo '<div class="text-muted mt-3 pt-3">
        <div class="media-body mb-0 small lh-125 border-bottom border-gray">
        <h4>'.date("l M j", strtotime(date('D'))-(86400*$i)).'</h4>
        </div>';
        $hasIncident = false;
        if(isset($updates)) {
          for ($j=0; $j<sizeof($updates); $j++) {
            $dateCalc = strtotime(date('D'))-(86400*($i-1)) - (strtotime($updates[$j]["updateTime"]));
            if ($dateCalc < 86400 && $dateCalc > 0) {
              $hasIncident = true;
              echo '<div class="text-muted pt-3">
            <div class="media-body mb-0 small lh-125">
              <h4 id="update-'.$updates[$j]["id"].'"><span class="badge badge-dark">'.$services[array_search($updates[$j]['serviceId'],$serviceLookup)]["serviceTag"].'</span> <span>'.$updates[$j]["updateTitle"].'</span>';
              edit();
              echo '</h4>
              <h6>'.date("G:i:s T", strtotime($updates[$j]["updateTime"])).'</h6>
              <span class="d-block">'.$updates[$j]["updateDescription"].'</span>
              </div>
            </div>';
            };
          };
        };
        if (!$hasIncident) {
          echo '<span class="pt-3 small">No incidents reported</span></div>';
        }
      }
    ?>
  </div>
  <div class="footer d-flex justify-content-between py-4 mt-4">
      <h6><a href="<?=SITE_URL;?>/admin<?php if(!empty($_SESSION["id"])){echo '/submitLogout.php">Logout';}else{echo '">Login';};?> </a></h6>
      <h6>&copy; <?=date('Y').' '.SRV_NAME;?></h6>
      <h6><a href="<?=SRV_LINK;?>" target="_blank"><?=SRV_NAME;?></a></h6>
    </div>
  </div>
      
  <?php
  if (!empty($_SESSION["id"])) {
    echo '<form class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true" method="POST" action="'.SITE_URL.'/admin/submitEdit.php">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">New message</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form>
            <data></data>
          </form>
        </div>
        <div class="modal-footer">
          <div class="input-group mr-auto">
            <div class="input-group-prepend">
              <div class="input-group-text">
              <input type="checkbox" name="confirm-delete" aria-label="Checkbox for following button input">
              </div>
            </div>
            <button type="submit" name="delete" class="btn btn-danger modal-check">Delete</button>
          </div>
          <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Update</button>
        </div>
      </div>
    </div>
  </form>';
    echo '<form class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true" method="POST" action="'.SITE_URL.'/admin/submitAdd.php">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addModalLabel">Add Update</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form>
            <data></data>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" id="add-btn">Add Update</button>
        </div>
      </div>
    </div>
  </form>';
  echo '<form class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true" method="POST" action="'.SITE_URL.'/admin/submitUser.php">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="userModalLabel">Edit User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <data>
            <div class="form-group">
              <label for="field-username" class="col-form-label">Username:</label>
              <input value="'.$_SESSION["username"].'" type="text" class="form-control" id="field-username" name="username" required>
            </div>
            <div class="form-group">
              <label for="field-email" class="col-form-label">Email:</label>
              <input value="'.$_SESSION["email"].'" type="email" class="form-control" id="field-email" name="email" required>
            </div>
            <div class="form-group">
              <label for="field-password" class="col-form-label">New Password:</label>
              <input type="password" class="form-control" id="field-password" name="password">
            </div>
            <input type="hidden" name="userid" value="'.$_SESSION["username"].'" id="field-userid">
          </data>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Update</button>
      </div>
    </div>
  </div>
</form>';
    if ($_SESSION['username'] == ADMIN_USER) {
    echo '<form class="modal fade" id="regModal" tabindex="-1" role="dialog" aria-labelledby="regModalLabel" aria-hidden="true" method="POST" action="'.SITE_URL.'/admin/submitRegistration.php">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="regModalLabel">Add User</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form>
            <data>
              <div class="form-group">
                <label for="field-reg-username" class="col-form-label">Username:</label>
                <input type="text" class="form-control" id="field-reg-username" name="username" required>
              </div>
              <div class="form-group">
                <label for="field-reg-email" class="col-form-label">Email:</label>
                <input type="email" class="form-control" id="field-reg-email" name="email" required>
              </div>
              <div class="form-group">
                <label for="field-reg-password" class="col-form-label">Password:</label>
                <input type="password" class="form-control" id="field-reg-password" name="password" required>
              </div>
            </data>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Register</button>
        </div>
      </div>
    </div>
  </form>';
      include_once(GLOBAL_URL."/admin/getUsers.php");
      echo '<script>let users = '.json_encode($users).'</script>';
      $userSelect = '<div class="input-group mb-3">
      <div class="input-group-prepend">
        <label class="input-group-text" for="field-selected-user">User</label>
      </div>
      <select required class="custom-select" id="field-selected-user" name="selected-user">';
        for ($k = 0; $k < sizeof($users); $k++) {
          $userSelect .= '<option value="'.$users[$k]["id"].'">'.$users[$k]["username"].'</option>';
        }
        $userSelect .= '
      </select>
      </div>';
      echo '<form class="modal fade" id="rootModal" tabindex="-1" role="dialog" aria-labelledby="rootModalLabel" aria-hidden="true" method="POST" action="'.SITE_URL.'/admin/submitUserAdmin.php">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="rootModalLabel">User Management</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form>
              <data>
                '.$userSelect.'
                <div class="form-group">
                  <label for="field-root-username" class="col-form-label">Username:</label>
                  <input value="'.$users[0]['username'].'" type="text" class="form-control" id="field-root-username" name="root-username" required>
                </div>
                <div class="form-group">
                  <label for="field-root-email" class="col-form-label">Email:</label>
                  <input value="'.$users[0]['email'].'" type="email" class="form-control" id="field-root-email" name="root-email" required>
                </div>
                <div class="form-group">
                  <label for="field-root-password" class="col-form-label">New Password:</label>
                  <input type="password" class="form-control" id="field-root-password" name="root-password">
                </div>
              </data>
            </form>
          </div>
          <div class="modal-footer">
            <div class="input-group mr-auto">
              <div class="input-group-prepend">
                <div class="input-group-text">
                  <input type="checkbox" name="confirm-delete" aria-label="Checkbox for following button input">
                </div>
              </div>
              <button type="submit" name="delete" class="btn btn-danger modal-check">Delete</button>
            </div>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Update</button>
          </div>
        </div>
      </div>
    </form>';
    };
  };
  ?>
</body>
</html>