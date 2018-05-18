<?php
class FormAction extends CTKAction
{
    public function run($id)
    {
    	//a sample can be found in co2/assets/js/dynform/commons
    	//add attributes 
    	//id : commons
    	//parentType : xxx
    	//parentId : xxx
        $form = PHDB::findOne( Form::COLLECTION ,array("id"=>$id));    	
    	echo Rest::json( $form );
    }
}