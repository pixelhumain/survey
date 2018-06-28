<?php
class IndexAction extends CAction
{
    public function run($id=NULL)
    {
    	$this->getController()->layout = "//layouts/empty";
    	if( @$id )
    	{
	 		if(@$form = PHDB::findOne( Form::COLLECTION , array("id"=>$id) )){
	 			$form["t"] = time(); 
	 			//pour etre sur qu'on passe par le process dans CO pour enregistrer on decodera le hash
	 			//dans l'autre sens 
	 			$form["h"] = hash('sha256', $form["t"].Yii::app()->params["idOpenAgenda"] );
	 			$answers = PHDB::find( Form::ANSWER_COLLECTION , array("formId"=>$id,"user"=> @Yii::app()->session["userId"] ) );
	 			if( $form["surveyType"] == "surveyList" || @$form["parentSurvey"] ){
	 				$pId = (@$form["parentSurvey"] ) ? $form["parentSurvey"]  : $id;
	 				$answers = PHDB::find( Form::ANSWER_COLLECTION , array("parentSurvey"=>$pId, "user"=> @Yii::app()->session["userId"] ) );	 				
	 			}
	 			if( @$form["parentSurvey"] )
	 				$form["parentSurvey"] = PHDB::findOne( Form::COLLECTION , array("id"=>$form["parentSurvey"]) );
	 			$params = array( "form" => $form, 
	 							 "answers"=>$answers );
	 			
		 		echo $this->getController()->render("index",$params );
	 		}
		 	else 
		 		echo "Form not found";
		 } else 
		 	echo $this->getController()->render("home");
    }
}