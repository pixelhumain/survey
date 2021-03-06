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
                $value = (!empty($_POST["answers"]) ? $_POST["answers"] : null);
                $verb = '$set';

                if( @$_POST["arrayForm"] && !@$_POST["edit"]){
                    $verb = '$addToSet';
                    if($value == null)
                        $verb = '$unset';
                }   

                if( $value != null && !@$_POST["pull"] ) {
                    $value["created"] = time();
                    $value["user"] = Yii::app()->session["userId"];
                }
                
                PHDB::update( $_POST["collection"],
                    array("_id"=>new MongoId((string)$el["_id"])), 
                    array($verb => array($key => $value)));
                
                if($value == null && @$_POST["pull"] ){
                    PHDB::update(   $_POST["collection"],
                                    array("_id"=>new MongoId((String)$el["_id"])), 
                                    array('$pull' => array($_POST["pull"] => null )));
                }

                if($_POST["collection"]==Action::COLLECTION && $value != null && !empty($value["project"]) ){
                    $child = array( "idLink"   => $value["project"],
                                    "typeLink" => Project::COLLECTION,
                                    "idAction" => (String)$el["_id"],
                                    "verbLink" => "projects" );
                    $msgLink=Actions::assign($child);
                }                    


                $msg=Yii::t("common","Evrything allRight");
                $res=true;
            } else
                $msg= "Element not found";
        } 

        echo json_encode( array("result"=>$res, "msg"=>$msg, "msgLink" => @$msgLink) );
    }
}