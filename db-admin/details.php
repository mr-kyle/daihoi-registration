<?php	
// Report all errors except E_NOTICE
error_reporting(E_ALL & ~E_NOTICE);
?>
<!doctype html>
<html class="no-js" lang="en">
<head>
    <?php require '_scripts.php' ?>

	<title>Registration Details</title>
	<script>
		var REGO_ID = <?php echo $_GET['id']; ?>;	
	</script>
	<style>
		#table-rooms td {padding:3px 10px;}
		#table-rooms tr:hover > td { font-weight:bold;}

		.capacity {
			float:left;
			border-radius:100px;
		}
		ul.users-link {
			margin: 0;
			padding: 0;
			list-style-type: none;
			padding-left: 30px
		}
		ul.users-link::after {
			clear:both;
		}

		.room-delete-button {
			background-color:maroon;
			border-radius:2px; padding: 3px 5px;
		}
	</style>
</head>
<body>
<?php require '_menu.php' ?>


    <div class="row">
      <div class="large-12 columns">
        <p>&nbsp;</p> 
      </div>
    </div>


 <div class="details">

<?php
	require '_db.php';
	//holds the admin notes
	$admin_notes = 'tt';

	function ListRegos($id = 0){

		$database = createDb();

		$rowHtml = '
			<tr class="%s">

				<td class="row-actions" data-type="%s" data-id="%d">

					 <div class="switch">
			            <input class="switch-input" onclick="paddleSwitchForClonedResponsiveTable(this)" type="checkbox" id="ci_%d" %s />
			             <label class="switch-paddle" for="ci_%d">
			              <span class="show-for-sr">Check In</span>
			              <span class="switch-active" aria-hidden="true">Yes</span>
			              <span class="switch-inactive" aria-hidden="true">No</span>
			            </label>
			          </div>

				</td>

				<td>%d) <a href="edit.php?%s=%d">%s</a></td>

				<td>%s</td>

				<td>%s</td>

				<td>%s</td>

				<td>%s</td>

				<td>%s</td>

				<td>%s</td>

				<td class="currency">$%01.2f</td>

				<td>
					<div class="rooms-action-container" data-id="%s">
						<button class="room-delete-button %s" onclick="removePersonsToRoom(%s)">X</button>&nbsp;
						<a href="#" onclick="openRoomsModal(%s);" data-open="roomsModal">
							<span class="room-label">%s</span>
						</a>
					</div>
				</td>

			</tr>';


			//we only want to query the group leader main contact id

			//check if the id given is the group leader
			$query = "SELECT (IFNULL(GroupLeaderMainContactId,0)) Id FROM MainContact WHERE MainContactId = " . $id . ";";
			$datas = $database->query($query)->fetchAll();
			
			//if not the group leader, we will use the assigned (db) group leader id
			$gId = (int)$datas[0]["Id"];
			if ($gId > 0) { $id = $gId; }


			//at this point the $id should be the group leader
			$query = "SELECT M.*, A.RoomId, R.RoomNumber FROM MainContact M 
			LEFT OUTER JOIN RoomAllocation A ON A.MainContactId = M.MainContactId
			LEFT OUTER JOIN Room R ON R.RoomId = A.RoomId
			WHERE M.MainContactId = " . $id ."  OR M.GroupLeaderMainContactId = " . $id . "
			ORDER BY IFNULL(GroupLeaderMainContactId,0), M.MainContactId ";


			$datas = $database->query($query)->fetchAll();	

			$counter = 0;
			$groupFees = 0;

			foreach($datas as $row){
				$counter = $counter + 1;
				
				if ($counter == 1 ) {
					

					echo sprintf('	<div class="row">

										<div class="large-6 medium-6 columns">

											<h4>%s %s</h4>
											<div class="medium-8 columns">
												<ul class="details-list">

													<li title="Reference" class="ref"><i class="fa fa-qrcode"></i> %s</li>

													<li title="Age"><i class="fa fa-birthday-cake"></i> %s</li>

													<li title="Email"><i class="fa fa-envelope-o"></i> %s</li>

													<li title="Phone" class="phone"><i class="fa fa-phone"></i> %s</li>

													<li title="Church"><i class="fa fa-university"></i> %s</li>

												</ul>
											</div>
											<div class="medium-4 columns">

												<ul class="details-list">

													<li title="Airport Transfer"><i class="fa fa-plane"></i> %s</li>

													<li title="Pensioner"><span class="secondary label" style="font-size: 0.8em; font-weight: bold;padding:4px 6px; margin-right: 10px;">P</span>%s</li>

													<li title="Fee"><i class="fa fa-dollar"></i> $%01.2f</li>

												</ul>
											</div>
											
											<div class="medium-12 columns">
												<p>Registered On: <a target="_blank" href="/register/view/?ref=%s">%s</a></p>
											</div>											

										</div>


										<div class="large-6 medium-6 columns">

												<h4>Comments</h4>

												<p>%s</p>

												<p>&nbsp;</p>

										</div>

									</div><div>&nbsp;</div>'



								, $row["FullName"]

								, ($row["Role"] !== '') ? '(' . $row["Role"] . ')' : ''

								, $row["Reference"]

								, $row["Age"]

								, $row["Email"]

								, $row["Phone"]

								, $row["Church"]

								, ToYesNo($row["AirportTransfer"])

								, ToYesNo($row["Pensioner"])

								, $row["Fee"]

								, $row["Reference"]

								, $row["DateTimeEntered"]

								, $row["Comments"]

								);



						echo ' <div class="row columns">

									<h4>Regos</h4>

									<div class="large-12 medium-12 columns">

									<table cellpadding="4" cellpadding="6" border="1" width="100%" role="grid" class="responsive" id="details-table">

										<thead>

										<tr>

											<th>Checkin</th>

											<th>Name</th>

											<th>Age</th>

											<th>Relation</th>

											<th>Family Discount</th>

											<th>Pensioner</th>

											<th>Airport</th>

											<th>Cancelled</th>

											<th>Fee</th>

											<th>Room</th>

										</tr></thead>

										<tbody>';

				}


				if ($row["FullName"] != '') {
					

					if ($row["Cancelled"] == false){
						$groupFees += $row["Fee"];
					}

					echo sprintf($rowHtml

								, ($row["Cancelled"]) ? 'strikeout' : ''

								, "MainContactId",  $row["MainContactId"]

								, $row["MainContactId"], (($row["CheckedIn"]) ? 'checked' : '')

								, $row["MainContactId"], $counter

								, "id"

								, $row["MainContactId"]

								, $row["FullName"]

								, $row["Age"]

								, $row["Relation"]

								, $row["FamilyDiscount"]

								, ToYesNo($row["Pensioner"])

								, ToYesNo($row["AirportTransfer"])

								, ToYesNo($row["Cancelled"])

								, $row["Fee"]

								, $row["MainContactId"]
								
								, ($row["RoomNumber"] == "" ? "hidden-soft" : "" )

								, "'" . $row["MainContactId"] . "'"

								, $row["MainContactId"]

								, ($row["RoomNumber"] == "" ? "ROOM" : $row["RoomNumber"] )

						);

				}

			
				//next foreach
			}



			echo sprintf('<tfoot><tr>
					<td colspan="8">&nbsp;</td>
					<td class="currency">$%01.2f</td>
					<td>&nbsp;</td>	
					</tr></tfoot>', 
					$groupFees);


			//terminate table
			echo '</tbody></table>';
			echo "</div></div>"; 


	}


	ListRegos($_GET["id"] );

