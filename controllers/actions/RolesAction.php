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
				"roles"=>$form["custom"]["roles"],
				"form"=>$form
			);

			if($role){
				$params["answers"] = PHDB::find( Form::ANSWER_COLLECTION , array("formId"=>$id, "categories.".$role=>array('$exists'=>1),"step"=>"ficheAction"));
				foreach ($params["answers"] as $key => $value) {
					$params["answers"][$key]["answers"] = PHDB::find( Form::ANSWER_COLLECTION , array("parentSurvey"=>$id));

					//CTE specific 
					foreach ( $params["answers"][$key]["answers"] as $k => $v ) {
						$params["answers"][$key]["answers"][ $v["formId"] ] = $v;
						if( @$v["answers"]["organization"]["id"] ){
							//get ORGANIZATION
							$params["answers"][$key]["answers"][ $v["formId"] ]['organization'] = Element::getByTypeAndId( Organization::COLLECTION , $v["answers"]["organization"]["id"] );
						}
						else if( @$v["answers"]["project"]["id"] )
							$params["answers"][$key]["answers"][ $v["formId"] ]['project'] = Element::getByTypeAndId( Project::COLLECTION , $v["answers"]["project"]["id"] );
					}
				}

				$params["actions"] = PHDB::find( Action::COLLECTION , array("parentIdSurvey"=>(String) $form["_id"], "role" => $role));

				// $params["actions"] = PHDB::find( Action::COLLECTION , array("parentIdSurvey"=>(String) $form["_id"]));
				// $params["actions"] = PHDB::find( Action::COLLECTION , array("formId"=>$id, "categories.".$role=>array('$exists'=>1)));
			}
	 		echo $ctrl->render( "roles" ,$params);
		} else 
			$ctrl->render("co2.views.default.unauthorised"); 
    }
}