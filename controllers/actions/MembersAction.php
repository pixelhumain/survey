<?php
class MembersAction extends CAction
{
    public function run($id)
    {
    	$this->getController()->layout = "//layouts/empty";

        $form = PHDB::findOne( Form::COLLECTION , array("id"=>$id));

    	if ( ! Person::logguedAndValid() ) {
            $this->getController()->render("co2.views.default.loginSecure");
        }else if( Form::canAdmin($id, $form) ){

        	$queryId = array("links.forms.".(String)$form["_id"]=> array('$exists' => 1) );
        	$persons = Person::getWhere($queryId);
        	$orgas = Organization::getWhere($queryId);
        	$merge = array_merge($persons, $orgas);
        	$elt = array();

            foreach ($merge as $key => $value) {
                if(!empty($form["links"]) &&
                    !empty($form["links"]["members"]) &&
                    !empty($form["links"]["members"][$key]) )
                    $elt[$key] = $value;
            }

			echo $this->getController()->render("members",
 												array(  "results" => $elt,
											 			"form"=> $form ));
		} else
			$this->getController()->render("co2.views.default.unauthorised"); 
    }
}