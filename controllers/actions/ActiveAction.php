<?php
class ActiveAction extends CTKAction{
    public function run(){
    	$data = array(
			"formId" => $_POST["formId"],
			"user" : $_POST["userId"],
		    "name" : $_POST["userName"],
		    "eligible" : false, 
		);

    	if(!empty($_POST["eligible"]) && ($_POST["eligible"] == true || $_POST["eligible"] == "true")) {
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
			Form::save($data);
	    	
    	}
    	
    	$res = Form::save($data);
    	echo Rest::json( $res );
    	
    }
}