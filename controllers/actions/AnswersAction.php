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
				$answers = PHDB::find( Form::ANSWER_COLLECTION , 
										array( "formId" => @$id ) );


				$results = Form::listForAdmin($answers) ;


				$userAdminAnswer = array();

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