<?php
class AdminAction extends CAction{

    public function run($id){

    	$this->getController()->layout = "//layouts/empty";

        $form = PHDB::findOne( Form::COLLECTION , array("id"=>$id));
    	if ( ! Person::logguedAndValid() ) {
            $this->getController()->render("co2.views.default.loginSecure");
        }else if(	Yii::app()->session["userId"] == $form["author"] ||
					(	!empty($form["links"]["forms"][Yii::app()->session["userId"]]) && 
						!empty($form["links"]["forms"][Yii::app()->session["userId"]]["isAdmin"]) &&
						$form["links"]["forms"][Yii::app()->session["userId"]]["isAdmin"] == true) ) {
    		echo $this->getController()->render("admin", array());
		} else 
			$this->getController()->render("co2.views.default.unauthorised"); 
    }
}