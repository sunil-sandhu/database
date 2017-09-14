<?php
session_start(); // Start session.

//include DB info
include_once('DB.php');

//instantiate database class
$database = new Database($dsn);

$loggedInUsername = $_SESSION['username'];

//if session not set (ie user not logged in)
//redirect to admin index (login) page
if(!isset($_SESSION['username']))
{
    header("Location:../admin/");
//    print("user not logged in");
}

else {

    $database->query("SELECT * from users WHERE username = :loggedInUser");
    $database->bind(":loggedInUser", $loggedInUsername);
    $loggedInUser = $database->single();
    $loggedInUserId = $loggedInUser['id'];


    //if have user admin permission (value == 1)
    if( $loggedInUser['pm_user_admin'] == 1 ){
        $isUserAdmin = '1';

        //select the data from the main news table
        $database->query("SELECT * from users ORDER BY username ASC ");
        $users = $database->resultset();


    } //else - they don't have admin permissions
    else {
        $isUserAdmin = '0';

        $title = 'Insufficient Permissions';
        $message = 'Sorry, you do not have the correct permissions to access this area';
    }
}


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

        <?php if($isUserAdmin == 1): ?>
            <a href="/<?= $blogUrl ?>/admin" class="button-blog-admin" style="float:right">Back to dashboard</a>


            <h1>Manage Users</h1>

            <p>From this area, you can add or remove users, and give them permissions <br></p>

            <table class="userstable">
                <tr>
                    <th>Username</th>
                    <th>Change/Set password</th>
                    <th>Can edit users?</th>
                    <th>Delete user</th>
                    <th>Update / Create</th>
                </tr>

                <tr class="user-create">
                    <td>
                        <input name="username" type="text" placeholder="create new user">
                        <span class="msg-un-blank">Username cannot be blank</span>
                        <span class="msg-un-taken">Sorry, that username is already in use</span>

                        <input name="user_id" type="hidden" value="">
                        <!--                    Set this value with JS when the form is submitted -->

                    </td>

                    <td>
                        <input name="password" type="password" placeholder="password">
                        <input name="passwordagain" type="password" placeholder="password (again)">
                        <div class="msg-pw-blank">Password cannot be empty</div>
                        <div class="msg-pw-nomatch">Sorry, those passwords don't match</div>
                    </td>

                    <td>
                        <input type="checkbox" name="pm_user_admin">
                    </td>

                    <td>
                        <input type="checkbox" name="delete_user" style="display:none">
                    </td>

                    <td>
                        <span class="create-user button-blog-admin">Create</span>
                        <span class="msg-created">User Created</span>
                        <span class="msg-updated">User Updated</span>
                    </td>

                </tr>

                <?php foreach( $users as $user ):?>

                    <tr id="user-<?= $user['id'] ?>">
                        <td>
                            <input name="username" readonly value="<?=$user['username']; if($user['id'] ==$loggedInUserId){ print(' (you)'); } ?>">

                            <input name="user_id" type="hidden" value="<?=$user['id']?>">
                        </td>
                        <td>
                            <input name="password" type="password" placeholder="new password">
                            <input name="passwordagain" type="password" placeholder="new password (again)">
                            <div class="msg-pw-nomatch">Sorry, those passwords don't match</div>
                        </td>
                        <td>
                            <input type="checkbox" name="pm_user_admin"
                                <?php if($user['pm_user_admin'] == '1') {print('checked');} ?>
                                <?php if($user['id'] ==$loggedInUserId){ print('disabled'); } ?>>
                        </td>
                        <td>
                            <?php if($user['id'] !=$loggedInUserId): ?>
                                <input type="checkbox" name="delete_user" >
                            <?php endif; ?>
                        </td>
                        <td>
                            <span class="update-user button-blog-admin">Update</span>
                            <span class="msg-updated">User Updated</span>
                        </td>

                    </tr>



                <?php endforeach; ?>

                <?php //this tr is a duplicate of the create form - is hidden and cloned later by JS ?>
                <tr class="user-create" style="display:none">
                    <td>
                        <input name="username" type="text" placeholder="create new user">
                        <span class="msg-un-blank">Username cannot be blank</span>
                        <span class="msg-un-taken">Sorry, that username is already in use</span>
                    </td>

                    <td>
                        <input name="password" type="password" placeholder="password">
                        <input name="passwordagain" type="password" placeholder="password (again)">
                        <div class="msg-pw-blank">Password cannot be empty</div>
                        <div class="msg-pw-nomatch">Sorry, those passwords don't match</div>
                    </td>

                    <td>
                        <input type="checkbox" name="pm_user_admin" >
                    </td>

                    <td>
                        <input type="checkbox" name="delete_user" style="display:none">
                    </td>

                    <td>
                        <span class="create-user button-blog-admin">Create</span>
                        <span class="msg-created">User Created</span>
                    </td>

                </tr>

            </table>

            <script>

                //UPDATE USER
                //            $('.update-user').click(function(){
                $('.userstable').on('click', '.update-user', function(){
                    console.log('update user');

                    var thisForm =  $(this).parents('tr');

                    var userId = thisForm.find('[name=user_id]').val();
                    var password = thisForm.find('[name=password]').val();
                    var passwordAgain = thisForm.find('[name=passwordagain]').val();
                    var userAdmin = thisForm.find('[name=pm_user_admin]').is(':checked');
                    var deleteUser = thisForm.find('[name=delete_user]').is(':checked');

                    //if passwords don't match
                    if( password != passwordAgain ){
                        thisForm.find($('.msg-pw-nomatch')).fadeIn(500).delay(2000).fadeOut(500);
                    }
                    //if they do match
                    else {
                        //POST the data via AJAX
                        $.post('editusers_script.php', {
                            user_id: userId,
                            password: password,
                            user_admin: userAdmin,
                            delete_user: deleteUser
                        }).done(function(response){
                                console.log(response);

                                //if the user was deleted
                                if(deleteUser){
                                    thisForm.fadeOut(500);

                                    //delay removing the element from the DOM so that fadeOut has time to be seen
                                    setTimeout(function(){
                                        thisForm.remove();
                                    }, 550);
                                }

                                thisForm.find('.msg-updated').fadeIn(300).delay(2000).fadeOut(500);
                            }
                        )
                    }
                });

                //CREATE NEW USER
                //            $('.create-user').click(function(){
                $('.userstable').on('click', '.create-user', function(){
                    console.log('create user button clicked');
                    var thisForm =  $(this).parents('tr');
                    var thisButton = $(this);

                    var username = thisForm.find('[name=username]').val();
                    var password = thisForm.find('[name=password]').val();
                    var passwordAgain = thisForm.find('[name=passwordagain]').val();
                    var userAdmin = thisForm.find('[name=pm_user_admin]').is(':checked');

                    console.log(username);

                    //if username empty
                    if(!username){
                        thisForm.find('.msg-un-blank').fadeIn(500).delay(2000).fadeOut(500);
                    }

                    //if passwords don't match OR are empty
                    else if( !password ){
                        $('.msg-pw-blank').fadeIn(500).delay(2000).fadeOut(500);
                        console.log('password empty');
                    }
                    else if( password != passwordAgain ){
                        thisForm.find('.msg-pw-nomatch').fadeIn(500).delay(2000).fadeOut(500);
                    }


                    //if passwords do match
                    else {

                        //POST the data via AJAX
                        $.post('editusers_script.php', {
                            username: username,
                            password: password,
                            user_admin: userAdmin
                        }).done(function(response){
                                //console.log("response " + response);

                                var newUserId = response.newUserId;
                                var usernameAvailable = response.usernameAvailable;

                                //check the username response returned by the PHP script
                                //if username is available
                                if( usernameAvailable == 1 ){

                                    thisForm.find('.msg-created').fadeIn(300).delay(2000).fadeOut(500);
                                    thisForm.find('.msg-un-blank').fadeOut(500);

                                    //make the username readonly
                                    thisForm.find('[name=username]').prop("readonly", true);

                                    //add the user id to the appropriate field (for use in edit form)
                                    thisForm.find('[name=user_id]').val(newUserId);


                                    //console.log(thisButton);

                                    //change the create button class to an update button
                                    $(thisButton).addClass('update-user');
                                    $(thisButton).removeClass('create-user');
                                    $(thisButton).html('Update');

                                    //show the delete option
                                    thisForm.find('[name=delete_user]').fadeIn(300);

                                    //add a new instance of the create user form
                                    $(thisForm).removeClass('user-create');
                                    $('.user-create').clone().insertBefore(thisForm).fadeIn(300);
                                }
                                else { //if username not available (record is not saved in PHP script)
                                    thisForm.find('.msg-un-taken').fadeIn(300).delay(2000).fadeOut(500);
                                }




                            }
                        )


                    }
                })

            </script>

        <?php else: ?>
            <h1><?= $title ?></h1>
            <p><?= $message ?></p>

        <?php endif; //end if/else user admin ?>
    </div>


    <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ PAGE CONTENT END ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~  -->

    <?php $path = $_SERVER['DOCUMENT_ROOT']; $path .= "/_includes/footer.php"; include_once($path); ?>
    <?php $path = $_SERVER['DOCUMENT_ROOT']; $path .= "/_includes/endbody.php"; include_once($path); ?>
     
</body>
 
</html>