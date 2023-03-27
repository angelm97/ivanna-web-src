
$(document).ready(function () {
    
    var url_for_email_confirmation = window.location.href;
    try {
        var captured = /email_activated=([^&]+)/.exec(url_for_email_confirmation)[1]; // Value is in [1] ('384' in our case)
        var result = captured ? captured : 'myDefaultValue';
        
        if (result == 'true'){
            swal("¡Bienvenido!", "Tu cuenta esta activada.", "success");
        }
    } catch (error) {

    }
    
    

    $("#rnc").focusout(function () {

    var var_rnc_company = $("#rnc").val();

    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        var datos = JSON.parse(this.responseText);
        company_data = datos.data[0]; 
        if (company_data) {
            console.log(company_data.state);
            $("#name_company").val(company_data.business_name);
            $("#TR_address_line1").val(company_data.sector + " " + company_data.street + " " + company_data.street_number);
            $("#recruiter_company_state").val(company_data.state);
        } else {
            $("#name_company").val('');
            $("#TR_address_line1").val('');
            $("#recruiter_company_state").val('FALSE');
            alert('RNC Not Found');
        }
    }
    xhttp.open("GET", "get_rnc.php?q="+ var_rnc_company);
    xhttp.send();   


    });

    $('#chat-btn').click( res=>{
        $(".chat-bot").css("display","block");
        $("#chat-btn").css("display","none");
    });

    $('#close-chat').click( res=>{
        $(".chat-bot").css("display","none");
        $("#chat-btn").css("display","block");
    });
    
    var input = document.getElementById("data");
        input.addEventListener("keyup", function(event) {
            if (event.keyCode === 13) {
                event.preventDefault();
                getAnswer();
            }
        });

    $("#send-btn").click( res=>{
        getAnswer();
    });

    function getAnswer () {
        $value = $("#data").val();
        $value = $value.trim();
        $("#data").val('');
        $(".chat-middle").append('<div class="user"> <p> ' +  $value + ' </p> </div> <div class="clear"></div>');
        $(".chat-middle").scrollTop($(".chat-middle")[0].scrollHeight);
       // $msg = '<div class="user-inbox inbox"><div class="msg-header"><p>'+ $value +'</p></div></div>';
        // $(".form").append($msg);
        // $("#data").val('');

        // start ajax code
        $.ajax({
            url: 'chatbot.php',
            type: 'POST',
            data: 'text='+$value,
            success: function(result){
                $replay =  result;
                $(".chat-middle").append('<div class="bot"> <p> ' +  $replay + ' </p> </div>');
               // $(".chat-middle").append($replay);
                // when chat goes down the scroll bar automatically comes to the bottom
                $(".chat-middle").scrollTop($(".chat-middle")[0].scrollHeight);
            }
        });
    }


    

});



// A $( document ).ready() block.
/*
$(document).ready(function () {
    $("#rnc").focusout(function () {
        var var_rnc_company = $("#rnc").val();
        if (var_rnc_company != "") {
            var var_url_api_rnc = "https://api.indexa.do/api/rnc?rnc=" + var_rnc_company;
            $.ajax({
                url: var_url_api_rnc,
                type: 'GET',
                dataType: "json",
                crossDomain: true,
                headers: {
                    'x-access-token': '35a139bf-f0d0-4ea0-adc6-0b7307a25da2'
                },
               
                success: function (result) {

                    var company_data = result.data[0];
                    if (company_data) {
                        console.log(company_data.state);
                        $("#name_company").val(company_data.business_name);
                        $("#TR_address_line1").val(company_data.sector + " " + company_data.street + " " + company_data.street_number);
                        $("#recruiter_company_state").val(company_data.state);
                    } else {
                        $("#name_company").val('');
                        $("#TR_address_line1").val('');
                        $("#recruiter_company_state").val('FALSE');
                        alert('RNC Not Found');
                    }

                },
                error: function (error) {
                    console.log(error);
                }
            });
        } else {
            $("#name_company").val('');
            $("#TR_address_line1").val('');
        }

    })

});

*/