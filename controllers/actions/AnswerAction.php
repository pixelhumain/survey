<?php
class AnswerAction extends CAction
{
    public function run($id,$user,$view=null)
    {
    	if ( Person::logguedAndValid() ) {
    		$form = PHDB::findOne( Form::COLLECTION , array("id"=>$id));
    		//todo check if user id authorised 
    			//only admins and user can review an answer
    			//Form::isAuthorised($user)
			if($user != Yii::app()->session["userId"] && Yii::app()->session["userId"] != $form["author"] ){
				$this->getController()->layout = "//layouts/empty";	
				$this->getController()->render("unauthorised");
			} else {
	    		if( $form["surveyType"] == "surveyList" && @$answers = PHDB::find( Form::ANSWER_COLLECTION , array("parentSurvey"=>@$id, "user"=>@$user) )){


		    			$user = Person::getById($user);
		    			$this->getController()->layout = "//layouts/empty";	
		    			foreach ($answers as $k => $v) {
		    				$answers[$v["formId"]] = $v;
		    			}
		    			$forms = PHDB::find( Form::COLLECTION , array("parentSurvey"=>$id));
		    			foreach ($forms as $k => $v) {
		    				$form["scenario"][$v["id"]]["form"] = $v;
		    			}
			 			echo $this->getController()->render( "answerList" ,array( 
									 			"answers" => $answers,
									 			"form"    => $form,
									 			"user"	  => $user ));

	    		}
		 		else if( @$answer = PHDB::findOne( Form::ANSWER_COLLECTION , array("_id"=>new MongoId($id) ) ) ){
		 			
		 			if( !$view ){
			 			$this->getController()->layout = "//layouts/empty";	
			 			echo $this->getController()->render( "answer" ,array( 
									 			"answer" => $answer,
									 			"form"   => $form ));
			 		} else {
			 			echo $this->getController()->renderPartial( $view ,array( 
									 			"answer" => $answer,
									 			"form"   => $form ));
			 		}
		 		}
			 	else 
			 		echo "Answer not found"; 
			} 
		} else {
				$this->getController()->layout = "//layouts/empty";	
				echo Yii::t("common","Please Login First");
			}
    }
}