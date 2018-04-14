var SUBMISSION =  {
    type: "macintosh",
    color: "red",

    submitRegistration: function (el) {

            var $this = $(el);
            $this.button('loading');

            var rego = collectRegistrantInfo(false);

            $.ajax({
                url: '/register/process/?process=1',
                type: 'POST',
                dataType: 'html',
                data: { reference: "test", json: JSON.stringify(rego), cache: Math.random() },
            })
            .done(function (data) {
                if (data !== "" ){
                    var obj = JSON.parse(data);    
                    if (obj.status){
                        setTimeout(function() {
                            location.replace("/register/view/?success=1&ref=" + obj.reference);
                        }, 100);
                    }else{
                        //alert("registration error: \n" + obj.message);
                        $("#myModal").modal("show").find("div.modal-body").text(obj.message + ', please click CANCEL to review your details and try again or contact the registration team.')
                    }
                }else {
                    $("#myModal").modal("show").find("div.modal-body").text("Error: registration error, no data returned, please click CANCEL to review your details and try again or contact the registration team.");
                }
                
            })
            .fail(function (x,e,t) {
                //console.log(x + e + t);
                $("#myModal").modal("show").find("div.modal-body")
                    .text("Error: failed sync (" + t + "), please click CANCEL to review your details and try again or contact the registration team.");
            })
            .always(function () {
                console.log("complete");
                $this.button('reset');
            });


    },


    randomX: function(length){

            var chars1 = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            var chars2 = "1234567890";

            var chars = chars1;

            var pass = "";
            for (var x = 0; x < length; x++) {
                var i = Math.floor(Math.random() * chars.length);
                pass += chars.charAt(i);
            }
            return pass;

    },


    randomNames: function(){

        var names = ["Nguyễn  ","Trần ","Lê  ","Phạm ","Huỳnh","Vũ  ","Phan ","Trương  ",
                      "Hoàng","Ngô ","Đặng ","Đỗ  ","Bùi ","Võ  ",
                      "Lý  ","Dương","Lương","Đinh ","Trịnh","Lưu ",
                      "Đoàn ","Đào ","Thái ","Mai ",
                      "Văn ","Cao ","Vương","Phùng","Quách",
                      "Tạ  ","Diệp ","Tôn ","La  ",
                      "Thạch","Thi ","Thanh","Đàm ","Vong ",
                      "Triệu","Bưu ","Phú ",
                      "Vĩnh ","Quang","Tiều ","Hòa ","Trang","Giang","Lục ",
                      "Banh ","Nghiêm"];


        var x = this.randomN(names.length + 1, 1) - 1;
        var y = this.randomN(names.length + 1, 1) - 1;
        return names[x].trim();// + ' ' + names[y];       

    },


    randomN: function(max, min){
            return Math.floor((Math.random() * max) + min);
    },


    fillRandomInfo: function(){

          $("#rego-form input").each(function (index, el) {
                
                switch ($(this).attr("type")) {
                    case "email":
                        el.value = "kyle@instil.org.au";
                        break;
                    case "text":
                        if (el.id == "tPhone") {
                            el.value = "03 9548 5689"
                        } else {
                            el.value = SUBMISSION.randomNames(); //SUBMISSION.randomX(10);
                        }
                        break;
                    case "number":
                        el.value = SUBMISSION.randomN(99,1);
                        break;
                    case "checkbox":
                        el.checked = (SUBMISSION.randomN(2, 1) == 2);
                        break;
                }

            });


            $("#rego-form select").each(function (index, el) {
                el.selectedIndex = SUBMISSION.randomN(el.length - 1, 0);
            });

            collectRegistrantInfo(false);

    },

}





