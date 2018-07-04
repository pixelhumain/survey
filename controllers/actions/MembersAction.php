<?php
class MembersAction extends CAction
{
    public function run($id)
    {
    	$this->getController()->layout = "//layouts/empty";

        $form = PHDB::findOne( Form::COLLECTION , array("id"=>$id));
    	if ( ! Person::logguedAndValid() ) {
            $this->getController()->render("co2.views.default.loginSecure");
        }else if(	Yii::app()->session["userId"] == $form["author"] ||
					(	!empty($form["links"]["forms"][Yii::app()->session["userId"]]) && 
						!empty($form["links"]["forms"][Yii::app()->session["userId"]]["isAdmin"]) &&
						$form["links"]["forms"][Yii::app()->session["userId"]]["isAdmin"] == true)){

        	$queryId = array("links.forms.".(String)$form["_id"]=> array('$exists' => 1) );

        	
        	$persons = Person::getWhere($queryId);
        	$orgas = Organization::getWhere($queryId);

        	$results = array_merge($persons, $orgas);
        	//Rest::json($results); exit ;

			echo $this->getController()->render("members",
 												array(  "results" => $results,
											 			"form"=> $form ));
		} else
			$this->getController()->render("co2.views.default.unauthorised"); 
    }
}