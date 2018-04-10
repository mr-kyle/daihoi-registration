<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/_cApp.php' ?>
<?php	
// Report all errors except E_NOTICE
error_reporting(E_ALL & ~E_NOTICE);
?>
<!doctype html>
<html class="no-js" lang="en">
<head>
    <title>Edit Details</title>
    <?php require '_scripts.php' ?>
    <style type="text/css">
      input:checked ~ .red { background: red !important; }
      .callout-cancelled {width: 80%; margin: 0 auto; text-align: center; border-radius: 7px !important;}
    </style>
</head>
<body>
<!-- http://foundation.zurb.com/sites/docs/forms.html -->
<?php require '_menu.php' ?>

<?php 
  /*****************************************************************
  / we get the registration details from the database and display it
   *****************************************************************
  */
  
  //init the variables
	$MainContactId  = $_GET["id"]; 
	$IsMainContact  = true;
	$IsDisabledHtml = '';
	$IsCancelled    = false;

  //the db connection
	require '_db.php';
	$database = createDb();

  //the sql formation
  $query = "SELECT *,  IFNULL(GroupLeaderMainContactId,0) GroupLeader FROM MainContact M WHERE M.MainContactId = " . $MainContactId;

  $datas = $database->query($query)->fetchAll();	

	$row = $datas[0];
  $IsCancelled = $row['Cancelled'];
  $IsMainContact = ($row['GroupLeader'] == 0);
  
	if ($row['Cancelled']){
		$IsDisabledHtml = ' disabled="disabled" ';
	}

