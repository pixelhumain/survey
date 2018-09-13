<?php
class SaveAction extends CAction
{
    public function run($id) {
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
			$res = Form::save( $id , $_POST );

        	$countStepSurvey = Form::countStep($_POST["parentSurvey"]);
        	$surveyParent = Form::getById($_POST["parentSurvey"]);
            // $typeChild = null ;
            // if(!empty($_POST["answers"][Organization::CONTROLLER]) ){
            //     $typeChild = Organization::COLLECTION;
            // }else if(!empty($_POST["answers"][Project::CONTROLLER]) ){
            //     $typeChild = Project::COLLECTION;
            // }else if(!empty($_POST["answers"][Event::CONTROLLER]) ){
            //     $typeChild = Event::COLLECTION;
            // }

            // if(!empty($typeChild)){
            //     $child = array();
            //     $child[] = array(   "id" => $_POST["answers"][""]["id"],
            //                         "type" => $typeChild,
            //                         "childName" => $_POST["answers"][""]["name"],
            //                         "roles" =>  array());
            //     //var_dump($child);
            //     $res = Link::multiconnect($child, (String)$surveyParent["_id"], Form::COLLECTION); 
            // }

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