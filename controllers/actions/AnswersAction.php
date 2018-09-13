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
										array( "formId" => @$id ) );

				//Rest::json($answers); exit ;
				$results = Form::listForAdmin($answers) ;


				$userAdminAnswer = array();
				// foreach ($answers as $key => $value) {
				// 	$userAdminAnswer[ $value["user"] ] = $value;
				// }
				
				// Rest::json($userAdminAnswer); exit ;
				//Rest::json($results); exit ;
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
		 		$ctrl->render("co2.views.default.unTpl",array("msg"=>Yii::t("project", "No answers found"),"icon"=>"fa-search")); 
		} else 
			$ctrl->render("co2.views.default.unTpl",array("msg"=>Yii::t("project", "Unauthorized Access."),"icon"=>"fa-lock"));
	}
}