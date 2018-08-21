<div class="container">


	<h2 class="text-center">

	<?php 
	$lblRole = array();
	foreach ($roles as $key) {
		$lblRole[InflectorHelper::slugify($key)] = $key;
		?>

		<a href="<?php echo Yii::app()->createUrl("/survey/co/roles/id/".$_GET["id"]."/role/".InflectorHelper::slugify($key) ) ?>" class="btn btn-xs btn-default"><?php echo $key; ?></a>
	<?php } ?>
	</h2>

	<h1 class="text-center">Synthèse <?php 
	if( @$_GET['role'] ){ ?><br/>thématique <?php echo $lblRole[ $_GET['role'] ]; } ?></h1>

	<h3>Les fiches actions <?php echo $lblRole[$_GET["role"]] ?></h3>
	<a href="" class="btn btn-primary"><i class="fa fa-plus"></i> Ajouter une FICHE ACTION</a>
	<hr>
	<?php 
	if( @$_GET['role'] ){ 
		if( count(@$answers) ){ ?>
		

		<h3>Les projets <?php echo $lblRole[$_GET["role"]] ?></h3>

		<div class="card-columns">
			
			<?php 
			$c = 1;
			foreach ( $answers as $key => $value ) {?>
				<div class="card col-xs-12 col-md-4">
					<div class="card-body padding-15 " style="border: 2px solid MidnightBlue;border-radius: 10px;min-height:265px;">
						<h4 class="card-title bold text-dark text-center padding-5" style="border-bottom:1px solid white">
							<i class="margin-5 fa fa-lightbulb fa-2x"></i><br><?php echo "#".$c." ".$value["answers"]["cte2"]["project"]["name"] ?></h4>

						<span class="card-text text-center col-xs-12 no-padding margin-bottom-20"><?php echo @$value["answers"]["cte2"]["project"]["shortDescription"] ?></span> 
						<a href="http://127.0.0.1/ph/survey/co/answer/id/<?php echo $_GET["id"] ?>/user/<?php echo $value["answers"]["cte2"]["user"] ?>" class="btn btn-default answeredfalse" style="width:100%"> Voir Réponses </a>
						 <div class="margin-top-10 rounded-bottom mdb-color lighten-3 text-center pt-3">
						    <ul class="list-unstyled list-inline font-small">
						      <li class="list-inline-item pr-2 white-text"><i class="fa fa-clock-o pr-1"></i><?php echo date("d/m/Y",@$value["answers"]["cte2"]["created"]) ?></li>
						      <li class="list-inline-item pr-2"><i class="fa fa-comments-o pr-1"></i>12</li>
						      <li class="list-inline-item pr-2"><i class="fa fa-thumbs-up pr-1"> </i>21</li>
						      <li class="list-inline-item"><i class="fa fa-thumbs-down pr-1"> </i>5</li>
						    </ul>
						  </div>
					</div>
				</div>
			<?php 
			$c++;
			} ?>

		</table>

	<?php } else { ?>

		<h2 class="text-center margin-top-50"> <i class="fa fa-circle-thin text-red"></i> <span class="text-red">Aucunes réponses validées</span> pour le moment </h2>

	<?php	}
	} else { ?>
		<p>
		Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
		tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
		quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
		consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
		cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
		proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
		</p>

		<p>
		Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
		tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
		quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
		consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
		cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
		proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
		</p>

		<p>
		Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
		tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
		quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
		consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
		cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
		proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
		</p>
	<?php } ?>
</div>
<script type="text/javascript">
	
	
</script>