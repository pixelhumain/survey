<?php
class SaveAction extends CAction
{
    public function run() {
		$controller=$this->getController();
		
		//imagine a validation process

		if ( ! Person::logguedAndValid() ) 
 			return json_encode(array("result"=>false, "msg"=>Yii::t("common", "You are not loggued or do not have acces to this feature ")));
 		
 		if( $_POST["h"] != hash('sha256', $_POST["t"].Yii::app()->params["idOpenAgenda"] ) )
 			return json_encode( array( "result"=>false, "msg"=>Yii::t("common", "Bad Orgine request")));

 		unset( $_POST["t"] );
 		unset( $_POST["h"] );
 		$_POST["created"] = time();
 		$res = "Empty data cannot be saved";
		if ( !empty($_POST) ){
			$res = Form::save($_POST);
        	$countStepSurvey=Form::countStep($_POST["parentSurvey"]);
        	$surveyParent=Form::getById($_POST["parentSurvey"]);
        	if($_POST["formId"]==$surveyParent["id"].$countStepSurvey){
        		$user=array(
        			"id" =>Yii::app()->session["userId"],
        			"name" => Yii::app()->session["user"]["name"],
        			"email" => Yii::app()->session["userEmail"]
        		);
        		Mail::confirmSavingSurvey($user, $surveyParent);
        		$adminSurvey = array($surveyParent["author"]);
                $link = Form::getSurveyByFormId($id, Person::COLLECTION, "isAdmin");

                foreach ($link as $key => $value) {
                    $adminSurvey[] = $key;
                }

        		foreach ($adminSurvey as $id){
        			$email=Person::getEmailById($id);
        			Mail::sendNewAnswerToAdmin($email["email"], $user, $surveyParent);
        		}
        	}
		}
        // else
        // 	$res = Form::remove($type,$id, $label);
  		echo json_encode(array("result"=>$res, "answers"=>$_POST));
        exit;
	}
}