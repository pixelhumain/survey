function bindAnwserList(){
	$(".activeBtn").on("click",function(e){
		var params = {
			childId : $(this).data("id"),
			childType : $(this).data("type"),
			childName : $(this).data("name"),
			userName : $(this).data("username"),
			userId : $(this).data("userid"),
			form : form._id.$id,
			formId : form.id,
			eligible : true,
		};

		if(typeof $(this).data("parentid") != "undefined" && typeof $(this).data("parenttype") != "undefined"){
			params["parentId"] = $(this).data("parentid");
			params["parentType"] = $(this).data("parenttype");
			params["parentName"] = $(this).data("parentname");
		}

		eligible(params);
	});


	$(".notEligibleBtn").on("click",function(e){
		var params = {
			childId : $(this).data("id"),
			childType : $(this).data("type"),
			childName : $(this).data("name"),
			userName : $(this).data("username"),
			userId : $(this).data("userid"),
			form : form._id.$id,
			formId : form.id,
			eligible : false,
		};

		if(typeof $(this).data("parentid") != "undefined" && typeof $(this).data("parenttype") != "undefined"){
			params["parentId"] = $(this).data("parentid");
			params["parentType"] = $(this).data("parenttype");
			params["parentName"] = $(this).data("parentname");
		}

		eligible(params);
	});
}

function eligible(params){
	$.ajax({
		type: "POST",
		url: baseUrl+'/'+activeModuleId+"/co/active/",
		data:params,
		dataType: "json",
		success: function(data){
			mylog.log("activeBtn ok", "#active"+params.childId+params.childType);

			if(data.result == true){
				toastr.success(data.msg);
			}else{
				toastr.error(data.msg);
			}
			$("#active"+params.childId+params.childType).html(data.msg);
			
		},
		error: function (error) {
			mylog.log("activeBtn error", error);
			toastr.error("Projet non éligible");
		}	
	});
}