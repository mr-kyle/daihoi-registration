<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/_cApp.php' ?>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/includes/_cRegistration.php');?>
<?php	
// Report all errors except E_NOTICE
error_reporting(E_ALL & ~E_NOTICE);
?>
<!DOCTYPE html>
<html lang="en">
<head>

    <?php include($_SERVER['DOCUMENT_ROOT'] . '/includes/_meta.php'); ?>
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/includes/_scripts.php'); ?>
    
	<style type="text/css">

		.panel-footer button {
			display: none;
		}

		#process-rego-button {
			display: block;
			min-width: 50%;
			margin: 0 auto;

		}

        td.cancelled { text-decoration: line-through; color: maroon; }
        .view-only { display: block !important; }
        #summary-content, #summary-content td, #summary-content th, #summary-content p, #summary-content li {
            color:#f7f7f7 !important;
        }


        #summary-content input[type=text] {
            background-color:white !important;
        }
	</style>

</head>

<body>

    <?php include($_SERVER['DOCUMENT_ROOT'] . '/includes/_menu.php');?>


    <div class="container body-content">

            <h1>Registration Information</h1>

            <p>Below is your registration information that we have on record. Please ensure that your details are correct and recent in case we need to contact you for conference updates.</p>

            <!-- <p>If you need to update your information, please contact our team at: <a href="mailto:info@melbourne2016.net.au">info@melbourne2016.net.au</a></p> -->

            <div>&nbsp;</div>

            <?php 

            	if ($_GET["ref"] && $_GET["success"]) {

						echo  '<div class="alert alert-dismissible alert-success font-normal no-print"><button type="button" class="close" data-dismiss="alert">X</button><i class="fa fa-smile-o fa-5x pull-left"> </i><p><strong>Awesome!</strong> You have successfully submitted your registration details for Dai Hoi Melbourne ' . AppConfig::$CONFERENCE_YEAR . ', please take note of your green reference number below. <p>On behalf of the conference, thank you and God bless.</p><div class="clearfix"></div></div>';

            	}

            ?>



            <div>&nbsp;</div>

            <div class="row" id="rego-summary" style="display: block !important;">

                <div class="well">

                    <div id="summary-content">

                        <?php viewRego(); ?> 

                    </div>

                    <div class="clearfix">&nbsp;</div>

                </div>

            </div>




    </div>

    <!-- footer -->
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/includes/_footer.php');?> 
    

</body>

</html>



