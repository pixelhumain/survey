<?php
$cssJS = array(
    '/plugins/jquery.dynForm.js',
    '/plugins/jquery.dynSurvey/jquery.dynSurvey.js',
); 
HtmlHelper::registerCssAndScriptsFiles($cssJS, Yii::app()->request->baseUrl);
?>

<style type="text/css">
.simple-pagination li a, .simple-pagination li span {
    border: none;
    box-shadow: none !important;
    background: none !important;
    color: #2C3E50 !important;
    font-size: 16px !important;
    font-weight: 500;
}
.simple-pagination li.active span{
	color: #d9534f !important;
    font-size: 24px !important;	
}
</style>

<div class="panel panel-white col-lg-offset-1 col-lg-10 col-xs-12 no-padding margin-top-50">
	<div class="col-md-12 col-sm-12 col-xs-12 text-center">
		<h1><?php echo $form["title"] ?> <a href="/ph/survey/co/index/id/<?php echo $form["id"] ?>"><i class="fa fa-arrow-circle-right"></i></a> </h1>
		<div id="" class="" style="width:80%;  display: -webkit-inline-box;">
	    	<input type="text" class="form-control" id="input-search-table" 
	                        placeholder="search by name or by #tag, ex: 'commun' or '#commun'">
		    <button class="btn btn-default hidden-xs menu-btn-start-search-admin btn-directory-type">
		        <i class="fa fa-search"></i>
		    </button>
	    </div>
    </div>
	
	
	<div class="pageTable col-md-12 col-sm-12 col-xs-12 padding-20 text-center"></div>
	<div class="panel-body">
		<div id="answerList">	
			
		</div>
	</div>
	<div class="pageTable col-md-12 col-sm-12 col-xs-12 padding-20"></div>
</div>

<div class="formFund" style="display:none;">
	<form class="inputFund" role="form">
		<input type="fundAmount" name="fundAmount" id="fundAmount">
	</form>
</div>

<script type="text/javascript">

jQuery(document).ready(function() {

	dyFObj.elementData = <?php echo json_encode( $answers ) ?>;
	dyFObj[dyFObj.activeElem] = <?php echo json_encode( $form ) ?>;
	var after = { 
		
		"vote" : {
			test : "voteUp",
			btn:"<a href='javascript:;' class='voteBtn btn btn-primary'><i class='fa fa-thumbs-up'></i></a>",
			else : "<a href='javascript:;' class='voteListBtn btn btn-default'><i class='fa fa-bars'></i></a>",
			pre : {
				lbl : "nb de vote",
				value:"voteUpCount",
				class : "badge"
			}
		}, 
		"fund" : {
			test : "fund",
			btn:"<a href='javascript:;' class='fundBtn btn btn-primary'><i class='fa fa-money'></i></a>",
			else : "<a href='javascript:;' class='fundListBtn btn btn-default'><i class='fa fa-bars'></i></a>",
			pre : {
				lbl : "nb de financeur",
				value:"fundCount",
				class : "badge"
			}
		} 
	};
	dyFObj.drawAnswers( "#answerList","answers", { session : "#<?php echo @$_GET['session']; ?>" },after );


	$('.voteBtn').click(function() { 
		//alert( "vote : "+$(this).parent().data('type')+" : "+$(this).parent().data('id') );
		elParent = $(this).parent();

		$.ajax({ type: "POST",
	        url: baseUrl+"/co2/action/addaction/",
	        data: {
	        	"action" : "voteUp",
				"collection" : $(this).parent().data('type'),
				"id" : $(this).parent().data('id')
	        },
			type: "POST",
	    }).done(function (data) {
	    	elParent.html("<i class='fa fa-thumbs-up'></i>")
			toastr.success('vote enregistré, merci!!');
	    });
	});

	$('.voteListBtn').click(function() { 
		getModal({ title : "Liste des voteurs de ce projet." ,
				   icon : "thumbs-up" }, "");
	});

	$('.fundBtn').click(function() { 
		//alert( "fund : "+$(this).parent().data('type')+" : "+$(this).parent().data('id') );
		elParent = $(this).parent();

		fundModal = bootbox.dialog({
	        message: $(".formFund").html(),
	        title: "Participez à financer ce projet",
	        show: false,
	        onEscape: function() {
	          fundModal.modal("hide");
	        },
	        buttons: {
	            success: {
	                label: "CoFund",
	                className: "btn-primary",
	                callback: function () {
	                    $.ajax({ type: "POST",
					        url: baseUrl+"/co2/action/addaction/",
					        data: {
					        	"action" : "fund",
								"collection" : elParent.data('type'),
								"id" : elParent.data('id'),
								"detail" : {
									amount : $($("input#fundAmount")[1]).val()
								}
					        },
							type: "POST",
					    }).done(function (data) {
					    	elParent.html("<i class='fa fa-thumbs-up'></i>")
					    	toastr.success('participation enregistré, merci!!');
					    });
	                }
	            },
	            cancel: {
	            	label: trad["cancel"],
	            	className: "btn-secondary",
	            	callback: function() {
	    				fundModal.modal("hide");        		
	            	}
	            }
	        }
	    });
	    fundModal.modal("show");
	});

	$('.fundListBtn').click(function() { 
		getModal({ title : "Liste des financeurs de ce projet.",
				   icon : "money" }, "");
	});
});	
</script>