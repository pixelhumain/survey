<?php 
$cssAnsScriptFilesModule = array(
  '/plugins/underscore-master/underscore.js',
  '/plugins/jquery-mentions-input-master/jquery.mentionsInput.js',
  '/plugins/jquery-mentions-input-master/jquery.mentionsInput.css',
);
HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, Yii::app()->getRequest()->getBaseUrl(true));
$cssAnsScriptFilesModule = array(
  '/assets/js/comments.js',
);
HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, Yii::app()->theme->baseUrl);
    Yii::app()->params["logoUrl"]=Yii::app()->getModule("eco")->assetsUrl."/images/custom/leport/tco.png";
    Yii::app()->params["logoUrl2"]=Yii::app()->getModule("eco")->assetsUrl."/images/custom/leport/tco.png";
?> 
<style type="text/css">
  .bannerCustom{
    position: absolute;
    background-repeat: no-repeat;
    
    background-image: url(<?php echo Yii::app()->getModule("survey")->assetsUrl; ?>/images/custom/cte/banniere-tco-cteV2.jpg);
    border: none;
    height: 560px;
    width: 100%;
    /* padding: 50px; */
    top:120px;
    /*opacity: 0.7;*/
    /*filter: saturate(12%) blur(2px) sepia(100%);*/
  }
    

  .content-header{
    margin-top: 20px;
    border-radius: 5px 5px 0px 0px;
    border: 1px solid #ccc;
    background-color: rgba(250,250,250,0.9)
  }
  .logo-survey {
    overflow: hidden;
    max-height: 373px;
  }
  
  .header-survey{
   height: : 373px;
   color: #333; 
  }
  .bannertitle{
    font-size: 4em;
    background-color: #333;
    opacity: 0.75;
    width: 80%;
    line-height: 1.25;
    position: absolute;
    top: 280px;
    padding-left: 10px;
  }
</style>


<img class="img-responsive" style="display: block; margin: 0 auto;" src="<?php echo Yii::app()->getModule("survey")->assetsUrl; ?>/images/custom/cte/banniere-tco-cteV2.jpg">

<div class="container col-xs-12" >
    
    <div id="surveyContent" class="formChart  col-xs-offset-1 col-xs-10 padding-bottom-20" >

<div class="row">
	 <div class="content-header col-xs-offset-1 col-xs-10 no-padding margin-bottom-20">
  		<div class="col-xs-12 col-md-12  header-survey text-center padding-20">
  			<span><h5>
				Les projets déposés entre juin et le 17 septembre 2018 pour la 1er session du CTE sont modifiables jusqu'au 1er octobre 2018. <br/><br/>
				De nouveaux projets peuvent toujours être déposés mais ne seront pas intégrés à cette session.</h5>
			</span>
  		</div>
  	</div>
