<?php if( $canAdmin && array_search('ficheAction', $steps) <= array_search($adminAnswers["step"], $steps)) { ?>
	<div class="container">
		<div class="col-xs-12 padding-20">
			<h1 class="text-center">Fiche Action</h1>
			Liste des thématiques auxquelles le projet est associé :
			<br>
			<div class="text-center margin-top-20">
				<?php foreach ($adminAnswers["categories"] as $key => $v)  {?>
					<a href="<?php echo Yii::app()->createUrl("/survey/co/roles/id/".$adminAnswers["formId"]."/session/".$session."/role/".InflectorHelper::slugify($key) ) ?>" class="btn btn-xs btn-default"><?php echo $v["name"]; ?></a>
				<?php } ?>
			</div>
			<!-- <br>
			Liste des fiches actions auxquelles le projet est associé :
			<br> -->

		</div>
	</div>

<?php } ?>