?>



</div>


	<div class="row fixed-top">

			<div class="large-12 columns">

				<div class="panel clearfix text-center">

					<div id="callout-success" class="success callout" data-animate="fade-out" data-closable style="display: none; width: 98%; margin: 0 auto;">

					  <h5>Success!</h5>

					  <p>This record was updated.</p>

					  <button class="close-button" aria-label="Dismiss alert" type="button" data-close>

					    <span aria-hidden="true">&times;</span>

					  </button>

					</div>



					<div id="callout-alert" class="alert callout" data-animate="fade-out" data-closable style="display: none; width: 98%; margin: 0 auto;">

						<h5>Error!</h5>

					  	<p>There was an error while trying to process your request.</p>

					  <button class="close-button" aria-label="Dismiss alert" type="button" data-close>

					    <span aria-hidden="true">&times;</span>

					  </button>

					</div>

				</div>


			</div>


	</div>



	<div class="row">


		<div class="large-12 columns text-center">


		    <button onclick="getJSON()" class="button round"><i class="fa fa-check-circle-o"> </i> Update Changes </button>


			<a class="hollow button round" data-open="adminNotesModal">Notes</a>

			<a class="hollow button round" data-open="smsModal" onclick="enableSMSButton()">SMS</a>

		    <!-- 
			<BUTTON ONCLICK="FILLREGOPAYMENTAMOUNTS()" CLASS="HOLLOW BUTTON ROUND" TITLE="PRE FILLS THE ENTIRE REGISTRATION OF THEIR RESPECTIVE FEE IN THE PAYMENT FIELD."><I CLASS="FA FA-USD"> </I> FILL ENTIRE REGISTRATION AMOUNT</BUTTON>
			-->
		    <!-- <button onclick="getJSON()" class="button round"><i class="fa fa-envelope-o"> </i> Email</button> -->			

		    <div>&nbsp;</div>
		</div>


	</div>





	<div class="row details column">

		<h4 class="twelve">Payments</h4>	



		<div class="large-6 columns">


			<div class="row">
				<div class="medium-12 columns">
					<div id="outstanding-balance">&nbsp;</div>
				</div>

			    <div class="medium-3 columns">

			      <label>Date Paid</label>

			        <input id="txtPaymentDate" type="text" maxlength="10" value="<?php echo date("d/m/Y") ?>" />


			    </div>

			    <div class="medium-9 columns">

			      <label>Amount</label>

					<div class="input-group">

					  <span class="input-group-label">$</span>

					  <input class="input-group-field " type="number" id="txtPaymentAmount" style="text-align: right;" placeholder="negative amounts for refunds" />

					  <div class="input-group-button">

					    <input type="button" onclick="makePayment(REGO_ID);" class="button" value="Add Payment" />

					  </div>

					</div>

			    </div>

			    <div class="medium-12 columns">
					<label>Comments</label>
			    	<input id="txtPaymentComments" type="text" maxlength="100" placeholder="any comments about the payment" />
			    	
			    	<div>&nbsp;</div>
			    </div>

			 </div>

		</div>	



		<div class="large-6 columns">

			<table id="table-payments"></table>

			&nbsp;

		</div>

	</div>




