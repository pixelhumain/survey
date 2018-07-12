<?php
class ActiveAction extends CTKAction{
	public function run(){
		$data = array(
			"formId" => $_POST["formId"],
			"user" => $_POST["userId"],
			"name" => $_POST["userName"],
			"eligible" => false, 
		);
		$res = array("result" => false,
					"msg" => "N\'est pas éligible");
		
	
		if(!empty($_POST["eligible"]) && ($_POST["eligible"] === true || $_POST["eligible"] == "true")) {

			$child = array();
			$child[] = array( 	"childId" => $_POST["childId"],
								"childType" => $_POST["childType"],
								"childName" => $_POST["childName"],
								"roles" =>  (!empty($_POST["roles"]) ? explode(",", $_POST["roles"]) : array()),
							 	"link" => "projectExtern");

			$res[] = Link::multiconnect($child, $_POST["form"], Form::COLLECTION);

			if(!empty($_POST["parentId"]) && !empty($_POST["parentType"])){

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

			// $data["eligible"] = true ;

			$res = array("result" => true,
							"msg" => "Eligible");
		}
		//Rest::json( $_POST ); exit ;
		// Rest::json( $data ); exit ;
		Form::save($data);
		echo Rest::json( $res );
		
	}
}