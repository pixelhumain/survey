<?php
class SwitchAction extends CTKAction{
	public function run(){

		$res = array(	"result" => false,
							"msg" => "Not",
							"data" => null);
		if(!empty($_POST["answerId"]) && !empty($_POST["id"])){
			$answer =  Form::getAnswerById($_POST["answerId"]);

			$user =  PHDB::findOne( Person::COLLECTION , array( "_id" => new MongoId($_POST["id"])), array("name", "email"));
			//echo Rest::json( $user ); exit ;

			$data = array("user" => $_POST["id"],
							"name" => $user["name"],
							"email" => $user["email"] );
			
			
			PHDB::update(Form::ANSWER_COLLECTION, 
							  	array("_id"=>new MongoId($_POST["answerId"])),
		                        array(	'$set' => $data));
			$res = array(	"result" => true,
							"msg" => "Eligible",
							"data" => $data);
		}
		
		echo Rest::json( $res );
		
	}
}