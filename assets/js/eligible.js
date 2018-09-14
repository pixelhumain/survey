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
			$("#answerId").val($(this).data("id"));
			$("#eligible").val(true);
			 
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
			email : $(this).data("email"),
			form : form._id.$id,
			formId : form.id,
			session : formSession,
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
				window.location.reload();
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