<?php
class RolesAction extends CAction
{
    public function run($id,$role=null)
    {
    	$ctrl = $this->getController();
    	$ctrl->layout = "//layouts/empty";
    	$form = PHDB::findOne( Form::COLLECTION , array("id"=>$id));

    	if ( ! Person::logguedAndValid() ) 
			$ctrl->render("co2.views.default.loginSecure");
		else if( Form::canAdmin( $id, $form ) )
		{ 
			$params = array(
				"roles"=>$form["custom"]["roles"]
			);

			if($role){
				$params["answers"] = PHDB::find( Form::ANSWER_COLLECTION , array("formId"=>$id, "categories.".$role=>array('$exists'=>1)));
			}
	 		echo $ctrl->render( "roles" ,$params);
		} else 
			$ctrl->render("co2.views.default.unauthorised"); 
    }
}