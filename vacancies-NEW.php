<?php //Mailmunch php
$path = $_SERVER['DOCUMENT_ROOT'];
$path .= "/_components/mailmunch.php";
include_once($path);
?>


<?php
session_start(); // Start session.

//include DB info
include_once('admin/DB.php');

//instantiate database class
$database = new Database($dsn);

// Once the database has been instantiated, you will now be connected. So queries can be run by writing something like the line below
$database->query("SELECT * from vacancies");
// The line above runs a query to fetch ALL data from the vacancies table.

// This now stores the results of the above query into a variable called $jobs. This will be used further down the page in a foreach loop.
$jobs = $database->resultset();


?>




<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">
    <title>Nottinghamshire YMCA</title>

    <meta name="title" content="Nottinghamshire YMCA">
    <meta name="description" content="">
    <meta name="keywords" content="">


    <!-- #################### HEAD #####################-->
    <?php
    $path = $_SERVER['DOCUMENT_ROOT'];
    $path .= "/_components/head.php";
    include_once($path);
    ?>

    <meta name="google-site-verification" content="vLvz5U-ahILlJSmo1O14JjGtSKA6KPSziA98o04P7O4" />

</head>

<?php $siteSection = "home"; //set which section of the site the page belongs to ?>
<?php $isSectionIndex = ""; //true, or blank==false ?>

<body class="headers-default homestyle" >
<!--Light headers - headers-light-->





<?php //#################### PAGETOP #####################
$path = $_SERVER['DOCUMENT_ROOT'];
$path .= "/_components/pagetop.php";
include_once($path);


?>



<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ PAGE CONTENT HERE ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->

<div class="contentwrapper">





<div class="missionstatement-home">
<h1>Vacancies</h1>
</div>


    <?php
    // use the $jobs variable from the top of the page and throw into foreach loop. The bits further down grab individual values from the database.
    foreach($jobs as $job): ?>

        <div class="linkbox-wrapper">

            <div class="roundedbox-centered-whole careers-margin">
                <div class="job-title">
                    <a href="VacancyJobs/<?= $job['more_info_link'] ?>">
                        <span><?= $job['job_title'] ?></span>
                    </a>
                </div>

                <div class="careers-info">
                    <span class="careers-sub-text-a">
                        Location:
                    </span>
                    <br>
                    <span class="careers-sub-text-b">
                    <?= $job['location'] ?>
                    </span>
                </div>

                <div class="careers-info">
                    <span class="careers-sub-text-a">
                        Hours:
                    </span>
                    <br>
                    <span class="careers-sub-text-b">
                    <?= $job['hours'] ?>
                    </span>
                </div>

                <div class="careers-info">
                    <span class="careers-sub-text-a">
                        Pay:
                    </span>
                    <br>
                    <span class="careers-sub-text-b">
                    £<?= $job['pay'] ?>
                    </span>
                </div>

                <div class="careers-info">
                    <span class="careers-sub-text-a">
                        Closing date:
                    </span>
                    <br>
                    <span class="careers-sub-text-b">
                    <?= $job['deadline'] ?>
                    </span>
                </div>

                <div class="careers-info">
                    <span class="careers-sub-text-a">
                        Interview dates:
                    </span>
                    <br>
                    <span class="careers-sub-text-b">
                    <?= $job['interview_date'] ?>
                    </span>
                </div>

                <div class="careers-more-info">
                    <a href="VacancyJobs/<?= $job['more_info_link'] ?>">More info</a>
                </div>
            </div>
        </div>


            <?php endforeach; ?>






</div>





<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ PAGE CONTENT END ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->






<!-- #################### PAGEBOTTOM #####################-->
<?php  //includes footer and scripts, then closes html and body
$path = $_SERVER['DOCUMENT_ROOT'];
$path .= "/_components/pagebottom.php";
include_once($path);
?>
