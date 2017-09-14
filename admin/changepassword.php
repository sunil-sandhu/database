<?php
session_start(); // Start session.

//include DB info
include_once('DB.php');

//instantiate database class
$database = new Database($dsn);



//if user is logged in
if(!empty( $_SESSION['loggedIn'] ) && !empty($_SESSION['username']) ):
    //show logged in / dashboard screen
    $userLoggedIn = true;

    //check if form has been submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST'):

        $newPassword = $_POST['newPassword'];
        $newPasswordAgain = $_POST['newPasswordAgain'];

        //check that new passwords match
        if( $newPassword == $newPasswordAgain && $newPassword != ''):

            //encrypt / hash the password for storage in the database
            $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);

            $database->query('UPDATE users SET password = :password WHERE username = :username');
            $database->bind(':password', $newPasswordHash);
            $database->bind(':username', $_SESSION['username']);
            $database->execute();

            $successMessage = 'Password changed - redirecting';

            header("Refresh: 3; url=index.php");


        else:
            $errorMessage = '<br><br>Sorry, the passwords you entered do not match, please try again';

        endif;



    endif;//end if form submitted


else:
    //redirect to index / login page
    header('Location: /'.$blogUrl.'/admin/index.php');

endif;


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

        <?php if( $userLoggedIn == 'true' ):

            //if password has been changed successfully
            if( isset( $successMessage ) ):
                print($successMessage);

            //if not, show form
            else: ?>

                <h1>Change Password for user: <?= $_SESSION['username'] ?></h1>

                <form action="changepassword.php" method="post">

                    <label for="newPassword">New Password:</label>
                    <input type="password" name="newPassword">

                    <br><br>

                    <label for="newPasswordAgain">New Password (again):</label>
                    <input type="password" name="newPasswordAgain">

                    <?php if( isset($errorMessage) ):

                        print($errorMessage);

                    endif; ?>

                    <br><br>

                    <input type="submit" name="submit" value="Change Password" class="button-blog-admin">


                </form>

            <?php endif; ?>



        <?php endif; ?>

    </div>


    <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ PAGE CONTENT END ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~  -->

    <?php $path = $_SERVER['DOCUMENT_ROOT']; $path .= "/_includes/footer.php"; include_once($path); ?>
    <?php $path = $_SERVER['DOCUMENT_ROOT']; $path .= "/_includes/endbody.php"; include_once($path); ?>
     
</body>
 
</html>