<?php	
// Report all errors except E_NOTICE
error_reporting(E_ALL & ~E_NOTICE);
?>
<!doctype html>

<html class="no-js" lang="en">

<head>



    <?php require '_scripts.php' ?>

	<link rel="stylesheet" href="css/responsive-tables.css">

    <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">

	<title>Registration Details</title>

	<style type="text/css">



		ul.details-list { list-style-type: none; }

		ul.details-list li { margin-bottom: 6px; }

		ul.details-list li i {width: 24px; font-size: 125%;}
/*

		#details-table label { display: inline; }



		#details-table td span.inside-row-fix {

			width: inherit !important;

		    margin-top: 40px;

		    vertical-align: baseline;

		    padding-top: 3px;

		}



		#details-table input.payment-amount {

		    color: #fff;

		    width: 80px;

		    display: inline-block;

		    font-size: 120%;

		    padding: 5px;

		    height: 30px;

		    background-color: #333;

		    border: 1px solid #444;

		    margin-bottom: 0;

		    text-align: right;

		}



		#details-table input.payment-amount:focus {

		    color: #333 !important;

		    background-color: #eee;

		}		



		#details-table input.paid{

			background-color: #027302;

		}*/

		div.switch {
			float: left;
			margin-bottom: 0;
		}

		#outstanding-balance { width: 100%; text-align: center; }
		#outstanding-balance .label {padding: 10px !important; width: 100%}
		#outstanding-balance .label wanring {color:#777;}

	</style>







	<script type="text/javascript">




	    var PAYLOAD = function () {

			this.type    = "",

			this.id      = 0,

			this.checkin = 0,

			this.paid    = 0

	    }



	    var PAYMENT = function () {

			this.type    = "",

			this.id      = 0,

			this.amount  = 0,

			this.comments  = '',			

			this.date    = null

	    }





	    function makePayment(){

			$("#callout-success").hide();

			$("#callout-alert").hide();

			

			var payment    = new PAYMENT();

			payment.date   = document.getElementById("txtPaymentDate").value;

			payment.amount = parseFloat(document.getElementById("txtPaymentAmount").value);

			payment.id     = <?php echo $_GET['id']; ?>;

			payment.comments = document.getElementById("txtPaymentComments").value;

			if (payment.amount == "" || isNaN(payment.amount)){
				alert("Please enter an amount.");
				return false;
			}				


			$("#json").html(JSON.stringify(payment));


			$.ajax({

				url: 'action.php?type=add-payment&cache=' + Math.random(),

				type: 'POST',

				dataType: 'json',

				data: {id: payment.id, json: JSON.stringify(payment)},

			})

			.done(function(data) {

				if (data.status == 1){

					$("#callout-success").slideDown();

					getPayments();

				}else{

					$("#callout-alert").slideDown().find("p:first").text(data.message);

				}

				console.log("success");

			})

			.fail(function(jqXHR) {

				$("#callout-alert").slideDown().find("p:first").text(jqXHR.responseText);

				console.log("error");

			})

			.always(function() {

				console.log("complete");

			});

	    }



		function getJSON(){



			$("#callout-success").hide();

			$("#callout-alert").hide();



			var json = []; 

			var payload;

			var exit = false;



			//at this stage, becuase of the responsive nature of the table, the target table can be created twice when in a smaller view

			//therefore we check if there are 2 tables of the same id, if so, get the first table. If not then use the just query as per normal.



			var tables = $("#details-table");

			if (tables.length > 1){

				tables = tables.first();

			}





	        $(tables).find("td.row-actions").each(function (index, el) {



				//create payload and assign attributes		        	

				payload         = new PAYLOAD();

				payload.type    = $(el).data("type");

				payload.id      = $(el).data("id");

				payload.checkin = $(el).find('input[type=checkbox]:first').prop("checked");


				// var paymentField = $(el).find('input[type=number]:first');
				// payload.paid    = paymentField.val();

				// //some validation
				// var max = paymentField.prop("max");
				// if ( parseInt(payload.paid) > parseInt(max) ){
				// 	$("#callout-alert").slideDown().find("p:first").text("You cannot pay more than the fee.");
				// 	paymentField.focus().select();
				// 	exit = true;
				// 	return false;

				// }



	        	//add to json
				json.push(payload);

	        });



	        if (exit) {

	        	return false;

	        }



	        if (json !== "") {


	        	$("#json").html(JSON.stringify(json));

	        	//console.log(JSON.stringify(json));

	        	sendData(JSON.stringify(json));

	        }

		}







		function sendData(json){

				$("#callout-alert").hide();

				$("#callout-success").hide();



				$.ajax({

					url: 'action.php?cache=' + Math.random(),

					type: 'POST',

					dataType: 'json',

					data: {json: json},

				})

				.done(function(data) {

					if (data.status == 1){

						$("#callout-success").slideDown();

					}else{

						$("#callout-alert").slideDown().find("p:first").text(data.message);

					}

					console.log("success");

				})

				.fail(function(jqXHR) {

					$("#callout-alert").slideDown().find("p:first").text(jqXHR.responseText);

					console.log("error");

				})

				.always(function() {

					console.log("complete");

				});

				



		}





		function addNotes(id){

				$.ajax({

					url: 'action.php?type=notes&cache=' + Math.random(),

					type: 'POST',

					dataType: 'json',

					data: {id: id, notes: $("#txtNotes").val() },

				})

				.done(function(data) {

					if (data.status == 1){

						getNotes();

					}else{

						$("#callout-alert").slideDown().find("p:first").text(data.message);

					}

					console.log("success");

				})

				.fail(function(jqXHR) {

					$("#callout-alert").slideDown().find("p:first").text(jqXHR.responseText);

					console.log("error");

				})

				.always(function() {

					console.log("complete");

				});



		}





		function getNotes(){

				var id = <?php echo $_GET['id']; ?>;

				if (id == "" || id < 0){

					return false; 

				}


				$.ajax({

					url: 'action.php?type=get-notes&cache=' + Math.random(),

					type: 'GET',

					dataType: 'json',

					data: {id: id },

				})

				.done(function(data) {

					if (data.status == 1){

						$("#table-notes").html(data.html)

					}



					console.log("success");

				})

				.fail(function(jqXHR) {

					$("#callout-alert").slideDown().find("p:first").text(jqXHR.responseText);

					console.log("error");

				})

				.always(function() {

					console.log("complete");

				});

		}





		function getPayments(){

				var id = <?php echo $_GET['id']; ?>;

				if (id == "" || id < 0){
					return false; 
				}



				$.ajax({

					url: 'action.php?type=get-payments&cache=' + Math.random(),
					type: 'GET',
					dataType: 'json',
					data: {id: id },

				})

				.done(function(data) {

					if (data.status == 1){

						$("#table-payments").html(data.html);
						$("#outstanding-balance").html(data.info);
						createTT();
					}

					console.log("success");

				})

				.fail(function(jqXHR) {

					$("#callout-alert").slideDown().find("p:first").text(jqXHR.responseText);
					console.log("error");

				})

				.always(function() {
					console.log("complete");

				});





		}



		function fillRegoPaymentAmounts(){

			$("input[type=number].payment-amount").each(function (index, el) {
				el.value = el.max;
				$(this).trigger('change');
	        });

		}



		function sendSMS(){

				$("#callout-alert").hide();
				$("#callout-success").hide();

				$("#cSendSMS").addClass("disabled")
				$("#cSendSMS").prop('disabled', true);

				$.ajax({

					url: 'action.php?type=sms&cache=' + Math.random(),
					type: 'POST',
					dataType: 'json',
					data: {phone: $("li.phone").text(), ref: $("li.ref").text(), id: <?php echo trim($_GET["id"]) ?> },

				})

				.done(function(data) {
					if (data.status == 1){
						
						setTimeout("getNotes()",250);
						$("#callout-success").slideDown().find("p:first").text(data.message);


					}else{
						$("#callout-alert").slideDown().find("p:first").text(data.message);
					}

					console.log("success");

				})

				.fail(function(jqXHR) {
					$("#callout-alert").slideDown().find("p:first").text(jqXHR.responseText);
					console.log("error");

				})
				.always(function() {
					console.log("complete");
					$('#smsModal').foundation('close');
				});

		}		

		function enableSMSButton(){
			$("#cSendSMS").removeClass("disabled")
			$("#cSendSMS").prop('disabled', false);			
		}

	</script>



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





	function ListRegos($id = 0, $firstRowMainContact = 1){


		$database = createDb();

					//  <a href="#" title="mark as paid"><i class="fa fa-usd"> </i></a> | 

					// <a href="#" title="mark as checked in"><i class="fa fa-check-circle-o"> </i></a> | 

					// <a href="#" title="send confirmation email"><i class="fa fa-envelope-o"> </i></a>


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


			</tr>';


			 $datas = $database->select("vAllRegos", "*" , [

				"MainContactId" => $id

			 ]);


			$counter = 0;

			$groupFees = 0;


			foreach($datas as $row){


				if ($counter == 0 ) {

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
													<!--<li title="Airbed"><i class="fa fa-bed"></i> %s</li>-->

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

								, ToYesNo($row["Airbed"])

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

										</tr></thead>

										<tbody>';



						if ($firstRowMainContact) {

							//main contact

							$counter = $counter + 1;

							if ($row["Cancelled"] == false){
								$groupFees += $row["Fee"];
							}


							echo sprintf($rowHtml

								, ($row["Cancelled"]) ? 'strikeout' : ''

								, "MainContactId",  $row["MainContactId"]

								, $row["MainContactId"], (($row["CheckedIn"]) ? 'checked' : '')

								, $row["MainContactId"], $counter

								, "mid"

								, $row["MainContactId"]

								, $row["FullName"]

								, $row["Age"]

								, ""

								, ""

								, ToYesNo($row["Pensioner"])

								, ToYesNo($row["AirportTransfer"])

								, ToYesNo($row["Cancelled"])

								, $row["Fee"]

								);							


						}									


				}




					if ($row["RName"] != '') {

						$counter = $counter + 1;

						if ($row["RCancelled"] == false){
							$groupFees += $row["RFee"];
						}


						echo sprintf($rowHtml

									, ($row["RCancelled"]) ? 'strikeout' : ''

									, "RegistrantId",  $row["RegistrantId"]

									, $row["RegistrantId"], (($row["RCheckedIn"]) ? 'checked' : '')

									, $row["RegistrantId"], $counter

									, "rid"

									, $row["RegistrantId"]

									, $row["RName"]

									, $row["RAge"]

									, $row["RRelation"]

									, $row["RFamilyDiscount"]

									, ToYesNo($row["RPensioner"])

									, ToYesNo($row["RAirportTransfer"])

									, ToYesNo($row["RCancelled"])

									, $row["RFee"]

									);



					}


			}



				echo sprintf('<tfoot><tr>

									<td colspan="8">&nbsp;</td>

									<td class="currency">$%01.2f</td></tr></tfoot>', $groupFees);


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

					    <input type="button" onclick="makePayment();" class="button" value="Add Payment" />

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

			<input type="button" onclick="addNotes(<?php echo $_GET['id']; ?>);" class="button round" value="Add Note" />

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

			<input type="button" id="cSendSMS" onclick="sendSMS();" class="button round" value="Send Status Update SMS" />

		</div>

	</div>

	<button class="close-button" data-close aria-label="Close reveal" type="button" id="buttonSMSClose">

		<span aria-hidden="true">&times;</span>

	</button>



</div>


	<div id="json"></div>


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

			setTimeout("getNotes();getPayments();",100);


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



