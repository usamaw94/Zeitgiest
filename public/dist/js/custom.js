$(document).on("click", "#editImgItem", function(){

    var id=$(this).attr('data-item-id');
    var name=$(this).attr('data-item-name');
    var img=$(this).attr('data-item-img');
    var liId=$(this).attr('data-list-id');
    var imgName=$(this).attr('data-img_name');


    $('#modalImgItemId').val(id);
    $('#modalImgListId').val(liId);
    $('#modalImgItemName').val(name);
    $('#modalOrigImg').val(img);
    $('#imgName').val(imgName);

    $('#modalItemImg').attr('src',img);

    $('#changeImg').change(function(event){
        var tmppath = URL.createObjectURL(event.target.files[0]);
        $("#modalItemImg").fadeIn("slow").attr('src',URL.createObjectURL(event.target.files[0]));
    });

    $('#removeImg').click(function(){
        $("#changeImg").val("");
        $("#modalItemImg").fadeIn("slow").attr('src','');
        $("#delStatus").val('yes');
    });

    $('#resetImg').click(function(){
        $("#changeImg").val("");
        $("#modalItemImg").fadeIn("slow").attr('src',img);
        $("#delStatus").val('no');
    });
});

$(document).on("click", "#editItem", function(){

    var id=$(this).attr('data-item-id');
    var name=$(this).attr('data-item-name');
    var liId=$(this).attr('data-list-id');

    $('#modalItemId').val(id);
    $('#modalItemName').val(name);
    $('#modalListId').val(liId);
});

$(document).on("click", "#saveItem", function(){
    var url="/editItem";
    var liId = $('#modalListId').val();
    var data=$('#newItemData').serialize();

    $.ajax({
        url:url,
        data:data,
        datatype:"json",
        method:"GET",
        success:function(){
            $('#reload').load("/listItems/"+liId+" #reload");
            $('#editListItem').modal('toggle');


            $('#notifyText').text('Item updated');

            $('#notify').delay(500).slideDown('medium').delay(2000)
                .slideUp('medium');
        }
    });
});


$(document).on("click", ".item-action-delete", function(){
    var id=$(this).attr('data-item-id');
    var liId=$(this).attr('data-list-id');

    $('#listID').text(liId);
    $('#idToDelete').text(id);
});

$(document).on("click", ".item-action-edit-city", function(){

    var id=$(this).attr('data-item-id');
    var name=$(this).attr('data-item-name');

    $('#modalItemId').val(id);
    $('#modalItemName').val(name);
});

$(document).on("click", "#saveCity", function(){
    var url="/editCity";
    var data=$('#newItemData').serialize();

    $.ajax({
        url:url,
        data:data,
        datatype:"json",
        method:"GET",
        success:function(){
            $('#reload').load("/cities #reload");
            $('#editListItem').modal('toggle');


            $('#notifyText').text('Data updated');

            $('#notify').delay(500).slideDown('medium').delay(2000)
                .slideUp('medium');
        }
    });
});

$(document).on("click", ".item-action-delete-city", function(){
    var id=$(this).attr('data-item-id');
    var name=$(this).attr('data-item-name');

    $('#cityName').text(name);
    $('#idToDelete').text(id);
});

$(document).on("click", "#delCity", function(){
    var id = $('#idToDelete').text();

    var url = "/deleteCity/"+id;

    $.ajax({
        url:url,
        data:id,
        datatype:"json",
        method:"GET",
        success:function(){

            $('#reload').load("/cities #reload");
            $('#deleteListItem').modal('toggle');

            $('#notifyText').text('City removed');

            $('#notify').delay(500).slideDown('medium').delay(2000)
                .slideUp('medium');
        }
    });
});

//----------------------------------------------------------------------//

$(document).on("click", ".shop-action-delete", function(){
    var id=$(this).attr('data-shop-id');
    $('#idToDelete').text(id);
});

$(document).on("click", "#delShop", function(){
    var id = $('#idToDelete').text();

    var url = "/deletetShop/"+id;

    $.ajax({
        url:url,
        data:id,
        datatype:"json",
        method:"GET",
        success:function(){

            $('#reload').load("/shops #reload");
            $('#deleteShop').modal('toggle');

            $('#notifyText').text('Shop deleted');

            $('#notify').delay(500).slideDown('medium').delay(2000)
                .slideUp('medium');
        }
    });
});

