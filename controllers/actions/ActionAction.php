<?php
class ActionAction extends CAction
{
    public function run($id)
    {
    	$ctrl = $this->getController();
    	$ctrl->layout = "//layouts/empty";
    	$action = PHDB::findOne( Action::COLLECTION , array("_id"=>new MongoId($id)));
    	$form = PHDB::findOne( $action["parentTypeSurvey"] , array("id"=>$action["parentIdSurvey"]));

    	if ( ! Person::logguedAndValid() ) 
			$ctrl->render("co2.views.default.loginSecure");
		else if( Form::canAdmin( $form["id"], $form ) || $user == Yii::app()->session["userId"])
		{ 
    		
    			$ctrl->layout = "//layouts/empty";	
    			$params = array( 'action' => $action,
    							'form' => $form );
	 			echo $ctrl->render( "action" ,$params);
    		
		} else 
			$this->getController()->render("co2.views.default.unauthorised"); 
    }
}