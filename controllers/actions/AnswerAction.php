<?php
class AnswerAction extends CAction
{
    public function run($id,$view=null)
    {
    	$ctrl = $this->getController();
    	$ctrl->layout = "//layouts/empty";

    	$form = PHDB::findOne( Form::COLLECTION , array("id"=>$id));
 ///test commit 
    	
    	if ( ! Person::logguedAndValid() ) 
			$ctrl->render("co2.views.default.unTpl",array("msg"=>Yii::t("common","Please Login First"),"icon"=>"fa-sign-in"));
		else if( Form::canAdmin( (string)$form["_id"], $form ) || $user == Yii::app()->session["userId"])
		{ 
			if(!@$form["session"][ $answer["session"] ])
	 				$ctrl->render("co2.views.default.unTpl",array("msg"=>"Session introuvable sur ".$answer["formId"],"icon"=>"fa-search")); 

    		if( $form["surveyType"] == "surveyList" && @$answer["answers"] )
    		{
				$adminForm = ( Form::canAdmin((string)$form["_id"], $form) ) 
								? PHDB::findOne( Form::COLLECTION , array("id"=>$answer["formId"]."Admin","session"=>$answer["session"] ) ) 
								: PHDB::findOne( Form::COLLECTION , array("id"=>$answer["formId"]."Admin","session"=>$answer["session"] ), array("scenarioAdmin") ) ;


				//$userO = Person::getById($answer["user"]);

				//$adminForm = ( Form::canAdmin((string)$form["_id"]) ) ? PHDB::findOne( Form::COLLECTION , array("id"=>$id."Admin","session"=>$session) ) : null ;


				$userO = Person::getById($user);
				if( !@$adminAnswers ){
					$adminAnswers = array(
						"formId" => $answer["formId"],
					    "user" 	 => $answer["user"],
					    "name"   => $userO["name"],
					);
					if(@$adminForm["scenarioAdmin"] && Form::canAdmin((string)$form["_id"], $form) )
						$adminAnswers["step"] = array_keys( $adminForm["scenarioAdmin"] )[1];
				}
    			
    			$ctrl->layout = "//layouts/empty";	
    			

    			$forms = PHDB::find( Form::COLLECTION , array("parentSurvey"=>$answer["formId"]));
    			foreach ($forms as $k => $v) {
    				$form["scenario"][$v["id"]]["form"] = $v;
    			}
    			$params = array( 
    				"session" 		=> $answer["session"],
		 			"answer" 		=> $answer,
		 			"form"    		=> $form,
		 			"user"	  		=> $userO,
		 			"adminForm" 	=> $adminForm,
		 			"roles" 		=> @Yii::app()->session["custom"]["roles"] );

    			if( in_array( @$adminAnswers["step"] , array( "risk","ficheAction" ) ) )
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
	 		else if( @$answer["formId"] && @$answer["answers"] )
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
		 		$ctrl->render("co2.views.default.unTpl",array("msg"=>"Answer not found","icon"=>"fa-search")); 
			//} 
		} else 
			$ctrl->render("co2.views.default.unTpl",array("msg"=>Yii::t("project", "Unauthorized Access."),"icon"=>"fa-lock"));
    }
}