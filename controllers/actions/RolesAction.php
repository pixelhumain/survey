<?php
class RolesAction extends CAction
{
    public function run($id,$session="1",$role=null)
    {
    	$ctrl = $this->getController();
    	$ctrl->layout = "//layouts/empty";
    	$form = PHDB::findOne( Form::COLLECTION , array("id"=>$id,"session"=>$session));

    	if ( ! Person::logguedAndValid() ) 
			$this->getController()->render("co2.views.default.unTpl",array("msg"=>Yii::t("common","Please Login First"),"icon"=>"fa-sign-in"));
		else if( Form::canAdmin( (string)$form["_id"], $form ) )
		{ 
			$params = array(
				"roles"=>$form["custom"]["roles"],
				"form"=>$form
			);

			if($role){
				$params["answers"] = PHDB::find( Form::ANSWER_COLLECTION , array("formId"=>$id, "categories.".$role=>array('$exists'=>1),"step"=>"ficheAction"));
				//Rest::json( $params["answers"]); exit;
				foreach ($params["answers"] as $key => $value) {
					$params["answers"][$key]["answers"] = PHDB::find( Form::ANSWER_COLLECTION , array("user"=>$value["user"]));

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

				$params["actions"] = PHDB::find( Action::COLLECTION , array("parentIdSurvey"=>(String) $form["_id"], "role.".$role => array('$exists' => 1) ));
				
				// $params["actions"] = PHDB::find( Action::COLLECTION , array("parentIdSurvey"=>(String) $form["_id"]));
				// $params["actions"] = PHDB::find( Action::COLLECTION , array("formId"=>$id, "categories.".$role=>array('$exists'=>1)));

			}
			//Rest::json($params["answers"]); exit;
	 		$ctrl->render( "roles" ,$params);
		} else 
			$this->getController()->render("co2.views.default.unTpl",array("msg"=>Yii::t("project", "Unauthorized Access."),"icon"=>"fa-lock"));
    }
}