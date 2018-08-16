<?php
class LogsAction extends CAction
{
    public function run($id,$user,$view=null)
    {
    	$ctrl = $this->getController();
    	$ctrl->layout = "//layouts/empty";
    	$form = PHDB::findOne( Form::COLLECTION , array("id"=>$id));

    	if ( ! Person::logguedAndValid() ) 
			$ctrl->render("co2.views.default.loginSecure");
		else if( Form::canAdmin( $id, $form ) || $user == Yii::app()->session["userId"])
		{ 
    		$logs = $form = PHDB::find( Log::COLLECTION , array("params.session"=>$id));

		 	if(!count($logs)) 
		 		$logs = "no Logs not found"; 

		 	echo $ctrl->render( "logs" ,array(  "logs" => $logs,
		 										"answers"=> PHDB::find( Form::ANSWER_COLLECTION , array("parentSurvey"=>$id,"user"=>$user )) ));
			//} 
		} else 
			$this->getController()->render("co2.views.default.unauthorised"); 
    }
}