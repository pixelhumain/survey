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
		//var_dump( ($_POST["eligible"] === true));
		 Rest::json( $data ); exit ;
		if(!empty($_POST["eligible"]) && ($_POST["eligible"] === true || $_POST["eligible"] == "true")) {

			$child = array();
			$child[] = array( 	"childId" => $_POST["childId"],
								"childType" => $_POST["childType"],
								"childName" => $_POST["childName"],
								"roles" =>  array(),
							 	"link" => "projectExtern");

			$res[] = Link::multiconnect($child, $_POST["form"], Form::COLLECTION);

			if(!empty($_POST["parentId"]) && !empty($_POST["parentType"])){
				$child = array();
				$child[] = array( 	"childId" => $_POST["parentId"],
									"childType" => $_POST["parentType"],
									"childName" => $_POST["parentName"],
									"roles" =>  array());
				$res[] = Link::multiconnect($child, $_POST["form"], Form::COLLECTION);
			}
			$data["eligible"] = true ;

			$res = array("result" => true,
					"msg" => "Eligible");
		}

		// Rest::json( $data ); exit ;
		Form::save($data);
		echo Rest::json( $res );
		
	}
}