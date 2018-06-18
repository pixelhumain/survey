<?php
class IndexAction extends CAction
{
    public function run($id="commons")
    {
    	$this->getController()->layout = "//layouts/empty";
    	
 		if(@$form = PHDB::findOne( Form::COLLECTION , array("id"=>$id) )){
 			$form["t"] = time(); 
 			//pour etre sur qu'on passe par le process dans CO pour enregistrer on decodera le hash
 			//dans l'autre sens 
 			$form["h"] = hash('sha256', $form["t"].Yii::app()->params["idOpenAgenda"] );
 			$answers = PHDB::find( Form::ANSWER_COLLECTION , array("formId"=>$id,"user"=> @Yii::app()->session["userId"] ) );
 			if( $form["surveyType"] == "surveyList" ){
 				$answers = array();
 				foreach ($form["scenario"] as $key => $value) {
 					$answers = array_merge($answers, PHDB::find( Form::ANSWER_COLLECTION , array("formId"=>$key, "user"=> @Yii::app()->session["userId"] ) ));
 				}
 			}
	 		echo $this->getController()->render("index",array( "form" => $form, 
	 														   "answers"=>$answers ) );
 		}
	 	else 
	 		echo "Form not found";
    }
}