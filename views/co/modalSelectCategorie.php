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
                 <input type="hidden" name="answerId" id="answerId" value=""/>
                 <input type="hidden" name="eligible" id="eligible" value=""/>
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

        if(typeof form != "undefined" && typeof form.custom != "undefined" && typeof form.custom.roles != "undefined" && notNull(form.custom.roles) && form.custom.roles.length > 0)
            rolesList = form.custom.roles ;

        $('#modalCatgeorieAnswers #selectCategorie').select2({tags:rolesList});
        $("#modalCatgeorieAnswers #validEligible").on("click",function(e){
            var params = {
                answerId : $("#answerId").val(),
                form : form._id.$id,
                formId : form.id,
                session : formSession,
                eligible : $("#eligible").val(),
                roles : $("#selectCategorie").val()
            };

            eligibleFct(params);
        });
    });
</script>