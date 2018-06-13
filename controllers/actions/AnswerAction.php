<?php
class AnswerAction extends CAction
{
    public function run($id,$view=null)
    {
    	if ( ! Person::logguedAndValid() ) {
	 		if( @$answer = PHDB::findOne( Form::ANSWER_COLLECTION , array("_id"=>new MongoId($id) ) ) ){
	 			$form = PHDB::findOne( Form::COLLECTION , array("id"=>$answer["formId"]));
	 			if( !$view ){
		 			$this->getController()->layout = "//layouts/empty";	
		 			echo $this->getController()->render( "answer" ,array( 
								 			"answer" => $answer,
								 			"form"   => $form ));
		 		} else {
		 			echo $this->getController()->renderPartial( $view ,array( 
								 			"answer" => $answer,
								 			"form"   => $form ));
		 		}
	 		}
		 	else 
		 		echo "Answer not found"; 
		} 
		else 
		{
			$this->getController()->layout = "//layouts/empty";	
			echo Yii::t("common","Please Login First");
		}
    }
}