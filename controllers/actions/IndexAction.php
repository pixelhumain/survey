<?php
class IndexAction extends CAction
{
    public function run($id=null,$session=null)
    {
    	$this->getController()->layout = "//layouts/empty";
    	if( @$id )
    	{
	 		if(@$form = PHDB::findOne( Form::COLLECTION , array("id"=>$id) )){

	 			$this->getController()->pageTitle = @$form["seo"]["title"];
				$this->getController()->keywords = @$form["seo"]["keywords"];
				
				$form["t"] = time();
	 			//pour etre sur qu'on passe par le process dans CO pour enregistrer on decodera le hash dans l'autre sens 
	 			$form["h"] = hash('sha256', $form["t"].Yii::app()->params["idOpenAgenda"] );
	 			
	 			$answers = array();
	 			if ( @$session){

	 				$answers[$session] = PHDB::find( Form::ANSWER_COLLECTION , array("parentSurvey"=>$id,"session"=>$session,"user"=> @Yii::app()->session["userId"] ) );
	 			} else {
	 				//si pas de session fourni on liste toute les 
	 				if(@$form["session"]){
			 			foreach ($form["session"] as $s => $sv) {
				 			$answers[$s] = PHDB::find( Form::ANSWER_COLLECTION , array("formId"=>$id,"session"=>(string)$s,"user"=> @Yii::app()->session["userId"] ) );
				 			if( $form["surveyType"] == "surveyList" || @$form["parentSurvey"] ){
				 				$pId = (@$form["parentSurvey"] ) ? $form["parentSurvey"]  : $id;
				 				$answers[$s] = PHDB::find( Form::ANSWER_COLLECTION , array("parentSurvey"=>$pId,"session"=>(string)$s, "user"=> @Yii::app()->session["userId"] ) );	 				
				 			}
				 		}
				 	} 
				 	//si on est sur un form child du scenario
				 	//on a forcement la session qui est transmise donc on est dans le if 
			 	}

	 			$startDate = null;
	 			$endDate = null;

	 			//si on est sur un child form
	 			$sessionExist = false;
	 			if( @$form["parentSurvey"] ){
	 				$form["parentSurvey"] = PHDB::findOne( Form::COLLECTION , array("id"=>$form["parentSurvey"]) );
	 				if($form["parentSurvey"]["session"][$session]){
	 					$sessionExist = true;
		 				if(@$form["parentSurvey"]["session"][$session]["startDate"])
		 					$startDate = $form["parentSurvey"]["session"][$session]["startDate"];
		 				if(@$form["parentSurvey"]["session"][$session]["endDate"])
		 					$endDate = $form["parentSurvey"]["session"][$session]["endDate"];
		 			}
	 			} else {
	 				//sinon on est sur le form parent, point de départ d'un survey
 					$sessionExist = true;
	 				if(@$form["session"][$session]["startDate"])
	 					$startDate = $form["session"][$session]["startDate"];
	 				if(@$form["session"][$session]["endDate"])
	 					$endDate = $form["session"][$session]["endDate"];
		 			
	 			}

	 			$params = array( "form"    => $form, 
	 							 "answers" => $answers );
	 			if($startDate)
	 				$params["startDate"] = $startDate;
	 			if($endDate)
	 				$params["endDate"] = $endDate;

	 			if(!$sessionExist)
	 				$this->getController()->render("co2.views.default.unTpl",array("msg"=>"Session introuvable sur ".$id,"icon"=>"fa-search")); 
	 			else 
		 			echo $this->getController()->render("index",$params );
	 		}
		 	else 
		 		$this->getController()->render("co2.views.default.unTpl",array("msg"=>"Formulaire introuvable","icon"=>"fa-search")); 
		 } else 
		 	echo $this->getController()->render("home");
    }
}