<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/_cApp.php' ?>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/includes/_cFee.php');?>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/includes/_cSms.php');?>
<?php	
// Report all errors except E_NOTICE
error_reporting(E_ALL & ~E_NOTICE);
?>
<?php require '_db.php';


	/*  
		*********************************************************
		File that contains the request and response for actions called from the webpage.
		*********************************************************
	*/

	class RESPONSE { //class to hold output to json

		//properties
		var $status  = 0;
		var $info    = "";
		var $message = "";
		var $html    = "";
		var $refresh = 0;
		
		
		function RESPONSE($s){
			$this->status    = $s;
		}

		function toJSON(){
			return json_encode($this);
		}	

	} // endclass to hold output to json


	class DELTA { //class to hold output to json
		var $FieldName  = "";
		var $OldValue = "";
		var $NewValue = "";
		
		function DELTA(){
			//do nothing;
		}

		function toJSON(){
			return json_encode($this);
		}

	} // endclass to hold output to json

	/**
	 * updates the status of paid and checkedin for a given Id
	 *
	 * @return void
	 * @author 
	 **/
	function updateCheckin($json){
		header('Content-Type: application/json');
		$r = new RESPONSE(0);

		//example JSON
		//[{"type":"MainContactId","id":121,"checkin":false,"paid":"0"},{"type":"RegistrantId","id":194,"checkin":false,"paid":"0"}]
		if (trim($json) == ""){
			$r->message = 'no json data to process.';
			echo $r->toJSON();
			return false;
		}

		//create the database object
		$database = createDb();

		// work through JSON and update either the main contact or the registrant
		$rowsAffected = 0;
		foreach (json_decode($json, true) as $entry ) {

			//update maincontact
			if ($entry['type'] == 'MainContactId' && $entry['id'] > 0) {

				$rowsAffected =	$database->update("MainContact", [
							"CheckedIn"     => $entry['checkin'],
							], [
							"AND" => [
								"MainContactId" => $entry['id'],
								"Cancelled" 	=> false
								]
						]);

				if ($rowsAffected > 0 ) {
					$r->status = 1;
				}else{
					$r->message .= "Nothing to update, record has existing information.";
				}

			}

		}

		//return json		
		echo $r->toJSON();		

	}

	/**
	 * adds a note
	 *
	 * @return json
	 * @author 
	 **/
	function addNotes(){

		//init variables
		$id = $_POST["id"];
		$notes = $_POST["notes"];

		//set the header
		header('Content-Type: application/json');
		$r = new RESPONSE(0);


		if ($notes == "" || $id < 1){
			$r->message = "No data.";
			echo $r->toJSON();	
			return false;
		}


		//create the database object
		$database = createDb();

		//perform the db action
		$rowsAffected   = $database->insert("Note", [
			"Notes"         => htmlentities($notes),
			"MainContactId" => $id,
		]);


		//parsing the result of the db action
		if ($rowsAffected > 0 ) {
			$r->status = 1;
		}else{
			$r->message = "Inserting new note was not successful.";
		}

		//return json
		
		echo $r->toJSON();				


	}

	/**
	 * fetches not for id
	 *
	 * @return json
	 * @author 
	 **/
	function getNotes(){


		header('Content-Type: application/json');
		
		$id = $_GET['id'];
		$r = new RESPONSE(0);

		//make sure id is present
		if ($id == "" || $id < 1){
			$r->message = "No data.";
			echo $r->toJSON();	
			return false;
		}

		//create the db
		$database = createDb();	

		//get the admin notes
		$datas = $database->select("Note", "*", [
			"MainContactId" => $id 
		]);


		//parse and format response
		if( count($datas) > 0){

			$r->html .= '<tbody>';	

			 foreach ($datas as $row) {
				 						 // process the notes
				 $notes = $row["Notes"];
				 
				 if ($notes != ""){
					$r->html .= sprintf('<tr><td>%s</td><td>%s</td></tr>', $row["DateTimeEntered"], $notes);	 
				 }

			 }



			$r->html .= '</tbody>';	
			$r->status = 1;

		}

		//the response
		echo $r->toJSON();	

	}


	/**
	 * updates registration details
	 *
	 * @return json
	 * @author 
	 **/
	function updateRegistrantDetails($json, $id){

		header('Content-Type: application/json');
		$r = new RESPONSE(0);

		//make sure there is something to process
		if (trim($json) == ""){
			$r->message = 'no json data to process.';
			echo $r->toJSON();
			return false;
		}

		//create the database object
		$database = createDb();

		//decode the json into associative arrays
		$rowsAffected = 0;
		$ob = json_decode($json, true);

			//update registrant
			if ($id > 0 && $ob['Fee'] > 0) {

				//create a calculator objcet
				$calculator = new FeeCalculator();

				//use object to calculate fee
				$calculatedFee = $calculator->calculateFee(
								$ob['Age'], 
								$ob['FamilyDiscount'], 
								false, 
								$ob['AirportTransfer'], 
								$ob['Pensioner'], 
								$ob['EarlyBirdSpecial']);

		    	//check to see if given fee is same as calculated fee
		    	if ($ob['Fee'] != $calculatedFee ){
					$r->message = 'The given fee: ' . $ob['Fee'] . ' is not equal to the calculated fee: ' . $calculatedFee;
					echo $r->toJSON();
					return false;
		    	};


				//get the old registrant info
				$oldinfo = $database->select("Registrant", "*", [
					"RegistrantId" => $id
				]);		
					
				//do the update
				$rowsAffected = $database->update("MainContact", [
						"FullName"         => $ob['Firstname'] . ' ' . $ob['Surname'],
						"Firstname"        => $ob['Firstname'],
						"Surname"          => $ob['Surname'],
						"Age"              => $ob['Age'],
						"Role"             => $ob['Role'],
						//"Airbed"           => $ob['Airbed'],
						"FamilyDiscount"   => $ob['FamilyDiscount'],
						"AirportTransfer"  => $ob['AirportTransfer'],
						"Gender"           => $ob['Gender'],
						"Relation"         => $ob['Relation'],
						"Fee"              => $ob['Fee'],
						"Cancelled"        => $ob['Cancelled'],
						"Pensioner"        => $ob['Pensioner'],
						"EarlyBirdSpecial" => $ob['EarlyBirdSpecial'],
						], [
						"MainContactId"     => $id
						]);

				if ($rowsAffected > 0 ) {
					$r->status = 1;

					//we work out whats changed and update the db
					addToAuditLog($ob , $oldinfo, $id, 'R');

					//redirect client to refresh if cancel status has been changed
					if ($ob['Cancelled'] != $oldinfo[0]['Cancelled']){
						$r->refresh=1;
					}


				}else{
					$r->message .= "Nothing to update, record has existing information.";
				}

			}else{

					$r->status  = 0;
					$r->message = 'No Id or no Fee: ' . $ob['Fee'];
					echo $r->toJSON();
					return false;
			}

		//return json		
		echo $r->toJSON();		

	}


	/**
	 * updates the contact details
	 *
	 * @return json
	 * @author 
	 **/
	function updateMainContactDetails($json, $id){

		header('Content-Type: application/json');
		$r = new RESPONSE(0);

		//make sure there is something to process
		if (trim($json) == ""){
			$r->message = 'no json data to process.';
			echo $r->toJSON();
			return false;
		}

		//create the database object
		$database = createDb();

		//decide json
		$rowsAffected = 0;
		$ob = json_decode($json, true);

			//update registrant
			if ($id > 0 && $ob['Fee'] > 0) {

				//create a calculator objcet
				$calculator = new FeeCalculator();

				//use object to calculate fee
				$calculatedFee = $calculator->calculateFee(
									$ob['Age'], 
									'-', 
									false, 
									$ob['AirportTransfer'], 
									$ob['Pensioner'], 
									$ob['EarlyBirdSpecial']);

		    	//check to see if given fee is same as calculated fee

		    	if ($ob['Fee'] != $calculatedFee ){
					$r->message = 'The given fee: ' . $ob['Fee'] . ' is not equal to the calculated fee: ' . $calculatedFee   ;
					echo $r->toJSON();
					return false;
		    	};



				//get the old registrant info
				$oldinfo = $database->select("MainContact", "*", [
					"MainContactId" => $id
				]);	
					
				//do the update
				$rowsAffected = $database->update("MainContact", [
						"FullName"         => $ob['Firstname'] . ' ' . $ob['Surname'],
						"Firstname"        => $ob['Firstname'],
						"Surname"          => $ob['Surname'],
						"Age"              => $ob['Age'],
						"Role"             => $ob['Role'],
						//"Airbed"           => $ob['Airbed'],
						"AirportTransfer"  => $ob['AirportTransfer'],
						"Gender"           => $ob['Gender'],
						"Church"           => $ob['Church'],
						"Phone"            => $ob['Phone'],
						"Email"            => $ob['Email'],
						"Fee"              => $ob['Fee'],
						"Cancelled"        => $ob['Cancelled'],
						"Pensioner"        => $ob['Pensioner'],
						"EarlyBirdSpecial" => $ob['EarlyBirdSpecial'],
						], [
						"MainContactId"    => $id
						]);

				if ($rowsAffected > 0 ) {
					$r->status = 1;

					//we work out whats changed and update the db
					addToAuditLog($ob , $oldinfo, $id, 'M' );

					//redirect client to refresh if cancel status has been changed
					if ($ob['Cancelled'] != $oldinfo[0]['Cancelled']){
						$r->refresh=1;
					}


				}else{
					$r->message .= "Nothing to update, record has existing information!";
				}

			}else{

					$r->status  = 0;
					$r->message = 'No Id or no Fee: ' . $ob['Fee'];
					echo $r->toJSON();
					return false;
			}

		//return json
		echo $r->toJSON();

	}

	/**
	 * adds JSON to log for auditing when required
	 *
	 * @return json
	 * @author 
	 **/
	function addToAuditLog($jsonArray, $oldinfo, $id, $type ){
			
			$array = array(); 

			foreach ($jsonArray as $key => $value) {

					$k = $key;
					if ($k == 'Reference') {continue; } //skip the reference
					if ($k == 'Comments') {continue; } //skip the reference
					if ($k == 'Name'){ $k = 'FullName'; } //cuz Name is stored as FullName in db

					//compare the json assoc array value and the old db value
					if ($oldinfo[0][$k] != $value){
						$delta = new DELTA();

						$delta->FieldName = $k;
						$delta->OldValue = $oldinfo[0][$k];
						$delta->NewValue = $value;

						array_push($array, $delta);

					}
			}


			if (count($array) > 0 ){
				//create the database object
				$database = createDb();

				$database->insert("AuditLog", [
					"ChangeText"    =>  json_encode($array),
					"Type"			=>	$type,
					"Id"			=>	$id
				]);
			}

	}

	/**
	 * Adds a payment to a registration
	 *
	 * @return json
	 * @author 
	 **/
	function AddRegoPayment(){
		$json = $_POST['json'];
		$id   = $_POST['id'];

		//set the header
		header('Content-Type: application/json');
		$r = new RESPONSE(0);

		//validate data
		if (trim($json) == "" || is_numeric($id) == false){
			$r->message = 'no data to process.';
			echo $r->toJSON();
			return false;
		}
			//create the database
			$database = createDb();

			//decode the JSON
			$ob = json_decode($json, true);

			//make sure there is an amount to add
			if (is_numeric($ob['amount']) == false){
				$r->message = 'No value to update.';
				echo $r->toJSON();
				return false;				
			}

			//check to see the balance
			$total = $database->sum("MainContact", "Fee", [
				"AND" => [
					"MainContactId" =>	$id,
					"Cancelled" 	=>	false]
				]);
			
			$total2 = $database->sum("Registrant", "Fee", [
				"AND" => [
					"MainContactId" =>	$id,
					"Cancelled" 	=>	false]
				]);


			$payments = $database->sum("Payment", "PaidAmount", [
					"MainContactId" =>	$id
				]);

			//the balance calculation
			$outstanding = ($total + $total2 - $payments);

			//we proceed only if the amount is less than the balance
			if ( $ob['amount'] > $outstanding ){
				$r->message = 'This amount: ' . $ob['amount'] . ' is greater than the outstanding amount: ' . $outstanding;
				echo $r->toJSON();
				return false;
			}



			//do insert if allowed
			$database->insert("Payment", [
				"PaidAmount"    =>  $ob['amount'],
				"Notes"    		=>  $ob['comments'],
				"PaidDate"      =>	strtotime($ob['date']),
				"MainContactId" =>	$id
			]);

			//set the status for success
			$r->status = 1;
		



		//return json
		echo $r->toJSON();		

	}

	/**
	 * gets payments for a registration
	 *
	 * @return json
	 * @author 
	 **/
	function getRegoPayments(){

		//set the header
		header('Content-Type: application/json');
		
		//init variables
		$id = $_GET['id'];
		$r = new RESPONSE(0);

		//validate the id and data
		if ($id == "" || $id < 1){
			$r->message = "No data.";
			echo $r->toJSON();	
			return false;
		}

		//create the database connecion
		$database = createDb();		


		//check to see the balance
		$total = $database->sum("MainContact", "Fee", [
			"AND" => [	
				"MainContactId" =>	$id,
				"Cancelled" 	=>	false]
			]);
		
		$total2 = $database->sum("Registrant", "Fee", [
			"AND" => [
				"MainContactId" =>	$id,
				"Cancelled" 	=>	false]
			]);

		//get the admin notes
		$datas = $database->select("Payment", "*", [
			"MainContactId" => $id 
		]);


		//loop and get all admin notes associated for this registration
		$counter = 0;
		$runningTotal = 0;
		if( count($datas) > 0){

			$r->html .= '<tbody><thead><tr><th>&nbsp;</th><th>Date Entered</th><th style="text-align:right">Payment Amount</th></tr></thead>';	

			 foreach ($datas as $row) {

				 $paymentVal = $row["PaidAmount"];
				 $notes 	 = $row["Notes"];
				 if ($notes != "" ){
				 		$notes = ' <span data-tooltip aria-haspopup="true" class="has-tip fa fa-comment" aria-hidden="true" tabindex="2" data-disable-hover="false"  title="' . $notes . '">&nbsp;</span>';
				 }
				 if ($paymentVal != ""){
				 	$counter += 1;
				 	$runningTotal += $paymentVal;
					$r->html .= sprintf('<tr><td>%d) %s</td><td>%s</td><td style="text-align:right; padding-right:10px !important;" class="payment-amounts">%s</td></tr>', 
						$counter, $notes,
						$row["DateEntered"], 
						money_format('%#0n', $paymentVal));	 
				 }

			 }

			 $r->html .= sprintf('<tfoot><tr><td colspan="3"  style="text-align:right; padding-right:10px;">%s</td></tr></tfoot>',  money_format('%#0n', $runningTotal));

			$outstanding = (($total + $total2) - $runningTotal );

			$r->html          .= '</tbody>';	
			$r->status        = 1;
			$r->info 		  =  ($outstanding > 0) ? '<span class="label warning">Outstanding: ' . money_format('%#0n',$outstanding) . '</span>' : '<span class="label success bold"> <i class="fa fa-check"> </i> Fully Paid</span>' ;

		}


		//return the results
		echo $r->toJSON();	

	}	


	/**
	 * sends a SMS
	 *
	 * @return json
	 * @author 
	 **/
	function sendSMS($phone, $ref, $id){

		header('Content-Type: application/json');
		$r = new RESPONSE(0);

			$phone = trim($phone);
			$ref = trim($ref);

			//send sms
			try {
				$r = new RESPONSE(0);

						//we try this as we dont want to show error if sms fails
						//we still want to show the registration information
						//check for aussie mobile prefix


						if ( substr($phone,0,5) == "+6104" || substr($phone,0,4) == "+614") {

							//create a SMS object
					        $sms = new SMSAdmin();

					        //check the token
					        if($sms->access_token){

					        	//send the SMS
					            $messageId = $sms->send($phone, 'Your rego has been updated @ ' . AppConfig::$TINYURL_VIEW .'?ref=' . $ref . '\n\nDaiHoi Melbourne' .  AppConfig::$CONFERENCE_YEAR . ' Team.'); 

					            if($messageId){
					            	//$rego->updateSMSMessageId($rego->Reference, $messageId);


									//add note after sending
									$database = createDb();	
									$rowsAffected   = $database->insert("Note", [
										"Notes"         => "SMS sent to " . $phone,
										"MainContactId" => $id,
									]);

					            	$r->status = 1;
					            	$r->message = 'SMS sent successfully to' . $phone;
									echo $r->toJSON();									


									return false;
					            }

					        }else{
					        	//token not valid
								$r->message = 'SMS Token not valid.';
								echo $r->toJSON();
								return false;
					        }

						}else{

							//number not aussie
								$r->message = 'Phone number not an Australian mobile number (' . $phone . ')';
								echo $r->toJSON();
								return false;
						}



			} catch (Exception $e) {

				//should log error in db
				$r->message = 'Exception Error: ' . $e->getMessage();
			}

			echo $r->toJSON();
	}


	/**
	 * lists rooms
	 *
	 * @return json
	 * @author 
	 **/
	function ListRooms(){

		//set the header
		header('Content-Type: application/json');
			
		//init variables
		$r = new RESPONSE(0);

		//validate the id and data
		// if ($id == "" || $id < 1){
		// 	$r->message = "No data.";
		// 	echo $r->toJSON();	
		// 	return false;
		// }

		//$html = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/register/summary_template.php");

		$mid = $_GET['id']; //person to assgin room to


		try {

			//create the database connecion
			$database = createDb();	

			$query = "
				SELECT R.*,
				(SELECT COUNT(*) FROM RoomAllocation A WHERE A.RoomId = R.RoomId) as Occupancy,
				(SELECT GROUP_CONCAT(M.Fullname SEPARATOR ', ' ) FROM RoomAllocation A INNER JOIN MainContact M ON M.MainContactId = A.MainContactId WHERE A.RoomId = R.RoomId) as Occupants,
				(SELECT GROUP_CONCAT(M.MainContactId SEPARATOR ',' ) FROM RoomAllocation A INNER JOIN MainContact M ON M.MainContactId = A.MainContactId WHERE A.RoomId = R.RoomId) as OccupantIds
				FROM Room R;			
			";
			$datas = $database->query($query)->fetchAll();	


			if( count($datas) > 0){
				
				foreach ($datas as $row) {

					//vaccancy lofic
					$status = '<span class="label secondary">Vaccant</span>';
					if ( (int)$row["Occupancy"] > (int)$row["Capacity"] ){
						$status = '<span class="label warning">Overfilled</span>';

					}elseif ((int)$row["Occupancy"] == (int)$row["Capacity"]){
						$status = '<span class="label success">Full</span>';
					}

					//logic to display occupants
					$occupantNames = explode(",",$row["Occupants"]);
					$occupantIds   = explode(",",$row["OccupantIds"]);
					$names = '';
					for ($x = 0; $x < count($occupantIds); $x++) {
						
						if ($occupantIds[$x] !== ""){

							$names .= sprintf('<a href="#" data-id="%s" style="padding-right:5px;"><i class="fa fa-user"></i> %s</a>&nbsp;',
									$occupantIds[$x],
									trim($occupantNames[$x]));

						}
						
					} 
					



				
					//format render
					$r->html .= sprintf('<tr>
											<td>%s</td>
											<td>%s</td>
											<td>%s : %s %s<br/>%s</td>
											<td>%s: %s</td>
											<td style="width: 50px; text-align:right;white-space:nowrap;">
											<button onclick="assignPersonToRoom(%s,%s)" class="button round small marginless"><i class="fa fa-check" aria-hidden="true"></i> assign</button>
											</td>
										</tr>', 
											$row["RoomNumber"],
											$row["RoomType"],
											$row["Capacity"],
											$row["Occupancy"],
											$status, 
											$names,
											$row["IsAvailable"],
											$row["Comments"],
											$mid,
											$row["RoomId"]);	
				}
				
				$r->html = '<table role="grid" class="responsive display" id="table-rooms"><thead><tr><th>Number</th><th>Type</th><th>Capacity/Occupancy</th><th>Comments</th><th>&nbsp;</th></tr></thead><tbody>' . $r->html . '</tbody></table>';
			}


			//
			$r->status = 1;
			$r->message = '';
			echo $r->toJSON();

			return false;


		} catch (Exception $e) {

			//should log error in db
			$r->message = 'Exception Error: ' . $e->getMessage();
		}

		echo $r->toJSON();

	}



	function assignPersonToRoom($personId, $roomId){


		//set the header
		header('Content-Type: application/json');
		$r = new RESPONSE(0);

		//validate data
		if (is_numeric($roomId) == false || is_numeric($personId) == false){
			$r->message = 'no data to process.';
			echo $r->toJSON();
			return false;
		}

		//create the database
		$database = createDb();

		//dont assign person twice
		$datas = $database->select("RoomAllocation", "*", [
			"MainContactId" => $personId 
		]);
				
		if(count($datas) > 0){
			$r->status = 0;
			$r->message = 'Person is already allocated to a room.';
			echo $r->toJSON();
			return false;
		}

		//do insert if allowed
		$database->insert("RoomAllocation", [
			"RoomId"    		=>  $roomId,
			"MainContactId"    	=>  $personId,
		]);

		//set the status for success
		$r->status = 1;
		$r->message = 'Successfully allocated';
		
		//return json
		echo $r->toJSON();				

	}



	/**
	 * determine what request it is and assign appropiate action
	 **/
	if( $_GET['type'] == "notes"){

		addNotes();
		
	}elseif ($_GET['type'] == "list-rooms") {
	
		ListRooms();

	}elseif ($_GET['type'] == "assign-person-to-room") {
	
		assignPersonToRoom($_POST["id"], $_POST["rid"]);

	}elseif ($_GET['type'] == "get-notes") {
		
		getNotes();

	}elseif ($_POST['type'] == "update-registrant") {

		updateRegistrantDetails($_POST["json"], $_POST["id"]);

	}elseif ($_POST['type'] == "update-maincontact") {

		updateMainContactDetails($_POST["json"], $_POST["id"]);

	}elseif ($_GET['type'] == "add-payment") {

		AddRegoPayment();
	
	}elseif ($_GET['type'] == "get-payments") {

		getRegoPayments();

	}elseif ($_GET['type'] == "sms") {

		//sends the status update sms from admin area
		sendSMS($_POST["phone"], $_POST["ref"], $_POST["id"]);
		
	}else{

		$json = $_POST["json"];
		if (!($json == "")) {
			updateCheckin($json);
		}else{
			
			header('Content-Type: application/json');
			$r = new RESPONSE(0);
			$r->message = 'No json data!!' . $_POST['type'] . 'XXXS';
			echo $r->toJSON();	
		}
	}



?>