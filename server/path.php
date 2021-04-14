<?php
    $PAGE_URL = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $HEADER_URL = substr($PAGE_URL, 0,strrpos($PAGE_URL,"/"));
    $HEADER_URL_CD = substr($HEADER_URL, 0,strrpos($HEADER_URL,"/"));
?>