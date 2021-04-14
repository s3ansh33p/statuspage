<title><?php echo($title.' | '.SRV_ABBR); ?></title>
<meta charset="UTF-8" /> 
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta id="mainviewport" name="viewport" content="width=device-width, initial-scale=1">
<meta property="og:url"           content="<?php echo strtok((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]", '?');?>" />
<meta property="og:type"          content="website" />
<meta property="og:title"         content="<?php echo($title.' | '.SRV_ABBR); ?>" />
<meta property="og:description"   content="<?=SRV_META;?>" />
<link href="<?=SITE_URL;?>/assets/images/logo.png" type="image/x-icon" rel="shortcut icon"/>
<link href="<?=SITE_URL;?>/assets/images/logo.png" type="image/x-icon" rel="icon"/>
<link href="<?=SITE_URL;?>/assets/css/bootstrap.css" rel="stylesheet">
<script src="<?=SITE_URL;?>/assets/js/jquery.slim.min.js"></script>
<script src="<?=SITE_URL;?>/assets/js/popper.min.js"></script>
<script src="<?=SITE_URL;?>/assets/js/bootstrap.min.js"></script>
<link href="<?=SITE_URL;?>/assets/css/main.css?v=<?=CSS_VER;?>" rel="stylesheet">
<script src="<?=SITE_URL;?>/assets/js/main.js?v=<?=JS_VER;?>"></script>
<?php include_once(GLOBAL_URL."/admin/userCheck.php"); ?>