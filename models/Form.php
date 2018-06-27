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
    public static function countStep($idParent){
    	return PHDB::count( self::COLLECTION, array("parentSurvey"=>$idParent));
    }
    public static function getById($parentSurvey, $fields=array()){
    	return PHDB::findOne( self::COLLECTION, array("id"=>$parentSurvey));
    }

    public static function getlinksById($parentSurvey){
    	return PHDB::findOne( self::COLLECTION, array("id"=>$parentSurvey));
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