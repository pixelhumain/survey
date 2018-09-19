<div class="modal fade" role="dialog" id="modalSwitchLink">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-green-k text-white">
                <h4 class="modal-title"><i class="fa fa-check"></i> <?php echo Yii::t("login","Choisissez la catégorie du projet") ?></h4>
            </div>
            <div class="modal-body center text-dark" style="height: 300px;">
	            <div class="col-xs-12">
	            	<h5><i class="fa fa-angle-down"></i> Search</h5>
					<input type="text" class="form-control text-left" placeholder='<?php echo Yii::t("invite", "A name, an e-mail..."); ?>' autocomplete = "off" id="inviteSearch" name="inviteSearch" value="">
					<div class="col-xs-12 no-padding" id="dropdown-search-invite" style="max-height: 400px; overflow: auto;"></div>
	                 <!-- <input type="hidden" name="answerId" id="answerId" value=""/>
	                 <input type="hidden" name="eligible" id="eligible" value=""/> -->
	            </div>

	            <div id="select" class="col-xs-12">
	            	<h5><i class="fa fa-angle-down"></i> Selectionner</h5>
					<span id="name"></span><br/>
					<span id="id"></span><br/>
					<div class="modal-footer">
						<button id="validEligible" type="button" class="btn btn-default letter-green" data-dismiss="modal"><i class="fa fa-check"></i> Validez </button>
		            </div>
	            </div>
            </div>
           
        </div>
    </div>
</div>

<script type="text/javascript">

jQuery(document).ready(function() {
	$('#modalSwitchLink #inviteSearch').keyup(function(e){
		var search = $('#modalSwitchLink #inviteSearch').val();
		mylog.log("#modalSwitchLink #inviteSearch", search);
		if(search.length>2){
			clearTimeout(timeout);
			timeout = setTimeout('autoCompleteInviteModalSwitchLink("'+encodeURI(search)+'")', 500); 
		}else{
			$("#modalSwitchLink #dropdown-search-invite").hide();
			$("#modalSwitchLink #form-invite").hide();
		}
	});

	$("#modalSwitchLink #validEligible").off().on("click",function(){
		var params = {
			answerId : adminAnswers._id.$id,
			id : $('#modalSwitchLink #id').html()
		};

		$.ajax({
			type: "POST",
			url: baseUrl+'/'+activeModuleId+"/co/switch/",
			data:params,
			dataType: "json",
			success: function(data){
				mylog.log("activeBtn ok");

				if(data.result == true){
					toastr.success(data.msg);
					window.location.reload();
				}else{
					toastr.error(data.msg);
				}
				
			},
			error: function (error) {
				mylog.log("activeBtn error", error);
				toastr.error("Projet non éligible");
			}	
		});
	});
});

function autoCompleteInviteModalSwitchLink(search){
	mylog.log("autoCompleteInvite", search);
	if (search.length < 3) { return }

	var data = { 
		"search" : search,
		"searchMode" : "personOnly"
	};

	mylog.log("url", baseUrl+'/'+moduleId+"/search/searchmemberautocomplete");
	$.ajax({
		type: "POST",
		url: baseUrl+'/'+moduleId+"/search/searchmemberautocomplete",
		data: data,
		dataType: "json",
		success: function(data){
			mylog.log("autoCompleteInvite success", data);
			showElementInvite(data);
			bindAdd2();
		}
	});
}

function showElementInvite(contactsList, invite=false, dropdown = "#dropdown-search-invite"){
	mylog.log("showElementInvite", contactsList, invite);
	mylog.log("showElementInvite length", Object.keys(contactsList.citoyens).length);
	//var dropdown = "#dropdown-search-invite";
	var listNotExits = true;
	var addRoles = {};
	var searchInContactsList=(dropdown=="#dropdown-mycontacts-invite") ? true : false;
	var str = "";
	if(invite == true){
		dropdown = "#dropdown-invite";
	}else if(!searchInContactsList){
		var str = "<div class='col-xs-12 no-padding'>"+
					"<div class='btn-scroll-type col-xs-12 not-find-inside padding-20'>"+
						"<a href='javascript:;' onclick='newInvitation()' class='col-xs-12 text-center'>"+trad.notfoundlaunchinvite+" !</a>"+
					"</div>"+
				"</div>";
	}
	if(notNull(contactsList.citoyens) && Object.keys(contactsList.citoyens).length ){
		// str += '<div class="col-xs-12 no-padding">'+
		// 			'<h5 class="padding-10 text-yellow"><i class="fa fa-user"></i> '+trad.People+'<hr></h5>'+			
		// 		'</div>';
		$.each(contactsList.citoyens, function(key, value){
			mylog.log("contactsList.citoyens key, value", key, value);
			str += htmlListInvite(key, value, invite, "citoyens", invite, searchInContactsList);
		});

		listNotExits = false;
	}

	mylog.log("showElementInvite end", dropdown);
	$("#modalSwitchLink "+dropdown).html(str);
	$("#modalSwitchLink "+dropdown).show();
	//bindAdd2();
}

function htmlListInvite(id, elem, invite, type, searchInContactsList){
	//( typeof elem.id != "undefined" ? elem.id : elem.email )
	mylog.log("htmlListInvite", id, elem, invite, type, searchInContactsList);
	var typeList = type ;
	if(type ==  "invites" )
		type = "citoyens";
	var profilThumbImageUrl = (typeof elem.profilThumbImageUrl != "undefined" && elem.profilThumbImageUrl != "") ? baseUrl + elem.profilThumbImageUrl : parentModuleUrl + "/images/thumb/default_"+type+".png";		
	var str = "<div class='col-xs-12 listInviteElement no-padding'>";
			str +="<div class='btn-scroll-type col-xs-12 add-invite' "+
					" data-id='"+id+"' "+
					'id="'+id+'AddList" '+
					'name="'+id+'AddList"'+
					" data-name='"+elem.name+"' "+
					" data-profilThumbImageUrl='"+profilThumbImageUrl+"' "+
					'data-type-list="'+typeList+'" ' +
					" data-type='"+type+"' >";
				str += '<img src="'+ profilThumbImageUrl+'" class="thumb-send-to col-xs-3 bg-yellow" height="35" width="35"> ';
			str += '<span class="text-dark text-bold name-invite col-xs-9 elipsis margin-top-15">' + elem.name ; 
			mylog.log("mailalal", typeList, elem.mail, (typeList == "invites" && typeof elem.mail != "undefined"));
			if(typeList == "invites" && typeof elem.mail != "undefined"){
				mylog.log("mailalal", typeList, elem.mail);
				str += ' <'+ elem.mail +'>';
			}

			str += '</span>';

		str += "</div>";
	str += "</div>";
	return str ;
}

function bindAdd2(){
	mylog.log("bindAdd2");
	$('#modalSwitchLink .add-invite').click(function(e){
		mylog.log(".add-invite");
		var id = $(this).data("id");
		var name = $(this).data("name");
		mylog.log(".add-invite", id, name);
		$('#modalSwitchLink #name').html(name);
		$('#modalSwitchLink #id').html(id);

		$("#modalSwitchLink #dropdown-search-invite").html("");
		$("#modalSwitchLink #dropdown-search-invite").hide();

		$("#modalSwitchLink #select").show();
	});
}

</script>