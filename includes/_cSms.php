<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/_cApp.php' ?>
<?php
        class SMS{

            var $access_token = ""; 
            var $provisionedNumber = "";

            function SMS(){
                
                $CONSUMER_KEY    ="KINhFsDOG8yXlkAi0N4Xi2R3pz39nhZH"; 
                $CONSUMER_SECRET =APP_SECRET_KEYS::$CONSUMER_SECRET1; 
                                    
                $url             = 'https://tapi.telstra.com/v2/oauth/token';
                $myvars          = 'client_id=' .$CONSUMER_KEY . '&client_secret=' . $CONSUMER_SECRET . '&grant_type=client_credentials&scope=NSMS';

                $ch = curl_init( $url );
                curl_setopt ($ch, CURLOPT_HTTPHEADER, Array("Content-Type: application/x-www-form-urlencoded"));
                curl_setopt( $ch, CURLOPT_POST, 1);
                curl_setopt( $ch, CURLOPT_POSTFIELDS, $myvars);
                curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
                curl_setopt( $ch, CURLOPT_HEADER, 0);
                curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1); 

                $response = curl_exec( $ch );

                if ($response){
                    $obj = json_decode($response,false);
                    if ($obj->access_token){
                        //have the access token
                        $this->access_token = $obj->access_token ;
                    }
                }

            }


            function provisionNumber(){

              
                $url     = 'https://tapi.telstra.com/v2/messages/provisioning/subscriptions';
                $myvars  = '{"activeDays": 30}';

                $ch = curl_init( $url );
                curl_setopt ($ch, CURLOPT_HTTPHEADER, Array("cache-control: no-cache","Content-Type: application/json", "Authorization: Bearer " . $this->access_token ));
                curl_setopt( $ch, CURLOPT_POST, 1);
                curl_setopt( $ch, CURLOPT_POSTFIELDS, $myvars); 
                curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
                curl_setopt( $ch, CURLOPT_HEADER, 0);
                curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);  

                $response = curl_exec( $ch );

                if ($response){
                    $obj = json_decode($response,false);
                    if ($obj->messageId){
                        $this->provisionedNumber = $obj->destinationAddress;
                    }
                }

            }


            function send($phone, $message){

                //trim to 160 characters
                $message = substr(trim($message),0,160);
                
                $url     = 'https://tapi.telstra.com/v2/messages/sms';
                $myvars  = '{"to": "' . $phone . '", "body":"' . $message .'"}';

                $ch = curl_init( $url );
                curl_setopt ($ch, CURLOPT_HTTPHEADER, Array("Content-Type: application/json", "Authorization: Bearer " . $this->access_token ));
                curl_setopt( $ch, CURLOPT_POST, 1);
                curl_setopt( $ch, CURLOPT_POSTFIELDS, $myvars); 
                curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
                curl_setopt( $ch, CURLOPT_HEADER, 0);
                curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);  

                $response = curl_exec( $ch );


                if ($response){
                    $obj = json_decode($response,false);
                    if ($obj->messageId){
                        return $obj->messageId;
                    }
                }

                return "";

            }


        }


/*
        $sms = new SMS();
        if($sms->access_token){
            echo "messageId: " . $sms->send("+61403478387","Hello, http://goo.gl/asxolc");
        }else{
            echo "token: " . $sms->access_token; 
        }

*/	


        class SMSAdmin{

            var $access_token = ""; 

            function SMSAdmin(){

                $CONSUMER_KEY    ="FR1QIRssWrUZeJOFyBIt7ZAqUXuAr1zQ"; 
                $CONSUMER_SECRET =APP_SECRET_KEYS::$CONSUMER_SECRET2; 
                
                $url             = 'https://api.telstra.com/v1/oauth/token';
                $myvars          = 'client_id=' .$CONSUMER_KEY . '&client_secret=' . $CONSUMER_SECRET . '&grant_type=client_credentials&scope=SMS';

                $ch = curl_init( $url );
                curl_setopt ($ch, CURLOPT_HTTPHEADER, Array("Content-Type: application/x-www-form-urlencoded"));
                curl_setopt( $ch, CURLOPT_POST, 1);
                curl_setopt( $ch, CURLOPT_POSTFIELDS, $myvars);
                curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
                curl_setopt( $ch, CURLOPT_HEADER, 0);
                curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1); 

                $response = curl_exec( $ch );

                if ($response){
                    $obj = json_decode($response,false);
                    if ($obj->access_token){
                        //have the access token
                        $this->access_token = $obj->access_token ;
                    }
                }

            }


            function send($phone, $message){
                //trim to 160 characters
                $message = substr(trim($message),0,160);
                
                $url     = 'https://api.telstra.com/v1/sms/messages';
                $myvars  = '{"to": "' . $phone . '", "body":"' . $message .'"}';

                $ch = curl_init( $url );
                curl_setopt ($ch, CURLOPT_HTTPHEADER, Array("Content-Type: application/json", "Authorization: Bearer " . $this->access_token ));
                curl_setopt( $ch, CURLOPT_POST, 1);
                curl_setopt( $ch, CURLOPT_POSTFIELDS, $myvars); 
                curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
                curl_setopt( $ch, CURLOPT_HEADER, 0);
                curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);  

                $response = curl_exec( $ch );


                if ($response){
                    $obj = json_decode($response,false);
                    if ($obj->messageId){
                        return $obj->messageId;
                    }
                }

                return "";

            }


        }

        


        class SMSBroadcast{

            var $access_token = "true"; 

            function SMSBroadcast(){


            }

            function directSendSMS($phone, $message) {

                $username = 'mrkyle';
                $password = APP_SECRET_KEYS::$SMS_BROADCAST_PWD;
                $destination = $phone; //Multiple numbers can be entered, separated by a comma
                $source    = 'DAIHOI_2018';
                $text = $message;
                $ref = '';


                $content =  'username='.rawurlencode($username).
                            '&password='.rawurlencode($password).
                            '&to='.rawurlencode($destination).
                            '&from='.rawurlencode($source).
                            '&message='.$text.
                            '&ref='.rawurlencode($ref);

                $ch = curl_init('https://www.smsbroadcast.com.au/api-adv.php');
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $output = curl_exec ($ch);
                curl_close ($ch);
                return $output;    
            }


            
            function send($phone, $message){

                $smsbroadcast_response = $this->directSendSMS($phone, $message);
                $response_lines = explode("\n", $smsbroadcast_response);
                
                 foreach( $response_lines as $data_line){
                    $message_data = "";
                    $message_data = explode(':',$data_line);
                    if($message_data[0] == "OK"){
                        //echo "The message to ".$message_data[1]." was successful, with reference ".$message_data[2]."\n";
                        return  $message_data[2];
                    }elseif( $message_data[0] == "BAD" ){
                        //echo "The message to ".$message_data[1]." was NOT successful. Reason: ".$message_data[2]."\n";
                        return  $message_data[2];
                    }elseif( $message_data[0] == "ERROR" ){
                        //echo "There was an error with this request. Reason: ".$message_data[1]."\n";
                        return  $message_data[1];
                    }
                 }

                 return "";

            }        

  


    }


?>