</div>
  
  <div class="content-header col-xs-offset-1 col-xs-10 no-padding margin-bottom-20">
 
		<div class="col-xs-12 col-md-12  header-survey text-center padding-20" >
			
		<?php 
			if(@$form["description"]) 
				echo "<span class='pull-left padding-20' style='font-size: 16px; text-align: left;'>".$form["description"]."</span>";

			if(!isset(Yii::app()->session['userId'])) { ?>
				<br/>
				<button class="btn btn-default bg-green margin-top-15 btn-lg" data-toggle="modal" data-target="#modalLogin">
					<i class="fa fa-sign-in"></i> <?php echo Yii::t("login","Log in") ?>
				</button>
				<button class="btn btn-link margin-top-15 btn-lg" data-toggle="modal" data-target="#modalRegister">
					<i class="fa fa-plus-circle"></i> <?php echo Yii::t("login","Create an account") ?>
				</button>

		<?php 
			}else{
      ?> 
        <table class="table table-striped table-bordered table-hover  directoryTable" style="table-layout: fixed; width:100%; word-wrap:break-word;">
        <thead>
          <tr>
            <th class="text-center col-xs-1">Session</th>
            <th class="text-center">Avancement</th>
            <th class="text-center">Organisation</th>
            <th class="text-center">Projet</th>
            <th class="text-center">Action</th>
          </tr> 
        </thead>
        <tbody>
<?php
$sessions = array();
if(@$_GET["session"])
  $sessions[(string)$_GET["session"]] = $form["session"][$_GET["session"]];
else 
  $sessions = $form["session"];

foreach ($sessions as $s => $sv) {
    //var_dump($answers);
    if(@$answers[$s]){

    foreach (@$answers[$s] as $a => $av){
      $count = count( @$av["answers"] );
        echo "<tr>";
            echo "<td>#".$s."</td>";
            $c = ($count < count($form["scenario"])) ? "orange" : $form["custom"]["color"];
            $step = ( $count == count($form["scenario"]) ) ? "<span class='badge' style='background-color:#1A242F'> ".strtoupper(@$av["step"])." </span>" : "<span class='badge' style='background-color:red'>INCOMPLET</span>" ;
            echo "<td class=' bold'><span class='text-dark badge margin-bottom-5' style='background-color:".$c."'>".$count." / ".count($form["scenario"])." </span> <br/>".$step."</td>";
            echo "<td>".@$av["answers"]["cte1"]["answers"]["organization"]["name"]."</td>";
            echo "<td>".@$av["answers"]["cte2"]["answers"]["project"]["name"]."</td>";

            echo "<td>";
			
      				if( $count < count($form["scenario"]) && !Form::isFinish(@$form["session"][$s]["endDate"] ) )
              { 
              	?>
              		<a href="<?php echo Yii::app()->getRequest()->getBaseUrl(true) ?>/survey/co/index/id/<?php echo $form['id'] ?><?php echo $count+1 ?>/session/<?php echo $s ?>/answer/<?php echo (string)$av['_id'] ?>" style="background-color:orange" class="pull-left btn btn-default answered<?php echo $count+1 ?>"  style="width:90%"><i class="fa fa-sign-in"></i> Reprendre</a>
          	  <?php }
              			
      				if($count > 0)
              { ?> 
              	<a href="<?php echo Yii::app()->getRequest()->getBaseUrl(true) ?>/survey/co/answer/id/<?php echo (string)@$av['_id'] ?> " style="background-color:<?php echo $form["custom"]["color"] ?>" class="pull-left btn btn-default answered<?php echo $count+1 ?>"  style="width:90%"><i class="fa fa-list"></i> Lire </a>

                <a href="javascript:;" class="btn btn-primary openAnswersComment" onclick="commentAnswer('<?php echo $av['_id'] ?>')">
                  <?php echo PHDB::count(Comment::COLLECTION, array("contextId"=>(string)$av['_id'],"contextType"=>Form::ANSWER_COLLECTION)); ?>
                  <i class='fa fa-comments'></i>
                </a>
          	<?php	}
              
              echo " <a href='javascript:;' data-id='".(string)$av['_id']."' class='deleteAnswer pull-right btn btn-default'><i class='fa text-red fa-times'></i> Suppr</a></td>";
          echo "</tr>";
      } 
    }

	echo "<tr><td>#".$s."</td>";
	echo " <td  colspan='4' class='text-center'>";
	if( Form::notOpen(@$sv["startDate"]) )
		echo "<h2 class='btn bold ' style='background-color:red'>La session n'a pas encore commencé.</h2>";
	else if( Form::isFinish(@$sv["endDate"]) )  
		echo "<h2 class='btn bold ' style='background-color:red'>La session est cloturé.</h2>";
	else 
		echo " <a href='".Yii::app()->getRequest()->getBaseUrl(true)."/survey/co/new/id/".$form['id']."/session/".$s."' class='btn btn-primary' style='width:100%' ><i class='fa fa-plus'></i> Ajouter une réponse</a>";
	echo "</td></tr>";
} ?>
        </tbody>
        </table>
			<?php }?>
		</div>
  </div>

