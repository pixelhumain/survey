function bindAnwserList(){
	mylog.log("bindAnwserList");
	// $(".activeBtn").on("click",function(e){
	// 	var params = {
	// 		childId : $(this).data("id"),
	// 		childType : $(this).data("type"),
	// 		childName : $(this).data("name"),
	// 		userName : $(this).data("username"),
	// 		userId : $(this).data("userid"),
	// 		form : form._id.$id,
	// 		formId : form.id,
	// 		eligible : true,
	// 	};

	// 	if(typeof $(this).data("parentid") != "undefined" && typeof $(this).data("parenttype") != "undefined"){
	// 		params["parentId"] = $(this).data("parentid");
	// 		params["parentType"] = $(this).data("parenttype");
	// 		params["parentName"] = $(this).data("parentname");
	// 	}

	// 	eligible(params);
	// });

	$(".activeBtn").on("click",function(e){
			$('#modalCatgeorieAnswers').modal("show");
			console.log("ffefe", $(this).data("id"));
			$("#childId").val($(this).data("id"));
			$("#childType").val($(this).data("type"));
			$("#childName").val($(this).data("name"));
			$("#userName").val($(this).data("username"));
			$("#userId").val($(this).data("userid"));
			$("#form").val(form._id.$id);
			$("#formId").val(form.id);
			$("#eligible").val(true);
			$("#parentId").val( $(this).data("parentid"));
			$("#parentType").val( $(this).data("parenttype"));
			$("#parentName").val($(this).data("parentname"));
			 
			// var params = {
			// 	childId : $(this).data("id"),
			// 	childType : $(this).data("type"),
			// 	childName : $(this).data("name"),
			// 	userName : $(this).data("username"),
			// 	userId : $(this).data("userid"),
			// 	form : form._id.$id,
			// 	formId : form.id,
			// 	eligible : true,
			// };

			// if(typeof $(this).data("parentid") != "undefined" && typeof $(this).data("parenttype") != "undefined"){
			// 	params["parentId"] = $(this).data("parentid");
			// 	params["parentType"] = $(this).data("parenttype");
			// 	params["parentName"] = $(this).data("parentname");
			// }

			// eligible(params);
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

		eligibleFct(params);
	});
}

function eligibleFct(params){
	mylog.log("eligible", params);
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