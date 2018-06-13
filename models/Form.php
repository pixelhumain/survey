<?php

class Form {
	const COLLECTION = "forms";
	const ANSWER_COLLECTION = "answers";
	const ICON = "fa-list-alt";
	const ICON_ANSWER = "fa-calendar-check-o";

	public static function save($data){
		try{
			PHDB::insert( self::ANSWER_COLLECTION, $data);
	        return true;	
		} catch (CTKException $e){
   			return $e->getMessage();
  		}
    }
    
	// public static function remove($id){
	// 	PHDB::update(self::ANSWER_COLLECTION, 
 //            array("_id" => new MongoId($id)) , 
 //            array('$unset' => array("properties.chart.".$label => 1))
 //        );
 //        return true;	
	// }
}
?>