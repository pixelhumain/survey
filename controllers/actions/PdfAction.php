<?php
class PdfAction extends CTKAction{
	public function run($id){
		// $id = "cte" ;
		// $user = "5ac4c5536ff9928b248b458a";
		// $session = "1";
		$controller=$this->getController();
		// $form = PHDB::findOne( Form::COLLECTION , array("id"=>$id));
		// $forms = PHDB::find( Form::COLLECTION , array("parentSurvey"=>$id));
		// foreach ($forms as $k => $v) {
		// 	$form["scenario"][$v["id"]]["form"] = $v;
		// }
		// $adminAnswers = PHDB::findOne( Form::ANSWER_COLLECTION , array("formId"=>$id ,"session"=>$session, "user"=> $user) );

		// $answers = PHDB::find( Form::ANSWER_COLLECTION , array("parentSurvey"=>$id,"session"=>$session, "user"=> $user ) ) ;
		// foreach ($answers as $k => $v) {
		// 	$answers[$v["formId"]] = $v;
		// }

		// $adminForm = ( Form::canAdmin((string)$form["_id"], $form) ) ? PHDB::findOne( Form::COLLECTION , array("id"=>$id."Admin") ) : PHDB::findOne( Form::COLLECTION , array("id"=>$id."Admin"), array("scenarioAdmin") ) ;

		
		// $userO = Person::getById($user);

		



		$answer = PHDB::findOne( Form::ANSWER_COLLECTION, array("_id"=>new MongoId($id)));
		$form = PHDB::findOne( Form::COLLECTION , array("id"=>$answer["formId"]));
		$forms = PHDB::find( Form::COLLECTION , array("parentSurvey"=>$answer["formId"]));

		foreach ($forms as $key => $value) {
			$forms[$value["id"]] = $value;
		}

		//Rest::json($forms); exit;

		$title = ( @$answer["answers"]["cte2"]["answers"]["project"]  ) ?  $answer["answers"]["cte2"]["answers"]["project"]["name"] : "Dossier";

		$params = array(
			"author" => @$answer["name"],
			"answer" => $answer,
			"title" => $title,
			"subject" => "CTE",
			"custom" => $form["custom"],
			"footer" => true,
			"tplData" => "cteDossier",
			"form" => $form,
			"forms" => $forms
		);

		$html = $controller->renderPartial('application.views.pdf.dossierCte', $params, true);

		$params["html"] = $html ;
		Pdf::createPdf($params);
		
	}
}