<?php
class ActionAction extends CAction
{
    public function run($id,$aid)
    {
    	$ctrl = $this->getController();
    	$ctrl->layout = "//layouts/empty";
    	$action = PHDB::findOne( Action::COLLECTION , array("_id"=>new MongoId($aid)));
    	
    	$user = Person::getById($action["creator"]);
    	$parentSurvey = PHDB::findOne( $action["parentTypeSurvey"] , array("_id"=>new MongoId($action["parentIdSurvey"])));
    	$form = PHDB::findOne( Form::COLLECTION , array( "id"=> $parentSurvey["id"]."Admin" ));
    	// var_dump( $form );
    	// var_dump(Form::canAdmin( $form["id"], $form ) );
    	// var_dump(( $user == Yii::app()->session["userId"] )); exit;
    	if ( ! Person::logguedAndValid() ) 
			$this->getController()->render("co2.views.default.unTpl",array("msg"=>Yii::t("common","Please Login First"),"icon"=>"fa-sign-in"));
		else if( Form::canAdmin( (string)$parentSurvey["_id"]) || $user == Yii::app()->session["userId"])
		{ 
			$idProject = [];
			$projects = [] ;
			$formParent = PHDB::findOne( Form::COLLECTION, array( "id"=> $parentSurvey["id"] ), array("links"));
			//Rest::json($action["role"]); exit ;
			// if(!empty($formParent["links"]["projectExtern"])){

			// 	foreach ($formParent["links"]["projectExtern"] as $key => $value) {
			// 		foreach ($action["role"] as $keyR => $valueR) {
			// 			if(in_array(trim ($valueR), $value["roles"]))
			// 				$idProject[] = new MongoId($key) ;
			// 		}
					
			// 	}
				
			// 	if(!empty($idProject))
			// 		$projects = PHDB::find(	Project::COLLECTION, 
			// 								array( "_id" => array('$in' => $idProject)) );
			// }

			if(!empty($action["role"])){
				$where = array();
				foreach ($action["role"] as $keyR => $valueR) {
					$where["categories.".$keyR.".name"] = $valueR;
				}
				
				$projectsA = null ;
				if(!empty($where))
					$projectsA = PHDB::find(Form::ANSWER_COLLECTION, $where );
				//Rest::json($projectsA); exit ;
				if(!empty($projectsA)){
					foreach ($projectsA as $key => $value) {

						if( !empty($value["answers"]["cte2"]["answers"]["project"]) ) {
							$projects[$value["answers"]["cte2"]["answers"]["project"]["id"]] = $value["answers"]["cte2"]["answers"]["project"]["name"];
						}
					}

				}


			}

			$params = array( "answers" => $action, 
							 'answerCollection' => "actions",
							 'answerId' => (string)$action["_id"] ,
							 "parentSurvey"=>$parentSurvey,
							 'form' => $form ,
							 'projects' => $projects,
							 "user" => $user,
							 'scenario' => "scenarioFicheAction" );
			//todo apply cte customisation ???
			
 			echo $ctrl->render( "action" , $params);
		} else 
			$this->getController()->render("co2.views.default.unTpl",array("msg"=>Yii::t("project", "Unauthorized Access."),"icon"=>"fa-lock"));
    }
}

/*
- top menu base sur id et pas session
- reload on create FA 
- icon de la page http://127.0.0.1/ph/survey/co/roles/id/cte/role/eco-mobilits
*/