//----------------------------------------------------------------------//

$(document).on("click", ".order-action-change", function(){

    var $select = $('#selectBox').empty();
    var $passwrd = $('#pass').val('');

    var id=$(this).attr('data-item-id');
    var shopId=$(this).attr('data-shop-id');
    var name=$(this).attr('data-c-name');
    var type=$(this).attr('data-order-type');
    var date=$(this).attr('data-o-date');
    var dDate=$(this).attr('data-d-date');
    var status=$(this).attr('data-status');
    var fabric=$(this).attr('data-fabric-id');
    var lining=$(this).attr('data-lining-id');

    $('#mOId').text(id);
    $('#mSId').text(shopId);
    $('#mCName').text(name);
    $('#mOType').text(type);
    $('#mODate').text(date);
    $('#mDDate').text(dDate);

    if(status == 'Pending Review'){
        $('#mStatus').text(status);
        $("#mStatus").addClass("label-warning");
    }else if(status == 'Pre-production'){
        $('#mStatus').text(status);
        $("#mStatus").addClass("label-pre-production");
    }else if(status == 'Canceled'){
        $('#mStatus').text(status);
        $("#mStatus").addClass("label-danger");
    }else if(status == 'In Production'){
        $('#mStatus').text(status);
        $("#mStatus").addClass("label-production");
    }else if(status == 'In Warehouse'){
        $('#mStatus').text(status);
        $("#mStatus").addClass("label-warehouse");
    }else if(status == 'In Store'){
        $('#mStatus').text(status);
        $("#mStatus").addClass("label-store");
    }else if(status == 'Sold'){
        $('#mStatus').text(status);
        $("#mStatus").addClass("label-success");
    }

    $('#orderID').val(id);
    $('#prevStatus').val(status);
    $('#fabric').val(fabric);
    $('#lining').val(lining);
    $('#itemType').val(type);

    $('<option>').val('Pending Review').text('Pending Review').appendTo('#selectBox');
    $('<option>').val('Pre-production').text('Pre-production').appendTo('#selectBox');
    $('<option>').val('Canceled').text('Canceled').appendTo('#selectBox');
    $('<option>').val('In Production').text('In Production').appendTo('#selectBox');
    $('<option>').val('In Warehouse').text('In Warehouse').appendTo('#selectBox');
    $('<option>').val('In Store').text('In Store').appendTo('#selectBox');

    $("#selectBox option[value='"+status+"']").remove();

});

$(document).on("click", ".order-action-customer", function(){
    var id =$(this).attr('data-customer-id');
    var name =$(this).attr('data-customer-name');
    var pPhone =$(this).attr('data-customer-p-phone');
    var sPhone =$(this).attr('data-customer-s-phone');
    var email =$(this).attr('data-customer-email');
    var city =$(this).attr('data-customer-city');
    var address=$(this).attr('data-customer-address');

    $('#cIdM').text(id);
    $('#cNameM').text(name);
    $('#cPPhoneM').text(pPhone);
    $('#cSPhoneM').text(sPhone);
    $('#cEmailM').text(email);
    $('#cCityM').text(city);
    $('#cAddressM').text(address);
});

$(document).on("click", ".customer-photo", function(){

    var img =$(this).attr('data-img-src');

    $('#enlargePhoto').attr('src',img);
});

$(document).on("click", ".close-status-modal", function(){

    var status = $('#mStatus').text();

    if(status == 'Pending Review'){
        $("#mStatus").removeClass("label-warning");
    }else if(status == 'Pre-production'){
        $("#mStatus").removeClass("label-pre-production");
    }else if(status == 'Canceled'){
        $("#mStatus").removeClass("label-danger");
    }else if(status == 'In Production'){
        $("#mStatus").removeClass("label-production");
    }else if(status == 'In Warehouse'){
        $("#mStatus").removeClass("label-warehouse");
    }else if(status == 'In Store'){
        $("#mStatus").removeClass("label-store");
    }else if(status == 'Sold'){
        $("#mStatus").removeClass("label-success");
    }
});

