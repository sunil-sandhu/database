<?php
session_start(); // Start session.

//include DB info
include_once('DB.php');

//instantiate database class
$database = new Database($dsn);

//make global so can be accessed from within included function
$isEditForm = 'true';



//if user is logged in
if(!empty( $_SESSION['loggedIn'] ) && !empty($_SESSION['username']) ):
    //show logged in / dashboard screen
    $userLoggedIn = true;


    //CHECK IF ARTICLE ID FOUND
//    print($_REQUEST['article']); //correct

    if(isset($_REQUEST['article']))
    {
//        print('REQUEST isset');
        $articleId=$_REQUEST['article'];

        //select article which matches slug
        $database->query("SELECT * from articles WHERE id = :id");
        $database->bind(':id', $articleId);
        $article = $database->single();

        //select article images
        $database->query("SELECT * from article_images WHERE article_id = :articleId");
        $database->bind(':articleId', $article['id']);
        $existingImages = $database->resultset();

//        print_r($existingImages);



        //if no matching article was found, redirect back to index
        if( !isset($article['id']) ) {

            //set notFound for later use
            $notFound = 'true';

            $title = "No DB found Article Not Found";
            $message = "Sorry, the article you are trying to edit has not been found.  Redirecting (or <a href='/$blogUrl'>click here</a>)";

            //redirect to main $blogUrl page
            //header("Refresh: 3; url=/$blogUrl");
        }
    }//end  if isset($_REQUEST)
    else
    {

//        print('request not set<br>');
//        print($_REQUEST['article']);

        //set notFound for later use
        $notFound = 'true';

        $title = "No REQUEST Article Not Found";
        $message = "Sorry, the article you are trying to edit has not been found.  Redirecting (or <a href='/$blogUrl'>click here</a>)";

        //redirect to main $blogUrl page
        //header("Refresh: 3; url=/$blogUrl");
    }

    //TODO - does this need to go within the IF id found statement?
    //form handling stuff
    //check if form has been submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST'):

        //if none of the required fields are missing
        if( !empty($_POST['title']) && !empty($_POST['slug']) && !empty($_POST['bodytext']) ):


            //don't need to do anything with slug as is read-only

            //transform the date
            $dateForDB = DateTime::createFromFormat('d-m-Y', $_POST['publish_date']);
            $dateForDB = $dateForDB->format('Y-m-d');


            //update database record
            $database->query("UPDATE articles SET publish_date=:publishdate, title=:title, body=:body, summary=:summary WHERE id=:articleId");

            $database->bind(':articleId', $articleId);
            $database->bind(':publishdate', $dateForDB);
            $database->bind(':title', $_POST['title']);
            $database->bind(':body', $_POST['bodytext']);
            $database->bind(':summary', $_POST['summary']);
            $database->execute();



            //if hide_blog is checked, amend the article record in DB (mark as deleted, not actual delete)
            if( $_POST['hide_blog'] == 1 ) :
                $database->query("UPDATE articles SET is_deleted='1' WHERE id=:articleId");
                $database->bind(':articleId', $articleId);
                $database->execute();
            endif;


            //EXISTING IMAGES
            //update primary image

            //id of the selected image
            $primaryimgId = $_POST['primaryimg'];


            //remove is_primary from all of this articles images
            //remove is_shown from all of this articles images
            $database->query("UPDATE article_images SET is_primary='0', is_shown='0' WHERE article_id=:articleId");
            $database->bind(':articleId', $articleId);
            $database->execute();


            //set is_primary on the selected image
            $database->query("UPDATE article_images SET is_primary='1' WHERE id=:primaryimgId");
            $database->bind(':primaryimgId', $primaryimgId);
            $database->execute();


            //set whether image should be shown below the article
            //get the id of every image where showimage is checked (as array)
            $shownImages = $_POST['shownimages'];

