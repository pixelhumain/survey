<?php


//assets from ph base repo
$cssAnsScriptFilesTheme = array(
	// SHOWDOWN
	'/plugins/showdown/showdown.min.js',
	//MARKDOWN
	'/plugins/to-markdown/to-markdown.js'
);
HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesTheme, Yii::app()->request->baseUrl);

//gettting asstes from parent module repo
$cssAnsScriptFilesModule = array( 
	'/js/dataHelpers.js',
	//'/css/md.css',
);
HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, Yii::app()->getModule( Yii::app()->params["module"]["parent"] )->getAssetsUrl() );

if( $this->layout != "//layouts/empty"){
	$layoutPath = 'webroot.themes.'.Yii::app()->theme->name.'.views.layouts.';
	$this->renderPartial($layoutPath.'header',array("page"=>"ressource","layoutPath"=>$layoutPath));
}
?>

<h1 style="margin-top: 50px; text-align: center;padding:10px;">
	<img height=50 src="<?php echo $this->module->assetsUrl?>/images/logo.png">
	<a href="/ph/survey/co/answers/id/<?php echo $form["id"]; ?>"><?php echo $form["title"]; ?></a>
</h1>
<h4 style="text-align: center;padding:10px;">
	Answers by <?php echo $answer["name"]; ?>
</h4>
<div id="doc">

<?php 
foreach ($answer["answers"] as $key => $value) {
	
	echo "# ".$key."\n";
	if(@$form["scenario"][$key]["json"]){
		$formQ = $form["scenario"][$key]["json"]["jsonSchema"]["properties"];
		foreach ($value as $q => $a) {
			echo "## ".$formQ[ $q ]["placeholder"]."\n";
			echo "### ".$a."\n";
		}
	//todo search dynamically if key exists
	}else if(@$form["scenario"]["survey"]["json"][$key]){
		$formQ = $form["scenario"]["survey"]["json"][$key]["jsonSchema"]["properties"];
		foreach ($value as $q => $a) {
			echo "## ".$formQ[ $q ]["placeholder"]."\n";
			echo "### ".$a."\n";
		}
	} 
	else if (@$form["scenario"][$key]["saveElement"]) {
		echo "## name : ".$value["name"]."\n";
		echo "go to the created ".$key." here [Link](http://".$value["type"]."/".$value["id"].") \n";
	}
}


?>
</div>

<script type="text/javascript">

$(document).ready(function() { 
	$('#doc').html( dataHelper.markdownToHtml( $('#doc').html() ) );		
});

</script>
