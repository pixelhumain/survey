<?php
class AnswersAction extends CAction{
	public function run($id,$session="1",$role=null){
		$this->getController()->layout = "//layouts/empty";

		$form = PHDB::findOne( Form::COLLECTION , array("id"=>$id,"session"=>$session));
		if ( ! Person::logguedAndValid() ) {
			$this->getController()->render("co2.views.default.loginSecure");
		}else if(Form::canAdmin((string)$form["_id"], $form)){ 
			
			if( $form["surveyType"] == "surveyList" )  {
				// $answers = PHDB::find( Form::ANSWER_COLLECTION , 
				// 						array("parentSurvey"=>@$id, 
				// 								"answers.project" => array('$exists' => 1) ) );

				$answers = PHDB::find( Form::ANSWER_COLLECTION , 
										array( "parentSurvey" => @$id, 
											   "answers" => array('$exists' => 1) ) );
				$adminAnswers = PHDB::find( Form::ANSWER_COLLECTION , array( "formId" => @$id ));
				$userAdminAnswer = array();
				foreach ($adminAnswers as $key => $value) {
					$userAdminAnswer[ $value["user"] ] = $value;
				}
				$results = ( empty($answers) ? array() : Form::listForAdminNews($form, $answers) );

	 			echo $this->getController()->render("answersList",
	 												array(  "results" => $results,
												 			"form"=> $form,
												 			"userAdminAnswer" => $userAdminAnswer,
												 			"roles" => $form["custom"]["roles"] ));

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