<!-- This is the first modal -->

<div class="reveal" id="adminNotesModal" data-reveal>


	<h4 class="twelve">Admin Notes</h4>	

	<table id="table-notes"></table>

	<div class="input-group">

		<input type="text" maxlength="500" id="txtNotes" class="input-group-field"  />

		<div class="input-group-button">

			<input type="button" onclick="addNotes(REGO_ID);" class="button round" value="Add Note" />

		</div>

	</div>

	<button class="close-button" data-close aria-label="Close reveal" type="button">

		<span aria-hidden="true">&times;</span>

	</button>



</div>



<div class="reveal" id="smsModal" data-reveal>


	<h4 class="twelve">SMS</h4>	
	<p>Sends an SMS message to the Main Contact mobile number if its an Australian Mobile number.</p>
	<div class="input-group">

		<div class="input-group-button">

			<input type="button" id="cSendSMS" onclick="sendSMS(REGO_ID);" class="button round" value="Send Status Update SMS" />

		</div>

	</div>

	<button class="close-button" data-close aria-label="Close reveal" type="button" id="buttonSMSClose">

		<span aria-hidden="true">&times;</span>

	</button>

</div>


<div id="roomsModal" class="reveal full" data-reveal  aria-hidden="true" role="dialog">
	<h3>Room<span class="label1" id="room-fullname"></span></h3>
	<div id="rooms-container"></div>
	<div style="width:100%; text-align:center;">
	<button class="button small secondary" style="width:150px;" data-close aria-label="Close reveal" type="button">
		Close
	</button>
	</div>
	<button class="close-button" data-close aria-label="Close reveal" type="button" id="buttonRoomsClose">
		<span aria-hidden="true">&times;</span>
	</button>

</div>



	<div id="json" class="<?php echo (AppConfig::$DEBUG ? '' : 'hidden' ) ?>"></div>


	<?php require '_scripts_startup.php' ?> 

	<script src="js/responsive-tables.js?v=20180301"></script>


	<script type="text/javascript">
		
		function createTT(){
			//$("#table-payments span.has-tip").each(function (index, el) {
				//var tt = new Foundation.Tooltip('.has-tip');
				//$(document).foundation('tooltip', 'reflow');
				//$(document).foundation('tooltip');
			//});

			var val;
			$("#table-payments td.payment-amounts").each(function (index, el) {
				val = $(el).text();
				if (val.indexOf("$-") == 0 ){
					$(el).css("color","red");
				}
			});			

			

		}

		$(function(){

			setTimeout("getNotes(REGO_ID);getPayments(REGO_ID);",100);


			//set colour of the payment boxes

			$("#details-table td.row-actions input[type=number]").each(function (index, el) {

					$(el).change(function(){

						var max = parseInt($(this).prop("max"));
						var val = parseInt($(this).val());

						if (val == max ){

							$(this).css("color","green");

						}else if (val > max ){

							$(this).css("color","red");

						}else{

							$(this).css("color","white");

						}


					}).trigger('change');

			});



			refreshRoomDeleteButtons();

		});


		// Helps when cloned/pinned checkbox have the same visual functionality.
		function paddleSwitchForClonedResponsiveTable(el){
			
			// The responsive-tables.js will clone a version of the table for responsive purposes,
			// and the checkbox gets cloned with same id, and thus will not work when interacting with cloned version.
			// The below will find the cloned version (div.pinned) and simulate the checkbox action.
			// The target checkbox needs to be decorated with onclick='paddleSwitchForClonedResponsiveTable(this)


			var $el = $(el);
			var $pinned = $('div.pinned').find('#' + el.id);
			
			if ($pinned.length > 0) {
				$pinned.prop("checked", !$pinned.prop("checked"));
			}
			
		}


		$(document).on('open.zf.reveal', '[data-reveal]', function () {
			var modal = $(this);
			if (modal.attr("id") == "roomsModal"){
				//listRooms(document.getElementById('rooms-container'))
			}
		});

		function openRoomsModal(id, name){
			listRooms(document.getElementById('rooms-container'), id);
			$('#roomsModal').foundation('open');
		}

	</script>



	<style type="text/css">
		
		/* fixes the large first column checkboxes(paddles) when it goes into responsive mode */
		@media only screen and (max-width: 767px) {

			table.responsive {position: relative; left:-85px;}
			table.responsive th:first-child, 
			table.responsive td:first-child, 
			table.responsive td:first-child, 
			table.responsive.pinned td {visibility: hidden !important; display: inline-block !important; overflow: auto;}
			
		}

	</style>

</body>

</html>
