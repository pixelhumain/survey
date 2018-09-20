<?php
class LogsAction extends CAction
{
    public function run($id,$view=null)
    {
    	$ctrl = $this->getController();
    	$ctrl->layout = "//layouts/empty";
    	$answer = PHDB::findOne( Form::ANSWER_COLLECTION, array("_id"=>new MongoId($id)));
    	$form = PHDB::findOne( Form::COLLECTION , array("id"=>$answer["formId"]));

    	if ( ! Person::logguedAndValid() ) 
			$this->getController()->render("co2.views.default.unTpl",array("msg"=>Yii::t("common","Please Login First"),"icon"=>"fa-sign-in"));
		else if( Form::canAdmin( (string)$answer["formId"], $form ) || $user == Yii::app()->session["userId"])
		{ 

			if(!@$form["session"][$answer["session"]])
                $ctrl->render("co2.views.default.unTpl",array("msg"=>"Session introuvable sur ".$id,"icon"=>"fa-search"));

    		$logs = PHDB::find( Log::COLLECTION , array("params.id"=>$id));

		 	if(!count($logs)) 
		 		$logs = "no Logs not found"; 

		 	$ctrl->render( "logs" ,array(  "logs" => $logs,
		 								"answers"=> PHDB::find( Form::ANSWER_COLLECTION , array("parentSurvey"=>$answer["formId"],"user"=>$answer["user"] )) ));
			//} 
		} else 
			$this->getController()->render("co2.views.default.unTpl",array("msg"=>Yii::t("project", "Unauthorized Access."),"icon"=>"fa-lock"));
    }
}