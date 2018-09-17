<?php


  //the db connection
	
  //


  class RoomUltility {

    require '_db.php';
    $database = null
    //new
    function RoomUltility() {
     $database = createDb();
    }


    function ListAvailableVaccantRooms(){

      $obj = (object)null; // create empty object, this syntax is the key
      $obj->value = 'hello';
      $obj->text = 'world';


      $datas = $database->select("vRoomOccupancy", "*" , [
        "IsAvailable" => 1
      ]);

      return json_encode($obj);
      
    }


  }


?>