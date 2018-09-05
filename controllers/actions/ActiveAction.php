<?php
class ActiveAction extends CTKAction{
	public function run(){
		$adminForm =  PHDB::findOne( Form::COLLECTION , array("id"=>$_POST["formId"]."Admin") );
		$data = array(
			"formId" => $_POST["formId"],
			"user" => $_POST["userId"],
			"name" => $_POST["userName"],
			"eligible" => false, 
			"step" => array_keys($adminForm["scenarioAdmin"])[1]
		);

		$paramMail = array( "tpl" => "eligibilite",
								"tplObject" => "Vous n'êtes pas éligible au CTE",
								"tplMail" => $_POST["email"],
								"messages" => "Vous n'êtes pas éligible au CTE");
		$res = array("result" => false,
					"msg" => "N\'est pas éligible");
		
		var_dump("HERE1");
		if(!empty($_POST["eligible"]) && ($_POST["eligible"] === true || $_POST["eligible"] == "true")) {

			$child = array();
			$child[] = array( 	"childId" => $_POST["childId"],
								"childType" => Element::getCollectionByControler($_POST["childType"]),
								"childName" => $_POST["childName"],
								"roles" =>  (!empty($_POST["roles"]) ? explode(",", $_POST["roles"]) : array()),
							 	"link" => "projectExtern");
			var_dump("HERE12");
			var_dump($child);

			var_dump("HERE13");
			var_dump($_POST["form"]);
			var_dump("HERE14");
			var_dump(Form::COLLECTION);
			//Rest::json($child);exit ;

			$res[] = Link::multiconnect($child, $_POST["form"], Form::COLLECTION);
			var_dump("HERE15");
			if(!empty($_POST["parentId"]) && !empty($_POST["parentType"])){
				
				$existParent =PHDB::findOne( $_POST["parentType"] , array("_id"=>new MongoId($_POST["parentId"])) );

				if(!empty($existParent)){
					$form = Form:: getByIdMongo($_POST["form"], array("parentId", "parentType"));

					// pour l'orga
					$child = array();
					$child[] = array( 	"childId" => $_POST["parentId"],
										"childType" => $_POST["parentType"],
										"childName" => $_POST["parentName"],
										"roles" =>  !empty($_POST["roles"]) ? explode(",", $_POST["roles"]) : array());
					//Rest::json( $form ); exit ;
					$res[] = Link::multiconnect($child, (String) $form["parentId"], $form["parentType"]);

					// pour le projet
					$child = array();
					$child[] = array( 	"childId" => $_POST["childId"],
										"childType" => $_POST["childType"],
										"childName" => $_POST["childName"],
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
		
		Form::save($data);
		Mail::createAndSend($paramMail);
		echo Rest::json( $res );
		
	}
}