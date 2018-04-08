<!doctype html>
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

			//SELECT M.*, SELECT(COUNT R.MainContactId FROM Registrant R WHERE R.MainContactId=M.MainContactId) GroupTotal FROM MainContact M ORDER BY M.MainContactId
			$query = "SELECT M.*, (SELECT COUNT(R.MainContactId) FROM Registrant R WHERE R.MainContactId = M.MainContactId) as OtherRegistrants FROM MainContact M ORDER BY M.MainContactId";
			$datas = $database->query($query)->fetchAll();
	


			//<table id="dt" class="display" cellspacing="0" width="100%" role="grid" class="responsive">
			echo '<div class="row column">
			<div class="large-12 medium-12 columns">
			<table cellpadding="2" cellpadding="2" border="1" width="100%" role="grid" class="responsive display" id="dt">
			
			<thead>
			<tr>
				<th>Name</th>
				<th>Reference</th>
				<th>Age</th>
				<th>Email</th>
				<th>Phone</th>
				<th>Church</th>
				<th>Airport</th>
				<th>Fee</th>
				<th>Registered</th>
				<th>Others</th>
			</tr></thead><tbody>';

			foreach($datas as $row){
				

					echo sprintf('
									<tr>
										<td><a href="details.php?id=%d">%s</a></td>
										<td>%s</td>
										<td>%s</td>
										<td>%s</td>
										<td>%s</td>
										<td>%s</td>
										<td>%s</td>
										<td>%01.2f</td>
										<td>%s</td>
										<td>%d</td>
									</tr>'
								, $row["MainContactId"]
								, $row["FullName"]
								, $row["Reference"]
								, $row["Age"]
								, $row["Email"]
								, $row["Phone"]
								, $row["Church"]
								, ToYesNo($row["AirportTransfer"])
								, $row["Fee"]
								, $row["DateTimeEntered"]
								, $row["OtherRegistrants"]
								
								);
			}

	
	
			echo "</tbody></table>";
			echo "</div></div>"; 
	}


	ListRegos2();

?>

	
	<?php require '_scripts_startup.php' ?>
	<script type="text/javascript">
		
		$(document).ready(function() {
	    	$('#dt').DataTable({
	    		 	"lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
					iDisplayLength: 50,
					repsonsive:true,
					destroy: true
	    	});
		} );


	</script>
</body>
</html>

