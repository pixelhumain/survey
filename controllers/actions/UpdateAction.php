<?php
class UpdateAction extends CAction
{
    public function run()
    {
        $res=false;
        $msg=Yii::t("common","Please Login First");
        if ( Person::logguedAndValid() ) 
        {
            $answer = PHDB::findOne(Form::ANSWER_COLLECTION , array("formId"=>@$_POST["formId"],
                                                                    "session"=>@$_POST["session"], 
                                                                    "user"=>$_POST["answerUser"]));
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
                                 "params" => array( "session" => ( @$answer["parentSurvey"] ) ? $answer[ "parentSurvey" ] : $_POST[ "formId" ],
                                                "answersUser" => $_POST["answerUser"],
                                                "key" => $key, 
                                                //"value" => $value
                                                 )));
                //****************************
                //update total scores 
                //****************************
                $answer = PHDB::findOne(Form::ANSWER_COLLECTION , array( 
                                "formId"=>@$_POST["formId"], 
                                "session"=>@$_POST["session"],
                                "user"=>@Yii::app()->session["userId"]));
                $form = PHDB::findOne(Form::COLLECTION , array( "id"=>@$_POST["formId"]."Admin","session"=>@$_POST["session"]));

                $total = null;
                
                if( ( @$_POST["answerKey"] && @$_POST["answerStep"] ) && 
                        ( @$answer[ "answers" ][ @$_POST["answerKey"] ][ @$_POST["answerStep"] ]["total"] || count( $answer[ "answers" ][ @$_POST["answerKey"] ][ @$_POST["answerStep"] ] ) == count( $form["scenario"] ) ) )
                {
                    //calculate total and update in DB
                    $total = 0;
                    foreach ( $answer[ "answers" ][ $_POST["answerKey"] ][ $_POST["answerStep"] ] as $key => $value) {
                        //FOR THE MOMENT ALL steps have same weight
                        if(@$value[ "total" ])
                            $total += (float)$value[ "total" ];
                    }
                    $total = floor( ($total / count( $form["scenario"] ))*100 ) / 100;
                    PHDB::update(Form::ANSWER_COLLECTION,
                        array( "_id"=>new MongoId( (string)$answer["_id"]) ), 
                        array( '$set' => array( 'answers.'.$_POST["answerKey"].".".$_POST["answerStep"].".total" => $total ) ) );
                }
                
                
                $msg=Yii::t("common","Evrything allRight");
                $res=true;
            } else
                $msg= "Answer not found";
        } 

        echo json_encode( array("result"=>$res, "msg"=>$msg, "total"=>@$total ) );
    }
}