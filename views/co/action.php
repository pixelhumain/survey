
<h1 class="text-center"> <i class="fa fa-folder-open-o"></i> FICHE ACTION </h1>

<?php 
	/* ---------------------------------------------
	ETAPE DU SCENARIO
	---------------------------------------------- */

	echo $this->renderPartial( "answerScenario" , array("form"=>$form,
														"answers" => $action,
														"user" => $form["user"] ) ); 
 



 ?>