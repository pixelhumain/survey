<?php
class AnswersAction extends CAction{
	public function run($id,$session="1",$role=null){
		$ctrl = $this->getController();
		$ctrl->layout = "//layouts/empty";

		$form = PHDB::findOne( Form::COLLECTION , array("id"=>$id));
		if ( ! Person::logguedAndValid() ) {
			$ctrl->render("co2.views.default.unTpl",array("msg"=>Yii::t("common","Please Login First"),"icon"=>"fa-sign-in"));
		} else if( Form::canAdmin((string)$form["_id"], $form) ){ 
			
			if(!@$form["session"][$session])
                $ctrl->render("co2.views.default.unTpl",array("msg"=>"Session introuvable sur ".$id,"icon"=>"fa-search")); 

			if( $form["surveyType"] == "surveyList" )  {
				$where = array();

				if( !empty( $form["links"]["members"][Yii::app()->session["userId"]]["roles"] ) || Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) ) ){
					if( (!empty( $form["links"]["members"][Yii::app()->session["userId"]]["roles"] ) && in_array("TCO", $form["links"]["members"][Yii::app()->session["userId"]]["roles"]) ) || Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) ) ){
						$where = array("formId" => @$id);
					}else{
						$or = array();
						foreach ($form["links"]["members"][Yii::app()->session["userId"]]["roles"] as $key => $value) {

							$or[] = array("categories.".InflectorHelper::slugify( $value ) => array('$exists' => 1));
						}
						$where = array('$and' => array(
										array("formId" => @$id),
										array('$or' => $or)
									));
					}

				}

				//Rest::json($where); exit;

				if(!empty($where))
					$answers = PHDB::find( Form::ANSWER_COLLECTION , $where );
				else
					$answers =array();

				//Rest::json($answers); exit;
				$results = Form::listForAdmin($answers) ;


				$userAdminAnswer = array();

				$page  = ( @$form["custom"]["answersTpl"] ) ? $form["custom"]["answersTpl"] : "answersList";
	 			$ctrl->render($page, array( "results" => $results,
										 			"form"=> $form,
										 			"userAdminAnswer" => $userAdminAnswer,
										 			"roles" => $form["custom"]["roles"] ));

	 		} else if(@$answers = PHDB::find( Form::ANSWER_COLLECTION , array("formId"=>@$id) )){
	 			
	 			$page  = ( @$form["custom"]["answersTpl"] ) ? $form["custom"]["answersTpl"] : "answers";
		 		
		 		$ctrl->render($page,array( 
						 			"results" => $answers,
						 			"form"=> $form ));
	 		} 
		 	else 
		 		$ctrl->render("co2.views.default.unTpl",array("msg"=>"No Answers Found","icon"=>"fa-search"));
		} else 
			$ctrl->render("co2.views.default.unTpl",array("msg"=>Yii::t("project", "Unauthorized Access."),"icon"=>"fa-lock"));
	}
}