<?php 
    Yii::app()->params["logoUrl"]=Yii::app()->getModule("eco")->assetsUrl."/images/custom/leport/tco.png";
    Yii::app()->params["logoUrl2"]=Yii::app()->getModule("eco")->assetsUrl."/images/custom/leport/tco.png";
?> 
<style type="text/css">
  .banner-tce{
    position: absolute;
    background-repeat: no-repeat;
    background-position: center;
    background-image: url(<?php echo Yii::app()->getModule("eco")->assetsUrl; ?>/images/custom/leport/banner.png);
    border: none;
    height: 450px;
    /* padding: 50px; */
    overflow: hidden;
    top:100px;
    left: -20px;
    right: -20px;
    opacity: 0.7;
    /*filter: saturate(12%) blur(2px) sepia(100%);*/
  }
  .content-header{
    height: 325px;
    margin-top: 110px;
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
</style>
<h1 class="text-center padding-20"> Contrat de Transition Écologique Du TCO </h1>
<div class="row margin-top-20">
  <div class="banner-tce">
  </div>
  <div class="content-header col-xs-offset-1 col-xs-10 no-padding">
      <div class="col-xs-6 logo-survey no-padding">
          <img class="img-responsive" src='<?php echo Yii::app()->getModule("survey")->assetsUrl; ?>/images/custom/cte/logo-tco-cte.jpg'> 
      </div>
      <div class="col-xs-6 header-survey text-center padding-20" >
        
        <?php if(@$form["description"]) echo "<span class='text-center pull-left padding-20'>".$form["description"]."</span>" ?>
        <?php if(!isset(Yii::app()->session['userId'])) { ?>
        <br/>
        <button class="btn btn-default bg-green margin-top-15" data-toggle="modal" data-target="#modalLogin">
          <i class="fa fa-sign-in"></i> <?php echo Yii::t("login","Log in") ?>
        </button>
        <button class="btn btn-link margin-top-15" data-toggle="modal" data-target="#modalRegister">
          <i class="fa fa-plus-circle"></i> <?php echo Yii::t("login","Create an account") ?>
         </button>
        
        <?php }else{ 
            $count=count($answers);
            $label=($count > 0) ? "Reprendre le dossier" : "Déposer une candidature"; 
          ?>
          <a href="<?php echo Yii::app()->getRequest()->getBaseUrl(true) ?>/survey/co/index/id/cte<?php echo $count+1 ?>" style="background-color:#00B794" class="btn btn-default answered<?php echo $count+1 ?>"  style="width:90%"><i class="fa fa-sign-in"></i> <?php echo $label ?></a>
        <?php  } ?>
      </div>
  </div>
  <div class="col-xs-offset-1 col-xs-10 shadow2" >
    <?php //if(@$form["description"]) echo "<span class='text-center pull-left padding-20'>".$form["description"]."</span>" ?>
    <h2 class="text-center" style="color:#00B794" >
    <?php if( count($form["scenario"]) > count($answers)) { ?>
        Inscrivez votre <b> projet de transition écologique</b>
    <?php } else {?>
        Merci pour votre participation au CTE, <br/>
        Votre projet sera très prochainement évalué <br/>
        Et vous serez informé de la suite.<br/><br/>
        <a href="<?php echo Yii::app()->getRequest()->getBaseUrl(true) ?>/survey/co/answer/id/<?php echo $form["id"] ?>/user/<?php echo Yii::app()->session["userId"] ?>" class="btn btn-primary">Revoir vos réponses</a>
    <?php } ?>
    </h2>
    <div id="surveyDesc" class="col-xs-12"></div>
    <div class="clear margin-bottom-20"></div>
  </div>

<div class="space50"></div>

  <div class="col-xs-offset-1 col-xs-10 shadow2 padding-20 margin-top-20">


  <div class="col padding-20-xs-12 col-md-6">
    <img class="img-responsive" src="http://www.tco.re/wp-content/uploads/2018/07/vignette-1_contrats-de-transition-ecologique-768x768.png" class="margin-15 pull-left">
  </div>
  <div class="col-xs-12 col-md-6 padding-20" style="font-size: 1.5em;">
    En décembre 2017, le gouvernement a annoncé la création de  «Contrats de transition écologique» (CTE) pour que les territoires fassent leur transition écologique.  L’ambition de ces contrats est d’accélérer l’action locale pour traduire les engagements pris par la France au niveau national <a href="https://www.ecologique-solidaire.gouv.fr/politiques/plan-climat" target="_blank">(Plan climat)</a> et international (<a href="https://www.ecologique-solidaire.gouv.fr/accord-paris-et-cadre-international-lutte-contre-changement-climatique#e2" target="_blank">COP21</a>, One Planet Summit) ; d’impliquer tous les acteurs du territoire autour d’un projet de transition durable (élus, acteurs économiques, partenaires sociaux, services déconcentrés, citoyens) ; et d’accompagner les mutations professionnelles. L’enjeu est de mobiliser la société autour de l’objectif de neutralité carbone d’ici 2050.
  </div>

<div class="col-xs-12"></div>

 <div class="col-xs-12 col-md-6 padding-20" style="font-size: 1.3em;">
    Sur la vingtaine de « Territoires d’expérimentations » qui devrait être identifié au niveau national, la Communauté d’agglomération du Territoire de la Côte Ouest (TCO) a été désignée le 26 avril dernier comme territoire pilote. Du 28 mai au 31 mai 2018, le TCO a organisé des rencontres bilatérales avec les maires et des séances de travail associant les institutions, les organismes parapublics, les organisations socioprofessionnelles et le monde économique.  Ces réunions de travail ont permis d’établir le fil rouge du CTE (Axes stratégiques) et de recenser des premiers projets concrets (publics et privés) matures : ayant fait l’objet d’une instruction par les services publics et/ou organismes parapublics ; qui correspondent aux <b>critères d’éligibilité du CTE (actions innovantes et réplicables ; actions chiffrées et mesurables ; actions financées ; actions prêtes au déploiement et réalisables dans les 3 ans )</b>. Le 06 juin 2018, Monsieur Sébastien LECORNU, Ministre de la Transition Ecologique a procédé au lancement de la stratégiquesuence d’initialisation du CTE.
  </div>
  <div class="col-xs-12 col-md-6 padding-20" style="font-size: 1.3em;">
  <img class="img-responsive" src="http://www.tco.re/wp-content/uploads/2018/07/vignette-2_contrats-de-transition-ecologique-768x768.png" class="margin-15 pull-left">
</div>

<div class="col-xs-12"></div>

 <div class="col-xs-12 col-md-6 padding-20">
    <img class="img-responsive" src="http://www.tco.re/wp-content/uploads/2018/07/vignette-3_contrats-de-transition-ecologique-768x768.png" class="margin-15 pull-left">
  </div>
  <div class="col-xs-12 col-md-6 padding-20" style="font-size: 1.3em;">
  <b>Le Contrat de transition écologique (CTE) du TCO sera opérationnel sur la période 2018-2021</b>
   <ul>

      <li> La première étape du CTE consistera à intégrer au CT, de la mi-juillet 2018, les projets matures issus de la séquence d’initialisation du mois de juin dernier.</li>
       
      <li>La seconde étape consistera à lancer un avis d’appel à projet (AAP) du 17 juillet au 17 août 2018 afin que les porteurs de projets (publics et privés) puissent déclarer leurs actions sur la plateforme collaborative « COMMUNECTER » du TCO, et afin que les experts (Têtes de réseau et Club des financeurs) réunis de manière collégiale en comité thématique (COTEM) puissent : se prononcer sur les conditions d’éligibilité des projets ; expertiser le projet (complétude, consistance, contraintes, cadre d’intervention etc.) ;  produire des recommandation ;  présélectionner les projets matures. Ceci dans l’objectif de communiquer au comité de pilotage (COPIL) du CTE une liste de projets prêts au déploiement, qui pourraient intégrer le CTE du TCO en fin d’année.</li>
       
      <li>D’autres avis d’appel à projet seront organisés sur la période 2019-2021, à raison d’un avis d’appel à projet par an.</li>
  </ul>
</div>

<div class="text-center margin-top-20">
  <img src="http://www.tco.re/wp-content/uploads/2018/07/slide-ppt_contrats-de-transition-ecologique-768x74.jpg">
</div>
 </div>

 <div class="space50"></div>

  <div class="col-xs-offset-1 col-xs-10 shadow2 padding-20 margin-top-20">
    <h3 class="text-center ">4 étapes du CTE </h3>
    <div class="card col-xs-3">
        <div class="card-body padding-15" style="border: 2px solid #00B795; border-radius: 10px;min-height:200px;">
          <h4 class="card-title bold text-dark text-center padding-5" style="border-bottom:1px solid white">
              <i class="margin-5 fa fa-folder-open-o fa-2x"></i><br/>
              1. Collecte
          </h4> 
          <span class="card-text text-center col-xs-12 no-padding ">
          09 juil. au 09 aout<br/>
          Soumettre un projet
          </span>

      </div>
    </div>

    <div class="card col-xs-3">
        <div class="card-body padding-15" style="border: 2px solid #00B795; border-radius: 10px;min-height:200px;">
          <h4 class="card-title bold text-dark text-center padding-5" style="border-bottom:1px solid white">
              <i class="margin-5 fa fa-gavel fa-2x"></i><br/>
              2. Eligibilité
          </h4> 
          <span class="card-text text-center col-xs-12 no-padding ">
          17 aout au 17 sept<br/>
          Établir le lien avec le CTE
          </span>
      </div>
    </div>

    <div class="card col-xs-3">
        <div class="card-body padding-15" style="border: 2px solid #00B795; border-radius: 10px;min-height:200px;">
          <h4 class="card-title bold text-dark text-center padding-5" style="border-bottom:1px solid white">
              <i class="margin-5 fa fa-flag-checkered fa-2x"></i><br/>
              3. Instruction - Selection 
          </h4> 
          <span class="card-text text-center col-xs-12 no-padding ">
          17 sept. au 17 oct.<br/>
          Consolider le projet
          </span>
      </div>
    </div>

    <div class="card col-xs-3">
        <div class="card-body padding-15" style="border: 2px solid #00B795; border-radius: 10px;min-height:200px;">
          <h4 class="card-title bold text-dark text-center padding-5" style="border-bottom:1px solid white">
              <i class="margin-5 fa fa-cogs fa-2x"></i><br/>
              4. Écosystème
          </h4> 
          <span class="card-text text-center col-xs-12 no-padding">
          17 oct. au 17 nov.<br/>
          Suivre et interconnecter les acteurs
          </span>
      </div>
    </div>
  </div>

  <div class="space20"></div>

</div>

 