//            //remove is_shown from all of this articles images
//            $database->query("UPDATE article_images SET is_shown='0' WHERE article_id=:articleId");
//            $database->bind(':articleId', $articleId);
//            $database->execute();

            //set is_shown to 1 (true) for all images where showimage was checked
            foreach( $shownImages as  $shownImage ){
                $database->query("UPDATE article_images SET is_shown='1' WHERE id=:imageId ");
                $database->bind(':imageId', $shownImage);
                $database->execute();
            }


            $deletedImages = $_POST['deletedimages']; //this is an array of image Id's

            //only run the code below if deleted images were set in the form
            if( $deletedImages ){

                foreach( $deletedImages as $deletedImage){

                    //delete the image file
                    //loop through all the images for this article (which are already selected from the database)
                    //if the id matches the id to be deleted, delete the file
                    foreach( $existingImages as $existingImage ){

                        if( $existingImage['id'] == $deletedImage ){
                            $filenameToDelete = $existingImage['image_name'];

                            unlink("/$blogUrl/article-images/$filenameToDelete");
                        }
                    }

                    //delete the image record from the database
                    $database->query("DELETE FROM article_images WHERE id=:imageId ");
                    $database->bind(':imageId', $deletedImage);
                    $database->execute();
                }
            }





            //FILE UPLOAD
            define("UPLOAD_DIR", "../article-images/"); //path relative to current file


            if (!empty($_FILES["images"]['name'][0])) { //needs ['name'][0] or tries to run this code even when no file selected


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
                    $database->bind(':articleid', $articleId);
                    $database->bind(':imagename', $name);
                    $database->bind(':imagetype', $file['type']);
                    $database->bind(':imagesize', $file['size']);
                    $database->execute();

                }

            }

            $blogSaved = 'true';

            $title = 'Blog post successful';
            $message = "Your post has been saved - redirecting (or <a href='/$blogUrl/?article=$article[slug]'>click here</a>)";

            //redirect to the post
            header("Refresh: 3; url=/$blogUrl/?article=$article[slug]");







        else:
            $submitError = "Sorry, some required fields are missing - please make sure you have entered a title, url, publish date and $blogUrl contents";
        endif;

    endif; //end if form submitted



//if user not logged in
else:
    //redirect to index / login page
    header('Location: /$blogUrl/admin');

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

    <script src="/<?= $blogUrl ?>/ckeditor/ckeditor.js"></script>


</head>
 
