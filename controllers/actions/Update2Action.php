<?php
class Update2Action extends CAction
{
    public function run()
    {
        $res=false;
        $msg=Yii::t("common","Please Login First");
        if ( Person::logguedAndValid() ) 
        {
            $el = PHDB::findOne($_POST["collection"] , array("_id"=>new MongoId( $_POST["id"] ) ));
            //canEDitAction
            if(!empty($el)){
                $key = $_POST["answerSection"];
                $value = $_POST["answers"];
                $value["created"] = time();
                $value["user"] = Yii::app()->session["userId"];
                PHDB::update($_POST["collection"],
                    array("_id"=>new MongoId((string)$el["_id"])), 
                    array('$set' => array($key => $value)));
                
                $msg=Yii::t("common","Evrything allRight");
                $res=true;
            } else
                $msg= "Element not found";
        } 

        echo json_encode( array("result"=>$res, "msg"=>$msg) );
    }
}