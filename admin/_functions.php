<?php


function primaryImageName($articleId){

    global $database;

    //select article first image
    $database->query("SELECT * from article_images WHERE article_id = :articleId");
    $database->bind(':articleId', $articleId);
    $indexImages = $database->resultset();



    //set up primary image
    foreach( $indexImages as $indexImage ){

        //primary image is set in DB
        if( $indexImage['is_primary'] == 1 ){ //if the image has is_primary set
            $primaryImage[$articleId] = $indexImage['image_name'];  //make it the $primaryImage
        }
    }

    //primary image NOT set in DB - just use the first image instead
    if( !isset($primaryImage[$articleId]) ){ //if no primary image set from DB

        $primaryImage[$articleId] = $indexImages[0]['image_name']; //make primary image the first one in the array
    }

    //prints the image_name column from the relevant image / article
    print(  $primaryImage[$articleId]);

}



//KEEP INPUT
//restore form input when form submitted with missing values
function keepInput($fieldName){

    global $isEditForm, $article; //tell the function to use this variable as a global, not local

    if( isset( $_POST[$fieldName] ) ){ //check if a value was entered before submitted

        //needs to be passed to JS, so json_encode the special characters
        if( $fieldName == 'bodytext' ){
            if( $fieldName == 'bodytext' ){
                print( json_encode( $_POST[$fieldName] ) );
            }
        }

        //doesn't need to go to JS so no need to encode
        else {
            print( htmlspecialchars( $_POST[$fieldName] ) );  //remove any potentially malicious code);
        }
    }
    else { //if not yet submitted

        //if is the EDIT form - need to populate with database values
        if( isset($isEditForm) ){

            //transform the date from the DB before displaying
            if($fieldName == 'publish_date'){
                $dateForForm = DateTime::createFromFormat('Y-m-d', $article[$fieldName]);
                $dateForForm = $dateForForm->format('d-m-Y');

                print($dateForForm);

            } else {
                print( $article[$fieldName] );
            }
        }

        //if is NOT the edit form
        else {
            if( $fieldName == 'publish_date' ) { //if it's the date field
                print( date('d-m-Y') ); //default value of today's date
            }

            else {
                //print('blank'); //blank
            }
        }//end if NOT edit form (else)

    }
}