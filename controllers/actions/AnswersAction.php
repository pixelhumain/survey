<?php
class AnswersAction extends CAction
{
    public function run($id)
    {
    	$this->getController()->layout = "//layouts/empty";

        $form = PHDB::findOne( Form::COLLECTION , array("id"=>$id));
    	if ( ! Person::logguedAndValid() ) {
            $this->getController()->render("co2.views.default.loginSecure");
        }else if(	Yii::app()->session["userId"] == $form["author"] ||
					(	!empty($form["links"]["forms"][Yii::app()->session["userId"]]) && 
						!empty($form["links"]["forms"][Yii::app()->session["userId"]]["isAdmin"]) &&
						$form["links"]["forms"][Yii::app()->session["userId"]]["isAdmin"] == true)){ 
    		if( $form["surveyType"] == "surveyList" && 
                @$answers = PHDB::find( Form::ANSWER_COLLECTION , array("parentSurvey"=>@$id) )){
    			$results = array();
    			$uniq = array();
    			$uniqO = array();
    			$uniqP = array();
    			$uniqE = array();
    			
    			foreach ( $answers as $key => $value) {
    				if(!in_array( $value["user"], $uniq )){
    					$value["type"] = Person::COLLECTION;
    					$value["id"] = $value["user"];
    					$results[] = $value;
    					$uniq[] = $value["user"];
    				}

    				if( !empty($value["answers"]) && 
                        !empty($value["answers"][Organization::CONTROLLER]) && 
                        !in_array( $value["answers"][Organization::CONTROLLER]["id"], $uniqO ) ){
    					$orga = Element::getElementById($value["answers"][Organization::CONTROLLER]["id"], Organization::COLLECTION, null, array("name", "email"));
    					$orga["id"] = $value["answers"][Organization::CONTROLLER]["id"];
    					$orga["type"] = Organization::COLLECTION;
                        $results[] = $orga;
                        $uniqO[] = $value["answers"][Organization::CONTROLLER]["id"];
					}

					if( !empty($value["answers"]) && 
                        !empty($value["answers"][Project::CONTROLLER]) && 
                        !in_array( $value["answers"][Project::CONTROLLER]["id"], $uniqP ) ){
    					$orga = Element::getElementById($value["answers"][Project::CONTROLLER]["id"], Project::COLLECTION, null, array("name", "email"));
    					$orga["id"] = $value["answers"][Project::CONTROLLER]["id"];
    					$orga["type"] = Project::COLLECTION;
                        $results[] = $orga;
                        $uniqP[] = $value["answers"][Project::CONTROLLER]["id"];
					}


					if( !empty($value["answers"]) && 
                        !empty($value["answers"][Event::CONTROLLER]) && 
                        !in_array( $value["answers"][Event::CONTROLLER]["id"], $uniqE ) ){
    					$orga = Element::getElementById($value["answers"][Event::CONTROLLER]["id"], Event::COLLECTION, null, array("name", "email"));
    					$orga["id"] = $value["answers"][Event::CONTROLLER]["id"];
    					$orga["type"] = Event::COLLECTION;
                        $results[] = $orga;
                        $uniqE[] = $value["answers"][Event::CONTROLLER]["id"];
					}
    			}
    			//Rest::json($results); exit ;
	 			echo $this->getController()->render("answersList",array( 
														 			"results" => $results,
														 			"form"=> $form ));

	 		} else if(@$answers = PHDB::find( Form::ANSWER_COLLECTION , array("formId"=>@$id) )){
		 		echo $this->getController()->render("answers",array( 
													 			"results" => $answers,
													 			"form"=> $form ));
	 		} 
		 	else 
		 		echo "No answers found"; 
		} else 
			$this->getController()->render("co2.views.default.unauthorised"); 
    }
}