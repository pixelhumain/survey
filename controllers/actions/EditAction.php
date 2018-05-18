<?php
class EditAction extends CAction
{
    public function run() {
		$controller=$this->getController();
		$id=$_POST["id"];
		$type=$_POST["type"];
		//echo $idProject;
		if(!empty($_POST["properties"]) && gettype ($_POST["properties"]) != "string"){
			if(@$_POST["properties"]["commons"]){
				$newProperties=$_POST["properties"]["commons"];
				$label="commons";
			}else if(@$_POST["properties"]["open"]){
				$newProperties=$_POST["properties"]["open"];
				$label="open";
			}
			
		}
		else{
			$label=$_POST["properties"];
			$newProperties=[];
		}
		/*$propertiesList=[];
		if(!empty($newProperties)){
			foreach ($newProperties as $data){
				$propertiesList[$data["label"]]=$data["value"];
			}
		}*/

		if (!empty($newProperties)){
        	$res = Form::save($type,$id,$newProperties, $label);
        }
        else
        	$res = Form::remove($type,$id, $label);

  		echo json_encode(array("result"=>true, "properties"=>$newProperties, "msg"=>Yii::t("common", "properties well updated")));
        exit;
	}
}