?>
<!-- start details id -->
<div id="rego-details">

  <form>

    <div class="row">
    	<div class="medium-12 columns">
    		
          <h1><?php echo ($IsMainContact) ? 'Main Contact' : 'Registrant' ?> Details</h1>

          <?php 
            if ($IsDisabledHtml !== ""){
              echo '<div>&nbsp;</div><div class="warning callout callout-cancelled" data-animate="fade-out" ><h5>Registration Cancelled</h5><p>This registration has been cancelled.</p></div><div>&nbsp;</div>';
            }
           ?>

    	</div>
    </div>

    <div class="row">
    	<div class="medium-3 columns">
    		<label>Firstname</label>
    		<input id="tFirstname" maxlength="50" type="text" placeholder="Firstname" value="<?php echo $row["Firstname"]; ?>" <?php echo $IsDisabledHtml; ?> />
    	</div>
      <div class="medium-3 columns">
        <label>Surname</label>
        <input id="tSurname" maxlength="50" type="text" placeholder="Surname" value="<?php echo $row["Surname"]; ?>" <?php echo $IsDisabledHtml; ?> />
      </div>    	
      <div class="medium-6 columns"> 
    	 		<label>Church</label>
      		<select id="ddlChurch" <?php echo ($IsMainContact) ? '' :  'disabled="disabled"' ?> <?php echo $IsDisabledHtml; ?> >
      			<?php include($_SERVER['DOCUMENT_ROOT'] . '/includes/_churches.php');?>
      		</select>
          <input type="hidden" id="tChurchHidden" value="<?php echo $row["Church"]; ?>" />
    	</div>
    </div>

    <div class="row">

    	<div class="medium-6 columns">
    		<label>Role</label>
    		<select id="ddlRole" <?php echo $IsDisabledHtml; ?>>
    			<?php include($_SERVER['DOCUMENT_ROOT'] . '/includes/_roles.php');?>
    		</select>
        <input type="hidden" id="tRoleHidden" value="<?php echo $row["Role"]; ?>" />
    	</div>
    	<div class="medium-3 columns">
    		<label>Gender</label>
    		<select id="ddlGender" <?php echo $IsDisabledHtml; ?>>
          <option value=""> - </option>
        	<option>M</option>
    			<option>F</option>
    		</select>
        <input type="hidden" id="tGenderHidden" value="<?php echo $row["Gender"]; ?>" />
    	</div>
    	<div class="medium-3 columns">
    	  		<label>Age</label>
    		    <input id="tAge" type="number" maxlength="3" max="150" placeholder="Age" 
            value="<?php echo $row["Age"]; ?>" <?php echo $IsDisabledHtml; ?> />	
    	</div>

    </div>


    
    <div class="row <?php echo ($IsMainContact) ? '' :  'hide' ?>">
    	<div class="medium-6 columns">
    		<label>Email</label>
    		<input maxlength="255" id="tEmail" type="text" placeholder="email" value="<?php echo $row["Email"]; ?>" <?php echo $IsDisabledHtml; ?> />
    	</div>
    	<div class="medium-6 columns">
    	<label>Contact Number</label>
    		<input maxlength="15"  id="tPhone" type="text" placeholder="03 9547 8901" value="<?php echo $row["Phone"]; ?>" <?php echo $IsDisabledHtml; ?> />
    	</div>

    </div>

  <div class="row">
        <div class="medium-3 columns">


           <fieldset class="fieldset" style="padding-bottom: 5px;">
            <p style="margin-bottom: 2px;">Airport Transfer</p>
            <div class="switch large">
              <input class="switch-input" id="cbAirport" type="checkbox" <?php echo ($row["AirportTransfer"]) ? 'checked' : ''; ?> <?php echo $IsDisabledHtml; ?> />
              <label class="switch-paddle" for="cbAirport">
                <span class="show-for-sr">Airport Transfer</span>
                <span class="switch-active" aria-hidden="true">Yes</span>
                <span class="switch-inactive" aria-hidden="true">No</span>
              </label>
            </div>


            </fieldset>
        </div>
	
        <div class="medium-3 column" style='display:none;'>
           <fieldset class="fieldset" style="padding-bottom: 5px;">
            <p style="margin-bottom: 2px;">Airbed</p>
              <div class="switch large">
                <input class="switch-input" id="cbAirbed" type="checkbox" <?php echo ($row["Airbed"]) ? 'checked' : ''; ?> <?php echo $IsDisabledHtml; ?> />
                <label class="switch-paddle" for="cbAirbed">
                  <span class="show-for-sr">Airbed</span>
                  <span class="switch-active" aria-hidden="true">Yes</span>
                  <span class="switch-inactive" aria-hidden="true">No</span>
                </label>
              </div>
            </fieldset>
        </div>

        <div class="medium-3 columns">
           <fieldset class="fieldset" style="padding-bottom: 5px;">
            <p style="margin-bottom: 2px;">Pensioner</p>
              <div class="switch large">
                <input class="switch-input" id="cbPensioner" type="checkbox" <?php echo ($row["Pensioner"]) ? 'checked' : ''; ?> />
                <label class="switch-paddle" for="cbPensioner">
                  <span class="show-for-sr">Pensioner</span>
                  <span class="switch-active" aria-hidden="true">Yes</span>
                  <span class="switch-inactive" aria-hidden="true">No</span>
                </label>
              </div>
            </fieldset>
        </div>

        <div class="medium-3 columns">
           <fieldset class="fieldset" style="padding-bottom: 5px;">
            <p style="margin-bottom: 2px;">Rego Cancelled</p>
              <div class="switch large">
                <input class="switch-input" id="cbCancelled" type="checkbox" <?php echo ($row["Cancelled"]) ? 'checked' : ''; ?> />
                <label class="switch-paddle red" for="cbCancelled">
                  <span class="show-for-sr">Cancelled</span>
                  <span class="switch-active" aria-hidden="true">Yes</span>
                  <span class="switch-inactive" aria-hidden="true">No</span>
                </label>
              </div>
            </fieldset>
        </div>

        <div class="medium-3 columns">
           <fieldset class="fieldset" style="padding-bottom: 5px;">
            <p style="margin-bottom: 2px;">EarlyBird</p>
              <div class="switch large">
                <input class="switch-input" id="cbEarlyBird" type="checkbox" <?php echo ($row["EarlyBirdSpecial"]) ? 'checked' : ''; ?> />
                <label class="switch-paddle" for="cbEarlyBird">
                  <span class="show-for-sr">EarlyBird</span>
                  <span class="switch-active" aria-hidden="true">Yes</span>
                  <span class="switch-inactive" aria-hidden="true">No</span>
                </label>
              </div>
            </fieldset>
        </div>


  </div>



    <div class="row <?php echo ($IsMainContact) ? 'hide' :  '' ?>">
    	<div class="medium-6 columns">
    		<label>Relation</label>
    		<select id="ddlRelation" <?php echo $IsDisabledHtml; ?>>
    			<?php include($_SERVER['DOCUMENT_ROOT'] . '/includes/_relationships.php');?>
    		</select>
        <input type="hidden" id="tRelationHidden" value="<?php echo $row["Relation"]; ?>" />
    	</div>
    	<div class="medium-6 columns">
    		<label>Family Discount</label>
    		<select id="ddlFamilyDiscount" <?php echo $IsDisabledHtml; ?>>
    			<?php include($_SERVER['DOCUMENT_ROOT'] . '/includes/_familydiscounts.php');?>
    		</select>		
    		<input type="hidden" id="tFamilyHidden" value="<?php echo $row["FamilyDiscount"]; ?>" />
    	</div>
    </div>
    	


  <div class="row">

      <div class="medium-6 columns">

            <div class="input-group">

              <span class="input-group-label">Fee $</span>

              <input class="input-group-field disabled" disabled="disabled" type="number" id="tFee" readonly="readonly" style="text-align: right; color:#333;" value="<?php echo $row['Fee']; ?>" />

            </div>

        
      </div>

      <div class="medium-6 columns text-center">
        <a class="button" style="width:70%" href="javascript:void(0);" onclick="<?php echo ($IsMainContact) ? 'getMainContact();' : 'getRegistrant();' ?>">Update Details</a>
        <a class="button hollow" style="width:28%" data-open="auditNotes">Logs</a>
        <!-- <a class="button hollow alert" style="width:19%" data-open="cancelModal">Cancel</a> -->
      </div>
    

  </div>
  </form>