<?php /* ?>
  <div class="col-xs-offset-1 col-xs-10 shadow2" >
    <?php //if(@$form["description"]) echo "<span class='text-center pull-left padding-20'>".$form["description"]."</span>" ?>
    <h2 class="text-center" style="color:#00B794" >
    <?php if( count($form["scenario"]) > count($answers)) { ?>
        Inscrivez votre <b> projet de transition écologique</b>
    <?php } else {?>
        Merci pour votre participation au CTE, <br/>
        Votre projet sera très prochainement évalué <br/>
        Et vous serez informé de la suite.<br/><br/>
        <a href="<?php echo Yii::app()->getRequest()->getBaseUrl(true) ?>/survey/co/answer/id/<?php echo $form["id"] ?>/session/<?php echo @$_GET["session"] ?>/user/<?php echo Yii::app()->session["userId"] ?>" class="btn btn-primary">Voir votre candidature</a>
    <?php } ?>
    </h2>
    <div id="surveyDesc" class="col-xs-12 padding-20"></div>
    
  </div>
*/?>
<div class="space50"></div>

  <div class="col-xs-offset-1 col-xs-10 shadow2 padding-20 margin-top-20">


  <div class="col padding-20-xs-12 col-md-6">
    <img class="img-responsive" src="http://www.tco.re/wp-content/uploads/2018/07/vignette-1_contrats-de-transition-ecologique-768x768.png" class="margin-15 pull-left">
  </div>
  <div class="col-xs-12 col-md-6 padding-20" style="font-size: 1.5em;">
    <p>En décembre 2017, le gouvernement a annoncé la création de  <span style="font-weight:bold;">«Contrats de transition écologique» </span> (CTE) pour que les territoires fassent leur transition écologique.</p> 
    <p>
      <span style="font-weight:bold;">L’ambition </span> de ces contrats est : <br/> 
    <ul>
      <li>
        d’accélérer l’action locale pour traduire les engagements pris par la France au niveau national <a href="http://www.tco.re/competences-et-projets/cte-contrat-de-transition-ecologique" target="_blank">(Plan climat)</a> et international (<a href="https://www.ecologique-solidaire.gouv.fr/accord-paris-et-cadre-international-lutte-contre-changement-climatique#e2" target="_blank">COP21</a>, One Planet Summit) ; 
      </li>
      <li>
        d’impliquer tous les acteurs du territoire autour d’un projet de transition durable (élus, acteurs économiques, partenaires sociaux, services déconcentrés, citoyens) ; et d’accompagner les mutations professionnelles.
       </li>
      </ul>
      </p>
    <p>
      <span style="font-weight:bold;">L’enjeu est de mobiliser la société autour de l’objectif de neutralité carbone d’ici 2050.</span>
    </p>
      
  </div>

<div class="col-xs-12"></div>

  <div class="col-xs-12 col-md-6 padding-20" style="font-size: 1.5em;">
    <p>
      Sur la vingtaine de <b>« Territoires d’expérimentations »</b> qui devrait être identifié au niveau national, la <b><a href="www.tco.re" target="_blank">Communauté d’agglomération du Territoire de la Côte Ouest</a></b> (TCO) a été désignée le 26 avril dernier comme territoire pilote.
    </p> 
    <p>
      Du 28 mai au 31 mai 2018, le TCO a organisé des rencontres bilatérales avec les maires et des séances de travail associant les institutions, les organismes parapublics, les organisations socioprofessionnelles et le monde économique. 
    </p>

    <p>
      Ces réunions de travail ont permis d’établir <b>le fil rouge</b> du CTE (Axes stratégiques) et de recenser des premiers projets concrets (publics et privés) matures : ayant fait l’objet d’une instruction par les services publics et/ou organismes parapublics ; qui correspondent aux <b>critères d’éligibilité du CTE :

    </p>

    <ul>
      <li>actions innovantes et réplicables</li>
      <li>actions chiffrées et mesurables</li>
      <li>actions financées</li>
      <li>actions prêtes au déploiement et réalisables dans les 3 ans</li>
    </ul>
  </b>
  <p>Le 6 juin 2018, Monsieur Sébastien LECORNU, Ministre de la Transition Ecologique a procédé au <a href="http://www.tco.re/actualite-du-tco/top-depart-pour-le-contrat-de-transition-ecologique-du-tco-20875.html"target="_blank">lancement de la séquence d’initialisation du CTE</a>.</p>
  </div>
  <div class="col-xs-12 col-md-6 padding-20" style="font-size: 1.3em;">
  <img class="img-responsive" src="http://www.tco.re/wp-content/uploads/2018/07/vignette-2_contrats-de-transition-ecologique-768x768.png" class="margin-15 pull-left">
