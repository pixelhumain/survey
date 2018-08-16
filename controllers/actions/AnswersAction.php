<?php
class AnswersAction extends CAction{
	public function run($id){
		$this->getController()->layout = "//layouts/empty";

		$form = PHDB::findOne( Form::COLLECTION , array("id"=>$id));
		if ( ! Person::logguedAndValid() ) {
			$this->getController()->render("co2.views.default.loginSecure");
		}else if(Form::canAdmin($id, $form)){ 
			
			if( $form["surveyType"] == "surveyList" )  {
				// $answers = PHDB::find( Form::ANSWER_COLLECTION , 
				// 						array("parentSurvey"=>@$id, 
				// 								"answers.project" => array('$exists' => 1) ) );

				$answers = PHDB::find( Form::ANSWER_COLLECTION , 
										array("parentSurvey"=>@$id, 
												"answers" => array('$exists' => 1) ) );
				$results = ( empty($answers) ? array() : Form::listForAdminNews($form, $answers) );

	 			echo $this->getController()->render("answersList",
	 												array(  "results" => $results,
												 			"form"=> $form,
												 			"roles" => @Yii::app()->session["custom"]["roles"] ));

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