<!-- end details id -->
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

<div class="reveal" id="auditNotes" data-reveal>
  <h4 class="twelve">Logs</h4> 
  <div>



      <?php 
        $data1 = '';
        if($IsMainContact){

           $data = $database->select("AuditLog", ['ChangeText','DateTime'],[
            "AND" => [
                "Id"            => $MainContactId,
                "AuditLog.Type" => "M"
              ],
              ["ORDER" => "DateTime"]
           ]);  
    

        }else{

           $data = $database->select("AuditLog", ['ChangeText','DateTime'],[
            "AND" => [
                "Id"            => $MainContactId,
                "AuditLog.Type" => "R"
              ],
              ["ORDER" => "DateTime"]
           ]);    

        }

        //outputs the change text
        if (count($data) > 0 ){

            echo '<table><caption>Changes Log</caption><thead><tr><th>Target</th><th>From</th><th>To</th><th>DateTime</th></tr></thead>';
            echo '<tbody>';

            foreach ($data as $row){  

                $j = json_decode($row["ChangeText"],true);

                foreach ($j as $obj) {
                    echo '<tr>';

                    echo '<td>' . $obj['FieldName'] . '</td>';
                  
                    echo '<td>' . $obj['OldValue'] . '</td>';

                    echo '<td>' . $obj['NewValue'] . '</td>';
                  
                    echo '<td>' . $row['DateTime'] . '</td>';

                    echo '</tr>';
                }   
            } 

            echo '</tbody></table>';

        }

       ?>


  </div>
  <button class="close-button" data-close aria-label="Close reveal" type="button">
    <span aria-hidden="true">&times;</span>
  </button>

</div>
 

<div class="reveal" id="cancelModal" data-reveal>
  <h4 class="twelve">Rego Cancellation</h4> 
  <div class="row">
    <div class="large-12 columns">
      <label>Cancellation Reason</label>
      <input class="twelve" maxlength="50" id="tCancelReason" type="text" value="" placeholder="cancellation reason" />
      <a class="button warning" style="width: 100%;">Cancel Registration</a>
    </div>


  </div>
  <button class="close-button" data-close aria-label="Close reveal" type="button">
    <span aria-hidden="true">&times;</span>
  </button>

</div>
 

