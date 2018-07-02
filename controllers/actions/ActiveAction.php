<?php
class ActiveAction extends CTKAction{
    public function run(){
    	$child = array();
		$child[] = array( 	"childId" => $_POST["childId"],
							"childType" => $_POST["childType"],
							"childName" => $_POST["childName"],
							"roles" =>  array(),
						 	"link" => "projectExtern");
		//var_dump($child);
		$res = Link::multiconnect($child, $_POST["parentId"], Form::COLLECTION);
    	echo Rest::json( $res );
    }
}