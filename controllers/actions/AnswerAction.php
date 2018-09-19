<?php
class AnswerAction extends CAction
{
    public function run($id,$view=null)
    {
    	$ctrl = $this->getController();
    	$ctrl->layout = "//layouts/empty"; 
    	$answer = PHDB::findOne( Form::ANSWER_COLLECTION, array("_id"=>new MongoId($id)));
    	$form = PHDB::findOne( Form::COLLECTION , array("id"=>$answer["formId"]));

    	if ( ! Person::logguedAndValid() ) 
			$ctrl->render("co2.views.default.unTpl",array("msg"=>Yii::t("common","Please Login First"),"icon"=>"fa-sign-in"));
		else if( Form::canAdmin( (string)$form["_id"], $form ) || $answer["user"] == Yii::app()->session["userId"])
		{ 
			if(!@$form["session"][ $answer["session"] ])
	 				$ctrl->render("co2.views.default.unTpl",array("msg"=>"Session introuvable sur ".$answer["formId"],"icon"=>"fa-search")); 

	 		$this->getController()->pageTitle = @$answer["name"];
    		if( $form["surveyType"] == "surveyList" && @$answer["answers"] )
    		{
				$adminForm = ( Form::canAdmin((string)$form["_id"], $form) ) 
								? PHDB::findOne( Form::COLLECTION , array("id"=>$answer["formId"]."Admin" ) ) 
								: PHDB::findOne( Form::COLLECTION , array("id"=>$answer["formId"]."Admin" ), array("scenarioAdmin") ) ;

				$userO = Person::getById($answer["user"]);
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

    			if( in_array( @$answer["step"] , array( "risk","ficheAction" ) ) )
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