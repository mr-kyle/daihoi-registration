<?php 
	
	require '_db.php';

	class OUTPUTj { //class to hold output to json
		var $status  = 0;
		var $id      = 0;
		var $message = "";
		var $html    = "";
		var $count   = 0;
		
		
		function OUTPUTj($s){

			$this->status    = $s;

		}

		function toJSON(){
			return json_encode($this);
		}

	} // endclass to hold output to json



	function execute($type){
		header('Content-Type: application/json');

		$searchTerm = trim($_GET["search"]);

		$database = createDb();

		$where = [];
		switch (trim($type)) {
			case 'name':
				$where = ["FullName[~]" => $searchTerm];
				// $where = [
				// 		"OR" => [
				// 			"FullName[~]" => $searchTerm,
				// 			"RName[~]"    => $searchTerm
				// 			]
				// 		];
				break;
			case 'ref':
				$where = ["Reference[~]" => $searchTerm];
				break;
			case 'email':
				$where = ["email[~]" => $searchTerm];
				break;
			case 'phone':
				$where = ["phone[~]" => $searchTerm];
				break;			
			default:
				# code...
				break;
		}

		//search the main contact
		$datas = $database->select("MainContact", [
			"FullName",
			"Email",
			"Phone",
			"Church",
			"Age",
			"Reference",
			"MainContactId"
			] , $where);


		/* 
		//search the registrants if its search by name
		if (trim($type) == "name"){

			$where = ["RName[~]" => $searchTerm];

			$datasR = $database->select("vAllRegos", [
				"RName(FullName)",
				"Empty(Email)",
				"Empty(Phone)",
				"Church",
				"RAge(Age)",
				"Reference",
				"MainContactId"
				] , $where);

			//merge the 2 arrays
			$datas = array_merge($datas, $datasR);
		}
		*/
		



		$count = count($datas);
		$r = new OUTPUTj(1);

		switch ($count) {
			case 0:
				$r->count = 0;
				$r->message = "No records matching your search term!! (" . $searchTerm . ")";
				break;
			case 1:
				$r->count = 1;
				$r->id = $datas[0]["MainContactId"];
				break;			
			default:
				//more than 1 matching records
				$r->count = $count;


				$r->html = $r->html . sprintf('<caption>%d records.</caption><thead><th>Name</th><th>Email</th><th>Phone</th><th>Age</th><th>Church</th><th>Ref</th></thead><tbody>', $count);
				foreach ($datas as $row) {
					$r->html = $r->html . sprintf('<tr><td><a href="details.php?id=%d">%s</a></td><td>%s</td><td>%s</td><td>%d</td><td>%s</td><td>%s</td></tr>'
												, $row['MainContactId']
												, $row['FullName']
												, $row['Email']
												, $row['Phone']
												, $row['Age']
												, $row['Church']
												, $row['Reference']
												);
				}
				$r->html = $r->html . '</tbody>';
				break;
		}


		//out the json
		echo $r->toJSON();
	}

	//main
	$type = strtolower($_GET["type"]);
	if ($type == 'name' || $type == 'email' || $type == 'phone' || $type == 'ref') {
		execute($type);
	}
		

 ?>

