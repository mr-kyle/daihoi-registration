<?php
// Report all errors except E_NOTICE
error_reporting(E_ALL & ~E_NOTICE);


date_default_timezone_set('Australia/Sydney');


if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');



/** Include PHPExcel */

require_once dirname(__FILE__) . '/PHPExcel.php';

	require '_db.php';

	$database = createDb();


	// Create new PHPExcel object
	$objPHPExcel = new PHPExcel();


	// Set document properties
	$objPHPExcel->getProperties()->setCreator("Kyle Huynh")
								 ->setLastModifiedBy("Kyle Huynh")
								 ->setTitle("Office 2007 XLSX")
								 ->setSubject("Office 2007 XLSX")
								 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
								 ->setKeywords("office 2007 openxml php")
								 ->setCategory("Regos");




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
				FROM vAllRegos R
			")->fetchAll();

		$MainContactId = 0;



			if(count($datas) > 0 ){





							// <th>Name</th>            = A1

							// <th>Reference</th>       = B1

							// <th>Age</th>             = C1

							// <th>Email</th>           = D1

							// <th>Phone</th>           = E1

							// <th>Church</th>          = F1

							// <th>Family Discount</th> = G1

							// <th>Airbed</th>          = H1

							// <th>Airport</th>         = I1

							// <th>Relation</th>        = J1

							// <th>Fee</th>             = K1

							// <th>Date</th>            = L1

							// <th>Comments</th>        = M1

							// <th>Checked In</th>      = N1

							// <th>Paid Amount</th>     = O1

							// <th>Cancelled</th>     	= P1

							// <th>Pensioner</th>     	= Q1

							// <th>Role</th>     		= R1

							// <th>Gender</th>     		= S1
							// <th>Firstname</th>     		= T1
							// <th>Surname</th>     		= U1
							// <th>Dates Paid</th>     		= V1
							// <th>Admin Notes</th>    		= W1


				// Add some data

				$objPHPExcel->setActiveSheetIndex(0)
				            ->setCellValue('A1', 'FullName')
				            ->setCellValue('B1', 'Reference')
				            ->setCellValue('C1', 'Age')
				            ->setCellValue('D1', 'Email')
							->setCellValue('E1', 'Phone')
				            ->setCellValue('F1', 'Church')
				            ->setCellValue('G1', 'FamilyDiscount')
				            ->setCellValue('H1', 'Airbed')
				            ->setCellValue('I1', 'AirportTransfer')
							->setCellValue('J1', 'Relation')
				            ->setCellValue('K1', 'Fee')
				            ->setCellValue('L1', 'DateTimeEntered')
				            ->setCellValue('M1', 'Comments')
				            ->setCellValue('N1', 'CheckedIn')
							->setCellValue('O1', 'PaidAmount')
							->setCellValue('P1', 'Cancelled')
							->setCellValue('Q1', 'Pensioner')
							->setCellValue('R1', 'Role')
							->setCellValue('S1', 'Gender')
							->setCellValue('T1', 'Firstname')
							->setCellValue('U1', 'Surname')
							->setCellValue('V1', 'Dates Paid')
							->setCellValue('W1', 'Admin Notes');

			



					$counter = 1;

					foreach($datas as $row){




						if ($MainContactId != $row["MainContactId"] ) {




							// Add some data

							$counter = $counter + 1;

							$objPHPExcel->setActiveSheetIndex(0)

							            ->setCellValue('A'.$counter, $row["FullName"])

							            ->setCellValue('B'.$counter, $row["Reference"] )

							            ->setCellValue('C'.$counter, $row["Age"])

							            ->setCellValue('D'.$counter, $row["Email"])

										->setCellValue('E'.$counter, $row["Phone"])

							            ->setCellValue('F'.$counter, $row["Church"])

							            ->setCellValue('G'.$counter, $row["FamilyDiscount"])

							            ->setCellValue('H'.$counter, ToYesNo($row["Airbed"]))

							            ->setCellValue('I'.$counter, ToYesNo($row["AirportTransfer"]))

										->setCellValue('J'.$counter,  '')

							            ->setCellValue('K'.$counter, $row["Fee"])

							            ->setCellValue('L'.$counter, $row["DateTimeEntered"])

							            ->setCellValue('M'.$counter, $row["Comments"])

							            ->setCellValue('N'.$counter, ToYesNo($row["CheckedIn"]))

										->setCellValue('O'.$counter, $row["TotalPaid"])

										->setCellValue('P'.$counter, $row["Cancelled"])

										->setCellValue('Q'.$counter, $row["Pensioner"])

										->setCellValue('R'.$counter, $row["Role"])

										->setCellValue('S'.$counter, $row["Gender"])

										->setCellValue('T'.$counter, $row["Firstname"])

										->setCellValue('U'.$counter, $row["Surname"])

										->setCellValue('V'.$counter, $row["PaidDates"])

										->setCellValue('W'.$counter, $row["AdminNotes"]);





								$MainContactId = $row["MainContactId"];

								

						}







						if ($row["RName"] != '') {

							// Add some data

							$counter = $counter + 1;

							$objPHPExcel->setActiveSheetIndex(0)

							            ->setCellValue('A'.$counter, $row["RName"])

							            ->setCellValue('B'.$counter, $row["Reference"] )

							            ->setCellValue('C'.$counter, $row["RAge"])

							            ->setCellValue('D'.$counter, '')

										->setCellValue('E'.$counter, '')

							            ->setCellValue('F'.$counter, $row["Church"])

							            ->setCellValue('G'.$counter, $row["RFamilyDiscount"])

							            ->setCellValue('H'.$counter, ToYesNo($row["RAirbed"]))

							            ->setCellValue('I'.$counter, ToYesNo($row["RAirportTransfer"]))

										->setCellValue('J'.$counter,  $row["RRelation"]	)

							            ->setCellValue('K'.$counter, $row["RFee"])

							            ->setCellValue('L'.$counter, $row["DateTimeEntered"])

							            ->setCellValue('M'.$counter, '')

							            ->setCellValue('N'.$counter, ToYesNo($row["RCheckedIn"]))

										->setCellValue('O'.$counter, 0)

										->setCellValue('P'.$counter, $row["RCancelled"])

										->setCellValue('Q'.$counter, $row["RPensioner"])

										->setCellValue('R'.$counter, $row["RRole"])

										->setCellValue('S'.$counter, $row["RGender"])

										->setCellValue('T'.$counter, $row["RFirstname"])

										->setCellValue('U'.$counter, $row["RSurname"])									

										->setCellValue('V'.$counter, "")	

										->setCellValue('W'.$counter, "");		



						}

							

					}





			

			}

				



			// Rename worksheet

			$objPHPExcel->getActiveSheet()->setTitle('regos');





			// Set active sheet index to the first sheet, so Excel opens this as the first sheet

			$objPHPExcel->setActiveSheetIndex(0);





			// Redirect output to a client’s web browser (Excel2007)

			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

			header('Content-Disposition: attachment;filename="Melbourne2016RegoExport.xlsx"');

			header('Cache-Control: max-age=0');

			// If you're serving to IE 9, then the following may be needed

			header('Cache-Control: max-age=1');



			// If you're serving to IE over SSL, then the following may be needed

			header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past

			header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified

			header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1

			header ('Pragma: public'); // HTTP/1.0



			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

			$objWriter->save('php://output');

			exit;













?>



	



