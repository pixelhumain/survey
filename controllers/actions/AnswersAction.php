<?php
class AnswersAction extends CAction{
	public function run($id,$session="1",$role=null){
		$ctrl = $this->getController();
		$ctrl->layout = "//layouts/empty";

		$form = PHDB::findOne( Form::COLLECTION , array("id"=>$id));
		if ( ! Person::logguedAndValid() ) {
			$ctrl->render("co2.views.default.unTpl",array("msg"=>Yii::t("common","Please Login First"),"icon"=>"fa-sign-in"));
		}else if(Form::canAdmin((string)$form["_id"], $form)){ 
			
			if(!@$form["session"][$session])
                $ctrl->render("co2.views.default.unTpl",array("msg"=>"Session introuvable sur ".$id,"icon"=>"fa-search")); 

			if( $form["surveyType"] == "surveyList" )  {
				// $answers = PHDB::find( Form::ANSWER_COLLECTION , 
				// 						array("parentSurvey"=>@$id, 
				// 								"answers.project" => array('$exists' => 1) ) );

				$answers = PHDB::find( Form::ANSWER_COLLECTION , 
										array( "parentSurvey" => @$id, 
											   "answers" => array('$exists' => 1) ) );
				$adminAnswers = PHDB::find( Form::ANSWER_COLLECTION , array( "formId" => @$id ));

				$adminAnswers2 = PHDB::find( Form::ANSWER_COLLECTION , array( "parentSurvey" => @$id ));

				$userAdminAnswer = array();
				foreach ($adminAnswers as $key => $value) {
					$userAdminAnswer[ $value["user"] ] = $value;

					foreach ($adminAnswers2 as $key2 => $value2) {
						if($value["user"] ==  $value2["user"] && in_array($value2["formId"], array("cte1", "cte2", "cte3")) ){
							if(empty($userAdminAnswer[ $value["user"] ]["scenario"]))
								$userAdminAnswer[ $value["user"] ]["scenario"] = array();

							$userAdminAnswer[ $value["user"] ]["scenario"][$value2["formId"]] = $value2["answers"] ;
						}
					}
				}

				// $userAdminAnswer = array();
				// foreach ($answers as $key => $value) {

				// 	if()
				// 	$userAdminAnswer[ $value["user"] ] = $value;

				// 	foreach ($adminAnswers2 as $key2 => $value2) {
				// 		if($value["user"] ==  $value2["user"] && in_array($value2["formId"], array("cte1", "cte2", "cte3")) ){
				// 			if(empty($userAdminAnswer[ $value["user"] ]["scenario"]))
				// 				$userAdminAnswer[ $value["user"] ]["scenario"] = array();

				// 			$userAdminAnswer[ $value["user"] ]["scenario"][$value2["formId"]] = $value2["answers"] ;
				// 		}
				// 	}
				// }
				
				$results = ( empty($answers) ? array() : Form::listForAdminNews($form, $answers) );
				//Rest::json($userAdminAnswer); exit ;
	 			$ctrl->render("answersList",
 												array(  "results" => $results,
											 			"form"=> $form,
											 			"userAdminAnswer" => $userAdminAnswer,
											 			"roles" => $form["custom"]["roles"] ));

	 		} else if(@$answers = PHDB::find( Form::ANSWER_COLLECTION , array("formId"=>@$id) )){
		 		$ctrl->render("answers",array( 
													 			"results" => $answers,
													 			"form"=> $form ));
	 		} 
		 	else 
		 		echo "No answers found"; 
		} else 
			$ctrl->render("co2.views.default.unTpl",array("msg"=>Yii::t("project", "Unauthorized Access."),"icon"=>"fa-lock"));
	}
}