<?php

class Form {
	const COLLECTION = "forms";
	const CONTROLLER = "forms";
	const ANSWER_COLLECTION = "answers";
	const ICON = "fa-list-alt";
	const ICON_ANSWER = "fa-calendar-check-o";

	public static $riskWeight = array(
		"11" => array( "w" => 1 , "c" => "lightGreen"),
		"12" => array( "w" => 2 , "c" => "lightGreen"),
		"13" => array( "w" => 3 , "c" => "lightGreen"),
		"14" => array( "w" => 4 , "c" => "orange"),
		"21" => array( "w" => 5 , "c" => "lightGreen"),
		"22" => array( "w" => 6 , "c" => "lightGreen"),
		"23" => array( "w" => 7 , "c" => "orange"),
		"24" => array( "w" => 8 , "c" => "red"),
		"31" => array( "w" => 9 , "c" => "lightGreen"),
		"32" => array( "w" => 10 , "c" => "orange"),
		"33" => array( "w" => 11 , "c" => "red"),
		"34" => array( "w" => 12 , "c" => "red"),
		"41" => array( "w" => 13 , "c" => "orange"),
		"42" => array( "w" => 14 , "c" => "red"),
		"43" => array( "w" => 15 , "c" => "red"),
		"44" => array( "w" => 16 , "c" => "red")
	);
	
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

