<?php
class AdminAction extends CAction{

    public function run($id,$session="1", $view=""){

        $ctrl = $this->getController();
    	$ctrl->layout = "//layouts/empty";

        $form = PHDB::findOne( Form::COLLECTION , array("id"=>$id,"session"=>$session));
    	if ( ! Person::logguedAndValid() ) {
            $ctrl->render("co2.views.default.unTpl",array("msg"=>Yii::t("common","Please Login First"),"icon"=>"fa-sign-in"));
        }else if(	Form::canAdmin((string)$form["_id"], $form) /*Yii::app()->session["userId"] == $form["author"] ||
					(	!empty($form["links"]["forms"][Yii::app()->session["userId"]]) && 
						!empty($form["links"]["forms"][Yii::app()->session["userId"]]["isAdmin"]) &&
						$form["links"]["forms"][Yii::app()->session["userId"]]["isAdmin"] == true) */) {
            if(!@$form["session"][$session])
                    $ctrl->render("co2.views.default.unTpl",array("msg"=>"Session introuvable sur ".$id,"icon"=>"fa-search")); 
            else     
    		  $ctrl->render("admin", array("id" => $id, "form" => $form));
		} else 
			$ctrl->render("co2.views.default.unTpl",array("msg"=>Yii::t("project", "Unauthorized Access."),"icon"=>"fa-lock"));
    }
}