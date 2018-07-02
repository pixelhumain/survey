<?php
class AnswersAction extends CAction
{
    public function run($id)
    {
    	$this->getController()->layout = "//layouts/empty";
        $form = PHDB::findOne( Form::COLLECTION , array("id"=>$id));
    	if ( ! Person::logguedAndValid() ) {
            $this->getController()->render("co2.views.default.loginSecure");
        }else if( $form["author"] != Yii::app()->session["userId"] ){
            $this->getController()->render("co2.views.default.unauthorised");
        } else {
    		
    		
    		if( $form["surveyType"] == "surveyList" && 
                @$answers = PHDB::find( Form::ANSWER_COLLECTION , array("parentSurvey"=>@$id) ))
    		{
    			$results = array();
    			$uniq = array();
    			foreach ( $answers as $key => $value) 
    			{
    				if(!in_array( $value["user"], $uniq ))
    				{
    					$results[] = $value;
    					$uniq[] = $value["user"];
    				}
    			}
	 			echo $this->getController()->render("answersList",array( 
														 			"results" => $results,
														 			"form"=> $form ));

	 		} else if(@$answers = PHDB::find( Form::ANSWER_COLLECTION , array("formId"=>@$id) )){
		 		echo $this->getController()->render("answers",array( 
													 			"results" => $answers,
													 			"form"=> $form ));
	 		} 
		 	else 
		 		echo "No answers found"; 
			
		  } 
    }
}