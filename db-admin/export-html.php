<?php
// Report all errors except E_NOTICE
error_reporting(E_ALL & ~E_NOTICE);

	require '_db.php';

	$database = createDb();

	$html_header = "";
	$html_body = "";


		$datas = $database->query("
			SELECT R.*, 
					IFNULL((SELECT SUM(P.PaidAmount) FROM Payment P WHERE P.MainContactId = R.MainContactId), 0 ) as TotalPaid,
				(
				    SELECT GROUP_CONCAT(P.DateEntered SEPARATOR '; ')
					FROM Payment P
				    WHERE P.MainContactId = R.MainContactId
				    GROUP BY P.MainContactId
				) as PaidDates,
				(
				    SELECT GROUP_CONCAT(N.Notes SEPARATOR '; ') 
				    FROM Note N 
				    WHERE N.MainContactId = R.MainContactId
				    GROUP BY N.MainContactId

				) as AdminNotes
				FROM MainContact R
			")->fetchAll();

		$MainContactId = 0;

		$counter = 0;

			if(count($datas) > 0 ){




				// Add some data


							$html_header = '<thead><tr>
											<th>Id</th>
											<th>FullName</th>' .
											'<th>Reference</th>' .
											'<th>Age</th>' .
											'<th>Email</th>' .
											'<th>Phone</th>' .																						
											'<th>Church</th>' .
											'<th>FamilyDiscount</th>' .
											'<th>Airbed</th>' .
											'<th>AirportTransfer</th>' .																						
											'<th>Relation</th>' .
											'<th>Fee</th>' .
											'<th>DateTimeEntered</th>' .
											'<th>Comments</th>' .																						
											'<th>CheckedIn</th>' .
											'<th>PaidAmount</th>' .
											'<th>Cancelled</th>' .
											'<th>Pensioner</th>' .																						
											'<th>Role</th>' .
											'<th>Gender</th>' .
											'<th>Firstname</th>' .
											'<th>Surname</th>' .																						
											'<th>Dates Paid</th>' .
											'<th>Admin Notes</th></tr></thead>';




					$counter = 1;

					foreach($datas as $row){




						if ($MainContactId != $row["MainContactId"] ) {




							// Add some data

							$counter = $counter + 1;

							$html_body = $html_body . '<tr>';

							$html_body = $html_body . '<td>' . $row["MainContactId"] . '</td>' ;

							$html_body = $html_body . '<td>' . $row["FullName"] . '</td>' ;

							$html_body = $html_body . '<td>' . $row["Reference"] . '</td>' ;

							$html_body = $html_body . '<td>' . $row["Age"] . '</td>' ;

							$html_body = $html_body . '<td>' . $row["Email"] . '</td>' ;

							$html_body = $html_body . '<td>' . $row["Phone"] . '</td>' ;

							$html_body = $html_body . '<td>' . $row["Church"] . '</td>' ;

							$html_body = $html_body . '<td>' . $row["FamilyDiscount"] . '</td>' ;

							$html_body = $html_body . '<td>' . ToYesNo($row["Airbed"]) . '</td>' ;

							$html_body = $html_body . '<td>' . ToYesNo($row["AirportTransfer"]) . '</td>' ;

							$html_body = $html_body . '<td>' .  '</td>' ;

							$html_body = $html_body . '<td>' .  $row["Fee"] . '</td>' ;

							$html_body = $html_body . '<td>' .  $row["DateTimeEntered"] . '</td>' ;

							$html_body = $html_body . '<td>' .  $row["Comments"] . '</td>' ;

							$html_body = $html_body . '<td>' .  ToYesNo($row["CheckedIn"]) . '</td>' ;

							$html_body = $html_body . '<td>' .  $row["TotalPaid"] . '</td>' ;

							$html_body = $html_body . '<td>' .  ToYesNo($row["Cancelled"]) . '</td>' ;

							$html_body = $html_body . '<td>' .  ToYesNo($row["Pensioner"]) . '</td>' ;

							$html_body = $html_body . '<td>' .  $row["Role"] . '</td>' ;

							$html_body = $html_body . '<td>' .  $row["Gender"] . '</td>' ;

							$html_body = $html_body . '<td>' .  $row["Firstname"] . '</td>' ;

							$html_body = $html_body . '<td>' .  $row["Surname"] . '</td>' ;

							$html_body = $html_body . '<td>' .  $row["PaidDates"]  . '</td>';

							$html_body = $html_body . '<td>' .  $row["AdminNotes"] . '</td>' ;

							$html_body = $html_body . '</tr>';


							$MainContactId = $row["MainContactId"];								

						}
							
					}

			}

			$date = new DateTime();			

			// clean the output buffer
			ob_clean();

			header("Content-type:application/vnd.ms-excel");
			header("Content-Disposition:attachment;filename='rego-export-" . $date->getTimestamp() .".xls'");
			
			echo '<table border="1">';
			echo $html_header;
			echo '<tbody>';
			echo $html_body;
			echo '</tbody>';
			echo '</table>';
			
			exit;
?>



	



