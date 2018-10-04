<div class="row margin-top-20  padding-20">

	<h1 class="text-center bold"> Tout les Formulaires </h1>
	<a href="javascript:;" onclick="dyFObj.openForm('action','sub')" class="btn btn-primary"><i class="fa fa-plus"></i> Demander un formulaire</a>
	<div class="card-columns col-xs-12 padding-15 ">
		<?php
		if( @$forms )
		{
			foreach ( $forms as $key => $value ) 
			{ ?>
				<div class="card col-xs-12 col-md-4 margin-bottom-10">
					<div class="card-body padding-15 " style="border: 2px solid MidnightBlue;border-radius: 10px;min-height:265px;">
						<h4 class="card-title bold text-dark text-center padding-5" style="border-bottom:1px solid white">
							<i class="margin-5 fa fa-lightbulb fa-2x"></i><br><?php echo $value["title"] ?></h4>
						
						<span class="card-text text-center col-xs-12 no-padding margin-bottom-20"><?php echo @$value["description"] ?></span> 
						<a href="<?php echo Yii::app()->createUrl("/survey/co/index/id/".$value["id"]); ?>" class="btn btn-default answeredfalse" style="width:100%"> Découvrir </a>
						 <div class="margin-top-10 rounded-bottom mdb-color lighten-3 text-center pt-3">
						    <ul class="list-unstyled list-inline font-small">
						      <li class="list-inline-item pr-2 white-text"><i class="fa fa-clock-o pr-1"></i> <?php echo date("d/m/Y",@$value["created"]) ?></li>
						      <li class="list-inline-item pr-2"><i class="fa fa-users pr-1"></i>12</li>
						    </ul>
						  </div>
					</div>
				</div>
			<?php 
			} 
		}?>

	</div>

</div>

<div class="row margin-top-20  padding-20">

	<h1 class="text-center bold"> TERRITORIAL SURVEYS & WEBFORMS </h1>
	
	<div class="col-xs-12">
		<div class="col-xs-6 padding-20">
		<h1 class="text-center">BUILD YOUR PROCESS</h1>
		<div class="col-xs-6 col-md-offset-2 padding-20">
		Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
		tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
		quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
		consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
		cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
		proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div></div>
		<div class="col-xs-6"><img class="img-responsive" src='<?php echo Yii::app()->getModule("survey")->assetsUrl; ?>/images/home/sample.png'> </div>
		</div>
	</div>

	<div class="col-xs-12 margin-top-20">
		<div class="col-xs-6"><img class="img-responsive" src='<?php echo Yii::app()->getModule("survey")->assetsUrl; ?>/images/home/evan-dennis-75563-unsplash.jpg'> </div>
		<div class="col-xs-6 padding-20">
		<h1 class="text-center">GET ANSWERS TO YOUR QUESTIONS</h1>
		<div class="col-xs-6 col-md-offset-2 padding-20">
		Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
		tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
		quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
		consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
		cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
		proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div></div>
	</div>
	
	<div class="col-xs-12">
		<div class="col-xs-6 padding-20">
		<h1 class="text-center">CROWD KNOWLEDGE & COLLECTIVE INTELLIGENCE</h1>
		<div class="col-xs-6 col-md-offset-2 padding-20">
		Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
		tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
		quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
		consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
		cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
		proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div></div>
		<div class="col-xs-6"><img class="img-responsive" src='<?php echo Yii::app()->getModule("survey")->assetsUrl; ?>/images/home/edwin-andrade-153753-unsplash.jpg'> </div>
		</div>
	</div>

	<div class="col-xs-12">
		<div class="col-xs-6"><img class="img-responsive" src='<?php echo Yii::app()->getModule("survey")->assetsUrl; ?>/images/home/glen-noble-18012-unsplash.jpg'> </div>
		<div class="col-xs-6 padding-20">
		<h1 class="text-center">PROJECT MUTUALISATION & EVALUATIONS </h1>
		<div class="col-xs-6 col-md-offset-2 padding-20">
		Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
		tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
		quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
		consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
		cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
		proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div></div>
	</div>

	<div class="col-xs-12">
		
		<div class="col-xs-6 padding-20">
		<h1 class="text-center"> TOOLS FOR DEMOCRACY </h1>
		<div class="col-xs-6 col-md-offset-2 padding-20">
		Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
		tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
		quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
		consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
		cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
		proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div></div>
		<div class="col-xs-6"><img class="img-responsive" src='<?php echo Yii::app()->getModule("survey")->assetsUrl; ?>/images/home/my-life-through-a-lens-110632-unsplash.jpg'> </div>
	</div>

	<div class="col-xs-12">
		<div class="col-xs-6"><img class="img-responsive" src='<?php echo Yii::app()->getModule("survey")->assetsUrl; ?>/images/home/cody-davis-253928-unsplash.jpg'> </div>
		<div class="col-xs-6 padding-20">
		<h1 class="text-center">OPEN SOURCE & LIBRE SOFTWARE </h1>
		<div class="col-xs-6 col-md-offset-2 padding-20">
		Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
		tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
		quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
		consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
		cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
		proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div></div>
	</div>

	<div class="col-xs-12">
		
		<div class="col-xs-6 padding-20">
		<h1 class="text-center"> BUILD PARTICIPATIVE COMMUNITIES </h1>
		<div class="col-xs-6 col-md-offset-2 padding-20">
		Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
		tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
		quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
		consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
		cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
		proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div></div>
		<div class="col-xs-6"><img class="img-responsive" src='<?php echo Yii::app()->getModule("survey")->assetsUrl; ?>/images/home/tim-marshall-114623-unsplash.jpg'> </div>
	</div>

	<div class="col-xs-12">
		<div class="col-xs-6"><img class="img-responsive" src='<?php echo Yii::app()->getModule("co2")->assetsUrl; ?>/images/logoBtn.png'> </div>
		<div class="col-xs-6 padding-20">
		<h1 class="text-center">LOVE & CO </h1>
		<div class="col-xs-6 col-md-offset-2 padding-20">
		Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
		tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
		quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
		consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
		cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
		proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div></div>
	</div>




	

</div>