$(document).on("click", "#submitStatusData", function(){
    var url="/ajxChangeStatus";
    var pass = $('#pass').val();
    var data=$('#changeStatusData').serialize();

    if(pass == null || pass == ''){
        alert('Please fill out password feild');
    } else {
        $.ajax({
            url:url,
            data:data,
            datatype:"json",
            method:"GET",
            success:function(data){
                $('#reload').load("/orders #reload");
                $('#changeStatus').modal('toggle');

                if(data.msg != null && data.msg != ''){
                    $('#notifyText').text(data.msg);

                    $('#notify').delay(500).slideDown('medium').delay(2000)
                        .slideUp('medium');
                }
                else if(data.errorMsg != null && data.errorMsg != ''){
                    $('#errorNotifyText').text(data.errorMsg);

                    $('#errorNotify').delay(500).slideDown('medium').delay(2000)
                        .slideUp('medium');
                }
            }
        });
    }
    var status = $('#mStatus').text();

    if(status == 'Pending Review'){
        $("#mStatus").removeClass("label-warning");
    }else if(status == 'Pre-production'){
        $("#mStatus").removeClass("label-pre-production");
    }else if(status == 'Canceled'){
        $("#mStatus").removeClass("label-danger");
    }else if(status == 'In Production'){
        $("#mStatus").removeClass("label-production");
    }else if(status == 'In Warehouse'){
        $("#mStatus").removeClass("label-warehouse");
    }else if(status == 'In Store'){
        $("#mStatus").removeClass("label-store");
    }else if(status == 'Sold'){
        $("#mStatus").removeClass("label-success");
    }
});

$(document).on("click", "#showTimeline", function(){
    var id=$(this).attr('data-item-id');

    var url = "/viewTimeline/"+id;

    $.ajax({
        url:url,
        data:id,
        datatype:"json",
        method:"GET",
        success:function(data){

            var count = data.timeline.length;

            var timeLineContainer = document.getElementById("timeLineContainer");
            while (timeLineContainer.hasChildNodes()) {
                timeLineContainer.removeChild(timeLineContainer.lastChild);
            }

            for(i = 0; i < count; i++) {

                var timelineListItem = document.createElement("li");
                timeLineContainer.appendChild(timelineListItem);

                var timelineI = document.createElement("i");
                timelineI.classList = "fa fa-calendar bg-blue";
                timelineListItem.appendChild(timelineI);

                var tDiv = document.createElement("div");
                tDiv.classList = "timeline-item";
                timelineListItem.appendChild(tDiv);

                var tHeader = document.createElement("h3");
                tHeader.classList = "timeline-header";
                var node1 = document.createTextNode(data.timeline[i].status);
                tHeader.appendChild(node1);
                tDiv.appendChild(tHeader);

                var tBody = document.createElement("div");
                tBody.classList = "timeline-body";
                var node2 = document.createTextNode("Date : "+data.timeline[i].change_date);
                tBody.appendChild(node2);
                tBody.appendChild(document.createElement("br"));
                var node3 = document.createTextNode("Updated By(Name) : "+data.timeline[i].user_name);
                tBody.appendChild(node3);
                tBody.appendChild(document.createElement("br"));
                var node4 = document.createTextNode("Email : "+data.timeline[i].user_email);
                tBody.appendChild(node4);
                tBody.appendChild(document.createElement("br"));
                tDiv.appendChild(tBody);

            }
        }
    });

});

//----------------------------------------------------------------------//