</div>

<div class="col-xs-12"></div>

 <div class="col-xs-12 col-md-6 padding-20">
    <img class="img-responsive" src="http://www.tco.re/wp-content/uploads/2018/07/vignette-3_contrats-de-transition-ecologique-768x768.png" class="margin-15 pull-left">
  </div>
  <div class="col-xs-12 col-md-6 padding-20" style="font-size: 1.5em;">
  <p>
    <b>Le Contrat de transition écologique (CTE) du TCO sera opérationnel sur la période 2018-2021</b>
  </p>
  <p>
    Pour 2018, le contrat de transition écologique comporte <b>deux étapes :</b>
     <ul>

        <li> <b>1ère étape</b> : Une sélection de projets matures issus de la séquence d’initialisation. </li>
     </ul>
   </p>

   <p>
     <ul> 
        <li><b>2ème étape </b> : du 17 juillet au 17 septembre 2018, les acteurs économiques pourront déclarer leurs projets en ligne sur la plateforme collaborative « Communecter ».</li>
    </ul>
  </p>
  <p>
    <a href="http://www.tco.re/competences-et-projets/cte-contrat-de-transition-ecologique" target="_blank"><i class="fa fa-plus"></i> Plus d'informations sur le Contrat de transition écologique du TCO</a>
  </p>
</div>

