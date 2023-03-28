<?
$social_footer_button='';
 if(tep_not_null(MODULE_FACEBOOK_FOOTER_LINK))
 $social_footer_button.=' <a href="'.MODULE_FACEBOOK_FOOTER_LINK.'"><i id="social-fb" class="fa fa2 fa-facebook-square fa-3x social"></i></a>';

 if(tep_not_null(MODULE_LINKEDIN_FOOTER_LINK))
 $social_footer_button.='<a href="'.MODULE_LINKEDIN_FOOTER_LINK.'"><i id="social-ln" class="fa fa2 fa-linkedin-square fa-3x social"></i></a>';

 if(tep_not_null(MODULE_TWITTER_FOOTER_LINK))
 $social_footer_button.='<a href="'.MODULE_TWITTER_FOOTER_LINK.'"><i id="social-tw" class="fa fa2 fa-twitter-square fa-3x social"></i></a>';

 if(tep_not_null(MODULE_GOOGLEPLUS_FOOTER_LINK))
 $social_footer_button.='<a href="'.MODULE_GOOGLEPLUS_FOOTER_LINK.'"><i id="social-gp" class="fa fa2 fa-google-plus-square fa-3x social"></i></a>';
//////////////////////
define('FOOTER_HTML','
<div class="container-fluid border-bottoms footer-vg-theme5 pt-4">
<footer class="container">
        <div class="row fontt">

            <div col-12 class="col-lg-3 mobile-col-md-3">

                    <div class="mb-2 font-weight-bold">TALENTO</div>

                <p>'.(check_login("jobseeker")?'<a href="'.tep_href_link(FILENAME_JOBSEEKER_CONTROL_PANEL).'">Panel de control</a>':'<a href="'.tep_href_link(FILENAME_JOBSEEKER_REGISTER1).'">Regístrate ahora</a>').'</p>
                <p>'.(check_login("jobseeker")?'<a href="'.tep_href_link(FILENAME_LOGOUT).'">Cerrar sesión</a>':'<a href="'.tep_href_link(FILENAME_JOBSEEKER_LOGIN).'">Inicia sesión</a>').'
                <p><a href="'.tep_href_link(FILENAME_JOB_SEARCH).'">Busca oportunidades laborales</a></p>
                <p><a href="'.tep_href_link('blog/').'">Educación laboral a tu alcance</a></p>
            </div>

            <div class=" col-12 col-lg-3 mobile-col-md-3">

                    <div class="mb-2 font-weight-bold">EMPRESA</div>

                <p>'.(check_login("recruiter")?'<a href="'.tep_href_link(FILENAME_RECRUITER_CONTROL_PANEL).'">Panel de control</a>':'<a href="'.tep_href_link(FILENAME_RECRUITER_REGISTRATION).'">Regístrate ahora</a>').'</p>
                <p>'.(check_login("recruiter")?'<a href="'.tep_href_link(FILENAME_LOGOUT).'">Cerrar sesión</a>':'<a href="'.tep_href_link(FILENAME_RECRUITER_LOGIN).'">Inicia sesión</a>').'</p>
                <p><a href="'.tep_href_link(FILENAME_RECRUITER_POST_JOB).'">Publica una oportunidad laboral</a></p>
                <p><a href="'.tep_href_link(FILENAME_RECRUITER_SEARCH_RESUME).'">Encuentra el talento ideal</a></p>
                <p><a href="'.tep_href_link(FILENAME_RECRUITER_SAVE_RESUME).'">Selecciona el paquete de tu preferencia</a></p>
                <p><a href="'.tep_href_link(FILENAME_RECRUITER_REGISTRATION).'">Educación laboral a tu alcance</a></p>
            </div>

            <div col-12  class="col-lg-3 mobile-col-md-3 mobile-margin-top">
                <div class="mb-2 font-weight-bold">INFORMACIÓN</div>
                <p><a href="'.tep_href_link(FILENAME_ABOUT_US).'">Sobre nosotros</a></p>
                <p><a href="'.tep_href_link(FILENAME_TERMS).'">Términos y condiciones</a></p>
                <p><a href="'.tep_href_link(FILENAME_PRIVACY).'">Política de privacidad</a></p>
                <!-- <p><a href="'.tep_href_link(FILENAME_ARTICLE).'">Recursos</a></p>
                <p><a href="'.tep_href_link(FILENAME_SITE_MAP).'">Mapa del sitio</a></p>-->
                <p><a href="'.tep_href_link(FILENAME_CONTACT_US).'">Contáctanos</a></p>
            </div>

            <div col-12  class="col-lg-3 mobile-col-md-3 mobile-margin-top">
            <a class="navbar-brand" href="'.tep_href_link("").'">
            <img src="'.tep_href_link('img/'.DEFAULT_SITE_LOGO).'" alt="Jobboard Logo" class="internal-logo">
            </a>
            <div class="mb-2 font-weight-bold">Síguenos</div>
           
            <p class="copyright PY-3">&copy; <a href="'.tep_href_link('').'"> Cuchumil </a></p>
        
        </div>
        </div>
        </footer>
        </div>

  		</div>	</div>


        <!-- /container -->
        <!-- jQuery -->
        <script src="'.HOST_NAME.'jscript/jquery-3.5.1.min.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="'.HOST_NAME.'jscript/bootstrap.bundle.min.js"></script>
        <!-- Script to Activate the Carousel -->
        <script>
        $(\'.carousel\').carousel({
          interval: 5000 //changes the speed
        });
        </script>
        <!-- bootstrap-select -->
        <script src="'.HOST_NAME.'jscript/bootstrap-select.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/i18n/defaults-*.min.js"></script>
        
        <script src="'.HOST_NAME.'jscript/cookiealert.js"></script>
        '.tep_get_google_analytics_code().'

        <script src="'.tep_href_link(PATH_TO_LANGUAGE.$language."/jscript/page.js").'"></script>

        <!--THis timout js is used for timout the error or success message-->
        <script src="'.HOST_NAME.'jscript/error_success_message_timeout.js"></script>
        <script src="'.HOST_NAME.'themes/waojobs/js/counting.js"></script>
        <script src="'.HOST_NAME.'themes/waojobs/js/search_rnc.js"></script>
        <script src="'.HOST_NAME.'librerias/htmlToCanvas.js"></script>
        <script src="'.HOST_NAME.'librerias/prueba.js"></script>
        


</body>
</html>');

?>