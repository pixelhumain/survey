<?php
class SearchAdminFormAction extends CTKAction{
    public function run(){

        
    	if ( Person::logguedAndValid() ) {
    		//$form = PHDB::findOne( Form::COLLECTION , array("id"=>$_POST["idForm"]));
    		$form = Form::getByIdMongo($_POST["idForm"],$fields=array("links", "author"));
            if(	!empty($form) && 
            	( Yii::app()->session["userId"] == $form["author"] ||
				(	!empty($form["links"]["forms"][Yii::app()->session["userId"]]) && 
					!empty($form["links"]["forms"][Yii::app()->session["userId"]]["isAdmin"]) &&
					$form["links"]["forms"][Yii::app()->session["userId"]]["isAdmin"] == true) ) ){

            	$indexMin = isset($_POST['indexMin']) ? $_POST['indexMin'] : 0;
				$indexStep = 30;

				$query = array();
            	
            	if (!empty($_POST["text"]))
            		$query = array('$and' => array( $query , array("name" => $_POST["text"]) ) );

            	$allRes = array();
            	//*********************************  PERSONS   ******************************************
		       	// if(strcmp($filter, Person::COLLECTION) != 0 && (Search::typeWanted(Person::COLLECTION, $searchType) || Search::typeWanted("persons", $searchType) ) ) {
					$prefLocality = (!empty($searchLocality) ? true : false);
					$queryPersons = array('$and' => array( $query , array("links.forms.".$_POST["idForm"] => array('$exists' => 1) ) ) );
					$queryPersons = ;

					if(@$ranges){
						$indexMin=$ranges[Person::COLLECTION]["indexMin"];
						$indexStep=$ranges[Person::COLLECTION]["indexMax"]-$ranges[Person::COLLECTION]["indexMin"];
					}
					$allRes = array_merge($allRes, Search::searchPersons($queryPersons, $indexStep, $indexMin, $prefLocality));

			  	// }

			  	//*********************************  ORGANISATIONS   ******************************************
				// if(strcmp($filter, Organization::COLLECTION) != 0 && Search::typeWanted(Organization::COLLECTION, $searchType)){
					if(@$ranges){
						$indexMin=$ranges[Organization::COLLECTION]["indexMin"];
						$indexStep=$ranges[Organization::COLLECTION]["indexMax"]-$ranges[Organization::COLLECTION]["indexMin"];
					}
					$allRes = array_merge($allRes, Search::searchOrganizations($query, $indexStep, $indexMin,  array(), array() ));
			  	// }

			  	date_default_timezone_set('UTC');
						
			  	//*********************************  EVENT   ******************************************
				// if(strcmp($filter, Event::COLLECTION) != 0 && Search::typeWanted(Event::COLLECTION, $searchType)){
					// $searchAll=false;
					// if(@$ranges){
					// 	$indexMin=$ranges[Event::COLLECTION]["indexMin"];
					// 	$indexStep=$ranges[Event::COLLECTION]["indexMax"]-$ranges[Event::COLLECTION]["indexMin"];
					// }
					
		   //     		if($search != "")
		   //     			$searchAll=true;
		   //     		$queryEvents=$query;
					// $allRes = array_merge($allRes, Search::searchEvents($queryEvents, $indexStep, $indexMin, $searchOnAll, $searchAll));
			  	// }
			  	//*********************************  PROJECTS   ******************************************
				// if(strcmp($filter, Project::COLLECTION) != 0 && Search::typeWanted(Project::COLLECTION, $searchType)){
					if(@$ranges){
						$indexMin=$ranges[Project::COLLECTION]["indexMin"];
						$indexStep=$ranges[Project::COLLECTION]["indexMax"]-$ranges[Project::COLLECTION]["indexMin"];
					}
					$queryPersons = array('$and' => array( $query , array("links.forms.".$_POST["idForm"] => array('$exists' => 1) ) ) );
					$allRes = array_merge($allRes, Search::searchProject($query, $indexStep, $indexMin));
			  	// }
	    		Rest::json($allRes); exit ;


			} else 
				$this->getController()->render("co2.views.default.unauthorised"); 
		} else
			$this->getController()->render("co2.views.default.loginSecure");
    }


}