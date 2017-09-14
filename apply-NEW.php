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


        <div class="roundedbox-centered-whole careers-margin">

            <div class="job-title">
              <h1>Applying for a job with Nottinghamshire YMCA</h1>
            </div>

        <div class="linkbox-wrapper">

                <h3><strong>Thank you for your interest in working for Nottinghamshire YMCA. Please read these notes as they will help you to fill in your application form and will also give you information about working for us. Please note that due to the importance we place on safeguarding children, young people and vulnerable adults all of our posts are subject to a DBS check and references.</strong><br />
                </h3>

                <div class="careers-info">

                    <div class="careers-sub-text-a">
                        <h3> 1. Completing your Application Form </h3>
                    </div>
                    <br>

                <div class="careers-sub-text-b">
                        <p>On your application form you need to show us how you meet the requirements listed on the person specification. </p>
                        <p>The main points to remember when filling in your application form are:-</p>
                        <ul>
                            <li>Use dark ink</li><br />
                            <li>Fill in <strong>all</strong> the sections of the form – please do not send a CV as it will not be considered.</li><br />
                            <li>Read the job description and person specification carefully and think how your skills, knowledge and experience match the requirements.</li><br />
                            <li>Show how you meet the requirements marked with an &ldquo;A&rdquo; on the person specification. It may help you to organise your information if you use the requirements as individual headings. </li><br />
                            <li>Fill in your form as fully as possible as we will not be able to make assumptions about your abilities and will not take into account previous applications or previous knowledge about you.&nbsp; </li><br />
                            <li>Make sure that if you say you can do something you give evidence of this on your application form.</li><br />
                            <li>If you have insufficient space then please continue on additional sheets.</li><br />
                            <li>If possible make a copy of your completed form and keep it for future reference.</li><br />
                            <li>Remember that the other requirements not marked with an &ldquo;A&rdquo; on the person specification will be tested elsewhere in the recruitment process e.g. in the interview, by a test, by looking at your documents etc</li><br />
                            <li>Make sure you return the form to us before the closing date, as we don&rsquo;t normally accept late applications.</li><br />
                            <li>Mark the envelope &ldquo;Application Form&rdquo; and post it to Human Resources, Nottinghamshire YMCA, 4 Shakespeare Street, Nottingham, NG1 4FG.</li></ul></div>

                </div>
                </div>

                <div class="careers-info">
                    <div class="careers-sub-text-a">
                        <h3>2. What Next?</h3>
                    </div>
                    <br>
                    <div class="careers-sub-text-b">
                        <p>Due to our charitable status we try to contain costs and therefore do not acknowledge receipt of your form or contact applicants who have not been shortlisted.</p>
                        <p>If you have been shortlisted we will try to contact you within 3 weeks of the closing date so if you haven&rsquo;t heard by then please assume that you haven&rsquo;t been short-listed on this occasion.</p>

                    </div>
                </div>

                <div class="careers-info">
                    <div class="careers-sub-text-a">
                        <h3>3. Note for Disabled Applicants</h3>
                    </div>
                    <br>
                    <div class="careers-sub-text-b">
                        <p>Alternative Formats - If you need us to send you the application form and job details in a different format please contact Human Resources on <a href="tel:01159489845">0115 9489845</a> or email us on <a href="mailto:hr@nottsymca.org">hr@nottsymca.org</a></p></div>

                    </div>


                <div class="careers-info">
                    <div class="careers-sub-text-a">
                        <h3>4. Working for Nottinghamshire YMCA</h3>
                    </div>
                    <div class="careers-sub-text-b">
                        <h3><strong>&nbsp;<em>&ldquo;Our mission, based on Christian values, is to develop the mind, body and spirit of individuals, families and communities and to improve health and well being for all.&rdquo;</em></strong></h3>
                        <ul>
                            <li>You will join an organisation that is working towards a culture where its Christian core values of honesty, caring, respect and responsibility are at the centre of all we do.</li>
                        </ul>
                        <ul>
                            <li>All permanent employees enjoy a <u>minimum</u> of 4 weeks annual leave plus 8 bank holidays or days off in lieu if a bank holiday is worked.</li>
                        </ul>
                        <ul>
                            <li>You will be entitled to free membership of our Health and Fitness facilities including a large modern gym and a range of exercise classes.<br />
                            </li>
                        </ul>
                        <ul>
                            <li>If you are new to Nottinghamshire YMCA you will be subject to a probationary period of 6 months during which you will receive regular assessment, support and feedback. If, at the end of this period we are happy with your work and conduct your employment will be confirmed.</li>
                        </ul>
                        <ul>
                            <li>You will have the chance to join a pension scheme. </li>
                        </ul>
                        <ul>
                            <li>After successfully completing your probationary period you will be eligible for a range of employee discounts and benefit schemes including assistance towards childcare costs, travel costs or health insurance.</li>
                        </ul>
                        <ul>
                            <li>Due to the nature of our work all posts are subject to a DBS Check and depending on your position you might be required to register with the Update Service.
                            </li>
                            <br />

                            <li>You will be offered development and training opportunities.<br />
                            </li><br />
                            <li>Your salary will be paid straight into your bank on the 22nd of each month or the last working day before this date.</li>
                        </ul>
                        <ul>
                            <li>We operate a non smoking policy in all our buildings, grounds and communal areas.</li>
                        </ul>
                    </div>
                </div>

            <div class="careers-info white">

                <div class="careers-more-info green">
                    <a href="../../careersMEDIA/16_03_Application_Form.docx">Application Form</a>
                </div>


                <div class="careers-more-info yellow">
                    <a href="../../careersMEDIA/11_10_Equal_Opps_Form.doc">Equal Opps Form</a>
                </div>

                <div class="careers-more-info red">
                    <a href="../../careersMEDIA/14_04_Guidance_Notes.pdf">Guidance Notes</a>
                </div>

                <div class="careers-more-info purple">
                    <a href="../../careersMEDIA/POLICY_STATMENT_SAFEGUARDING.pdf">Policy Statement</a>
                </div>
            </div>
            </div>
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
