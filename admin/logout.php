<?php
session_start();
unset($_SESSION['username']);
unset($_SESSION['loggedIn']);
//session_destroy();

$userLoggedIn = 'false';

header("Refresh: 1; url=index.php");


?>

<!doctype html>
<html>
 
<head>
 
    <meta charset="UTF-8">
    <title></title>
 
    <meta name="title" content="">
    <meta name="description" content="">
    <meta name="keywords" content="">

    <?php $path = $_SERVER['DOCUMENT_ROOT']; $path .= "/_includes/head.php"; include_once($path); ?>

 
</head>
 
<body>

    <?php $path = $_SERVER['DOCUMENT_ROOT']; $path .= "/_includes/header.php"; include_once($path); ?>
    <?php $path = $_SERVER['DOCUMENT_ROOT']; $path .= "/_includes/nav.php"; include_once($path); ?>

    <!--  ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ PAGE CONTENT START ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~  -->


    <div class="content-main">
        Successfully logged out - redirecting
    </div>


    <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ PAGE CONTENT END ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~  -->

    <?php $path = $_SERVER['DOCUMENT_ROOT']; $path .= "/_includes/footer.php"; include_once($path); ?>
    <?php $path = $_SERVER['DOCUMENT_ROOT']; $path .= "/_includes/endbody.php"; include_once($path); ?>
     
</body>
 
</html>