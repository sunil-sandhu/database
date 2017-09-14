<?php
session_start(); // Start session.

//include DB info
include_once('DB.php');

//instantiate database class
$database = new Database($dsn);


//print(sys_get_temp_dir());



//if user is logged in
if(!empty( $_SESSION['loggedIn'] ) && !empty($_SESSION['username']) ):
    //show logged in / dashboard screen
    $userLoggedIn = true;

    //form handling stuff
    //check if form has been submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST'):

        //if none of the required fields are missing
        if( !empty($_POST['title']) && !empty($_POST['slug']) && !empty($_POST['bodytext']) ):

            //remove non-url characters from slug
            //str replace slug and save as variable
            $bannedCharacters = [' ', '?', '&', '/', '"', "'", '_']; //replace these
            $cleanSlug = str_replace( $bannedCharacters, '-', $_POST['slug']); //with dash
            $cleanSlug = strtolower($cleanSlug); //remove any capitals


            //check the slug is not already in use
            $database->query('SELECT slug FROM articles WHERE slug = :slug');
            $database->bind(':slug', $cleanSlug);
            $matchingSlugs = $database->resultset(); //get all the slugs that match

            //if records were found
            if( sizeof($matchingSlugs) > 0 ):
                $submitError = "Sorry, that URL is already in use - please choose a unique URL";

            //if the slug check passes, save and proceed to file upload
            else:

                //transform the date
                $dateForDB = DateTime::createFromFormat('d-m-Y', $_POST['publish_date']);
                $dateForDB = $dateForDB->format('Y-m-d');

                //save $blogUrl to database
                $database->query('INSERT INTO articles (publish_date, slug, title, body, summary) VALUES (:publishdate, :slug, :title, :body, :summary)');
                $database->bind(':publishdate', $dateForDB);
                $database->bind(':slug', $cleanSlug);
                $database->bind(':title', $_POST['title']);
                $database->bind(':body', $_POST['bodytext']);
                $database->bind(':summary', $_POST['summary']);
                $database->execute();

                //get the id of the article just saved so can be saved to images table
                $lastArticleId = $database->lastInsertId();



                //FILE UPLOAD
                define("UPLOAD_DIR", "../article-images/"); //path relative to current file


                if (!empty($_FILES["images"]['name'][0])) { //needs ['name'][0] or tries to run this code even when no file selected (due to transforming array?)

                    //this was running when it shouldn't when just ['name'] used - returning empty array with key - Array ( [0] => )
                    //print('files are selected!<br>');
                    //print_r($_FILES["images"]['name'][0]);


                    //TRANSFORM THE ARRAY
                    //make each file its own array so can loop with foreach
                    $fileArray = array();
                    $file_count = count($_FILES['images']['name']);
                    $file_keys = array_keys($_FILES['images']);

                    for ($i=0; $i<$file_count; $i++) {
                        foreach ($file_keys as $key) {
                            $fileArray[$i][$key] = $_FILES['images'][$key][$i];
                        }
                    }


                    foreach( $fileArray as $file ){

                        if ($file["error"] !== UPLOAD_ERR_OK) {
                            echo "<p>An error occurred.</p>";
                            exit;
                        }

                        // ensure a safe filename
                        $name = preg_replace("/[^A-Z0-9._-]/i", "_", $file["name"]);


                        // don't overwrite an existing file
                        $i = 0;
                        $parts = pathinfo($name);
                        while (file_exists(UPLOAD_DIR . $name)) {
                            $i++;
                            $name = $parts["filename"] . "-" . $i . "." . $parts["extension"];
                        }


                        // move file from temporary directory
                        $success = move_uploaded_file($file["tmp_name"],
                            UPLOAD_DIR . $name);
                        if (!$success) {
                            echo "<p>Unable to save file.</p>";
                            exit;
                        }


                        // set proper permissions on the new file
                        chmod(UPLOAD_DIR . $name, 0644);


                        //save images to another table, include article ID and filename
                        $database->query('INSERT INTO article_images (article_id, image_name, image_type, image_size) VALUES (:articleid, :imagename, :imagetype, :imagesize)');
                        $database->bind(':articleid', $lastArticleId);
                        $database->bind(':imagename', $name);
                        $database->bind(':imagetype', $file['type']);
                        $database->bind(':imagesize', $file['size']);
                        $database->execute();

                    }

                }

                $blogSaved = 'true';

                $title = 'Blog post successful';
                $message = "Your post has been saved - redirecting (or <a href='/$blogUrl/?article=$cleanSlug'>click here</a>)";

                //redirect to the post
                header("Refresh: 3; url=/$blogUrl/?article=$cleanSlug");

            endif;






        else:
            $submitError = "Sorry, some required fields are missing - please make sure you have entered a title, url, publish date and $blogUrl contents";
        endif;

    endif; //end if form submitted



