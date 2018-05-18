<?php
class IndexAction extends CAction
{
    public function run($id="commons")
    {
    	$this->getController()->layout = "//layouts/empty";
    	
 		if(@$form = PHDB::findOne( Form::COLLECTION , array("id"=>$id) ))
	 		echo $this->getController()->render("index",array("form"=>$form) );
	 	else 
	 		echo "Form not found";
    }
}