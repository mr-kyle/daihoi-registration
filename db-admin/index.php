<?php	
// Report all errors except E_NOTICE
error_reporting(E_ALL & ~E_NOTICE);
?>
<!doctype html>
<html class="no-js" lang="en">
<head>
	<title>Registration Dashboard</title>
	<?php require '_scripts.php' ?>
</head>

<body>
<?php require '_menu.php' ?>

<?php 
	require '_db.php';

	$html1 = "";
	$database = createDb();
	$datas = $database->select("MainContact", [
			"FullName",
			"Email",
			"Church",
			"Phone",
			"DateTimeEntered",
			"MainContactId"
		] , [
			"AND" => [
				"MainContactId[>]" => 0,
				"GroupLeaderMainContactId" => null
			],
			"ORDER" => ["MainContactId" => "DESC"]
		]
	);
	//$datas = $database->select("MainContact", "*");


	$records = count($datas);
	
	if ($records > 0) {
		$html1 = sprintf('<h5><a href="details.php?id=%d">%s</a></h5>
				<p>%s, %s<br />%s<p>%s',
				$datas[0]["MainContactId"],
				$datas[0]["FullName"],
				$datas[0]["Phone"],
				$datas[0]["Email"], 
				$datas[0]["Church"],
				$datas[0]["DateTimeEntered"]
				);

		//gets the next 20 records
		$counter = 0;
		$html3 = "";
		foreach ($datas as $row) {
			$counter += 1;
			if ($counter > 1){
				$html3 .=  sprintf('<li><a href="details.php?id=%d">%s</a>, %s<br />%s</li>',
								$row["MainContactId"],
								$row["FullName"],
								$row["DateTimeEntered"],
								$row["Church"]);

			}
		}
		if ($html3 != ""){
			$html3 = '<br /><a class="button small expanded secondary" href="#" onclick="$(\'#next20\').slideToggle();">Show Next 20 </a><ol id="next20">' . $html3 . '</ol>';
		}


	}else{
		$html1 = "<h5>No records</h5>";
	}


	$query = "SELECT  (SELECT COUNT(M.MainContactId) FROM MainContact M WHERE M.Cancelled = 0) TotalAttendance, 
	(SELECT SUM(P.PaidAmount) FROM Payment P) TotalPaid,
	(SELECT SUM(M.Fee) FROM MainContact M WHERE M.Cancelled = 0) TotalFees,
	(SELECT COUNT(*) FROM MainContact M INNER JOIN RoomAllocation A ON A.MainContactId = M.MainContactId WHERE M.Cancelled = 0) RoomAllocatedTotal,
	(SELECT COUNT(*) FROM MainContact M WHERE M.Cancelled = 0 AND M.CheckedIn = 1) CheckedInTotal;";
	$datas = $database->query($query)->fetchAll();


	$transfers = $database->query("SELECT COUNT(M.AirportTransfer) as AirportTransferTotal FROM MainContact M WHERE M.AirportTransfer = 1 AND M.Cancelled = 0")->fetchAll();


	$ages = $database->query("SELECT M.Age FROM MainContact M GROUP BY M.Age ORDER BY Age;")->fetchAll();

	setlocale(LC_MONETARY, 'en_AU');
	$html2 = sprintf('<div class="row">
						<div class="medium-6 columns"><div class="panel-stats">Attendees<br/>%d</div></div>
					  	<div class="medium-6 columns"><div class="panel-stats">Paid<br/>%s</div></div>
					  </div>
					  <div>&nbsp;</div>
					  <div class="row">
					  	<div class="medium-6 columns"><div class="panel-stats">Outstanding<br/>%s</div></div>
					  	<div class="medium-6 columns"><div class="panel-stats">Airport Transfer<br/>%d</div></div>
					  </div>
					  <div>&nbsp;</div>
					  <div class="row">
					  	<div class="medium-6 columns"><div class="panel-stats">Persons Allocated<br/>%d</div></div>
					  	<div class="medium-6 columns"><div class="panel-stats">Checked In<br/>%d</div></div>
					  </div>', 
		$datas[0]["TotalAttendance"], 
		money_format('%#0n', $datas[0]["TotalPaid"]), 
		money_format('%#0n', $datas[0]["TotalFees"]), 
		$transfers[0]["AirportTransferTotal"],
		$datas[0]["RoomAllocatedTotal"],
		$datas[0]["CheckedInTotal"]
	);

	
	//look up room allocations
	$transfers = $database->query("SELECT COUNT(M.AirportTransfer) as AirportTransferTotal FROM MainContact M WHERE M.AirportTransfer = 1 AND M.Cancelled = 0")->fetchAll();
	

 ?>



	<div>&nbsp;</div>

    <div class="row columns">
    

      	<div class="large-4 columns">
			      		
				<div class="panel callout radius">
					<h5>Most Recent</h5>
					<hr>
				 	<?php echo $html1; ?>
				 	<?php echo $html3; ?>
				</div>

      	</div>


      	<div class="large-4 columns">
			      		
				<div class="panel callout radius">
					<h5>Stats</h5>
					<hr>
					<div style="padding-left:15px; padding-right: 15px;">
				 	<?php echo $html2; ?>		
				 	</div>	
				</div> 
			      		
      	</div>
      	 	<div class="large-4 columns">

			<div class="canvas-holder panel callout radius">
				<h5>Chart</h5>
				<hr>
				<canvas id="canvas" style="width: 100%; height: 250px;">
				</canvas>
			

				<?php 

					//payments stats
					$query = "SELECT M.DateTimeEntered , SUM(M.Fee) as TotalFee,
					IFNULL((SELECT SUM(P.PaidAmount) FROM Payment P WHERE P.MainContactId = M.MainContactId), 0 ) as TotalPaid,
												DATEDIFF(CURDATE(), M.DateTimeEntered) DaysElapsed,
												Month(M.DateTimeEntered) MonthRegistered
											FROM MainContact M
											WHERE M.Cancelled = 0
											GROUP BY M.DateTimeEntered, M.MainContactId
											ORDER BY M.DateTimeEntered";

					$datas = $database->query($query)->fetchAll();	

					$days30  = 0;
					$days60  = 0;
					$days90  = 0;
					$days120 = 0;
					
					$chartLabelArray    = array();
					$chartDataFeeArray  = array();
					$chartDataPaidArray = array();

					foreach ($datas as $row) {

						$days = $row['DaysElapsed'];
						if ($row['TotalPaid'] < $row['TotalFee']){

							if ($days > -1 && $days <= 30){
								$days30 += 1;
							}elseif ($days > 30 && $days <= 60){
								$days60 += 1;
							}elseif ($days > 60 && $days <= 90){
								$days90 += 1;
							}else{ //greater than 90 days
								$days120 += 1;
							}
						}


						//we calculate the chart data
						$index = $row['MonthRegistered'];

						$chartLabelArray	[$index]		=	'"' . substr(ToMonth($index),0,3) . '"';
						$chartDataFeeArray	[$index]		+=	$row['TotalFee'];
						$chartDataPaidArray	[$index]		+=	$row['TotalPaid'];


					}

					echo '<p>1 Month: ' . $days30 . ', ';
					echo '2 Months: ' . $days60 . ', ';
					echo '3 Months: ' . $days90 . ', ';
					echo '3+ Months: ' . $days120 . '</p>';	

					function ToMonth($month_int){
						$month_int = (int)$month_int;

						$timestamp = mktime(0, 0, 0, $month_int);

						return date('F', $timestamp);
					}
				 ?>
			</div>

		</div>

    </div>
    
    <div class="row columns">
    	


    </div>


    <div>&nbsp;</div>
    <div>&nbsp;</div>
		    	
		<form onsubmit="doSearch();return false;" autocomplete="off">
		  <div class="row columns">
		    <div class="large-12 columns">
		      <div class="row collapse">
		      	<label>Search</label>
		        <div class="large-9 columns">
		          <input type="text" placeholder="Search Term" id="tSearch" autocomplete="off" max="50" maxlength="50" />
		        </div>
		        <div class="large-2 columns">
		          <select id="searchType" style="width: 100%;">
		          	 <option value="ref">Reference</option>
		          	 <option>Name</option>
		          	 <option>Email</option>
		          	 <option>Phone</option>
		          </select>
		        </div>
		        <div class="large-1 columns">
		          <input type="button" class="button postfix" id="bGo" onclick="doSearch()" value=" GO " style="width: 100%;" accesskey="s" tabindex="0" />
		        </div>
		      </div>
				<div class="alert callout hide" data-closable id="warningAlert">
				  <p>No records found matching your search term.</p>
				  <button class="close-button" aria-label="Dismiss alert" type="button" data-close>
				    <span aria-hidden="true">&times;</span>
				  </button>
				</div>
		    </div>
		  </div>
		 </form>
 

	<div class="row column">

		<div class="large-12 medium-12 columns" id="results-wrapper" style="display: none" >
			<div>&nbsp;</div>
			<h4 class="search-header">Search Results</h4>
			<table cellpadding="2" cellpadding="2" border="1" width="100%" role="grid" class="responsive display" id="grid">
			</table>
			<div>&nbsp;</div>
		</div>

	</div>

