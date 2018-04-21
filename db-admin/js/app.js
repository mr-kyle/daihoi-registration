$(document).foundation();


//FRONT PAGE
function doSearch() {

    $("#warningAlert").hide();

    var search 	= document.getElementById('tSearch').value;
    var type 	= $("#searchType").val();
    if ($.trim(search) == ""){return false;}

    $("#bGo").val("Searching...").addClass('disabled');
    $("#grid").html("");
    $("#results-wrapper").hide()


    $.ajax({
        url: 'search.php?anti=' + Math.random(),
        type: 'GET',
        dataType: 'json',
        data: {type: type, search: search},
    })
    .done(function(data) {
        if ($.trim(data) !== ""){
            if (data.status == 1 ) {

                if (data.count == 1) {
                    location.href="details.php?id=" + data.id;
                    return false;
                }
                if (data.count > 1) {
                    $("#results-wrapper").show();
                    $("#grid").html(data.html);
                    renderTable();
                }else {
                    //no records
                    showAlert(data.message);
                }						

            }else{
                showAlert("Status is false.");
            }
        }else{
            showAlert("No data recieved.");
        }

        console.log("success");
    })
    .fail(function(err, x, t) {
        alert("error fetching results! " + t)
        console.log("error");
    })
    .always(function() {
        console.log("complete");
        $("#bGo").val(" GO ").removeClass('disabled');
    });

}

function showAlert(msg){
    $("#warningAlert").show().removeClass('hide').children("p:first").text(msg);
}

function renderTable(){
    $('#grid').DataTable({
         "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        iDisplayLength: 50,
        repsonsive:true,
        destroy: true
    });
}


function renderAnyTable(id, callback){
    $('#' + id).DataTable({
         "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
         "initComplete": function(settings, json) {

            
            if (typeof callback == "function") {
                // Call it, since we have confirmed it is callable​
                callback();
            }
        },  
        iDisplayLength: 10,
        repsonsive:true,
        destroy: true
    });
}

/* DETAILS PAGE */


var PAYLOAD = function () {
    this.type    = "",
    this.id      = 0,
    this.checkin = 0,
    this.paid    = 0
}



var PAYMENT = function () {
    this.type    = "",
    this.id      = 0,
    this.amount  = 0,
    this.comments  = '',			
    this.date    = null
}



function makePayment(id){

    closeCallOuts();

    var payment    = new PAYMENT();
    payment.date   = document.getElementById("txtPaymentDate").value;
    payment.amount = parseFloat(document.getElementById("txtPaymentAmount").value);
    payment.id     = id; //<?php echo $_GET['id']; ?>;
    payment.comments = document.getElementById("txtPaymentComments").value;

    if (payment.amount == "" || isNaN(payment.amount)){
        alert("Please enter an amount.");
        return false;
    }				


    $("#json").html(JSON.stringify(payment));
    $.ajax({
        url: 'action.php?type=add-payment&cache=' + Math.random(),
        type: 'POST',
        dataType: 'json',
        data: {
            id: payment.id, 
            json: JSON.stringify(payment)
        },
    })
    .done(function(data) {
        if (data.status == 1){
            $("#callout-success").slideDown();
            getPayments(id);
        }else{
            $("#callout-alert").slideDown().find("p:first").text(data.message);
        }
        console.log("success");
    })
    .fail(function(jqXHR) {
        $("#callout-alert").slideDown().find("p:first").text(jqXHR.responseText);
        console.log("error");
    })
    .always(function() {
        console.log("complete");
    });

}


