<?php
class SearchAdminFormAction extends CTKAction{
    public function run(){

        
    	if ( Person::logguedAndValid() ) {
    		//$form = PHDB::findOne( Form::COLLECTION , array("id"=>$_POST["parentSurvey"]));
    		$form = Form::getById($_POST["parentSurvey"],$fields=array("links", "author"));
            if(	Form::canAdmin((string)$form["_id"], $form) ){

            	$indexMin = isset($_POST['indexMin']) ? $_POST['indexMin'] : 0;
				$indexStep = 30;
				$queryId = array("parentSurvey"=>$_POST["parentSurvey"]) ;
            	if (!empty($_POST["text"])){
            		$text = $_POST['text'];
            		//$queryText = array( '$or' => array(
  									// array( "answers.organization.name" => new MongoRegex("/.*{$text}.*/i")),
  									// array( "answers.project.name" => new MongoRegex("/.*{$text}.*/i"))));

            		$queryText = array( "answers.project.name" => new MongoRegex("/.*{$text}.*/i"));
            		$query = array('$and' => array( $queryId , $queryText ) );
            	}else
            		$query = $queryId;
            	
            	$query = array('$and' => array( $query , array( "answers.project" => array('$exists' => 1)) ) );
            	$answers = PHDB::find( Form::ANSWER_COLLECTION , $query );
            	$results = Form::listForAdmin($answers);
	    		Rest::json($results); exit ;

			} else 
				$this->getController()->render("co2.views.default.unauthorised"); 
		} else
			$this->getController()->render("co2.views.default.unTpl",array("msg"=>Yii::t("project", "Unauthorized Access."),"icon"=>"fa-lock"));
    }


}