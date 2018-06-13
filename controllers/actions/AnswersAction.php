<?php
class AnswersAction extends CAction
{
    public function run($id="commons")
    {
    	$this->getController()->layout = "//layouts/empty";
    	//if ( ! Person::logguedAndValid() ) {
	    	if(@$answers = PHDB::find( Form::ANSWER_COLLECTION , array("formId"=>$id) )){
		 		echo $this->getController()->render("answers",array( 
								 			"results" => $answers,
								 			"form"=> PHDB::findOne( Form::COLLECTION , array("id"=>$id)) ));
	 		}
		 	else 
		 		echo "No answers found"; 
		 // } else 
			//  echo "<h1>".Yii::t("common","Please Login First")."</h1>";
    }
}