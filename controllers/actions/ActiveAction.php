<?php
class ActiveAction extends CTKAction{
	public function run(){
		

		$answer =  Form::getAnswerById($_POST["answerId"]);

		$adminForm =  PHDB::findOne( Form::COLLECTION , array("id"=>$answer["formId"]."Admin","session"=>$answer["session"]) );

		$form = Form::getByIdMongo( $_POST["form"] );
		
		$data = array(
			"eligible" => false,
			"step" => array_keys($adminForm["scenarioAdmin"])[1]
		);

		$paramMail = array( "tpl" => "eligibilite",
								"tplObject" => "Vous n'êtes pas éligible au CTE",
								"tplMail" => $answer["email"],
								"messages" => "Vous n'êtes pas éligible au CTE");
		$res = array("result" => false,
					"msg" => "N\'est pas éligible");
		
		$projet = array();

		if(!empty($answer["answers"]["cte2"]["answers"]["project"])){
			$project = array("id" => $answer["answers"]["cte2"]["answers"]["project"]["id"],
								"type" => $answer["answers"]["cte2"]["answers"]["project"]["type"],
								"name" => $answer["answers"]["cte2"]["answers"]["project"]["name"]);
		}
	
		if(!empty($_POST["eligible"]) && ($_POST["eligible"] === true || $_POST["eligible"] == "true") && !empty($project)) {

			$child = array();
			$child[] = array( 	"childId" => $project["id"],
								"childType" => Element::getCollectionByControler($project["type"]),
								"childName" => $project["name"],
								"roles" =>  (!empty($_POST["roles"]) ? explode(",", $_POST["roles"]) : array()),
							 	"link" => "projectExtern");

			$res[] = Link::multiconnect($child, $_POST["form"], Form::COLLECTION);

			$orga = array();

			if(!empty($answer["answers"]["cte1"]["answers"]["organization"])){
				$orga = array("id" => $answer["answers"]["cte1"]["answers"]["organization"]["id"],
									"type" => $answer["answers"]["cte1"]["answers"]["organization"]["type"],
									"name" => $answer["answers"]["cte1"]["answers"]["organization"]["name"]);
			}

			if(!empty($orga["id"]) && !empty($orga["type"])){

				$existParent =PHDB::findOne( Element::getCollectionByControler($orga["type"]) , array("_id"=>new MongoId($orga["id"])) );
				//Rest::json($existParent); exit; 
				if(!empty($existParent)){
					$form = Form:: getByIdMongo($_POST["form"], array("parentId", "parentType"));

					// pour l'orga
					$child = array();
					$child[] = array( 	"childId" => $orga["id"],
										"childType" => Element::getCollectionByControler($orga["type"]),
										"childName" => $orga["name"],
										"roles" =>  !empty($_POST["roles"]) ? explode(",", $_POST["roles"]) : array());
					//Rest::json( $form ); exit ;
					$res[] = Link::multiconnect($child, (String) $form["parentId"], $form["parentType"]);

					// pour le projet
					$child = array();
					$child[] = array( 	"childId" => $project["id"],
										"childType" => Element::getCollectionByControler($project["type"]),
										"childName" => $project["name"],
										"roles" =>  (!empty($_POST["roles"]) ? explode(",", $_POST["roles"]) : array()));

					$res[] = Link::multiconnect($child, (String) $form["parentId"], $form["parentType"]);
				}
			}

			$data["eligible"] = true ;
			$data["step"] = array_keys($adminForm["scenarioAdmin"])[2] ;
			$roles = explode(",", $_POST["roles"]);

			$pourcentage = round(100 / count($roles), 2);

			$data["categories"] = array() ;

			foreach ($roles as $key => $value) {
				$data["categories"][InflectorHelper::slugify( $value )] = array( "name" => $value,"pourcentage" => $pourcentage);
			}


			$paramMail["messages"] = "Vous etes éligible au CTE, revenez sur la plateforme pour voir la suite";
			$paramMail["tplObject"] = "Vous êtes éligible au CTE";
			
			
			
			$res = array("result" => true,
							"msg" => "Eligible",
							"data" => $data);
		}
		PHDB::update(Form::ANSWER_COLLECTION, 
						  	array("_id"=>new MongoId($_POST["answerId"])),
	                        array(	'$set' => $data));
		Mail::createAndSend($paramMail);
		echo Rest::json( $res );
		
	}
}