
$( document ).ready(function() {
    $("#xxx").hide();

    $('#envimg').click( res => {
        alert('Imagenes enviadas');
        tomarImagenPorSeccion('contentmorado','Waojobs');
        tomarImagenPorSeccion('contentamarillo','Waojobs');
    });
    
      $( "#printt" ).click(function() {  
        setTimeout(function(){
            window.open("/print_cv/", "", "width=500,height=400");
        }, 2000);
      });

      $( "#downl" ).click(function() {  
          
        $("#xxx").show();
    
        var element = document.getElementById('xxx');
        var opt = {
            margin:       10,
            filename:     'mi_cv.pdf',
            image:        { type: 'jpeg', quality: 0.98 },
            html2canvas:  { scale: 2, logging: true, dpi: 192, letterRendering: true },
            jsPDF:        { unit: 'mm', format: 'a4', orientation: 'portrait' }
        };

        html2pdf().set(opt).from(element).save();
        setTimeout(function(){
            $("#xxx").hide();
        }, 2000);
        
    });

    if(localStorage.getItem("create")){

        html2canvas(document.querySelector("#cv")).then(canvas => {
            var img = canvas.toDataURL();
            localStorage.setItem("element", img);
            document.getElementById('xxx').innerHTML = "<div id='downl_cv' style='text-align: center'> <img style='width:100%; max-height: 1080px !important;' src='"+localStorage.getItem("element")+"'> </div>";
            localStorage.removeItem("create");
        });
    
    }

});