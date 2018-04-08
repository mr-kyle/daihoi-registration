<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/_cApp.php' ?>
<?php
        class SMS{

            var $access_token = ""; 

            function SMS(){
                
                $CONSUMER_KEY    ="buCe3bret2CGY0yatbfhPxTYE9zK73Nq"; 
                $CONSUMER_SECRET =APP_SECRET_KEYS::$CONSUMER_SECRET1; 
                
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

        
?>
