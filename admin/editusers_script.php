<?php

session_start(); // Start session.

//include DB info
include_once('DB.php');

//instantiate database class
$database = new Database($dsn);



if( $_SERVER['REQUEST_METHOD'] =='POST' ){

//    print_r($_POST);




    //UPDATE USER
    //if a user_id was sent, it's the update form

    if(isset($_POST['user_id'])){
//        print('<br> update user PHP script<br>');

        $userId = $_POST['user_id'];

        //change password
        if( !empty($_POST['password']) ){

            $newPassword = $_POST['password'];

            //encrypt / hash the password for storage in the database
            $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);

            $database->query('UPDATE users SET password=:password WHERE id=:id');
            $database->bind(':password', $newPasswordHash);
            $database->bind(':id', $userId);
            try {
                $saveSuccess = $database->execute();
                //print_r((int)$saveSuccess);
            } catch ( \Exception $e ) {
                print_r($e);
            }
        }

        //user admin
        //set value to 1 if true
        if( $_POST['user_admin'] == 'true' ){
            $database->query("UPDATE users SET pm_user_admin='1' WHERE id=:id");
            $database->bind(':id', $userId);
            try {
                $saveSuccess = $database->execute();
                //print_r((int)$saveSuccess);
            } catch ( \Exception $e ) {
                print_r($e);
            }

        }//set value to 0 if false
        else {
            $database->query("UPDATE users SET pm_user_admin='0' WHERE id=:id");
            $database->bind(':id', $userId);
            try {
                $saveSuccess = $database->execute();
                //print_r((int)$saveSuccess);
            } catch ( \Exception $e ) {
                print_r($e);
            }
        }

//    //delete user
        if( $_POST['delete_user'] == 'true' ){
            $database->query("DELETE FROM users where id=:id");
            $database->bind(':id', $userId);
            try {
                $saveSuccess = $database->execute();
                //print_r((int)$saveSuccess);
            } catch ( \Exception $e ) {
                print_r($e);
            }

            $result['deleted'] = 'true';
        }



        $message = 'success';

        $result['status'] = 'success';


    }

    //NEW USER
    //if a user_id wasn't sent, it's the new user form
    else {
        $newUsername = $_POST['username'];

        //test the username doesn't already exist
        $database->query('SELECT username FROM users WHERE username = :newUsername');
        $database->bind(':newUsername', $newUsername);
        $matchingUsers = $database->resultset(); //get all the usernames that match
        //print_r($matchingUsers);

        //if existing user with same username found
        //don't save the record
        if( sizeof($matchingUsers) > 0 ){
            $usernameAvailable = 0; //false, not available

            //SEND DATA back to page
            $data = array(
                'usernameAvailable' => $usernameAvailable
            );
            //specify the type of data that's going to be sent
            header('Content-Type: application/json');
            echo json_encode($data);
        }
        else { //username avaiable, save the record
            $usernameAvailable = 1;

            //if false is sent, database error as value is equivalent to null - set an explicit value
            if( $_POST['pm_user_admin'] == false ){
                $pmUserAdmin = 0;
            } else {
                $pmUserAdmin = 1;
            }

            //encrypt password
            $postPassword = $_POST['password'];
            $passwordHash = password_hash($postPassword, PASSWORD_DEFAULT);


            $database->query('INSERT INTO users (username, password, pm_user_admin) VALUES (:username, :password, :userAdmin)');
            $database->bind(':username', $newUsername);
            $database->bind(':password', $passwordHash);
            $database->bind(':userAdmin', $pmUserAdmin);
            try {
                $saveSuccess = $database->execute();
                $message = "success";
                //print_r((int)$saveSuccess);
            } catch ( \Exception $e ) {
                print_r($e);
                $message = "Sorry, an error occurred";
            }

            $newUserId = $database->lastInsertId();

            //SEND DATA back to page
            $data = array(
                'newUserId' => $newUserId,
                'usernameAvailable' => $usernameAvailable
            );
            //specify the type of data that's going to be sent
            header('Content-Type: application/json');
            echo json_encode($data);
        }






    } //endif update/new

    //this works, but not accessible by the update script when this script next runs (returns 0)
    //need to pass to JS?
//    $newUserId = $database->lastInsertId();
//    print('new user id: ');
//    print_r($newUserId);


    // echo $message;


}
