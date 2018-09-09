<?php
class AdminAction extends CAction{

    public function run($id,$session, $view=""){

    	$this->getController()->layout = "//layouts/empty";

        $form = PHDB::findOne( Form::COLLECTION , array("id"=>$id,"session"=>$session));
    	if ( ! Person::logguedAndValid() ) {
            $this->getController()->render("co2.views.default.loginSecure");
        }else if(	Form::canAdmin((string)$form["_id"], $form) /*Yii::app()->session["userId"] == $form["author"] ||
					(	!empty($form["links"]["forms"][Yii::app()->session["userId"]]) && 
						!empty($form["links"]["forms"][Yii::app()->session["userId"]]["isAdmin"]) &&
						$form["links"]["forms"][Yii::app()->session["userId"]]["isAdmin"] == true) */) {
    		echo $this->getController()->render("admin", array("id" => $id, "form" => $form));
		} else 
			$this->getController()->render("co2.views.default.unauthorised"); 
    }
}