<div id="json" class="<?php echo (AppConfig::$DEBUG ? '' : 'hidden' ) ?>"></div>


	<?php require '_scripts_startup.php' ?> 

	<script src="js/responsive-tables.js"></script>
  <script src="/js/register_objects.js?<?php echo rand() ?>"></script>

	<script type="text/javascript">

	    $(function(){
	      //setTimeout("getNotes()",500);

	      $("#ddlFamilyDiscount").val(document.getElementById("tFamilyHidden").value);
	      $("#ddlRelation").val(document.getElementById("tRelationHidden").value);

	      setOptionText("ddlRole",  document.getElementById("tRoleHidden").value);
	      setOptionText("ddlChurch",document.getElementById("tChurchHidden").value);
	      //$("#ddlChurch").val(document.getElementById("tChurchHidden").value);
	      //$("#ddlRole").val(document.getElementById("tRoleHidden").value);
	      $("#ddlGender").val(document.getElementById("tGenderHidden").value);


	        //add triggers
	        $("#tAge").bind("change", function () {
	            updateFee();
	        });
	        $("#ddlFamilyDiscount").bind("change", function () {
	            updateFee();
	        });
	        $("#cbAirbed").bind("change", function () {
	            updateFee();
	        });
	        $("#cbAirport").bind("change", function () {
	            updateFee();
	        });    
          $("#cbPensioner").bind("change", function () {
              updateFee();
          });      
          $("#cbEarlyBird").bind("change", function () {
              updateFee();
          }); 


		});


	    function setOptionText(id, text){

	        var dd = document.getElementById(id);
	        for (var i = 0; i < dd.options.length; i++) {
	            if (dd.options[i].text === text) {
	                dd.selectedIndex = i;
	                break;
	            }
	        }

	    }


	    function updateFee(){

          console.log("update fee");

	        var Age             = $("#tAge").val();
	        var AirportTransfer = document.getElementById("cbAirport").checked;
          var Pensioner       = document.getElementById("cbPensioner").checked;
	        var EarlyBird       = document.getElementById("cbEarlyBird").checked;

	        var fee = REGO_CALCULATOR.calculateFeeAdmin(Age, AirportTransfer,
	          document.getElementById("ddlFamilyDiscount").selectedIndex, Pensioner, EarlyBird);

	        document.getElementById('tFee').value = fee;

	        return fee;


	    }


	    function getRegistrant(){

          var r              = new REGISTRANT();
          
          r.Firstname        = $("#tFirstname").val();
          r.Surname          = $("#tSurname").val();
          r.Age              = $("#tAge").val();
          r.Relation         = $("#ddlRelation").val();
          r.Role             = $("#ddlRole").val();
          r.FamilyDiscount   = $("#ddlFamilyDiscount").val();
          r.Gender           = $("#ddlGender").val();
          r.AirportTransfer  = document.getElementById("cbAirport").checked;
          //r.Airbed           = document.getElementById("cbAirbed").checked;
          r.Fee              = updateFee();
          r.Cancelled        = document.getElementById("cbCancelled").checked;
          r.Pensioner        = document.getElementById("cbPensioner").checked;
          r.EarlyBirdSpecial = document.getElementById("cbEarlyBird").checked;

	        $("#json").html(JSON.stringify(r)).show();

	        sendData(JSON.stringify(r), <?php echo ($MainContactId == "") ? 0 : $MainContactId ; ?>, "update-registrant");
	    }

	    function getMainContact(){

          var r              = new REGO();
          
          r.Firstname        = $("#tFirstname").val();
          r.Surname          = $("#tSurname").val();
          r.Age              = $("#tAge").val();
          r.Role             = $("#ddlRole").val();
          r.Email            = $("#tEmail").val();
          r.Phone            = $("#tPhone").val();
          r.Gender           = $("#ddlGender").val();
          r.AirportTransfer  = document.getElementById("cbAirport").checked;
          //r.Airbed           = document.getElementById("cbAirbed").checked;
          r.Church           = $("#ddlChurch").val();
          r.Fee              = updateFee();
          r.Cancelled        = document.getElementById("cbCancelled").checked;
          r.Pensioner        = document.getElementById("cbPensioner").checked;
          r.EarlyBirdSpecial = document.getElementById("cbEarlyBird").checked;
	        

	        $("#json").html(JSON.stringify(r)).show();
          //toTable(r);

	        sendData(JSON.stringify(r), <?php echo ($MainContactId == "") ? 0 : $MainContactId ; ?>, "update-maincontact");

	    }


	    function sendData(json, id, type){
	        $("#callout-alert").hide();
	        $("#callout-success").hide();

	        $.ajax({
	          url: 'action.php?cache=' + Math.random(),
	          type: 'POST',
	          dataType: 'json',
	          data: {json: json, id: id, type: type },
	        })
	        .done(function(data) {
	          if (data.status == 1){
	            $("#callout-success").slideDown();
	            if (data.refresh == 1) {
	            	setTimeout("location.reload()",500);
				}
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


      function toTable(jsonObj){
        var myObj, txt = "";
            myObj = jsonObj;//JSON.parse(json);
            txt += "<table border='1'>"
            for (x in myObj) {
              txt += "<tr>" 
              txt += "<td>" + x + "</td>";
              txt += "<td>" + myObj[x].toString() + "</td>";
              txt += "</tr>"  
            }
            txt += "</table>"        
            document.getElementById("json").innerHTML = txt;

      }

	</script>


</body>

</html>

