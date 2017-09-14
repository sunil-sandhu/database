<?php
session_start(); // Start session.

$todayDate = date('Y-m-d');
$tomorrowDate = date("Y-m-d", strtotime('+1 days'));

//include DB info
include_once('DB.php');

//instantiate database class
$database = new Database($dsn);


//use to reset password - make hash
//print (password_hash('temp', PASSWORD_DEFAULT));


//if user is logged in
if(!empty( $_SESSION['loggedIn'] ) && !empty($_SESSION['username']) ):
    //show logged in / dashboard screen
    $userLoggedIn = true;


    $database->query("SELECT * from vacancies ORDER BY deadline DESC");
    $articles = $database->resultset();




//if username and password were supplied in the form (POST)
elseif( !empty($_POST['username']) && !empty($_POST['password']) ):
    //check login details / log user in

    $postUsername = $_POST['username'];
    $postPassword = $_POST['password'];

    $database->query("SELECT username, password from admin_users WHERE username = :username");
    $database->bind(':username', $postUsername);
    $user = $database->single();

    //if no matching user record found
    if( empty($user) ) :

        $userNotFound = 'true';

        $title = 'Incorrect Username';
        $message = 'Sorry, no user was found with that username.  Please <a href="index.php">click here to try again</a>';



    //if matching user found
    else:
        $dbPassword = $user['password'];

        //verify password
        if( password_verify($postPassword, $dbPassword) ):

            //set the details in session
            $_SESSION['username'] = $user['username'];
            $_SESSION['loggedIn'] = 1;

            $loginRedirect = 'true';

            $title = 'Logged In';
            $message = 'Logged in successfully - redirecting (or <a href="index.php">Click Here</a>)';


            //redirect back to same page to show logged-in data
            header("Refresh: 1; url=index.php");



        else:

            $incorrectPassword = 'true';
            $title = 'Incorrect Password';
            $message = 'Sorry, that password is incorrect.  Please <a href="index.php">click here to try again</a>';


        endif;


    endif; // end if matching user found




//if not yet logged in or submitted login form
else :
    //display login form
    $showLoginForm = 'true';

endif; //end if form posted / details supplied
?>

<!doctype html>
<html>
 
<head>
 
    <meta charset="UTF-8">
    <title></title>
 
    <meta name="title" content="">
    <meta name="description" content="">
    <meta name="keywords" content="">

    <?php
    $path = $_SERVER['DOCUMENT_ROOT'];
    $path .= "/_components/head.php";
    include_once($path);
    ?>
 
</head>
 
<body>

<?php //#################### PAGETOP #####################
$path = $_SERVER['DOCUMENT_ROOT'];
$path .= "/_components/pagetop.php";
include_once($path);


?>
    <!--  ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ PAGE CONTENT START ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~  -->


    <div class="content-main">

        <?php

        //if( $loginRedirect == 'true' ):




        if ($userNotFound == 'true' | $incorrectPassword == 'true' | $loginRedirect == 'true' ): ?>

            <h1><?php print( $title ); ?></h1>
            <p><?php print( $message ); ?></p>

        <?php endif;



        if( $showLoginForm == 'true' ): ?>

            <h1>Blog Admin Login</h1>

            <form action="index.php" method="post" name="blogLogin" id="blogLogin">

                <label for="username">Username:</label>
                <input type="text" name="username">

                <br><br>

                <label for="password">Password:</label>
                <input type="password" name="password">

                <br><br>

                <input type="submit" name="login" value="Log In">

            </form>


        <?php endif;



        //main page content for logged in user
        if( $userLoggedIn == 'true' ): ?>

            <h1>Blog Dashboard</h1>
            <h3>
                You are logged in as <?php print( $_SESSION[username] );?>
            </h3>


            <a href="newpost.php" class="button-blog-admin">
                New Blog Post
            </a>

            <a href="/<?= $blogUrl ?>" class="button-blog-admin">
                View Live Posts
            </a>



            <a href="/<?= $blogUrl ?>/admin/logout.php" class="button-blog-admin">Log Out</a>

            <a href="/<?= $blogUrl ?>/admin/changepassword.php" class="button-blog-admin">Change Password</a>


            <a href="/<?= $blogUrl ?>/admin/users.php" class="button-blog-admin">Manage Users</a>

            <br>

            <p>Articles marked with <span class="icon-deleted"></span> are deleted, those marked with <span class="icon-unpublished"></span> have a publish date in the future</p>




            <?php
            foreach( $articles as $article):

                $articleId = $article['id'];
                $formattedDate =  strtotime($article['publish_date']);

                ?>


                <?php //primaryImageName($articleId) ?>



                <article class="blog-preview" style="background-image: url('/<?= $blogUrl ?>/article-images/<?php primaryImageName($articleId) ?>') ">

                    <a class="fullsize-link" href="/<?= $blogUrl ?>?article=<?= $article['slug']; ?>">

                        <header class="previewtext">
                            <h3><?= ucfirst($article['title']); ?></h3>
                            <?= $article['summary']; ?>

                            <span class="blog-readmore">Read more...</span>

                        </header>

                        <div class="blog-date">
                            <?= date('d', $formattedDate); ?>
                            <br>
                            <?= date('M', $formattedDate); ?>
                        </div>
                    </a>

                    <?php if($userLoggedIn == 'true'): ?>
                        <a  href="/<?= $blogUrl ?>/admin/editpost.php/?article=<?=$article['id']?>" class="button-blog-admin">Edit Article</a>
                    <?php endif; ?>

                    <div class="statusicons">
                        <?php if ( $article['is_deleted'] == '1' ): ?>
                            <span class="icon-deleted"></span>
                        <?php endif; // end if is NOT deleted

                        if( $article['publish_date'] > $todayDate ): ?>
                            <span class="icon-unpublished"></span>
                        <?php endif; ?>


                    </div>





                </article>
            <?php endforeach; ?>




        <?php endif; ?>


    </div>


    <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ PAGE CONTENT END ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~  -->


<!-- #################### PAGEBOTTOM #####################-->
<?php  //includes footer and scripts, then closes html and body
$path = $_SERVER['DOCUMENT_ROOT'];
$path .= "/_components/pagebottom.php";
include_once($path);
?>

     
</body>
 
</html>