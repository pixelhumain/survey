<?php
class LogsAction extends CAction
{
    public function run($id,$session="1",$user,$view=null)
    {
    	$ctrl = $this->getController();
    	$ctrl->layout = "//layouts/empty";
    	$form = PHDB::findOne( Form::COLLECTION , array("id"=>$id,"session"=>$session));

    	if ( ! Person::logguedAndValid() ) 
			$this->getController()->render("co2.views.default.unTpl",array("msg"=>Yii::t("common","Please Login First"),"icon"=>"fa-sign-in"));
		else if( Form::canAdmin( (string)$form["_id"], $form ) || $user == Yii::app()->session["userId"])
		{ 
    		$logs = $form = PHDB::find( Log::COLLECTION , array("params.session"=>$id));

		 	if(!count($logs)) 
		 		$logs = "no Logs not found"; 

		 	echo $ctrl->render( "logs" ,array(  "logs" => $logs,
		 										"answers"=> PHDB::find( Form::ANSWER_COLLECTION , array("parentSurvey"=>$id,"user"=>$user )) ));
			//} 
		} else 
			$this->getController()->render("co2.views.default.unTpl",array("msg"=>Yii::t("project", "Unauthorized Access."),"icon"=>"fa-lock"));
    }
}