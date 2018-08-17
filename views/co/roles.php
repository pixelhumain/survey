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
	<?php 
	if( @$_GET['role'] ){ 
		if( count(@$answers) ){ ?>
		
		<table border="1" id="riskList"  class="table table-striped table-bordered table-hover  directoryTable margin-bottom-20" style="width:100%;">
			
			<?php foreach ($answers as $key => $value ) {?>
				<tr>
					<th><?php echo $value["name"] ?></th>
				</tr>	
			<?php } ?>
			

			
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