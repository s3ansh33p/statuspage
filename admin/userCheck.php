<?php

    if ( isset( $_SESSION['id']) ) {
        if ($_SESSION["username"] == ADMIN_USER) {
            echo '<script>console.log("Configuration", { "Name" : "'.SRV_NAME.'", "Description" : "'.SRV_META.'", "GlobalURL" : "'.str_replace('\\', '\\\\', GLOBAL_URL).'", "SiteURL" : "'.SITE_URL.'", "GlobalVersion": "'.VERSION.'", "JSVersion": "'.JS_VER.'", "CSSVersion": "'.CSS_VER.'" });</script>';
        };
        // Auto logout set in timeout
        echo '<script>setTimeout(() => {
            window.location.href = "'.SITE_URL.'/admin/submitLogout.php"
           },('.USER_TIMEOUT.' - (Date.now()/1000 - '.$_SESSION['started'].'))*1000)</script>';
        if (time() - $_SESSION['started'] > USER_TIMEOUT) {

            session_unset();
            session_destroy();
            // Redirect them to the home page
            header('location: '.SITE_URL);
            exit;
        } else {
            //Update latest time session
            $_SESSION['started'] = time();
        }
    }

?>