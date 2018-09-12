<?php
class EditAction extends CTKAction
{
    public function run($id,$session="1")
    {
    	//takes a form ID
        //builds the corresponding dynForm specification
        //listing all scenarios 
        //and each property cn be edited 
        $form = PHDB::findOne( Form::COLLECTION ,array("id"=>$id));
        $form["scenario"][$id]['json'] = array(
            "jsonSchema" => array(
                "title" => $form[ "title" ],
                "properties"=> array()
            )
        );
        //run through parent Survey scenario
        foreach ($form["scenario"] as $key => $value) 
        {
            $stepform = PHDB::findOne( Form::COLLECTION ,array("id"=>$key,"session"=>$session));
            $form["scenario"][$key]['json'] = array(
                "jsonSchema" => array(
                    "title" => $stepform[ "title" ],
                    "properties"=> array()
                )
            );
            //for each step , scan child scenario
            foreach ($stepform["scenario"] as $s => $sv ) 
            {    
                //if carries a dynform definition
                if( @$sv["json"] )
                {
                    //add a separator for this step
                    $form["scenario"][$key]['json']['properties'][$s] = array (
                        "inputType" => "custom",
                        "html" => "<p class='text-dark'>".$s." ! <hr></p>"
                    );            
                    //run through it's properties 
                    foreach ($sv["json"]["jsonSchema"]["properties"] as $k => $v) {
                        $form["scenario"][$key]['json']['properties'][$k] = array (
                                "inputType" =>"text",
                                "label" => @$v["label"],
                                "placeholder" => @$v["placeholder"]
                        );
                    }
                } 
                //it's an external dynform cannot be edited 
                else if( @$sv["saveElement"] )
                {
                    $form["scenario"][$key]['json']['properties'][$s] = array (
                        "inputType" => "custom",
                        "html" => "<p class='text-dark'>".$s." is an external dynform definition and cannot be edited ! <hr></p>"
                    );
                }
            }
        }

        //ideas : 
        // make a dynform editor == based on jsonSchema generate all editable features, CRUDing inputs into the edited DF
        // make an answerScenario listing all sections of a survey in a tree manor with btns that generate a dynform that can add more inputs
        

    	// //echo Rest::json( $form );
        $this->getController()->layout = "//layouts/empty";
        echo $this->getController()->render("edit",array( "form"=> $form ) );
    }
}