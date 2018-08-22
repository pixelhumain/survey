<?php
$cssAnsScriptFilesModule = array(
    '/plugins/jquery-simplePagination/jquery.simplePagination.js',
	'/plugins/jquery-simplePagination/simplePagination.css',
	'/plugins/select2/select2.min.js' ,
	'/plugins/select2/select2.css',
);
HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, Yii::app()->getRequest()->getBaseUrl(true));

$cssAnsScriptFilesModule = array( 
	'/js/eligible.js',
);
HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, Yii::app()->getModule( "survey" )->getAssetsUrl() );


$cssJS = array(
    '/js/dataHelpers.js'
);
HtmlHelper::registerCssAndScriptsFiles($cssJS, Yii::app()->getModule( Yii::app()->params["module"]["parent"] )->getAssetsUrl() );

?>

<style type="text/css">
	.round{
		border-radius: 100%;
		width: 250px;
		height: 250px;
		padding-top: 70px;
		border-color: #333;
 	}
</style>
<div class="panel panel-white col-lg-offset-1 col-lg-10 col-xs-12 no-padding">
	
	<div class="col-md-12 col-sm-12 col-xs-12 text-center">
		<h1><?php echo $form["title"] ?> <a href="<?php echo Yii::app()->getRequest()->getBaseUrl(true) ?>/survey/co/index/id/<?php echo $form["id"] ?>"><i class="fa fa-arrow-circle-right"></i></a> </h1>

		<h2 class="text-center">
			<a href="javascript:;" onclick="showType('line')" class="btn btn-xs btn-default">Tous</a>
			<?php 
			$lblRole = array();
			foreach ($form["custom"]["roles"] as $key) {
				$lblRole[InflectorHelper::slugify($key)] = $key;
				?>
				<a href="javascript:;" onclick="showType('<?php echo InflectorHelper::slugify($key)?>')" class="btn btn-xs btn-default"><?php echo $key; ?></a>
			<?php } ?>
			</h2>

		<div style="width:80%;  display: -webkit-inline-box;">
	    	<input type="text" class="form-control" id="search" placeholder="search by name or by #tag, ex: 'commun' or '#commun'">
	    </div>
    </div>
	<div class="pageTable col-md-12 col-sm-12 col-xs-12 padding-20 text-center"></div>
	<div class="panel-body">
		<div>
			<!-- <a href="<?php //echo '#element.invite.type.'.Form::COLLECTION.'.id.'.(string)$form['_id'] ; ?>" class="btn btn-primary btn-xs pull-right margin-10 lbhp">Invite Admins & Participants</a> -->
			<span><b>Il y a <?php echo count(@$results); ?> réponses</b></span> 
			<a href="<?php echo Yii::app()->createUrl('survey/co/roles/id/'.$_GET["id"]); ?>" class="pull-right btn btn-xs btn-primary margin-10">Fiche Action</a>
			<br/>

			<table class="table table-striped table-bordered table-hover directoryTable" id="panelAdmin">
				<thead>
					<tr>
						<th>#</th>
						<th>Nom du projet</th>
						<th>Organisation</th>
						<th>Utilisateur</th>
						<th>Etape</th>
						<th>Voir la réponse</th>
						<th>Eligibilité</th>
						<th>Priorisation</th>
						<th>Risques</th>
						<th>Fiche Action</th>
					</tr>
				</thead>
				<tbody class="directoryLines">
					<?php
						$nb = 0;
						foreach ($results as $k => $v) {
							$nb++;
						?>
						<tr class="<?php if(@$userAdminAnswer[$k]["categories"])foreach (@$userAdminAnswer[$k]["categories"] as $key => $value) {
									echo $key." ";
								}
								 ?> line">
							<td><a href="<?php echo Yii::app()->getRequest()->getBaseUrl(true) ; ?>/survey/co/logs/id/<?php echo $form['id'] ?>/user/<?php echo @$k  ?>" ><?php echo @$nb ?></a></td>
							<td><?php echo @$v['name'] ?></td>
							<td><?php echo @$v['parentName'] ?></td>
							<td><?php echo @$v['userName'] ?></td>
							<td>
								<?php
								$c = 0 ;
								foreach ($v['scenario'] as $key => $value) {
									if($value == true)
										$c++;
								}
								$classText = ($c == count(@$v['scenario'])) ? 'text-success' : 'text-red';
								echo "<span class='".$classText."'>".$c." / ".count(@$v['scenario'])."</span>"; ?>
							</td>
							<td><a href="<?php echo Yii::app()->getRequest()->getBaseUrl(true) ; ?>/survey/co/answer/id/<?php echo $form['id'] ?>/user/<?php echo @$k  ?>" target="_blanck" class="btn btn-primary">Lire</a></td>
							<td><?php if(isset($userAdminAnswer[$k]["eligible"])){ echo ($userAdminAnswer[$k]["eligible"]) ? "Éligible" : "Non Éligible"; } ?></td>
							<td><?php if(@$userAdminAnswer[$k]["categories"]){
								foreach ($userAdminAnswer[$k]["categories"] as $key => $value) {
									echo $value["name"]."<br/>";
								}
								} ?></td>
							<td><?php if(@$userAdminAnswer[$k]["risks"]){
								echo count(array_keys($userAdminAnswer[$k]["risks"]));
								} ?></td>
							<td><?php echo (@$userAdminAnswer[$k]["step"] == "ficheAction") ? "Selectionné" : ""; ?></td>
						</tr>
						<?php
					} ?>
				</tbody>
			</table>
			
		</div>
	</div>
	<div class="pageTable col-md-12 col-sm-12 col-xs-12 padding-20"></div>
</div>

<script type="text/javascript">

function showType (type) { 
	$(".line").hide();
	$("."+type).show();
}

jQuery(document).ready(function() {
	
	$("#search").on("keyup", function() {
	    var value = $(this).val().toLowerCase();
	    $("#panelAdmin tr.line").filter( function() {
	      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
	    });
	});

});



</script> 

