<div class="modal fade" role="dialog" id="modalCatgeorieAnswers">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-green-k text-white">
                <h4 class="modal-title"><i class="fa fa-check"></i> <?php echo Yii::t("login","Choisissez la catégorie du projet") ?></h4>
            </div>
            <div class="modal-body center text-dark hidden" id="modalRegisterSuccessContent"></div>
            <div class="modal-body center text-dark">
                
                <h5><i class="fa fa-angle-down"></i> Catégorie</h5>
                <input id="selectCategorie" class="" type="text" data-type="select2" name="roles" placeholder="Choisissez une catégorie" style="width:100%;">
                 <input type="hidden" name="childId" id="childId" value=""/>
                <input type="hidden" name="childType" id="childType" value=""/>
                <input type="hidden" name="childName" id="childName" value=""/>
                <input type="hidden" name="userName" id="userName" value=""/>
                <input type="hidden" name="userId" id="userId" value=""/>
                <input type="hidden" name="form" id="form" value=""/>
                <input type="hidden" name="formId" id="formId" value=""/>
                <input type="hidden" name="eligible" id="eligible" value=""/>
                <input type="hidden" name="parentId" id="parentId" value=""/>
                 <input type="hidden" name="parentType" id="parentType" value=""/>
                <input type="hidden" name="parentName" id="parentName" value=""/>
                <input type="hidden" name="form" id="form" value=""/>
                <input type="hidden" name="formId" id="formId" value=""/>
            </div>
            <div class="modal-footer">
                 <button id="validEligible" type="button" class="btn btn-default letter-green" data-dismiss="modal"><i class="fa fa-check"></i> Validez </button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    

    jQuery(document).ready(function() {
        if(typeof rolesListCustom != "undefined" && notNull(rolesListCustom) && rolesListCustom.length > 0)
            rolesList = rolesListCustom ;
        $('#modalCatgeorieAnswers #selectCategorie').select2({tags:rolesList});
        $("#validEligible").on("click",function(e){
            var params = {
                childId : $("#childId").val(),
                childType : $("#childType").val(),
                childName : $("#childName").val(),
                userName : $("#userName").val(),
                userId : $("#userId").val(),
                form : $("#form").val(),
                formId : $("#formId").val(),
                eligible : $("#eligible").val(),
                roles : $("#selectCategorie").val()
            };

            if($("#parentId").val() != "" && $("#parentType").val() != ""){
                params["parentId"] = $("#parentId").val();
                params["parentType"] =$("#parentType").val();
                params["parentName"] = $("#parentName").val();
            }

            eligibleFct(params);
        });
    });
</script>