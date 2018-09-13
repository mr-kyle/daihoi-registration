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

			$query = "SELECT M.*, 
			(SELECT COUNT(R.MainContactId) 
			FROM MainContact R 
			WHERE R.GroupLeaderMainContactId = M.MainContactId AND R.Cancelled = 0) as OtherRegistrants,
			(SELECT SUM(IFNULL(T.Fee,0)) 
			FROM MainContact T 
			WHERE T.GroupLeaderMainContactId = M.MainContactId AND T.Cancelled = 0) As OtherFees,
			IFNULL((SELECT SUM(P.PaidAmount) FROM Payment P WHERE P.MainContactId = M.MainContactId), 0 ) as TotalPaid		
			FROM MainContact M 
			WHERE M.GroupLeaderMainContactId IS NULL
			AND M.Cancelled = 0
			ORDER BY M.MainContactId DESC";

			$datas = $database->query($query)->fetchAll();
	


			//<table id="dt" class="display" cellspacing="0" width="100%" role="grid" class="responsive">
			echo '<div class="row column">
			<div class="large-12 medium-12 columns">
			<table cellpadding="2" cellpadding="2" border="1" width="100%" role="grid" class="responsive display" id="dt">
			
			<thead>
			<tr>
				<th>Name</th>
				<th>Reference</th>
				<th>Email</th>
				<th>Phone</th>
				<th>Church</th>
				<th>Total Fee</th>
				<th>Outstanding Amount</th>
				<th>Registered</th>
				<th>Others</th>
			</tr></thead><tbody>';

			foreach($datas as $row){
					$otherFees = (is_numeric($row["OtherFees"]) ? $row["OtherFees"] : 0);
					$totalFees = intVal($row["Fee"]) + intVal($otherFees);
					$totalPaid = intVal($row["TotalPaid"]);
					echo sprintf('
									<tr>
										<td><a href="details.php?id=%d">%s</a></td>
										<td>%s</td>
										<td>%s</td>
										<td>%s</td>
										<td>%s</td>
										<td>%01.2f</td>
										<td>%01.2f</td>
										<td>%s</td>
										<td>%d</td>
									</tr>'
								, $row["MainContactId"]
								, $row["FullName"]
								, $row["Reference"]
								, $row["Email"]
								, $row["Phone"]
								, $row["Church"]
								//, ToYesNo($row["AirportTransfer"])
								, $totalFees
								, ($totalFees - $totalPaid)
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