function getJSON(){

    closeCallOuts();

    var json = []; 

    var payload;

    var exit = false;

    //at this stage, becuase of the responsive nature of the table, the target table can be created twice when in a smaller view
    //therefore we check if there are 2 tables of the same id, if so, get the first table. If not then use the just query as per normal.

    var tables = $("#details-table");

    if (tables.length > 1){
        tables = tables.first();
    }


    $(tables).find("td.row-actions").each(function (index, el) {

        //create payload and assign attributes		        	
        payload         = new PAYLOAD();
        payload.type    = $(el).data("type");
        payload.id      = $(el).data("id");
        payload.checkin = $(el).find('input[type=checkbox]:first').prop("checked");

        // var paymentField = $(el).find('input[type=number]:first');
        // payload.paid    = paymentField.val();

        // //some validation
        // var max = paymentField.prop("max");
        // if ( parseInt(payload.paid) > parseInt(max) ){
        // 	$("#callout-alert").slideDown().find("p:first").text("You cannot pay more than the fee.");
        // 	paymentField.focus().select();
        // 	exit = true;
        // 	return false;

        // }

        //add to json
        json.push(payload);

    });


    if (exit) {
        return false;
    }



    if (json !== "") {
        $("#json").html(JSON.stringify(json));
        //console.log(JSON.stringify(json));
        sendData(JSON.stringify(json));
    }

}


function sendData(json){

    closeCallOuts();

        $.ajax({
            url: 'action.php?cache=' + Math.random(),
            type: 'POST',
            dataType: 'json',
            data: {json: json},
        })

        .done(function(data) {
            if (data.status == 1){
                $("#callout-success").slideDown();
            }else{
                $("#callout-alert").slideDown().find("p:first").text(data.message);
            }
            console.log("success");
        })
        .fail(function(jqXHR) {
            $("#callout-alert").slideDown().find("p:first").text(jqXHR.responseText);
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });

}


function addNotes(id){

        $.ajax({
            url: 'action.php?type=notes&cache=' + Math.random(),
            type: 'POST',
            dataType: 'json',
            data: {id: id, notes: $("#txtNotes").val() },
        })
        .done(function(data) {
            if (data.status == 1){
                getNotes(id);
            }else{
                $("#callout-alert").slideDown().find("p:first").text(data.message);
            }
            console.log("success");
        })
        .fail(function(jqXHR) {
            $("#callout-alert").slideDown().find("p:first").text(jqXHR.responseText);
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });

}


function getNotes(id){

        //var id = <?php echo $_GET['id']; ?>;
        if (id == "" || id < 0){ return false; }

        $.ajax({
            url: 'action.php?type=get-notes&cache=' + Math.random(),
            type: 'GET',
            dataType: 'json',
            data: {id: id },

        })
        .done(function(data) {
            if (data.status == 1){
                $("#table-notes").html(data.html)
            }
            console.log("success");

        })
        .fail(function(jqXHR) {
            $("#callout-alert").slideDown().find("p:first").text(jqXHR.responseText);
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });

}


function getPayments(id){

        //var id = <?php echo $_GET['id']; ?>;

        if (id == "" || id < 0){
            return false; 
        }

        $.ajax({
            url: 'action.php?type=get-payments&cache=' + Math.random(),
            type: 'GET',
            dataType: 'json',
            data: {id: id },

        })
        .done(function(data) {

            if (data.status == 1){
                $("#table-payments").html(data.html);
                $("#outstanding-balance").html(data.info);
                createTT();
            }
            console.log("success");
        })
        .fail(function(jqXHR) {

            $("#callout-alert").slideDown().find("p:first").text(jqXHR.responseText);
            console.log("error");

        })
        .always(function() {
            console.log("complete");

        });





}


function fillRegoPaymentAmounts(){

    $("input[type=number].payment-amount").each(function (index, el) {
        el.value = el.max;
        $(this).trigger('change');
    });

}


function sendSMS(id){
        //var id = <?php echo trim($_GET["id"]) ?> };
        closeCallOuts();

        $("#cSendSMS").addClass("disabled")
        $("#cSendSMS").prop('disabled', true);

        $.ajax({
            url: 'action.php?type=sms&cache=' + Math.random(),
            type: 'POST',
            dataType: 'json',
            data: {
                    phone: $("li.phone").text(), 
                    ref: $("li.ref").text(), 
                    id: id
                }
        })
        .done(function(data) {
            if (data.status == 1){
                setTimeout("getNotes()",250);
                $("#callout-success").slideDown().find("p:first").text(data.message);

            }else{
                $("#callout-alert").slideDown().find("p:first").text(data.message);
            }

            console.log("success");
        })
        .fail(function(jqXHR) {
            $("#callout-alert").slideDown().find("p:first").text(jqXHR.responseText);
            console.log("error");

        })
        .always(function() {
            console.log("complete");
            $('#smsModal').foundation('close');
        });

}		

