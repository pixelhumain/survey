<?php
class IndexAction extends CAction
{
    public function run($id="commons")
    {
    	$this->getController()->layout = "//layouts/empty";
    	
 		if(@$form = PHDB::findOne( Form::COLLECTION , array("id"=>$id) )){
 			$form["t"] = time(); 
 			//pour etre sur qu'on passe par le process dans CO pour enregistrer on decodera le hash
 			//dans l'autre sens 
 			$form["h"] = hash('sha256', $form["t"].Yii::app()->params["idOpenAgenda"] );
	 		echo $this->getController()->render("index",array( "form" => $form ) );
 		}
	 	else 
	 		echo "Form not found";
    }
}