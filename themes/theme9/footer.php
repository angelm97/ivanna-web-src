<?
$social_footer_button='';
 if(tep_not_null(MODULE_FACEBOOK_FOOTER_LINK))
 $social_footer_button.='<a href="'.MODULE_FACEBOOK_FOOTER_LINK.'" class="btn btn-social-icon btn-facebook"><i class="fa fa-facebook bg-white py-2 px-3 rounded"></i></a>';

 if(tep_not_null(MODULE_LINKEDIN_FOOTER_LINK))
 $social_footer_button.='<a href="'.MODULE_LINKEDIN_FOOTER_LINK.'" class="btn btn-social-icon btn-linkedin"><i class="fa fa-linkedin bg-white py-2 px-3 rounded"></i></a>';

 if(tep_not_null(MODULE_TWITTER_FOOTER_LINK))
 $social_footer_button.='<a href="'.MODULE_TWITTER_FOOTER_LINK.'" class="btn btn-social-icon btn-twitter"><i class="fa fa-twitter bg-white py-2 px-3 rounded"></i></a>';

 if(tep_not_null(MODULE_GOOGLEPLUS_FOOTER_LINK))
 $social_footer_button.='<a href="'.MODULE_GOOGLEPLUS_FOOTER_LINK.'" class="btn btn-social-icon btn-google-plus bg-white py-2 px-3 rounded"><i class="fa fa-google-plus"></i></a>';
//////////////////////

define('FOOTER_HTML','	        <div class="container-fluid footer-container theme9-bg-yellow mt-4 py-2">
<div class="footer">
            <div class="container">
                <div class="row text-center">
                    <div class="col-md-12 mb-2"><a class="btn btn-text" href="'.tep_href_link('').'">Home</a>                    <a class="btn btn-text" href="'.tep_href_link(FILENAME_ABOUT_US).'">About us</a>                    <a class="btn btn-text" href="'.tep_href_link(FILENAME_PRIVACY).'">Privacy policy</a>
                    <a class="btn btn-text" href="'.tep_href_link(FILENAME_TERMS).'">Terms of use</a>
                    <a class="btn btn-text" href="'.tep_href_link(FILENAME_ARTICLE).'">Resources</a>
                    <a class="btn btn-text" href="'.tep_href_link(FILENAME_SITE_MAP).'">Site map</a>
                    <a class="btn btn-text" href="'.tep_href_link(FILENAME_CONTACT_US).'">Contact</a>
                    <a class="btn btn-text" href="'.tep_href_link(FILENAME_INDUSTRY_RSS).'">RSS</a>
                    
                </div>
            </div>
        </div>
        <div class="sub-footer">
            <div class="container">
                <div class="row text-center">
				<div class="col-md-12 text-center mb-2">Copyright '.date("Y").' - <a href="'.tep_href_link('').'">'.SITE_TITLE.'</a> - <span class="theme9-break-line">All rights reserved</span></div>
				<div class="col-md-12">'.$social_footer_button.'
                    </div>
                </div>
            </div>
        </div>
		</div>
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
    <script src="'.HOST_NAME.'jscript/cookiealert.js"></script>
    '.tep_get_google_analytics_code().'

    <!--THis timout js is used for timout the error or success message-->
    <script src="'.HOST_NAME.'jscript/error_success_message_timeout.js"></script>
    <script src="'.tep_href_link(PATH_TO_LANGUAGE.$language."/jscript/page.js").'"></script>
    <script language="javascript" type="text/javascript" src="'.tep_href_link("themes/theme9/tab.js").'"></script>
</body>
</html>
');
?>