function enableSMSButton(){
    $("#cSendSMS").removeClass("disabled");
    $("#cSendSMS").prop('disabled', false);			
}

function closeCallOuts(){
    $("#callout-alert").hide();
    $("#callout-success").hide();
}


function listRooms(targetEl, personId, callback){

    closeCallOuts();
    document.getElementById("room-fullname").innerText = "";
    $("#rooms-overlay").show();

    //$("#json").html(JSON.stringify(payment));
    $.ajax({
        url: 'action.php?type=list-rooms&cache=' + Math.random(),
        type: 'GET',
        dataType: 'json',
        data: {
            id: personId,
        },
    })
    .done(function(data) {
        if (data.status == 1){
            targetEl.innerHTML = data.html;
            renderAnyTable('table-rooms', function(){
                $("#rooms-overlay").hide();
            });
            document.getElementById("room-fullname").innerText = " allocation for: " + data.info;

        }else{
            $("#callout-alert").slideDown().find("p:first").text(data.message);
        }
        console.log("success");
    })
    .fail(function(jqXHR) {
        $("#callout-alert").slideDown().find("p:first").text(jqXHR.responseText);
        console.log("error");
    })
    .always(function() {
        console.log("complete");
    });

};


function assignPersonToRoom(personId, roomId, roomLabel){

    closeCallOuts();

    //$("#json").html(JSON.stringify(payment));
    $.ajax({
        url: 'action.php?type=assign-person-to-room&cache=' + Math.random(),
        type: 'POST',
        dataType: 'json',
        data: {
            id: personId,
            rid: roomId,
        },
    })
    .done(function(data) { 
        if (data.status == 1){
            $("#callout-success").slideDown().find("p:first").text(data.message);
            updateRoomLabel(personId, roomLabel);
            toggleRoomDeleteButton(personId, true);
        }else {
            $("#callout-alert").slideDown().find("p:first").text(data.message);
        }
        console.log("success");
    })
    .fail(function(jqXHR) {
        $("#callout-alert").slideDown().find("p:first").text(jqXHR.responseText);
        console.log("error");
    })
    .always(function() {
        $('#roomsModal').foundation('close');
        console.log("complete");
    });

};

function updateRoomLabel(id, label){
    $(".rooms-action-container").each(function(index, el){
        
        if($(el).attr("data-id") == id){
            $(el).find("span.room-label").html(label);
            return;
        }

    });
};

function toggleRoomDeleteButton(id, visible){
    $(".rooms-action-container").each(function(index, el){
        
        if($(el).attr("data-id") == id){
            if (visible){
                $(el).find(".room-delete-button").show();
            }else {
                $(el).find(".room-delete-button").hide();
            }
            return;
        }

    });
}


function removePersonsToRoom(personIds){

    closeCallOuts();

    //$("#json").html(JSON.stringify(payment));
    $.ajax({
        url: 'action.php?type=remove-persons-from-room&cache=' + Math.random(),
        type: 'POST',
        dataType: 'json',
        data: {
            ids: personIds
        },
    })
    .done(function(data) { 
        if (data.status == 1){
            $("#callout-success").slideDown().find("p:first").text(data.message);

            var array = personIds.split(",");
            $.each(array,function(i){
                updateRoomLabel(array[i], "ROOM");
                toggleRoomDeleteButton(array[i], false);
             });


        }else {
            $("#callout-alert").slideDown().find("p:first").text(data.message);
        }
        console.log("success");
    })
    .fail(function(jqXHR) {
        $("#callout-alert").slideDown().find("p:first").text(jqXHR.responseText);
        console.log("error");
    })
    .always(function() {
        console.log("complete");
    });

};

function refreshRoomDeleteButtons(){

    $("span.room-label").each(function(){
        var $el = $(this);
        var $btn = $el.closest(".rooms-action-container").find(".room-delete-button");
        if ($el.text() == "ROOM"){
          $btn.hide();
        } else{
          $btn.show();
        }
      });

}