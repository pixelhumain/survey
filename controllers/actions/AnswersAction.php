<?php
class AnswersAction extends CAction
{
    public function run($id)
    {
    	$this->getController()->layout = "//layouts/empty";

        $form = PHDB::findOne( Form::COLLECTION , array("id"=>$id));
    	if ( ! Person::logguedAndValid() ) {
            $this->getController()->render("co2.views.default.loginSecure");
        }else if(	Yii::app()->session["userId"] == $form["author"] ||
					(	!empty($form["links"]["forms"][Yii::app()->session["userId"]]) && 
						!empty($form["links"]["forms"][Yii::app()->session["userId"]]["isAdmin"]) &&
						$form["links"]["forms"][Yii::app()->session["userId"]]["isAdmin"] == true)){ 
    		if( $form["surveyType"] == "surveyList" && 
                @$answers = PHDB::find( Form::ANSWER_COLLECTION , 
                						array("parentSurvey"=>@$id, 
            									"answers.project" => array('$exists' => 1) ) ) ) {

    			//Rest::json($answers); exit ;

    			$results = Form::listForAdmin($answers);
    			//Rest::json($results); exit ;
	 			echo $this->getController()->render("answersList",
	 												array(  "results" => $results,
												 			"form"=> $form ));

	 		} else if(@$answers = PHDB::find( Form::ANSWER_COLLECTION , array("formId"=>@$id) )){
		 		echo $this->getController()->render("answers",array( 
													 			"results" => $answers,
													 			"form"=> $form ));
	 		} 
		 	else 
		 		echo "No answers found"; 
		} else 
			$this->getController()->render("co2.views.default.unauthorised"); 
    }
}