$(document).on("click", ".fabric-action-edit", function(){

    $('#fMThreePiece').prop('checked', false);
    $('#fMTwoPiece').prop('checked', false);
    $('#fMJacket').prop('checked', false);
    $('#fMWaistCoat').prop('checked', false);
    $('#fMPant').prop('checked', false);
    $('#fMShirt').prop('checked', false);
    $('#modalFabricId').val('');
    $('#modalfabricNum').val('');
    $('#mfabricStock').val('');
    $('#modalfabricImgName').val('');

    var id=$(this).attr('data-item-id');
    var number=$(this).attr('data-item-number');
    var img=$(this).attr('data-item-img');
    var stock=$(this).attr('data-fabric-stock');
    var imgName=$(this).attr('data-fabric-img-name');
    var threePiece = $(this).attr('data-three-piece');
    var twoPiece = $(this).attr('data-two-piece');
    var jacket = $(this).attr('data-jacket');
    var waistCoat = $(this).attr('data-waist-coat');
    var pant = $(this).attr('data-pant');
    var shirt = $(this).attr('data-shirt');


    $('#modalFabricId').val(id);
    $('#modalfabricNum').val(number);
    $('#modalFabricImg').attr('src',img);
    $('#mfabricStock').val(stock);
    $('#modalfabricImgName').val(imgName);

    if(threePiece == 'yes'){
        $('#fMThreePiece').prop('checked', true);
    }
    if(twoPiece == 'yes'){
        $('#fMTwoPiece').prop('checked', true);
    }
    if(jacket == 'yes'){
        $('#fMJacket').prop('checked', true);
    }
    if(waistCoat == 'yes'){
        $('#fMWaistCoat').prop('checked', true);
    }
    if(pant == 'yes'){
        $('#fMPant').prop('checked', true);
    }
    if(shirt == 'yes'){
        $('#fMShirt').prop('checked', true);
    }

    $('#fmchangeImg').change(function(event){
        var tmppath = URL.createObjectURL(event.target.files[0]);
        $("#modalFabricImg").fadeIn("slow").attr('src',URL.createObjectURL(event.target.files[0]));
    });

    $('#resetFabricImg').click(function(){
        $("#fmchangeImg").val("");
        $("#modalFabricImg").fadeIn("slow").attr('src',img);
    });
});

$(document).on("click", ".fabric-action-delete", function(){
    var id=$(this).attr('data-fabric-id');
    var num=$(this).attr('data-fabric-num');

    $('#fabricIdToDelete').text(id);
    $('#fabricNumToDelete').text(num);
});

$(document).on("click", "#delFabric", function(){
    var id = $('#fabricIdToDelete').text();

    var url = "/deleteFabric/"+id;

    $.ajax({
        url:url,
        data:id,
        datatype:"json",
        method:"GET",
        success:function(){

            $('#fabricReload').load("/fabricLining #fabricReload");
            $('#deleteFabricItem').modal('toggle');

            $('#notifyText').text('Fabric deleted');

            $('#notify').delay(500).slideDown('medium').delay(2000)
                .slideUp('medium');
        }
    });
});

$(document).on("click", ".lining-action-edit", function(){

    $('#lMThreePiece').prop('checked', false);
    $('#lMTwoPiece').prop('checked', false);
    $('#lMJacket').prop('checked', false);
    $('#lMWaistCoat').prop('checked', false);
    $('#lMPant').prop('checked', false);
    $('#lMShirt').prop('checked', false);
    $('#modalLiningId').val('');
    $('#modalLiningNum').val('');
    $('#mLiningStock').val('');
    $('#modalLiningImgName').val('');

    var id=$(this).attr('data-item-id');
    var number=$(this).attr('data-lining-number');
    var img=$(this).attr('data-item-img');
    var stock=$(this).attr('data-lining-stock');
    var imgName=$(this).attr('data-lining-img-name');
    var threePiece = $(this).attr('data-three-piece');
    var twoPiece = $(this).attr('data-two-piece');
    var jacket = $(this).attr('data-jacket');
    var waistCoat = $(this).attr('data-waist-coat');
    var pant = $(this).attr('data-pant');
    var shirt = $(this).attr('data-shirt');

    $('#modalLiningId').val(id);
    $('#modalLiningNum').val(number);
    $('#modalLiningImg').attr('src',img);
    $('#mliningStock').val(stock);
    $('#modalliningImgName').val(imgName);

    if(threePiece == 'yes'){
        $('#lMThreePiece').prop('checked', true);
    }
    if(twoPiece == 'yes'){
        $('#lMTwoPiece').prop('checked', true);
    }
    if(jacket == 'yes'){
        $('#lMJacket').prop('checked', true);
    }
    if(waistCoat == 'yes'){
        $('#lMWaistCoat').prop('checked', true);
    }
    if(pant == 'yes'){
        $('#lMPant').prop('checked', true);
    }
    if(shirt == 'yes'){
        $('#lMShirt').prop('checked', true);
    }

    $('#lmchangeImg').change(function(event){
        var tmppath = URL.createObjectURL(event.target.files[0]);
        $("#modalLiningImg").fadeIn("slow").attr('src',URL.createObjectURL(event.target.files[0]));
    });

    $('#resetLiningImg').click(function(){
        $("#lmchangeImg").val("");
        $("#modalLiningImg").fadeIn("slow").attr('src',img);
    });
});