<div class="col-xs-12  padding-20" style="font-size: 1.5em;">
		<p><b>L’objectif est de pouvoir sélectionner d’autres projets innovants, d’organiser des ateliers thématiques</b> sous l’égide des «Têtes de réseaux» et <b>signer un amendement au CTE</b> d’ici la mi-novembre 2018 :</p>
		<p>
			<ul>
				<li> <b>Thématique Production et efficacité énergétique</b> : SPL Energie, TEMERGIE, ADEME et Région ;</li>
				<li> <b>Thématique Economie circulaire et déchets</b> : ADIR, Cluster Green, CCIR, Chambre des Métiers et de l’Artisanat ;</li>
				<li> <b>Thématique Agriculture et biodiversité</b> : CIRAD, IRD, Qualitropic, Chambre d’agriculture, DAAF ;</li>
				<li> <b>Thématique Mobilités durables</b> : SMTR, Région ;</li>
				<li> <b>Thématique Economie sociale, solidaire et numérique</b> : CRESS et DIGITAL Réunion ;</li>
			</ul>
		</p>

		<p>
		Dans cette perspective, <b>le TCO</b> en tant que chef de file <b>finalise l’organisation et la méthode d’intervention en mode projet</b>, ce qui recouvre :</p>

		<p>
			<ul>
				<li> <b>Le contrat du CTE </b> (Charte d’engagements, Cadre d’intervention, les fiches projets),</li>
				<li> <b>la plateforme collaborative numérique Communecter </b> (Charte de fonctionnement, et applications),</li>
				<li> <b>l’Avis d’appel à projet</b> (AAP) du CTE</li>
				<li> <b>l’organisation du CTE</b> (Guichet unique, COPIL, Calendrier, la méthodologie etc.).</li>
			</ul>
		 </p>
	</div>
 </div>

 <div class="space50"></div>

  <div class="col-xs-offset-1 col-xs-10 shadow2 padding-20 margin-top-20">
    <h3 class="text-center ">Les 4 étapes du CTE </h3>
    <div class="card col-xs-12 col-md-3">
        <div class="card-body padding-15" style="border: 2px solid <?php echo $form["custom"]["color"] ?>; border-radius: 10px;min-height:200px;">
          <h4 class="card-title bold text-dark text-center padding-5" style="border-bottom:1px solid white">
              <i class="margin-5 fa fa-folder-open-o fa-2x"></i><br/>
              1. Collecte
          </h4> 
          <span class="card-text text-center col-xs-12 no-padding ">
          Soumettre un projet
          </span>

      </div>
    </div>

    <div class="card col-xs-12 col-md-3">
        <div class="card-body padding-15" style="border: 2px solid <?php echo $form["custom"]["color"] ?>; border-radius: 10px;min-height:200px;">
          <h4 class="card-title bold text-dark text-center padding-5" style="border-bottom:1px solid white">
              <i class="margin-5 fa fa-gavel fa-2x"></i><br/>
              2. Eligibilité
          </h4> 
          <span class="card-text text-center col-xs-12 no-padding ">
          Établir le lien avec le CTE
          </span>
      </div>
    </div>

    <div class="card col-xs-12 col-md-3">
        <div class="card-body padding-15" style="border: 2px solid <?php echo $form["custom"]["color"] ?>; border-radius: 10px;min-height:200px;">
          <h4 class="card-title bold text-dark text-center padding-5" style="border-bottom:1px solid white">
              <i class="margin-5 fa fa-flag-checkered fa-2x"></i><br/>
              3. Instruction - Selection 
          </h4> 
          <span class="card-text text-center col-xs-12 no-padding ">
          Consolider le projet
          </span>
      </div>
    </div>

    <div class="card col-xs-12 col-md-3">
        <div class="card-body padding-15" style="border: 2px solid <?php echo $form["custom"]["color"] ?>; border-radius: 10px;min-height:200px;">
          <h4 class="card-title bold text-dark text-center padding-5" style="border-bottom:1px solid white">
              <i class="margin-5 fa fa-cogs fa-2x"></i><br/>
              4. Écosystème 
          </h4> 
          <span class="card-text text-center col-xs-12 no-padding">
          Interconnecter les acteurs
          </span>
      </div>
    </div>
  </div>

  <div class="space20"></div>

</div>

 <script type="text/javascript">
   $(document).ready(function() { 
  
  $('.deleteAnswer').off().click( function(){
      id = $(this).data("id");
      bootbox.dialog({
          title: "Confirmez la suppression du dossier",
          message: "<span class='text-red bold'><i class='fa fa-warning'></i> Cette action sera irréversible</span>",
          buttons: [
            {
              label: "Ok",
              className: "btn btn-primary pull-left",
              callback: function() {
                window.location.href = baseUrl+"/survey/co/delete/id/"+id;
              }
            },
            {
              label: "Annuler",
              className: "btn btn-default pull-left",
              callback: function() {}
            }
          ]
      });
    });
});

   function commentAnswer(answerId){
  var modal = bootbox.dialog({
          message: '<div class="content-risk-comment-tree"></div>',
          title: "Fil de commentaire du projet",
          buttons: [
          
            {
              label: "Annuler",
              className: "btn btn-default pull-left",
              callback: function() {
                console.log("just do something on close");
              }
            }
          ],
          onEscape: function() {
            modal.modal("hide");
          }
      });
    modal.on("shown.bs.modal", function() {
      $.unblockUI();
        getAjax(".content-risk-comment-tree",baseUrl+"/"+moduleId+"/comment/index/type/answers/id/"+answerId,
      function(){  //$(".commentCount").html( $(".nbComments").html() ); 
      },"html");

      //bindEventTextAreaNews('#textarea-edit-news'+idNews, idNews, updateNews[idNews]);
    });
     // modal.modal("show");
  //}
}
 </script>