<?php 
class Risk {
	const COLLECTION = "risks";
	const ICON = "fa-warning";
	const COLOR = "red";


	//From Post/Form name to database field name with rules
	public static $dataBinding = array(
	    "desc" => array("name" => "desc", "rules" => array("required")),
	    "type" => array("name" => "type", "rules" => array("required")),
	    "actions" => array("name" => "actions"),
	    "creator" => array("name" => "creator"),
	    "created" => array("name" => "created"),
	    "updated" => array("name" => "updated"),
	    "modified" => array("name" => "modified"),
	);
}