<?php
class MembersAction extends CAction
{
    public function run($id,$session="1")
    {
    	$this->getController()->layout = "//layouts/empty";

        $form = PHDB::findOne( Form::COLLECTION , array("id"=>$id,"session"=>$session));

    	if ( ! Person::logguedAndValid() ) {
            $this->getController()->render("co2.views.default.unTpl",array("msg"=>Yii::t("common","Please Login First"),"icon"=>"fa-sign-in"));
        }else if( Form::canAdmin((string)$form["_id"], $form) ){

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

			$this->getController()->render("members", array(  "results" => $elt,
											 			      "form"=> $form ));
		} else
			$this->getController()->render("co2.views.default.unTpl",array("msg"=>Yii::t("project", "Unauthorized Access."),"icon"=>"fa-lock"));
    }
}