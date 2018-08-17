<?php if( $canAdmin && array_search('ficheAction', $steps) <= array_search($adminAnswers["step"], $steps)) { ?>
	<div class="container">
		<div class="col-xs-12 padding-20">
			<h1 class="text-center">Projet Passé en Fiche Action</h1>
			Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
			tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
			quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
			consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
			cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
			proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
			<br>
			<div class="text-center margin-top-20">
				<?php foreach ($adminAnswers["categories"] as $key => $v)  {?>
					<a href="<?php echo Yii::app()->createUrl("/survey/co/roles/id/".$_GET["id"]."/role/".InflectorHelper::slugify($key) ) ?>" class="btn btn-xs btn-default"><?php echo $v["name"]; ?></a>
				<?php } ?>
			</div>
		</div>
	</div>

<?php } ?>