<div class="row columns"> <!-- expanded -->

</div>


<?php require '_scripts_startup.php' ?>
<!-- 
<script type="text/javascript" src="/js/Chart.min.js"></script>
<script src="/js/Chart.Scatter.min.js"></script>
 -->
<script type="text/javascript" src="/js/Chart.min.js"></script>
<!-- https://github.com/Regaddi/Chart.StackedBar.js -->
<script type="text/javascript" src="/js/Chart.StackedBar.js"></script>
<script type="text/javascript">
	
	$(function(){
		stackedChart()
	});

	function chartScatter(){

		var data = [
		    {
		      label: 'My Second dataset',
		      strokeColor: '#007ACC',
		      pointColor: '#007ACC',
		      pointStrokeColor: '#fff',
		      data: [
		        { x: 19, y: 75, r: 4 }, 
		        { x: 27, y: 69, r: 7 }, 
		        { x: 28, y: 70, r: 5 }, 
		        { x: 40, y: 31, r: 3 },
		        { x: 48, y: 76, r: 6 },
		        { x: 52, y: 23, r: 3 }, 
		        { x: 24, y: 32, r: 4 }
		      ]
		    }
		  ];

		var ctx = document.getElementById("canvas").getContext('2d');
 		var options = {datasetFill : false, datasetStroke: false};
		var myLineChart = new Chart(ctx).Scatter(data, options);

	}


	function stackedChart() {

		var data = {
		    labels: [<?php echo implode(',',$chartLabelArray) ?>],
		    datasets: [
		        {
		        	label: 'Fees',
					fillColor : "rgba(220,220,220,0.5)",
					strokeColor : "rgba(220,220,220,0.8)",
					highlightFill: "rgba(220,220,220,0.75)",
					highlightStroke: "rgba(220,220,220,1)",
		            data: [<?php echo implode(',',$chartDataFeeArray) ?>]
		        },
		        {
		        	label: 'Paid',
					fillColor : "rgba(151,187,205,0.5)",
					strokeColor : "rgba(151,187,205,0.8)",
					highlightFill : "rgba(151,187,205,0.75)",
					highlightStroke : "rgba(151,187,205,1)",
		            data: [<?php echo implode(',',$chartDataPaidArray) ?>]
		        }
		    ]
		};

		var ctx = document.getElementById('canvas').getContext('2d');
		var options = {barStrokeWidth : 1,
			multiTooltipTemplate: function (valuesObject) { //formats the toolip
                return valuesObject.datasetLabel + ": " + Chart.helpers.formatNumber(valuesObject.value, "group");
            },
            tooltipTemplate: function (valuesObject) { //formats the toolip
                return valuesObject.label + ": " + Chart.helpers.formatNumber(valuesObject.value, "group");
            }
		  };
		var myStackedBarChart = new Chart(ctx).StackedBar(data, options);

	}

</script>

</body>
</html>

