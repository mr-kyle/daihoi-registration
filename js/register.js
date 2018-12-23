    jQuery.extend({
      getQueryParameters : function(str) {
          return (str || document.location.search).replace(/(^\?)/,'').split("&").map(function(n){return n = n.split("="),this[n[0]] = n[1],this}.bind({}))[0];
      }
    });


    var PAGE_VALIDATOR;
    var ROW_COUNTER = 1;
    

    function removeRow(el) {
        if (ROW_COUNTER == 1 ) {
            return false;
        }
        var div = $(el).parents("div.row:first");
        //div.next("div").empty();
        div.fadeOut(400,function(){
            $(this).remove();
        });
        
        ROW_COUNTER = ROW_COUNTER - 1;
        collectRegistrantInfo();
    }


    function addMoreRegistrants() {
            
        if (ROW_COUNTER > 12) {
            alert("You have reached the maximum allowed.");
            return false;
        }

        for (var x = 1; x < 4; x++) {
            var html = $(".form-inline div.row:first").html();
            html = '<div class="row other-registrants">' + html + "</div>"; //<div>&nbsp;</div>
            var template = jQuery.validator.format(html);
            $(template(ROW_COUNTER++, "force-show")).insertBefore("#add-more-button-row");

        }


        $(".form-inline input[type=number].age").each(function (index, el) {
            //triggers the age validation for the newly created rows
            PAGE_VALIDATOR.element(el);
        })

        attachEventsToRegistrants();
        collectRegistrantInfo();
        
    }


    function getMainContactInfo() {
        var el = document.getElementById("tAge");
        var age = el.options[el.selectedIndex].text;
        var pensioner = document.getElementById("pensioner00").checked;

        //fee calculation for main contact
        
        var airbed    = false; //document.getElementById("airbed00").checked;
        var airport   = document.getElementById("airport00").checked;

        var fee       = REGO_CALCULATOR.calculateFee(age, pensioner, airport);

        //update the display
        $(".form-horizontal .form-group .line-total").html("$ " + fee.toFixed(2));

        
        //collect other information
        el = document.getElementById("tChurch");
        var church = el.options[el.selectedIndex].text;
        if (el.selectedIndex == 0) { church = ""}
        var phone  = $("#tPhone").intlTelInput("getNumber"); //document.getElementById("tPhone").value;
        var name   = document.getElementById("tFullName").value;
        var surname= document.getElementById("tSurname").value;
        var email  = document.getElementById("tEmail").value;
        var notes  = document.getElementById("tNotes").value;
        el = document.getElementById("tGender");
        var gender   = el.options[el.selectedIndex].value;
        el = document.getElementById("tRole");
        var role = el.options[el.selectedIndex].value;
        el = document.getElementById("tState");
        var zState = el.options[el.selectedIndex].value;

        return {
            email       : htmlEncode($.trim(email)),
            name        : htmlEncode($.trim(name)),
            surname     : htmlEncode($.trim(surname)),
            fee         : fee,
            age         : age,
            airbed      : airbed,
            airport     : airport,
            church      : htmlEncode($.trim(church)),
            phone       : htmlEncode($.trim(phone)),
            notes       : htmlEncode($.trim(notes)),
            role        : role,
            gender      : gender,
            pensioner   : pensioner,
            state       : zState
        }


    }


    function collectRegistrantInfo(showJSON) {

        
        //gets the main rego fee
        var groupRego = new REGO();
        var info = getMainContactInfo();

        groupRego.Firstname       = info.name;
        groupRego.Surname         = info.surname;
        groupRego.Age             = info.age;
        groupRego.Church          = info.church;
        groupRego.Airbed          = info.airbed;
        groupRego.AirportTransfer = info.airport;
        groupRego.Fee             = info.fee;
        groupRego.Phone           = info.phone;
        groupRego.Email           = info.email;
        groupRego.Comments        = info.notes;
        groupRego.Reference       = "MELBOURNE2018";    //groupRego.generateReference(10);
        groupRego.Role            = info.role;
        groupRego.Gender          = info.gender;
        groupRego.Pensioner       = info.pensioner;
        groupRego.State           = info.state;

        var total = 0;
        var person;
        $(".form-inline .row input[type=text].name").each(function (index, el) {
        	person = updateRowFee(el);
        	
        	if (person.isValid()){ //only add to array if person is valid
        		groupRego.Registrants[index] = person;
            	total = total + person.Fee;
        	}
            
        })

        total = total + groupRego.Fee;

        document.getElementById("TotalAmount").value = total;


        var queryParams = $.getQueryParameters();
        if (queryParams.debug == "1"){
                //alert(JSON.stringify(aa))
                $("#json").html(JSON.stringify(groupRego)).show();
            
        }

        return groupRego;
    }


    function updateRowFee(el) {

        var groups = new REGISTRANT();
        
        var age             = "";
        var name            = "";
        var surname         = "";
        var fee             = 0;
        var role            = "";
        var gender          = "";
        var familyDiscount  = 0;
        var airport         = false;
        var pensioner       = false;

        var div = $(el).parents("div.row:first");

        //find the pensioner
        $(div).find("input[type=checkbox].pensioner:checked").each(function (index, el) {
            pensioner = el.checked
        });
            
        $(div).find("input[type=text].name").each(function () {
            name = htmlEncode($.trim($(this).val()));
        });

        $(div).find("input[type=text].surname").each(function () {
            surname = htmlEncode($.trim($(this).val()));
        });

        $(div).find("input[type=number].age").each(function () {
            age = parseInt($(this).val());
        });
        $(div).find("select.role").each(function () {
            role = $(this).val();
        });
        $(div).find("select.gender").each(function () {
            gender = $(this).val();
        });


        $(div).find("select.family-discount").each(function (index, e) {
            familyDiscount = e.selectedIndex;
            groups.DiscountFamily = $(e).val();

        });


        //find the airbed discount (removed)
        /*
        $(div).find("input[type=checkbox].discount-airbed:checked").each(function (index, el) {
            fee = fee - REGO_CALCULATOR.airbed_discount_amount
            groups.Airbed = el.checked;
        });
        */

        //find the airport transfer
        $(div).find("input[type=checkbox].airport-transfer:checked").each(function (index, el) {
            airport = el.checked;
        });

        if (name !== "" && surname !== "" && isNaN(age) == false) {
            fee = REGO_CALCULATOR.calculateFee(age, pensioner, airport, familyDiscount);

        }


        //display the fee
        $(div).find(".line-total").each(function () {
            $(this).html("$ " + fee.toFixed(2))//.fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100);               
        });


        
        groups.Age              = age;
        groups.Firstname        = $(div).find("input[type=text].name").val();
        groups.Surname          = $(div).find("input[type=text].surname").val();
        groups.Fee              = fee;
        groups.Relation         = $(div).find("select.relation:first").val();
        groups.Role             = role;
        groups.Gender           = gender;
        groups.Pensioner        = pensioner;
        groups.AirportTransfer  = airport;

        return groups;

    }


    // updates the data template with the rego data for summary
    function updateSummary(htmlTemplate) {
        var regoInfo = collectRegistrantInfo();

        htmlTemplate = jQuery.validator.format(htmlTemplate);
        //find out if there are any extra registrants for the rego
        var registrants = "";
        var paymentSummary = "";

        var html = "<tr><td>{NAME}</td><td>{AGE}</td><td>{GENDER}</td><td>{RELATION}</td><td>{PENSIONER}</td><td>{FAMILY}</td><td>{AIRPORT}</td><td>{ROLE}</td><td>${FEE}</td></tr>"; //<td>{AIRBED}</td>
        var htmlShort = "<tr><td>{COUNTER}.</td><td>{NAME}</td><td>{AGE}</td><td>${FEE}</td></tr>";

        //add the main contact to the payment summary
        paymentSummary = htmlShort.replace("{NAME}",        regoInfo.Name())
                                    .replace("{AGE}",       regoInfo.Age)
                                    .replace("{COUNTER}",   "1")
                                    .replace("{GENDER}",    regoInfo.Gender)
                                    .replace("{ROLE}",      regoInfo.Role)
                                    .replace("{FEE}",       regoInfo.Fee);

        
        var person;
        var personCounter=0;
        for (var index in regoInfo.Registrants) {
            person = regoInfo.Registrants[index];

            if (person.isValid()) {
                personCounter += 1
                registrants += html.replace("{NAME}",       person.Name())
                                    .replace("{AGE}",       person.Age)
                                    .replace("{RELATION}",  person.Relation)
                                    .replace("{PENSIONER}", toYesNo(person.Pensioner))
                                    .replace("{FAMILY}",    person.DiscountFamily)
                                    .replace("{AIRBED}",    toYesNo(person.Airbed))
                                    .replace("{AIRPORT}",   toYesNo(person.AirportTransfer))
                                    .replace("{GENDER}",    person.Gender)
                                    .replace("{ROLE}",      person.Role)                                   
                                    .replace("{FEE}",       person.Fee);
                                    


                paymentSummary += htmlShort.replace("{NAME}",       person.Name())
                                            .replace("{AGE}",       person.Age)
                                            .replace("{COUNTER}",   (parseInt(personCounter) + 1))
                                            .replace("{FEE}",       person.Fee);

            }
    
        }

        //the extra registrants display attr
        var display = (registrants == "" ? "hidden" : "");





        $("#summary-content").html(
            $(htmlTemplate(
                regoInfo.Reference,
                regoInfo.Name(),
                regoInfo.Age,
                regoInfo.Email,
                regoInfo.Phone,
                regoInfo.Role,
                regoInfo.Gender,
                //toYesNo(regoInfo.Airbed),
                toYesNo(regoInfo.AirportTransfer),
                toYesNo(regoInfo.Pensioner),
                regoInfo.Church,
                regoInfo.Fee,
                regoInfo.Comments,
                display,
                registrants,
                regoInfo.sumTotalFees(true),
                paymentSummary,
                regoInfo.sumTotalFees(),
                regoInfo.State
                )
            ).html()

        );

        return true;

    }


    //validator hookup for age and name to be dependant on each other
    $.validator.addMethod("age", function (value, element) { 

        var dependantLen = $.trim($(element).parent().prev().prev().children("input[type=text].name:first").val()).length;
        var currentLen = $.trim(value).length;
        if ($.trim(value) == "" && dependantLen == 0) {
            return true;
        }
        var b = currentLen > 0 && dependantLen > 0;
        return b;

    }, "Name &amp; Age required");

   
    $(function () {

        attachEventsToMainContact();
        attachEventsToRegistrants();
        addCountriesToPhone();
        hookStateChange();

        PAGE_VALIDATOR =  $("#rego-form").validate({
            debug: true,
            focusInvalid: false,
            errorClass: "validate-error",
            submitHandler: function (form) {

                var groupRego   = collectRegistrantInfo();
                var result      = groupRego.validate(); //does the main contact validation 
                
                if (!result.isValid) {
                    alert(result.errMsg)
                    return false;
                } else {
                    //alert("get summary")
                    getSummary();
                }
                
            },
            invalidHandler: function (form, validator) {

                if (!validator.numberOfInvalids())
                    return;

                    
                var top = $(validator.errorList[0].element).offset().top;
                if (top > 50) { top = top - 60 }
                if (top < 0) { top = 0}

                $('html, body').animate({
                    scrollTop: top
                }, 750);
            }


        });



        //init shepard
        //initShepard();

    });


    function attachEventsToRegistrants() {
        $("div.form-inline input, div.form-inline select.family-discount").each(function (index, el) {
            $(el).bind("change", function () {

                collectRegistrantInfo()
            })
        });
    }


    function attachEventsToMainContact() {
        //attach to main contact
        $(".form-horizontal input, .form-horizontal select").each(function (index, el) {
            $(el).bind("change", function () {

                collectRegistrantInfo()
            })
        });
   
    }


    function addCountriesToPhone() {
        //https://github.com/jackocnr/intl-tel-input#browser-compatibility
        $("#tPhone").intlTelInput({
            // allowDropdown: false,
            // autoHideDialCode: false,
            // autoPlaceholder: false,
            // dropdownContainer: "body",
            excludeCountries: ["do"],
            // geoIpLookup: function(callback) {
            //   $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
            //     var countryCode = (resp && resp.country) ? resp.country : "";
            //     callback(countryCode);
            //   });
            // },
            // initialCountry: "auto",
            // nationalMode: false,
            // numberType: "MOBILE",
            // onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
            preferredCountries: ['au', 'vn', 'nz', 'us', 'ca'],
            // separateDialCode: true,
            utilsScript: "/js/utils.js"
        });

        //telInput.intlTelInput("isValidNumber")
        //$("#tPhone").intlTelInput("getNumber")

        PHONE_VALIDATOR.bindPhone();

    }



    var PHONE_VALIDATOR = {
        telInput:   $("#tPhone"),
        errorMsg:   $("#phone-error-msg"),
        validMsg:   $("#phone-valid-msg"),
        reset: function () {
            PHONE_VALIDATOR.errorMsg.addClass("hidden");
            PHONE_VALIDATOR.validMsg.addClass("hidden");
        },

        bindPhone: function(){
            
            // on blur: validate
            this.telInput.blur(function () {
                PHONE_VALIDATOR.reset();
                if ($.trim($(this).val())) {
                    if ($(this).intlTelInput("isValidNumber")) {
                        PHONE_VALIDATOR.validMsg.removeClass("hidden");
                    } else {
                        PHONE_VALIDATOR.errorMsg.removeClass("hidden");
                    }
                }
            });

            // on keyup / change flag: reset
            this.telInput.on("keyup change", PHONE_VALIDATOR.reset);

        }


    }



    function toYesNo(v) {

        if (v == "1" || v == "true") {
            return "Yes"
        } else {
            return "No"
        }

    }


    function addCommas(nStr) {
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    }


    function getSummary() {



        $.ajax({
            url: '/register/summary_template.php',
            type: 'GET',
            dataType: 'html',
            data: { cache: Math.random() },
        })
        .success(function (data) {
            //document.getElementById("summary-content").innerHTML = data;
            updateSummary(data);
            swapRegoSummary();
        })
        .done(function (data) {
            //alert(data)
            //document.getElementById("summary-content").innerHTML = data;

        })
        .fail(function () {
            console.log("error");
            alert("error")
        })
        .always(function () {
            console.log("complete");

        });


    }

    function swapRegoSummary() {
        $("#rego-form").toggle();
        $("#rego-summary").fadeToggle();

        $('html, body').animate({
            scrollTop: $('#fee-structure-end').offset().top
        }, 500);

    }


    function htmlEncode(value) {
        //create a in-memory div, set it's inner text(which jQuery automatically encodes)
        //then grab the encoded contents back out.  The div never exists on the page.
        return $('<div/>').text(value).html();
    }

    function htmlDecode(value) {
        return $('<div/>').html(value).text();
    }

    function isNumeric(n) {
      return !isNaN(parseFloat(n)) && isFinite(n);
    }    




        //SHEPARD

        var tour;

        function initShepard(){

            tour = new Shepherd.Tour({
              defaults: {
                classes: 'shepherd-theme-arrows',
                showCancelLink: true,
                when: {
                    show: function() {
                        $("#rego-form").addClass('shepherd-active');

                        var x = $(formatAttachTo(this.options.attachTo));
                        var offsetTop = 250;
                        var wHeight = $(window).height();

                        if (wHeight < 660){
                            if (this.id == "OtherRegos" || this.id == "OtherFee" || this.id == "MoreRegos" || this.id == "TotalFee" || this.id == "Comments"){
                                offsetTop = 350;
                            }
                        }
                        $('html, body').animate({scrollTop : x.offset().top - offsetTop}, "slow");
                        console.log(this.id)
                    },
                    cancel: function(){
                        doneShepherd();
                    }
                }                 

              }

            });



            tour.addStep('FullName', {
              title: 'FullName',
              text: 'It is important the Name is entered correctly (especially Vietnamese punctuations) <br> as this field will be used for your name tag.',
              attachTo: '#tFullName bottom',
                 buttons: [
                        {
                          text: 'Exit',
                          classes: 'shepherd-button-secondary',
                          action: tour.cancel,
                          action: function(){
                                tour.cancel();
                                doneShepherd();
                          }
                        }, {
                          text: 'Next',
                          action: tour.next
                        }
                    ]            

            });



            tour.addStep('Fee', {
              title: 'Fee',
              text: 'Your fee calculated for this registrant.',
              attachTo: 'body > .container.body-content > div:first-child > form:last-child > .panel.panel-default > .panel-body > .form-horizontal > .form-group .line-total bottom',
                 buttons: [
                        {
                          text: 'Back',
                          classes: 'shepherd-button-secondary',
                          action: tour.back
                        }, {
                          text: 'Next',
                          action: tour.next
                        }
                    ]            

            });            


            tour.addStep('OtherRegos', {
              title: 'Other Registrants',
              text: 'Add more registrants using here, <br />you must enter, at least, the Name & Age.',
              attachTo: '.form-inline.custom > .row:first-child top',
                 buttons: [
                        {
                          text: 'Back',
                          classes: 'shepherd-button-secondary',
                          action: tour.back
                        }, {
                          text: 'Next',
                          action: tour.next
                        }
                    ]            
            });   



            tour.addStep('OtherFee', {
              title: 'Other Registrants - Fee',
              text: 'Fee for the individual registrant.',
              attachTo: 'body > .container.body-content > div:first-child > form:last-child > .panel.panel-default > .panel-body > .col-md-11.col-md-offset-1 > .form-inline.custom > .row:first-child div.line-total top',
                 buttons: [
                        {
                          text: 'Back',
                          classes: 'shepherd-button-secondary',
                          action: tour.back
                        }, {
                          text: 'Next',
                          action: tour.next
                        }
                    ]            

            });   



            tour.addStep('MoreRegos', {
              title: 'More Registrants',
              text: 'Click to add more registrants.',
              attachTo: '#add-more-button-row .btn top',
                 buttons: [
                        {
                          text: 'Back',
                          classes: 'shepherd-button-secondary',
                          action: tour.back
                        }, {
                          text: 'Next',
                          action: tour.next
                        }
                    ]            

            });





            tour.addStep('TotalFee', {
              title: 'Total Fee',
              text: 'Your total calculated Fee Amount<br>for the entire registration.<br>(Main Contact & Other Registrants).',
              attachTo: '#TotalAmount top',
                 buttons: [
                        {
                          text: 'Back',
                          classes: 'shepherd-button-secondary',
                          action: tour.back
                        }, {
                          text: 'Next',
                          action: tour.next
                        }
                    ]            

            }); 


            tour.addStep('Comments', {
              title: 'Your Comments',
              text: 'Include your Airport Transfer information<br> (flight ref, arrival and departure times), <br> dietary requests, special needs if applicable.',
              attachTo: '#tNotes top',
                 buttons: [

                        {
                          text: 'Back',
                          classes: 'shepherd-button-secondary',
                          action: tour.back
                        }, {
                          text: 'Next',
                          action: tour.next
                        }
                    ]            
            }); 

            tour.addStep('Done', {
              title: 'Done',
              text: 'When you are done, click to proceed.',
              attachTo: 'body > .container.body-content > div:first-child > form:last-child > .panel.panel-default > .panel-body > .col-md-11.col-md-offset-1 > .row input.btn bottom',     
                     buttons: [
                        {
                          text: 'Back',
                          classes: 'shepherd-button-secondary',
                          action: tour.back
                        }, {

                         id : 'test1',

                          text: 'Done',

                          action: function(){
                                tour.next();
                                doneShepherd();
                          }
                        }
                    ]            

            }); 
            //tour.start();

        };





        function formatAttachTo(s){
            var ss = s.split(" ");
            ss.pop();
            return ss.join(" ");

        }



        function doneShepherd(){
            var x = $("#rego-form");
            x.removeClass('shepherd-active');
            $('html, body').animate({scrollTop : x.offset().top}, "slow");          

        }


    function hookStateChange(){
        console.log('hookStateChange')
        $('#tState').on('change',function(){
            triggerStateChange();
        });
    }

    function triggerStateChange(){
        var myState = $('#tState').val();
        var selectedIndex = 0;
        
        $('#tChurch option').map(function(index, el) { 
            var $el = $(this);
            var currentState = $el.attr('data-state');

            if (myState == "") {
                $el.show();
            }else{
                if (currentState == myState ){
                    if (selectedIndex == 0) { selectedIndex = index} 
                    $el.show();
                } else{

                    if (currentState.indexOf(myState) > -1) {
                        if (selectedIndex == 0) { selectedIndex = index} 
                        $el.show();
                    }else{
                        $el.hide();
                    }
                }    
            }
        });

        document.getElementById('tChurch').selectedIndex = selectedIndex;
    }


    //callout for pensioner
    var main_contact_pensioner_alert = 0;
    var other_registrants_pensioner_alert = 0;
    function alertPensioner(el, type){
        if (!el.checked) {return false}

        if (type == 'main') {
            if (main_contact_pensioner_alert == 1){
                return false;
            }
            main_contact_pensioner_alert = 1;
        }
        if (type == 'other') {
            if (other_registrants_pensioner_alert == 1){
                return false;
            }
            other_registrants_pensioner_alert = 1;
        }


        $("#callout").slideDown()
                .find("p:first")
                .text('Please note, only select Pensioner if you are holding a valid Pensioner Concession Card.');

    }    
