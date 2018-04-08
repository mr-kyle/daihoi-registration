<?php 


	class FeeCalculator{


    	const FAMILY_DISCOUNT1_AMOUNT = 50;

	    const FAMILY_DISCOUNT2_AMOUNT = 100;

	    const AIRBED_DISCOUNT_AMOUNT = 0;

	    const AIRPORT_FEE = 25;

	    const EARLY_BIRD_DISCOUNT_AMOUNT1 = 20;

	    const EARLY_BIRD_DISCOUNT_AMOUNT2 = 20;


		function FeeCalculator(){


		}


		function calculateFee(	$Age = 0, 
								$FamilyDiscount = '-', 
								$Airbed = 0, 
								$AirportTransfer = 0,
								$Pensioner = 0,
								$EarlyBirdSpecial = 0){


		        $fee = 0;

		        //normal pricing
	            switch (true) {
	                case ($Age <= 5):
	                    $fee = 50;
	                    break;
	                case ($Age > 5 && $Age <= 12):
	                    $fee = 350;
	                    break;
	                case ($Age > 12 && $Age < 65):
	                    $fee = 450;
						break;
	                case ($Age >= 65 ):                 	
	                    $fee = 400;
						break;
                    default:
						# code...
						break;

	            }

				//pensioner (can only be pensioner at 18)
	            if ($Age > 17 && $Pensioner) { $fee = 400;}


	            //any family discounts
				switch ($FamilyDiscount) {

					case '2nd child 5yo or under':
						//only apply if age is under 6
						if ($Age < 6){
							$fee = $fee - self::FAMILY_DISCOUNT1_AMOUNT;
						}
						break;

					case '2nd child over 5yo':
						if ($Age > 5){
							$fee = $fee - self::FAMILY_DISCOUNT2_AMOUNT;
						}
						break;

					default:
						# code...
						break;					

				} 

				//adjustment of fee as the airbed and transfer fee are additional on top (not part of any discounts)
        		if ($fee < 0) { 
        			$fee = 0 ;
        		}


				//early bird special
				if ($EarlyBirdSpecial){
					$fee = $this->calculateEarlyBirdDiscount($fee, $Age, $Pensioner); //removal of discount as it has elapsed
				}


				//if ($fee >= self::AIRBED_DISCOUNT_AMOUNT && $Airbed) { //airbed discount
				//	$fee = $fee - self::AIRBED_DISCOUNT_AMOUNT;
				//}
        		if ($fee < 0) { $fee = 0 ;}				


				//airport transfer fee
				if ($AirportTransfer) {
					$fee = $fee + self::AIRPORT_FEE;
				}

				//adjustment of fee
        		if ($fee < 0) { 
        			$fee = 0 ;
        		}


            	return $fee;

			}




			private function calculateEarlyBirdDiscount($fee, $age, $pensioner){



				if (is_numeric($fee)){	

					//if (new DateTime() < new DateTime("2016-09-30 00:00:00")) {


				            switch (true) {
				                case ($age <= 5):
				                    $fee = $fee - self::EARLY_BIRD_DISCOUNT_AMOUNT1;
				                    break;
				                case ($age > 5 && $age <= 12):
				                    $fee = $fee - self::EARLY_BIRD_DISCOUNT_AMOUNT1;
				                    break;

				                case ($age > 12 && $age < 65):
				                    $fee = $fee - self::EARLY_BIRD_DISCOUNT_AMOUNT2;
				                    break;

				                case ($age >= 65):
				                    $fee = $fee - self::EARLY_BIRD_DISCOUNT_AMOUNT2;

				                    break;

			                    default:
									# code...
									break;

				            }
			    			
				    		return $fee;
					//}

				}else{
					return $fee;
				}
		
			}




	//end class
	}


?>