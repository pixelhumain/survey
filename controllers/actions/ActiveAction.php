<?php
class ActiveAction extends CTKAction{
    public function run($id){
    	//$form = PHDB::findOne( Form::COLLECTION ,array("id"=>$id));    	
    	echo Rest::json( $_POST );
    }
}