$(document).on("click", ".lining-action-delete", function(){
    var id=$(this).attr('data-lining-id');
    var num=$(this).attr('data-lining-num');
    $('#liningIdToDelete').text(id);
    $('#liningNumToDelete').text(num);
});

$(document).on("click", "#delLining", function(){
    var id = $('#liningIdToDelete').text();

    var url = "/deleteLining/"+id;

    $.ajax({
        url:url,
        data:id,
        datatype:"json",
        method:"GET",
        success:function(){

            $('#liningReload').load("/fabricLining #liningReload");
            $('#deleteLiningItem').modal('toggle');

            $('#notifyText').text('Lining deleted');

            $('#notify').delay(500).slideDown('medium').delay(2000)
                .slideUp('medium');
        }
    });
});

//----------------------------------------------------------------------//

$(document).on("click", ".garment-action-edit", function(){

    var id=$(this).attr('data-garment-id');
    var name=$(this).attr('data-garment-name');
    var fabricConsumption=$(this).attr('data-fabric-consumption');
    var liningConsumption=$(this).attr('data-lining-consumption');

    $('#modalGarmentId').val(id);
    $('#mGarmentName').text(name);
    $('#mfabricConsumption').val(fabricConsumption);
    $('#mliningConsumption').val(liningConsumption);
});

$(document).on("click", "#changeGarment", function(){

    var data=$('#changeGarmentData').serialize();

    var url = "/changeCosumption";

    $.ajax({
        url:url,
        data:data,
        datatype:"json",
        method:"GET",
        success:function(){

            $('#garmentReload').load("/garment #garmentReload");
            $('#editGarment').modal('toggle');

            $('#notifyText').text('Garment consumption updated');

            $('#notify').delay(500).slideDown('medium').delay(2000)
                .slideUp('medium');
        }
    });
});

$(document).on("click", ".base-size-action-edit", function(){

    var id=$(this).attr('data-bs-id');
    var baseSize=$(this).attr('data-bs-bs');
    var garment=$(this).attr('data-bs-garment');

    $('#mBSId').val(id);
    $('#mBSize').val(baseSize);
    $('#mBSGarment').val(garment);
});

$(document).on("click", "#changeBaseSize", function(){

    var data=$('#changeBaseSizeData').serialize();

    var url = "/changeBaseSize";

    $.ajax({
        url:url,
        data:data,
        datatype:"json",
        method:"GET",
        success:function(){

            $('#baseSizeReload').load("/garment #baseSizeReload");
            $('#editBaseSize').modal('toggle');

            $('#notifyText').text('Base size updated');

            $('#notify').delay(500).slideDown('medium').delay(2000)
                .slideUp('medium');
        }
    });
});

$(document).on("click", ".base-size-action-delete", function(){
    var id=$(this).attr('data-bs-id');
    $('#baseSizeIdToDelete').text(id);
});

$(document).on("click", "#confirmDeleteBS", function(){
    var id = $('#baseSizeIdToDelete').text();

    var url = "/deleteBaseSize/"+id;

    $.ajax({
        url:url,
        data:id,
        datatype:"json",
        method:"GET",
        success:function(){

            $('#baseSizeReload').load("/garment #baseSizeReload");
            $('#deleteBaseSize').modal('toggle');

            $('#notifyText').text('Base size deleted');

            $('#notify').delay(500).slideDown('medium').delay(2000)
                .slideUp('medium');
        }
    });
});

$(document).on("click", ".base-pattern-action-edit", function(){

    var id=$(this).attr('data-basep-id');
    var basePattern=$(this).attr('data-base-pattern');
    var garment=$(this).attr('data-basep-garment');

    $('#mBasePId').val(id);
    $('#mBPattern').val(basePattern);
    $('#mBasePGarment').val(garment);
});

$(document).on("click", "#changeBasePattern", function(){

    var data=$('#changeBasePatternData').serialize();

    var url = "/changeBasePattern";

    $.ajax({
        url:url,
        data:data,
        datatype:"json",
        method:"GET",
        success:function(){

            $('#basePatternReload').load("/garment #basePatternReload");
            $('#editBasePattern').modal('toggle');

            $('#notifyText').text('Base pattern updated');

            $('#notify').delay(500).slideDown('medium').delay(2000)
                .slideUp('medium');
        }
    });
});

