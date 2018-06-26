<?php
class AnswersAction extends CAction
{
    public function run($id)
    {
    	$this->getController()->layout = "//layouts/empty";
    	//if ( ! Person::logguedAndValid() ) {
    		$form = PHDB::findOne( Form::COLLECTION , array("id"=>$id));
    		
    		if( $form["surveyType"] == "surveyList" && @$answers = PHDB::find( Form::ANSWER_COLLECTION , array("parentSurvey"=>@$id) ))
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
			
		 // } else 
			//  echo "<h1>".Yii::t("common","Please Login First")."</h1>";
    }
}