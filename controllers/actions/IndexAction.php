<?php
class IndexAction extends CAction
{
    public function run($id=NULL)
    {
    	$this->getController()->layout = "//layouts/empty";
    	if( @$id )
    	{
	 		if(@$form = PHDB::findOne( Form::COLLECTION , array("id"=>$id) )){
	 			$this->getController()->pageTitle = @$form["seo"]["title"];
	 			$this->getController()->keywords = @$form["seo"]["keywords"];
	 			$form["t"] = time(); 
	 			//pour etre sur qu'on passe par le process dans CO pour enregistrer on decodera le hash
	 			//dans l'autre sens 
	 			$form["h"] = hash('sha256', $form["t"].Yii::app()->params["idOpenAgenda"] );
	 			$answers = PHDB::find( Form::ANSWER_COLLECTION , array("formId"=>$id,"user"=> @Yii::app()->session["userId"] ) );
	 			if( $form["surveyType"] == "surveyList" || @$form["parentSurvey"] ){
	 				$pId = (@$form["parentSurvey"] ) ? $form["parentSurvey"]  : $id;
	 				$answers = PHDB::find( Form::ANSWER_COLLECTION , array("parentSurvey"=>$pId, "user"=> @Yii::app()->session["userId"] ) );	 				
	 			}

	 			$startDate = null;
	 			$endDate = null;
	 			if( @$form["parentSurvey"] ){
	 				$form["parentSurvey"] = PHDB::findOne( Form::COLLECTION , array("id"=>$form["parentSurvey"]) );
	 				if(@$form["parentSurvey"]["startDate"])
	 					$startDate = $form["parentSurvey"]["startDate"];
	 				if(@$form["parentSurvey"]["endDate"])
	 					$endDate = $form["parentSurvey"]["endDate"];
	 			} else {
	 				if(@$form["startDate"])
	 					$startDate = $form["startDate"];
	 				if(@$form["endDate"])
	 					$endDate = $form["endDate"];
	 			}


	 			$params = array( "form" => $form, 
	 							 "answers"=>$answers );
	 			if($startDate)
	 				$params["startDate"] = $startDate;
	 			if($endDate)
	 				$params["endDate"] = $endDate;

	 			
		 			echo $this->getController()->render("index",$params );
	 		}
		 	else 
		 		echo "Form not found";
		 } else 
		 	echo $this->getController()->render("home");
    }
}