$(document).on("click", ".base-pattern-action-delete", function(){

    var id=$(this).attr('data-basep-id');
    $('#basePatternIdToDelete').text(id);

});

$(document).on("click", "#confirmDeleteBP", function(){
    var id = $('#basePatternIdToDelete').text();

    var url = "/deleteBasePattern/"+id;

    $.ajax({
        url:url,
        data:id,
        datatype:"json",
        method:"GET",
        success:function(){

            $('#basePatternReload').load("/garment #basePatternReload");
            $('#deleteBasePattern').modal('toggle');

            $('#notifyText').text('Base pattern delete');

            $('#notify').delay(500).slideDown('medium').delay(2000)
                .slideUp('medium');
        }
    });
});

//----------------------------------------------------------------------//

$(document).on("click", ".user-action-activate", function(){

    var id=$(this).attr('data-user-id');
    $('#idToActivate').text(id);

});

$(document).on("click", "#confirmActivateUser", function(){
    var id = $('#idToActivate').text();

    var url = "/activateUser/"+id;

    $.ajax({
        url:url,
        data:id,
        datatype:"json",
        method:"GET",
        success:function(){

            $('#usersReload').load("/users #usersReload");
            $('#activateUser').modal('toggle');

            $('#notifyText').text('User Activated');

            $('#notify').delay(500).slideDown('medium').delay(2000)
                .slideUp('medium');
        }
    });
});


$(document).on("click", ".user-action-deactivate", function(){

    var id=$(this).attr('data-user-id');
    $('#idToDeactivate').text(id);

});

$(document).on("click", "#confirmDeactivateUser", function(){
    var id = $('#idToDeactivate').text();

    var url = "/deactivateUser/"+id;

    $.ajax({
        url:url,
        data:id,
        datatype:"json",
        method:"GET",
        success:function(){

            $('#usersReload').load("/users #usersReload");
            $('#deactivateUser').modal('toggle');

            $('#notifyText').text('User De-activated');

            $('#notify').delay(500).slideDown('medium').delay(2000)
                .slideUp('medium');
        }
    });
});

$(document).on("click", ".user-action-delete", function(){
    var id=$(this).attr('data-user-id');
    $('#idToDelete').text(id);

});

$(document).on("click", "#confirmDeleteUser", function(){
    var id = $('#idToDelete').text();

    var url = "/deleteUser/"+id;

    $.ajax({
        url:url,
        data:id,
        datatype:"json",
        method:"GET",
        success:function(){

            $('#usersReload').load("/users #usersReload");
            $('#deleteUser').modal('toggle');

            $('#notifyText').text('User Deleted');

            $('#notify').delay(500).slideDown('medium').delay(2000)
                .slideUp('medium');
        }
    });
});

$(document).on("click", ".user-action-show-password", function(){
    var id=$(this).attr('data-user-id');
    $('#idToShowPassword').val(id);

});

$(document).on("click", "#showUserPassword", function(){
    var data = $('#showingPassword').serialize();

    var url = "/showUserPassword/";

    $.ajax({
        url:url,
        data:data,
        datatype:"json",
        method:"GET",
        success:function(data){
            var result = data.result;

            $('#aPassword').val('');

            if(result == 'Incorrect Admin Password'){
                $('#uPassword').text(result);
                $('#passwordDiv').slideDown('medium');
            }else if(result == 'Enter Admin Password'){
                $('#uPassword').text(result);
                $('#passwordDiv').slideDown('medium');
            } else{
                $('#uPassword').text('User Password : '+result);
                $('#adminPasswordDiv').slideUp('medium');
                $('#passwordDiv').slideDown('medium');
            }
        }
    });
});

$('#showPassword').on('hidden.bs.modal', function () {
    $('#aPassword').val('');
    $('#passwordDiv').slideUp('Fast');
    $('#adminPasswordDiv').slideDown('Fast');
});

//----------------------------------------------------------------------//

$('[hint="tooltip"]').tooltip();

$(document).on("click", "#openNotify", function(){

    $('#notify').slideDown('medium').delay(1000)
        .slideUp('medium');
});

setTimeout(function() {
    $('#staticNotify').fadeOut('slow');
}, 2000); // <-- time in milliseconds

setTimeout(function() {
    $('#staticErrorNotify').fadeOut('slow');
}, 2000); // <-- time in milliseconds