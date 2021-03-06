<?php
class NewAction extends CAction
{
    public function run($id,$session) {
		$ctrl=$this->getController();
		
		if ( ! Person::logguedAndValid() ) 
 			$ctrl->render("co2.views.default.unTpl",array("msg"=>Yii::t("common","Please Login First"),"icon"=>"fa-sign-in"));

        //check form et session exist
        if($form = PHDB::findOne( Form::COLLECTION , array("id"=>$id))){
            if(@$form["session"][$session])
            {
                if( Form::isFinish( $form["session"][$session]["endDate"]) ){
                    $ctrl->render("co2.views.default.unTpl",array("msg"=>"La session est terminé","icon"=>"fa-calendar")); 
                } else {
                    $new =  array(
                        "id" => $id,
                        "user"=>Yii::app()->session["userId"],
                        "name"=>Yii::app()->session["user"]["name"],
                        "email"=>Yii::app()->session["userEmail"],
                        "session" => $session
                    );
                    $res = Form::newAnswer( $new );
                    $firstId = (@$form["scenario"]) ? array_keys($form["scenario"])[0] : $form["id"];
                    $ctrl->redirect(Yii::app()->createUrl("/survey/co/index/id/".$firstId."/session/".$session."/answer/".(string)$res["answer"]['_id']));
                }
            } else 
            $ctrl->render("co2.views.default.unTpl",array("msg"=>"Session introuvable","icon"=>"fa-search")); 
        } else 
            $ctrl->render("co2.views.default.unTpl",array("msg"=>"Survey introuvable","icon"=>"fa-search")); 
	}
}