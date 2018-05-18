<?php

class Form {
	const COLLECTION = "forms";

	public static function saveChart($type, $id, $properties, $label){
	    //TODO SABR - Check the properties before inserting
	    PHDB::update(self::COLLECTION,
			array("_id" => new MongoId($id)),
            array('$set' => array("properties.chart.".$label=> $properties))
        );
        return true;
    }
    
	public static function removeChart($type, $id, $label){
		PHDB::update(self::COLLECTION, 
            array("_id" => new MongoId($id)) , 
            array('$unset' => array("properties.chart.".$label => 1))
        );
        return true;	
	}
}
?>