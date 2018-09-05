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
			$ctrl->render("co2.views.default.loginSecure");
		else if( Form::canAdmin( $form["id"] ) || $user == Yii::app()->session["userId"])
		{ 
			$idProject = [];
			$projects = [] ;
			$formParent = PHDB::findOne( Form::COLLECTION, array( "id"=> $parentSurvey["id"] ), array("links"));
			//Rest::json($action["role"]); exit ;
			if(!empty($formParent["links"]["projectExtern"])){
				foreach ($formParent["links"]["projectExtern"] as $key => $value) {

					foreach ($action["role"] as $keyR => $valueR) {
						if(in_array($valueR, $value["roles"]))
							$idProject[] = new MongoId($key) ;
					}
					
				}

				if(!empty($idProject))
					$projects = PHDB::find(	Project::COLLECTION, 
											array( "_id" => array('$in' => $idProject)) );
			}

			
			
			//Rest::json($projects); 
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
			$this->getController()->render("co2.views.default.unauthorised"); 
    }
}

/*
- top menu base sur id et pas session
- reload on create FA 
- icon de la page http://127.0.0.1/ph/survey/co/roles/id/cte/role/eco-mobilits
*/