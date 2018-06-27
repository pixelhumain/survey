<?php

class Form {
	const COLLECTION = "forms";
	const CONTROLLER = "forms";
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
    	return PHDB::findOne( self::COLLECTION, array("id"=>$parentSurvey), $fields);
    }

    public static function getByIdMongo($id,$fields=array()){
    	return PHDB::findOne(self::COLLECTION,array("_id"=>new MongoId($id)), $fields);
    }

    public static function getLinksById($id){
    	return self::getByIdMongo($id,array("links"));
    }

    public static function getSurveyByFormId($id, $type="all", $role=null) {
	  	$res = array();
	  	
	  	$form = self::getLinksById($id);

	  	if (empty($form)) {
            throw new CTKException(Yii::t("form", "The form id is unkown : contact your admin"));
        }
	  	if (isset($form) && isset($form["links"]) && isset($form["links"]["survey"])) {
	  		$members=array();
	  		foreach($form["links"]["survey"] as $key => $member){
	  		 	if(!@$member["toBeValidated"] && !@$member["isInviting"])
	  		 		$members[$key]= $member;
	  		}
	  		//No filter needed
	  		if ($type == "all") {
	  			return $members;
	  		} else {
	  			foreach ($form["links"]["survey"] as $key => $member) {
		            if ($member['type'] == $type) {
		            	if ( !empty($role) && @$member[$role] == true ) {

			            	if($role=="isAdmin"){
			            		if(!@$member["isAdminPending"] && !@$member["toBeValidated"] && !@$member["isInviting"] && $member["isAdmin"] == true)
			            			$res[$key] = $member;	
			            	} else {
			                	$res[$key] = $member;

			            	}
			            } else if(empty($role) && !@$member["toBeValidated"] && !@$member["isInviting"]){
			            	$res[$key] = $member;
			            }
		            }

		           
	        	}
	  		}
	  	}
	  	return $res;
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