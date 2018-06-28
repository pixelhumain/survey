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

<div class="panel panel-dark col-lg-offset-1 col-lg-10 col-xs-12 no-padding margin-top-50">
	<div class="col-md-12 col-sm-12 col-xs-12 text-center">
		<h1><a class="lbh" href="/ph/survey/co/answers/id/<?php echo $form["id"]; ?>"><?php echo $form["title"]; ?></a> </h1>
		<h4 style="text-align: center;padding:10px;">
			Answers by <?php echo $answer["name"]; ?>
		</h4>
    </div>

<div class="pageTable col-md-12 col-sm-12 col-xs-12 padding-20 text-center"></div>
	<div class="panel-body">
		<div>	

	<?php 
	foreach ($answer["answers"] as $key => $value) {
		
		echo "<h1>".$key."</h1>";
		echo '<table class="table table-striped table-bordered table-hover  directoryTable" id="panelAdmin">'.
			'<thead>'.
				'<tr>'.
					'<th>Question</th>'.
					'<th>Answer</th>'.
				'</tr>'.
			'</thead>'.
			'<tbody class="directoryLines">';
		if(@$form["scenario"][$key]["json"]){
			$formQ = $form["scenario"][$key]["json"]["jsonSchema"]["properties"];
			foreach ($value as $q => $a) {
				echo '<tr>';
					echo "<td>".$formQ[ $q ]["placeholder"]."</td>";
					echo "<td>".$a."</td>";
				echo '</tr>';
			}
		//todo search dynamically if key exists
		}else if(@$form["scenario"]["survey"]["json"][$key]){
			$formQ = $form["scenario"]["survey"]["json"][$key]["jsonSchema"]["properties"];
			foreach ($value as $q => $a) {
				echo '<tr>';
					echo "<td>".$formQ[ $q ]["placeholder"]."</td>";
					echo "<td>".$a."</td>";
				echo '</tr>';
			}
		} 
		else if (@$form["scenario"][$key]["saveElement"]) {
			echo '<tr>';
				echo "<td> name </td>";
				echo "<td> <a class='btn btn-default' href='http://".$value["type"]."/".$value["id"]."'>".$value["name"]."</a></td>";
			echo '</tr>';
		}
		echo "</tbody></table>";
	}


	?>
</div>
</div>
</div>



<script type="text/javascript">

$(document).ready(function() { 
	$('#doc').html( dataHelper.markdownToHtml( $('#doc').html() ) );		
});

</script>
