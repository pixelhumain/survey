<?php
class SearchAdminMembersAction extends CTKAction{
    public function run(){
    	if ( Person::logguedAndValid() ) {
    		//$form = PHDB::findOne( Form::COLLECTION , array("id"=>$_POST["parentSurvey"]));
    		$form = Form::getById($_POST["parentSurvey"],$fields=array("links", "author"));
            if(	Form::canAdmin($_POST["parentSurvey"], $form)  ){

            	$queryId = array("links.forms.".(String)$form["_id"]=> array('$exists' => 1) );
            	if (!empty($_POST["text"])){
            		$text = $_POST['text'];
            		//$queryText = array( "name" => new MongoRegex("/.*{$text}.*/i"));
                    $queryText = array('$or' => array(   
                                            array( "name" => new MongoRegex("/.*{$text}.*/i") ) , 
                                            array( "email" => new MongoRegex("/.*{$text}.*/i") ) ) );
            		$query = array('$and' => array( $queryId , $queryText ) );
            	}else
            		$query = $queryId;
            	//Rest::json($query); exit ;
                $persons = Person::getWhere($query);
                $orgas = Organization::getWhere($query);
                $results = array_merge($persons, $orgas);
	    		Rest::json($results); exit ;

			} else 
				$this->getController()->render("co2.views.default.unauthorised"); 
		} else
			$this->getController()->render("co2.views.default.loginSecure");
    }


}