<body>

    <?php $path = $_SERVER['DOCUMENT_ROOT']; $path .= "/_includes/header.php"; include_once($path); ?>
    <?php $path = $_SERVER['DOCUMENT_ROOT']; $path .= "/_includes/nav.php"; include_once($path); ?>

    <!--  ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ PAGE CONTENT START ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~  -->


    <div class="content-main">


        <?php if( $blogSaved == 'true' || $notFound == 'true' ): ?>

            <h1><?=$title; ?></h1>

            <p><?=$message;?></p>

        <?php else: ?>

            <a href="/<?= $blogUrl ?>/admin" class="button-blog-admin">Back to Dashboard</a>
            <a href="/<?= $blogUrl ?>" class="button-blog-admin">See all blogs</a>

            <h1>Edit Blog Post</h1>

            <p><strong>On this page you can:</strong></p>
            <ul>
                <li>Change the blog title</li>
                <li>Change the blog publish date</li>
                <li>Change the blog content</li>
                <li>Add more images</li>
                <li><span style="text-decoration: line-through">Delete existing images</span> - Coming soon</li>
                <li>Choose the 'main' image for the blog (shown in the banner)</li>
                <li>Permanently hide the blog (as if deleted)</li>
            </ul>

        <br>

            <h3>Editing Blog: <?=$article['title']?> (ID: <?=$article['id'] ?>)</h3>

        <br>


            <form action="editpost.php/?article=<?= $article['id'] ?>" method="post" name="editpost" enctype="multipart/form-data">

                <label for="title">Blog Title:</label>
                <input type="text" name="title" value="<?php keepInput('title') ?>" required>

                <br><br>

                <div class="form-readonly">
                    <label for="slug">Blog URL:</label>
                    <?= $siteUrl ?>/<?= $blogUrl ?>/
                    <input type="text" name="slug" value="<?= $article['slug'] ?>" required readonly>
                </div>
                <div class="input-info">
                    NB: the blog URL cannot be changed - displayed for reference only.
                </div>

                <br><br>


                <?= $_POST[$publish_date] ?>

                <label for="publish_date">Publish Date:</label>
                <input type="text" class="datepicker" name="publish_date" value="<?php keepInput('publish_date'); ?>" required>
                <div class="input-info">
                    You can set this to a date in the future, and the article will be hidden until that date
                </div>


                <br><br>

                <label for="hide_blog">Hide / Delete post</label>
                <input type="checkbox" name="hide_blog" value="1"
                    <?php if( $article['is_deleted'] == 1 ) { print('checked');} ?>
                    >

                <div class="input-info">Checking this box will hide (soft delete) this blog post - remember to click 'Update Post' at the bottom of this page before this will take effect.
                </div>

                <br>
                <div class="input-info">
                    To PERMANENTLY delete a post, email roxy@serosensa.com with the ID number <strong><?= $article['id'] ?></strong>
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


                <h3>Previously uploaded Images:</h3>

                <div class="input-info">
                    <?php if(empty($existingImages)): ?>
                        <p>This article currently has no images - you can upload some in the section below</p>
                    <?php else: ?>
                        Click 'primary image' on an image below to select the main image to be used in the blog title banner and preview
                        <br>
                        The URL displayed below each image can be used to insert an image within the text
                    <?php endif; ?>
                </div>

                <div class="blog-images">
                    <?php foreach($existingImages as $existingImage): ?>
                        <div class="image-edit">

                            <div class="imgwrapper">
                                <img src="/<?= $blogUrl ?>/article-images/<?= $existingImage['image_name'] ?>">

                                <div class="url-text">
                                    <div class="url-label">URL:</div>
                                    <?= $siteUrl ?>/<?= $blogUrl ?>/article-images/<?= $existingImage['image_name'] ?>
                                </div>
                            </div>


                            <!--   Make primary image (radio)   -->
                            <input class="radio-primaryimg"
                                   type="radio" name="primaryimg" value="<?= $existingImage['id'] ?>" id="image-<?= $existingImage['id'] ?>"
                                <?php if( $existingImage['is_primary'] ==  1 ) { print('checked'); } //pre-check button if is primary in DB ?>
                                >

                            <label class="radio-primaryimg" for="image-<?= $existingImage['id'] ?>">
                                Primary Image
                            </label>


                            <label class="checkbox-showbelow">
                                <input type="checkbox" name="shownimages[]" value="<?= $existingImage['id'] ?>"
                                    <?php if( $existingImage['is_shown'] ==  1  || $existingImage['is_shown'] == null ) { print('checked'); } //pre-check if is_shown or not yet set in DB ?>
                                    >
                                Show below article
                            </label>

                            <br>

                            <label class="checkbox-deleteimage">
                                <input type="checkbox" name="deletedimages[]" value="<?= $existingImage['id'] ?>" >
                                Delete this image
                            </label>

                        </div>
                    <?php endforeach; ?>
                </div>



                <br><br>

                <h3>Add More images:</h3>
                <br>

                <label for="images[]">Choose images: </label>
                <input type="file" name="images[]" multiple>
                <br>
                <div class="input-info">
                    Press the CTRL(windows) or CMD(mac) key as you click to select multiple images.
                    <br>
                    These images will not display above until you click the 'Update Post' button - you will then be able to select one as the main image.
                </div>

                <br><br>


                <?php if( isset($submitError) ):
                    print( "<p class='errormessage'>" . $submitError . "</p>" );
                endif; ?>

                <input type="submit" name="submit" value="Update Post" class="button-blog-admin">

                <a href="/<?= $blogUrl ?>/?article=<?= $article['slug'] ?>" class="button-blog-cancel">Cancel</a>



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

                <?php else: //not submitted - display database info ?>
                // Replace the <textarea id="editor1"> with a CKEditor instance, using default configuration.
                var savedBodyText =  <?php print(  json_encode($article['body']) ); ?>

                    CKEDITOR.replace( 'bodytext').setData(savedBodyText);
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
                            yearRange: "-100:+0"
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