//if user not logged in
else:
    //redirect to index / login page
    header('Location: /$blogUrl/admin/index.php');

endif;


//--------------------------------------------------------

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

    <script src="../ckeditor/ckeditor.js"></script>


</head>
 
<body>

    <?php $path = $_SERVER['DOCUMENT_ROOT']; $path .= "/_includes/header.php"; include_once($path); ?>
    <?php $path = $_SERVER['DOCUMENT_ROOT']; $path .= "/_includes/nav.php"; include_once($path); ?>

    <!--  ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ PAGE CONTENT START ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~  -->


    <div class="content-main">

        <?php if( $blogSaved == 'true' ): ?>

            <h1><?=$title; ?></h1>

            <p><?=$message;?></p>

        <?php else: ?>

            <a href="/<?=$blogUrl?>/admin" class="button-blog-admin">Back to Dashboard</a>

            <h1>Create Blog Post</h1>


            <form action="newpost.php" method="post" name="newpost" enctype="multipart/form-data">

                <label for="title">Blog Title:</label>
                <input type="text" name="title" value="<?php keepInput('title') ?>" required>

                <br><br>



                <label for="slug">Blog URL:</label>
                <?= $siteUrl ?>/<?= $blogUrl ?>/<input type="text" name="slug" value="<?php keepInput('slug') ?>" required>
                <br>
                <div class="input-info">
                    Letters, numbers and dashes only.  This <strong>cannot</strong> be changed.
                </div>


                <br><br>

                <label for="publish_date">Publish Date:</label>
                <input type="text" class="datepicker" name="publish_date" value="<?php keepInput('publish_date'); ?>" required>
                <div class="input-info">
                    You can set this to a date in the future, and the article will be hidden until that date
                </div>

                <br><br>

                <label for="bodytext">Blog Content:</label>
                <br>
                <textarea name="bodytext" id="bodytext" cols="30" rows="10" required></textarea>


                <br><br>

                <label for="summary">Summary:</label>
                <br>
                <textarea name="summary" id="summary" rows="3" maxlength="200" required><?php keepInput('summary') ?></textarea>
                <div class="summary-remaining"></div>
                <div class="input-info">
                    The summary will be displayed in the article list - you may enter a max of 200 characters.
                </div>


                <br><br><br>

                <label for="images[]">Choose images for this blog: </label>
                <input type="file" name="images[]" multiple>
                <br>
                <div class="input-info">
                    Press the CTRL(windows) or CMD(mac) key as you click to select multiple images.
                    <br>
                    If you'd like to choose a particular image as the main/banner image, you can do this later by editing the blog post.
                </div>

                <br><br>


                <?php if( isset($submitError) ):
                    print( "<p class='errormessage'>" . $submitError . "</p>" );
                endif; ?>

                <input type="submit" name="submit" value="Create New Post" class="button-blog-admin">



            </form>

            <script>

                <?php
                //if the bodytext has been submitted, pass this into the CKeditor
                if( isset( $_POST['bodytext'] ) ): ?>

                //get the body text from POST into a js variable
                var submittedBodyText =  <?php keepInput('bodytext'); ?>  ;
                console.log(submittedBodyText);

                // Replace the <textarea id="editor1"> with a CKEditor instance
                CKEDITOR.replace( 'bodytext').setData(submittedBodyText); //

                <?php else: //not submitted - just a plain editor ?>
                // Replace the <textarea id="editor1"> with a CKEditor instance, using default configuration.
                CKEDITOR.replace( 'bodytext');
                <?php endif; ?>



                //Summary character count
                $('#summary').keyup(function(){
                    var characters = $('#summary').val().length;

                    //change this value of length changes
                    var remaining = 200 - characters;

                    $('.summary-remaining').html("Characters remaining: " + remaining);

                    console.log(remaining);
                });



            </script>

            <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
            <script>
                $(document).ready(function(){

                    //DATEPICKER
                    //attach jquery datepicker
                    $( function() {
                        $( ".datepicker" ).datepicker({
                            dateFormat: "dd-mm-yy",
                            changeMonth: true,
                            changeYear: true,
                            yearRange: "-100:+0",
                        });
                    } );

                });
            </script>

        <?php endif; ?>


    </div>


    <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ PAGE CONTENT END ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~  -->

    <?php $path = $_SERVER['DOCUMENT_ROOT']; $path .= "/_includes/footer.php"; include_once($path); ?>

    <?php $path = $_SERVER['DOCUMENT_ROOT']; $path .= "/_includes/endbody.php"; include_once($path); ?>
     
</body>
 
</html>