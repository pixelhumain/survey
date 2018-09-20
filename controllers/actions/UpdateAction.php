<?php
class UpdateAction extends CAction
{
    public function run()
    {
        $res=false;
        $msg=Yii::t("common","Please Login First");
        //ajouter Form::canAdmin( (string)$form["_id"], $form )
        if ( Person::logguedAndValid()  ) 
        {
            $answer = PHDB::findOne( Form::ANSWER_COLLECTION , array( "_id"=>new MongoId(@$_POST["answerId"]) ) );
            if(!empty($answer)){
                $key = $_POST["answerSection"];
                $value = $_POST["answers"];
                if( @$_POST["date"] )
                    $value["date"] = time();
                PHDB::update(Form::ANSWER_COLLECTION,
                    array("_id"=>new MongoId((string)$answer["_id"])), 
                    array('$set' => array($key => $value)));

                Log::save( array( "userId" => Yii::app()->session["userId"], 
                                 "created" => new MongoDate(time()), 
                                 "action" => "survey.updateAction", 
                                 "params" => array( 
                                                "id" => $_POST["answerId"],
                                                "answersUser" => $_POST["answerUser"],
                                                "key" => $key )));
                
                //****************************
                //update total scores 
                //****************************
                $answer = PHDB::findOne(Form::ANSWER_COLLECTION , array( "_id"=>new MongoId(@$_POST["answerId"])) );
                $form = PHDB::findOne(Form::COLLECTION , array( "id"=>@$_POST["formId"]."Admin","session"=>@$_POST["session"]));

                $total = null;
                
                if( ( @$_POST["answerKey"] && @$_POST["answerStep"] ) && 
                        ( @$answer[ @$_POST["answerKey"] ][ @$_POST["answerStep"] ]["total"] || count( $answer[ @$_POST["answerKey"] ][ @$_POST["answerStep"] ] ) == count( $form["scenario"] ) ) )
                {
                    //calculate total and update in DB
                    $total = 0;
                    foreach ( $answer[ $_POST["answerKey"] ][ $_POST["answerStep"] ] as $key => $value) {
                        //FOR THE MOMENT ALL steps have same weight
                        if(@$value[ "total" ])
                            $total += (float)$value[ "total" ];
                    }
                    $total = floor( ($total / count( $form["scenario"] ))*100 ) / 100;
                    PHDB::update ( Form::ANSWER_COLLECTION,
                        array( "_id"=>new MongoId( (string)$answer["_id"]) ), 
                        array( '$set' => array( $_POST["answerKey"].".".$_POST["answerStep"].".total" => $total ) ) );
                }
                
                
                $msg=Yii::t("common","Evrything allRight");
                $res=true;
            } else
                $msg= "Answer not found";
        } 

        echo json_encode( array("result"=>$res, "msg"=>$msg, "total"=>@$total ) );
    }
}