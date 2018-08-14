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
    	return PHDB::count( self::COLLECTION, array("parentForm"=>$idParent));
    }

    public static function getById($parentForm, $fields=array()){
    	return PHDB::findOne( self::COLLECTION, array("id"=>$parentForm), $fields);
    }

    public static function getByIdMongo($id,$fields=array()){
    	return PHDB::findOne(self::COLLECTION,array("_id"=>new MongoId($id)), $fields);
    }

    public static function getLinksById($id){
    	return self::getByIdMongo($id,array("links"));
    }

    public static function getLinksFormsByFormId($id, $type="all", $role=null) {
	  	$res = array();
	  	
	  	$form = self::getLinksById($id);

	  	if (empty($form)) {
            throw new CTKException(Yii::t("form", "The form id is unkown : contact your admin"));
        }
	  	if (isset($form) && isset($form["links"]) && isset($form["links"]["Form"])) {
	  		$members=array();
	  		foreach($form["links"]["Form"] as $key => $member){
	  		 	if(!@$member["toBeValidated"] && !@$member["isInviting"])
	  		 		$members[$key]= $member;
	  		}
	  		//No filter needed
	  		if ($type == "all") {
	  			return $members;
	  		} else {
	  			foreach ($form["links"]["Form"] as $key => $member) {
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
	public static function listForAdmin($answers = array()){
		$results = array();
		$uniq = array();
		$uniqO = array();
		$uniqP = array();
		$uniqE = array();
		
		foreach ( $answers as $key => $value) {
			// if(!in_array( $value["user"], $uniq )){
			// 	$value["type"] = Person::COLLECTION;
			// 	$value["id"] = $value["user"];
			// 	$results[] = $value;
			// 	$uniq[] = $value["user"];
			// }

			if( !empty($value["answers"]) && 
				!empty($value["answers"][Organization::CONTROLLER]) && 
				!in_array( $value["answers"][Organization::CONTROLLER]["id"], $uniqO ) ){
				$orga = Element::getElementById($value["answers"][Organization::CONTROLLER]["id"], Organization::COLLECTION, null, array("name", "email"));
				$orga["id"] = $value["answers"][Organization::CONTROLLER]["id"];
				$orga["type"] = Organization::COLLECTION;
				$results[] = $orga;
				$uniqO[] = $value["answers"][Organization::CONTROLLER]["id"];
			}

			if( !empty($value["answers"]) && 
				!empty($value["answers"][Project::CONTROLLER]) && 
				!in_array( $value["answers"][Project::CONTROLLER]["id"], $uniqP ) ){

				$orga = Element::getElementById($value["answers"][Project::CONTROLLER]["id"], Project::COLLECTION, null, array("name", "email"));
				$orga["id"] = $value["answers"][Project::CONTROLLER]["id"];
				$orga["type"] = Project::COLLECTION;

				if(!empty($value["answers"][Project::CONTROLLER]["parentId"])){
					$orga["parentId"] = $value["answers"][Project::CONTROLLER]["parentId"];
					$orga["parentType"] = Element::getCollectionByControler($value["answers"][Project::CONTROLLER]["parentType"]);
					$parent = Element::getSimpleByTypeAndId($orga["parentType"], $orga["parentId"]);
					$orga["parentName"] = $parent["name"];
				}else{
					$answersParent = PHDB::findOne( Form::ANSWER_COLLECTION , 
										array("parentSurvey"=>@$value["parentSurvey"], 
												"answers.organization" => array('$exists' => 1),
												"user" => $value["user"]) );
					// Rest::json(array("parentSurvey"=>@$value["parentSurvey"], 
					// 							"answers.organization" => array('$exists' => 1),
					// 							"user" => $value["user"])); exit;
					//Rest::json($answersParent); exit;
					$orga["parentId"] = $answersParent["answers"][Organization::CONTROLLER]["id"];
					$orga["parentType"] = Organization::COLLECTION;
					$orga["parentName"] = $answersParent["answers"][Organization::CONTROLLER]["name"];
				}

				$orga["userId"] = $value["user"];
				$orga["userName"] = $value["name"];
				
				$results[] = $orga;
				$uniqP[] = $value["answers"][Project::CONTROLLER]["id"];
			}


			if( !empty($value["answers"]) && 
				!empty($value["answers"][Event::CONTROLLER]) && 
				!in_array( $value["answers"][Event::CONTROLLER]["id"], $uniqE ) ){
				$orga = Element::getElementById($value["answers"][Event::CONTROLLER]["id"], Event::COLLECTION, null, array("name", "email"));
				$orga["id"] = $value["answers"][Event::CONTROLLER]["id"];
				$orga["type"] = Event::COLLECTION;
				$results[] = $orga;
				$uniqE[] = $value["answers"][Event::CONTROLLER]["id"];
			}
		}

		return $results ;	
	}

	public static function canAdmin($id, $form = array()){
		//var_dump($form); exit;
		if(empty($form));
			$form = PHDB::findOne( Form::COLLECTION , array("id"=>$id));

		$res = false;
		if(	Yii::app()->session["userId"] == $form["author"] ||
			(	!empty($form["links"]["members"][Yii::app()->session["userId"]]) && 
				!empty($form["links"]["members"][Yii::app()->session["userId"]]["isAdmin"]) &&
				$form["links"]["members"][Yii::app()->session["userId"]]["isAdmin"] == true &&
				in_array("TCO", $form["links"]["members"][Yii::app()->session["userId"]]["roles"]) ) ){
    		$res = true;
    		
        }else if( Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )){
			$res = true;
		}
        return $res ;
	}

}
?>