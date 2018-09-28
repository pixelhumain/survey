<?php
class FormAction extends CTKAction
{
    public function run($id,$session="1")
    {
        $form = PHDB::findOne( Form::COLLECTION ,array("id"=>$id));    	
    	echo Rest::json( $form );
    }
}