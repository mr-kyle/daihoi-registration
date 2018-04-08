<!doctype html>
<html class="no-js" lang="en">
<head>
	<title>Registration Listing</title>
	<?php require '_scripts.php' ?>
	
</head>

<body>
<?php require '_menu.php' ?>


	<div>&nbsp;</div>



<?php
	require '_db.php';


	function ListRegos2(){

			$database = createDb();


			// $datas = $database->select("MainContact", "*" , [
			// 	"MainContactId[>]" => 0,
			// 	"ORDER" => "MainContactId"
			// ]);

			/*
ALTER ALGORITHM=UNDEFINED DEFINER=`melbou99`@`localhost` SQL SECURITY DEFINER VIEW `vPaidVsFeeVsPersons` AS select (`M`.`Fee` + ifnull((select sum(`R`.`Fee`) from `Registrant` `R` where (`R`.`MainContactId` = `M`.`MainContactId`)),0)) AS `TotalFees`,ifnull((select sum(`P`.`PaidAmount`) from `Payment` `P` where (`P`.`MainContactId` = `M`.`MainContactId`)),0) AS `TotalPaid`,(select count(0) from `Registrant` `R` where (`R`.`MainContactId` = `M`.`MainContactId`)) AS `TotalPersons`,`M`.`MainContactId` AS `MainContactId`,`M`.`FullName` AS `FullName`,`M`.`Age` AS `Age`,`M`.`Church` AS `Church`,`M`.`Email` AS `Email`,`M`.`Phone` AS `Phone`,`M`.`DateTimeEntered` AS `DateTimeEntered`,`M`.`AirportTransfer` AS `AirportTransfer`,`M`.`Airbed` AS `Airbed`,`M`.`Comments` AS `Comments`,`M`.`Fee` AS `Fee`,`M`.`Reference` AS `Reference`,`M`.`CheckedIn` AS `CheckedIn`,`M`.`Role` AS `Role`,`M`.`Gender` AS `Gender`,`M`.`Cancelled` AS `Cancelled`,`M`.`Firstname` AS `Firstname`,`M`.`Surname` AS `Surname`,`M`.`Pensioner` AS `Pensioner` from `MainContact` `M` order by `M`.`MainContactId`
*/

			//SELECT M.*, SELECT(COUNT R.MainContactId FROM Registrant R WHERE R.MainContactId=M.MainContactId) GroupTotal FROM MainContact M ORDER BY M.MainContactId
			$query = "SELECT * FROM vPaidVsFeeVsPersons;";
			$datas = $database->query($query)->fetchAll();
	

			$index 		= 1;
			$headers 	= "MIME-Version: 1.0" . "\r\n";
			$headers 	.= "Content-type:text/html;charset=UTF-8" . "\r\n"; 		
			$headers 	.= "From: DaiHoi Melbourne2016 <registration@melbourne2016.net.au>" . "\r\n";
			//$headers 	.= "Bcc: kyle@instil.org.au" . "\r\n";
			$res = false;

			foreach($datas as $row){
					$to 	= $row["Email"];
					$html 	= 'Dear ' . $row["FullName"] . '<p>Please be aware that our early bird specials will end soon and any payment not received by Friday 30 Sep 2016 will not be eligible for the early bird discounts. Any outstaning payments must be recevied in full by by Friday 30 Sep 2016.<p><p>Please review your registration (<a href="http://melbourne2016.net.au/register/view/?ref=' . $row["Reference"] . '">http://melbourne2016.net.au/register/view/</a>) using your reference number: ' . $row["Reference"] . ' </p><p>Thank you<br/>The Melbourne2016 Registration Team</p>';

	if ( $index  >= 91 && $index <= 105 && 1==2){


					try {
						mail($to, "DaiHoi Melbourne 2016 Early Bird Reminder",$html,$headers);
						$res = true;
					} catch (Exception $e) {
						echo 'Caught exception: ',  $e->getMessage(), "\n";
						$res  = false;
					}
				
					echo sprintf('<div style="padding-left:50px;">%s. <b>%s</b>, %s: %s</div><hr/>', $index, $to , $row["Reference"], $res );
					
					if (!$res) {
						return false;
					}

	}

					$index = $index + 1;

			}

	
	

	}


	ListRegos2();

?>

	

</body>
</html>

