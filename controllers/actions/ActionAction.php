<?php
class ActionAction extends CAction
{
    public function run($id)
    {
    	$ctrl = $this->getController();
    	$ctrl->layout = "//layouts/empty";
    	$action = PHDB::findOne( Action::COLLECTION , array("_id"=>new MongoId($id)));
    	$parentSurvey = PHDB::findOne( $action["parentTypeSurvey"] , array("_id"=>new MongoId($action["parentIdSurvey"])));
    	$form = PHDB::findOne( Form::COLLECTION , array( "id"=> $parentSurvey["id"]."Admin" ));

    	if ( ! Person::logguedAndValid() ) 
			$ctrl->render("co2.views.default.loginSecure");
		else if( Form::canAdmin( $form["id"], $form ) || $user == Yii::app()->session["userId"])
		{ 
			
			$params = array( "answers" => $action, 
							 'answerCollection' => "actions",
							 'answerId' => (string)$action["_id"] ,
							 'form' => $form ,
							 "user" => Person::getById( $action["creator"]),
							 'scenario' => "scenarioFicheAction" );
			//todo apply cte customisation ???
			
 			echo $ctrl->render( "action" , $params);
		} else 
			$this->getController()->render("co2.views.default.unauthorised"); 
    }
}

/*
- top menu 
- reload on create FA 
- check FA in espace CO 
- icon de la page http://127.0.0.1/ph/survey/co/roles/id/cte/role/eco-mobilits
*/