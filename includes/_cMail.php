<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/_cApp.php' ?>
<?php
		// Report all errors except E_DEPRECATED
		error_reporting(E_ALL ^ E_DEPRECATED);
		class Mailer{

				function Mailer(){ }


				function sendMail($to,  $subject,  $message, $include_viet_section ){
					//TODO: REMOVE FOR PROD
					return true;
					
					
					if (trim($to) == "" ){
						$to = "kyle@instil.org.au";
					}
					//$subject = "My subject";
					if (!$this->checkEmailValidity($to)){
						$to = AppConfig::$DEFAULT_EMAIL_ADDRESS;
					}
					
					$headers 	= "MIME-Version: 1.0" . "\r\n";
					$headers 	.= "Content-type:text/html;charset=UTF-8" . "\r\n"; 		
					$headers 	.= "From: " . AppConfig::$APP_NAME ." <" . AppConfig::$DEFAULT_EMAIL_ADDRESS .">" . "\r\n";
					$headers 	.= "Bcc: " . AppConfig::$DEFAULT_EMAIL_ADDRESS . "\r\n";
					
					$html = '<!DOCTYPE html>
								<html lang="en">
								<head>
								    <meta charset="utf-8" />
								    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
								    <style>
								        body {
								            color: #333;
								            font-size: 13px;
								            background-color: #fff;
								            font-family: "Lato", "Helvetica Neue", Helvetica, Arial, sans-serif;
								        }

								        #rego-summary{
								            max-width:970px;
								            min-width:700px;
								            margin: 0 auto;

								        }
								        .well {
								            background-color: transparent;
								            padding: 20px;
								        }

								        .clearfix {
								            clear: both;
								        }

								        .row, .col-lg-12, .panel, .panel-body {
								            
								        }

								        .col-lg-6 {
								            padding-right:10px;
								        }

								        table {             
								        	width: 100%;
								            display: table;
								            margin-bottom:20px;
								        }

								        .table {
								            width: 100%;
								            display: table;
								            margin-bottom:20px;
								        }

								        .table th, th {
								            text-align:left;
								            padding-bottom:10px;
								        }

								        table td {
								            padding:3px;
								        }

								        .table-striped > tbody > tr {
								            background-color: #bbbbbb;
								            color: #333333;
								        }

								        caption {
								            padding-top: 6px;
								            padding-bottom: 6px;
								            border-bottom:2px solid black;
								            color: #4e5d6c;
								            text-align: left;
								            font-size:120%;
								            font-weight:bold;
								        }

								        .panel-body {
								            color: #f5f5f5;
								            padding:25px;
								            background-color: #213244;
								        }

								        .panel-body ul {
								            margin-left:20px;
								        }

								        .panel-body caption {
								            color:#88A5A3;

								        }

								        .panel-body  .table-striped > tbody > tr {
								            background-color: #4E5D6C;
								            color: #f5f5f5;
								        }



								        #payment-summary table td:last-child{
								            text-align:right;
								        }

								        .label {
								            -moz-border-radius: 3px;
								            -webkit-border-radius: 3px;
								            border-radius: 3px;
								            padding:3px;
								            font-size:90%;
								        }

								        .label-success {
								            background-color:#73a839;
								            color:#fff;
								            padding:5px;
								        }

								        label-summary-total {
								            text-align:right;
								        }


								        .label-warning {
								            background-color:#f0ad4e;
								            color:#fff;
								            padding:5px
								        }

										.panel-footer button {
										    display: none;
										}

								        div#summary-content table, 
								        div#summary-content .panel-body table {
								            border-top: 1px solid #DF691A !important;
								            border-collapse: initial;
								            border-spacing: 2px;
								            border: none;
								        }

								        .hidden {display:none;}
										.print-only {display:block !important;}
								    </style>
								</head>
								<body>
											
								            <div>&nbsp;</div>
								            <div class="row" id="rego-summary" style="display: block !important;">
								                <div class="well">
								                    <div id="summary-content">
								                            <!--CONTENT-->
								                            ' . $this->getVietSection($include_viet_section)  . '
								                    </div>
								                    <div class="clearfix">&nbsp;</div>
								                </div>
								            </div>


								</body>
								</html>
								';


					$html = str_replace('<!--CONTENT-->', $message, $html);

					try {
						//https://www.telemessage.com/developer/faq/how-do-i-encode-non-ascii-characters-in-an-email-subject-line/
						//https://ncona.com/2011/06/using-utf-8-characters-on-an-e-mail-subject/
						mail($to, '=?utf-8?B?'.base64_encode($subject).'?=',$html,$headers,"-f " . AppConfig::$DEFAULT_EMAIL_ADDRESS);
						return true;
					} catch (Exception $e) {
						echo 'Caught exception: ',  $e->getMessage(), "\n";
						return false;
					}
				 

				}


				function getVietSection($include_viet_section){
					if ($include_viet_section == 1){
                		return file_get_contents(($_SERVER['DOCUMENT_ROOT'] . '/includes/_viet.php'),false);
                	}
                	return "";
				}

				function checkEmailValidity($email){

					// check the email fields for validity
					if ($email) {
					   $email = trim($email);
					   $string_exp = '^[_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,6}$';
					   
						//if (!eregi($string_exp, $email)){
					   if(!preg_match('/'.$string_exp.'/i',$email)){
					   	return false;
					   }else{
					   	return true;
					   }
					   
					}


					return false;
				}




		} //end class


		
		// if ($_GET["test"] == "1"){
		// 	$x = new Mailer();
		// 	$x->sendMail("","test","test",1);
		// 	echo "sent";
		// }
		



	?>


