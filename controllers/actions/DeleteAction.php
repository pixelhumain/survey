<?php
class DeleteAction extends CAction
{
    public function run($id) {
		$ctrl=$this->getController();
		
		if ( ! Person::logguedAndValid() ) 
 			$ctrl->render("co2.views.default.unTpl",array("msg"=>Yii::t("common","Please Login First"),"icon"=>"fa-sign-in"));

        //check form et session exist
        if($answer = PHDB::findOne( Form::ANSWER_COLLECTION , array("_id"=>new MongoId(($id)))) ) 
        {
            if($answer["user"] == Yii::app()->session["userId"])
            {
                Form::delAnswer( $id );
                $ctrl->redirect(Yii::app()->createUrl("/survey/co/index/id/".$answer["formId"]));
            } else 
              $ctrl->render("co2.views.default.unTpl",array("msg"=>"Réponse introuvable ou ","icon"=>"fa-search")); 
        } else 
            $ctrl->render("co2.views.default.unTpl",array("msg"=>"Survey introuvable","icon"=>"fa-search")); 
	}
}