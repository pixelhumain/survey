<?php
class AnswerAction extends CAction
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
    		if( $form["surveyType"] == "surveyList" && @$answers = PHDB::find( Form::ANSWER_COLLECTION , array("parentSurvey"=>@$id, "user" => @$user ) ) )
    		{
				$adminAnswers = PHDB::findOne( Form::ANSWER_COLLECTION , array("formId"=>@$id, "user"=> @$user) );
				$adminForm = ( Form::canAdmin($form["id"]) ) ? PHDB::findOne( Form::COLLECTION , array("id"=>$id."Admin") ) : null;
				$userO = Person::getById($user);
				if( !@$adminAnswers ){
					$adminAnswers = array(
						"formId" => $id,
					    "user" 	 => $user,
					    "name"   => $userO["name"],
					    "step"   => array_keys( $adminForm["scenarioAdmin"] )[1]
					);
				}
    			
    			$ctrl->layout = "//layouts/empty";	
    			foreach ($answers as $k => $v) {
    				$answers[$v["formId"]] = $v;
    			}

    			$forms = PHDB::find( Form::COLLECTION , array("parentSurvey"=>$id));
    			foreach ($forms as $k => $v) {
    				$form["scenario"][$v["id"]]["form"] = $v;
    			}
    			$params = array( 
		 			"answers" 		=> $answers,
		 			"form"    		=> $form,
		 			"user"	  		=> $userO,
		 			"adminAnswers"	=> $adminAnswers,
		 			"adminForm" 	=> $adminForm,
		 			"roles" 		=> @Yii::app()->session["custom"]["roles"] );

    			if( in_array( $adminAnswers["step"] , array( "risk","ficheAction" ) ) )
    			{
    				$params["riskCatalog"] = PHDB::find( "risks" , array("type"=>array('$ne'=>'riskTypes')) );
    				$params["riskTypes"] = array();
    				foreach ($params["riskCatalog"] as $k => $v) {
    					if(!in_array($v["type"], $params["riskTypes"]) ) 
    						$params["riskTypes"][] = $v["type"];
    				}
    			}
	 			echo $ctrl->render( "answerList" ,$params);
    		}
	 		else if( @$answer = PHDB::findOne( Form::ANSWER_COLLECTION , array("_id"=>new MongoId($id) ) ) )
	 		{
	 			if( !$view ){
		 			$ctrl->layout = "//layouts/empty";	
		 			echo $ctrl->render( "answer" ,array( 
								 			"answer" => $answer,
								 			"form"   => $form ));
		 		} else {
		 			echo $ctrl->renderPartial( $view ,array( 
								 			"answer" => $answer,
								 			"form"   => $form ));
		 		}
	 		}
		 	else 
		 		echo "Answer not found"; 
			//} 
		} else 
			$this->getController()->render("co2.views.default.unauthorised"); 
    }
}