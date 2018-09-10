<?php
class AnswerAction extends CAction
{
    public function run($id,$session="1",$user,$view=null)
    {
    	$ctrl = $this->getController();
    	$ctrl->layout = "//layouts/empty";
    	$form = PHDB::findOne( Form::COLLECTION , array("id"=>$id));

    	if ( ! Person::logguedAndValid() ) 
			$ctrl->render("co2.views.default.unTpl",array("msg"=>Yii::t("common","Please Login First"),"icon"=>"fa-sign-in"));
		else if( Form::canAdmin( (string)$form["_id"], $form ) || $user == Yii::app()->session["userId"])
		{ 
			if(!@$form["session"][$session])
	 				$ctrl->render("co2.views.default.unTpl",array("msg"=>"Session introuvable sur ".$id,"icon"=>"fa-search")); 

    		if( $form["surveyType"] == "surveyList" && @$answers = PHDB::find( Form::ANSWER_COLLECTION , array("parentSurvey"=>@$id, "user" => @$user ) ) )
    		{
				$adminAnswers = PHDB::findOne( Form::ANSWER_COLLECTION , array("formId"=>@$id,"session"=>$session, "user"=> @$user) );
				// $adminForm = ( Form::canAdmin($form["id"]) ) ? PHDB::findOne( Form::COLLECTION , array("id"=>$id."Admin") ) : PHDB::findOne( Form::COLLECTION , array("id"=>$id."Admin"), array("scenarioAdmin") ) ;

				$adminForm = ( Form::canAdmin((string)$form["_id"]) ) ? PHDB::findOne( Form::COLLECTION , array("id"=>$id."Admin") ) : null ;


				$userO = Person::getById($user);
				if( !@$adminAnswers ){
					$adminAnswers = array(
						"formId" => $id,
					    "user" 	 => $user,
					    "name"   => $userO["name"],
					);
					if(@$adminForm["scenarioAdmin"])
						$adminAnswers["step"] = array_keys( $adminForm["scenarioAdmin"] )[1];
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
	 		else if( @$id & @$answer = PHDB::findOne( Form::ANSWER_COLLECTION , array("formId"=>$id ) ) )
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