	public static function listForAdminNews($form, $answers = array() ){
		$results = array();
		$uniq = array();
		$uniqO = array();
		$uniqP = array();
		$uniqE = array();

		$scenario = array();
		

		foreach ( $form["scenario"] as $key => $value) {
			$scenario[$key] = false;
		}

		//Rest::json($answers); exit ;
		foreach ( $answers as $key => $value) {
			
			if( !empty($value["answers"]) && 
				!empty($value["answers"][Organization::CONTROLLER]) && 
				!in_array( $value["answers"][Organization::CONTROLLER]["id"], $uniqO )  && 
				( 	empty($results[$value["user"]]) || 
					(!empty($results[$value["user"]]) && empty($results[$value["user"]]["parentId"]) ) ) ) {

					$orga = Element::getElementById($value["answers"][Organization::CONTROLLER]["id"], Organization::COLLECTION, null, array("name", "email"));
					$ans["parentId"] = $value["answers"][Organization::CONTROLLER]["id"];
					$ans["parentType"] = Organization::COLLECTION;
					$ans["parentName"] = $orga["name"];
					$ans["userId"] = $value["user"];
					$results[$value["user"]] = $ans;
				
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
					
					$orga["parentId"] = $answersParent["answers"][Organization::CONTROLLER]["id"];
					$orga["parentType"] = Organization::COLLECTION;
					$orga["parentName"] = $answersParent["answers"][Organization::CONTROLLER]["name"];
				}

				$orga["userId"] = $value["user"];
				$orga["userName"] = $value["name"];
				
				$results[ $value["user"] ]["id"] = @$orga["id"];
				$results[ $value["user"]]["type"] = @$orga["type"];
				$results[ $value["user"]]["name"] = @$orga["name"];
				$results[ $value["user"]]["email"] = @$orga["email"];
				$results[ $value["user"]]["parentId"] = @$orga["parentType"];
				$results[ $value["user"]]["parentName"] = @$orga["parentName"];
				$results[ $value["user"]]["userId"] = @$orga["userId"];
				$results[ $value["user"]]["userName"] = @$orga["userName"];

				$uniqP[] = $value["answers"][Project::CONTROLLER]["id"];
			}


			if ( !empty($results[$value["user"]]) ) {

				if ( empty($results[$value["user"]]["scenario"]) )
					$results[$value["user"]]["scenario"] = $scenario;
				//var_dump($results[$value["user"]]); echo "</br></br>";
				if ( isset($results[$value["user"]]["scenario"][$value["formId"]]) )
					$results[$value["user"]]["scenario"][$value["formId"]] = true;
			}
		}
		// Rest::json($results);exit ;
		return $results ;	
	}


	public static function listForAdmin($answers = array()){
		$results = array();
		$uniq = array();
		$uniqO = array();
		$uniqP = array();
		$uniqE = array();
		
		foreach ( $answers as $key => $value) {

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
		if(empty($form) && @$id)
			$form = PHDB::findOne( Form::COLLECTION , array("_id"=>new MongoId($id)));

		$res = false;
		if(	Yii::app()->session["userId"] == $form["author"] ||
			(	!empty($form["links"]["members"][Yii::app()->session["userId"]]) && 
				!empty($form["links"]["members"][Yii::app()->session["userId"]]["isAdmin"]) &&
				$form["links"]["members"][Yii::app()->session["userId"]]["isAdmin"] == true /*&&
				 !empty($form["links"]["members"][Yii::app()->session["userId"]]["roles"]) &&
				in_array("TCO", $form["links"]["members"][Yii::app()->session["userId"]]["roles"]) */ ) ){
    		$res = true;
    		
        }else if( Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )){
			$res = true;
		}
        return $res ;
	}

	public static function canAdminRoles($id, $role, $form = array() ){
		if(empty($form))
			$form = PHDB::findOne( Form::COLLECTION , array("_id"=>new MongoId($id)));

		$res = false;
		if( !empty($form["links"]) && 
			!empty($form["links"]["members"]) && 
			!empty($form["links"]["members"][Yii::app()->session["userId"]]) &&
			!empty($form["links"]["members"][Yii::app()->session["userId"]]["isAdmin"]) &&
			$form["links"]["members"][Yii::app()->session["userId"]]["isAdmin"] == true &&
			!empty($form["links"]["members"][Yii::app()->session["userId"]]["roles"]) &&
			in_array($role, $form["links"]["members"][Yii::app()->session["userId"]]["roles"]) ){
    		$res = true;
        }else if( Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )){
			$res = true;
		}

        return $res ;
	}

	public static function canSuperAdmin($id,$session, $form = array(), $formAdmin = array()){
		if(empty($form))
			$form = PHDB::findOne( Form::COLLECTION , array("id"=>$id,"session"=>$session));

		if(empty($formAdmin))
			$formAdmin = PHDB::findOne( Form::COLLECTION , array("id"=>$id."Admin","session"=>$session));
		if(@$formAdmin["adminRole"])
			$res = self::canAdminRoles((string)$form["_id"], $formAdmin["adminRole"], $form = array() ) ;
		else
			$res = false;
        return $res ;
	}

	public static function updatePriorisation($params ){

		$res = Link::removeRole($params["contextId"], $params["contextType"], $params["childId"], $params["childType"], @$params["roles"], Yii::app()->session['userId'], $params["connectType"]);

		$answer = PHDB::findOne(self::ANSWER_COLLECTION,array("_id"=>new MongoId($params["answer"])));
		$roles = explode(",", $params["roles"]);
		$pourcentage = round(100 / count($roles), 2);
		$categories = array() ;
		$priorisation = array() ;

		foreach ($roles as $key => $value) {
			$slug = InflectorHelper::slugify( $value ) ; 
			if(!empty($answer["categories"][$slug])){
				$categories[$slug] = $answer["categories"][$slug];
				if(!empty($answer["answers"]["priorisation"][$slug]))
					$priorisation[$slug] = $answer["answers"]["priorisation"][$slug];
			}else{
				$categories[$slug] = array( "name" => $value,"pourcentage" => $pourcentage);
			}
			

		}

		PHDB::update(self::ANSWER_COLLECTION,
						array("_id"=>new MongoId($params["answer"])),
						array('$set' => array("categories"=>$categories, "answers.priorisation"=>$priorisation))
					);

        return $res ;
	}



	public static function isFinish($form){
		$res = false;
		$today = date(DateTime::ISO8601, strtotime("now"));
		if(!empty($form["endDate"]) ){
			$endDate = date(DateTime::ISO8601, $form["endDate"]->sec);
			if($endDate < $today)
				$res = true;
		}
		return $res ;
	}

	

	

}
?>