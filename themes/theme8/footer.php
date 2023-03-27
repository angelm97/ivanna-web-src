<?
$social_footer_button='';
 if(tep_not_null(MODULE_FACEBOOK_FOOTER_LINK))
 $social_footer_button.='<a href="'.MODULE_FACEBOOK_FOOTER_LINK.'" class="btn btn-social-icon btn-facebook"><i class="fa fa-facebook text-white"></i></a>';

 if(tep_not_null(MODULE_LINKEDIN_FOOTER_LINK))
 $social_footer_button.='<a href="'.MODULE_LINKEDIN_FOOTER_LINK.'" class="btn btn-social-icon btn-linkedin"><i class="fa fa-linkedin text-white"></i></a>';

 if(tep_not_null(MODULE_TWITTER_FOOTER_LINK))
 $social_footer_button.='<a href="'.MODULE_TWITTER_FOOTER_LINK.'" class="btn btn-social-icon btn-twitter"><i class="fa fa-twitter text-white"></i></a>';

 if(tep_not_null(MODULE_GOOGLEPLUS_FOOTER_LINK))
 $social_footer_button.='<a href="'.MODULE_GOOGLEPLUS_FOOTER_LINK.'" class="btn btn-social-icon btn-google-plus"><i class="fa fa-google-plus text-white"></i></a>';

$social_footer_button_int='';
 if(tep_not_null(MODULE_FACEBOOK_FOOTER_LINK))
 $social_footer_button_int.='<a href="'.MODULE_FACEBOOK_FOOTER_LINK.'"><img src="'.HOST_NAME.'themes/theme8/images/facebook.jpg" alt="Facebook" width="34" height="34" border="0"></a>';

 if(tep_not_null(MODULE_LINKEDIN_FOOTER_LINK))
 $social_footer_button_int.='<a href="'.MODULE_LINKEDIN_FOOTER_LINK.'"><img src="'.HOST_NAME.'themes/theme8/images/linkedin.jpg" alt="LinkedIn" width="38" height="34" border="0"></a>';

 if(tep_not_null(MODULE_TWITTER_FOOTER_LINK))
 $social_footer_button_int.='<a href="'.MODULE_TWITTER_FOOTER_LINK.'"><img src="'.HOST_NAME.'themes/theme8/images/twitter.jpg" alt="Twitter" width="39" height="34" border="0"></a>';

 if(tep_not_null(MODULE_GOOGLEPLUS_FOOTER_LINK))
 $social_footer_button_int.='<a href="'.MODULE_GOOGLEPLUS_FOOTER_LINK.'"><img src="'.HOST_NAME.'themes/theme8/images/gplus.jpg" alt="Gplus" width="44" height="34" border="0"></a>';

//////////////////////

define('FOOTER_HTML','<div class="container-fluid footer-container theme8-bg-dark border-top mt-4 py-4">

<div class="footer">
	<div class="container text-center">
		<div class="row">
		<div class="col-md-12 mb-3">
		    <a class="btn btn-text text-white" href="'.tep_href_link('').'">Home</a>
            <a class="btn btn-text text-white" href="'.tep_href_link(FILENAME_ABOUT_US).'">About Us</a>
            <a class="btn btn-text text-white" href="'.tep_href_link(FILENAME_PRIVACY).'">Privacy Policy</a>
            <a class="btn btn-text text-white" href="'.tep_href_link(FILENAME_TERMS).'">Terms of Use</a>
            <a class="btn btn-text text-white" href="'.tep_href_link(FILENAME_ARTICLE).'">Resources</a>
            <a class="btn btn-text text-white" href="'.tep_href_link(FILENAME_SITE_MAP).'">Site Map</a>
            <a class="btn btn-text text-white" href="'.tep_href_link(FILENAME_CONTACT_US).'">Contact</a>
            <a class="btn btn-text text-white" href="'.tep_href_link(FILENAME_INDUSTRY_RSS).'">RSS</a>
		</div>
		<div class="col-md-12 mb-3"><font color="#fff">Copyright 2020 - <a class="text-white" href="'.tep_href_link('').'">'.SITE_TITLE.'</a> - <span class="theme8-break-line">All rights Reserved</span></font></div>
		<div class="col-md-12">'.$social_footer_button.'</div>
		</div>
	</div>
</div></div>

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

    <script language="javascript" type="text/javascript" src="'.tep_href_link("themes/theme8/tab.js").'"></script>

    <script src="'.HOST_NAME.'jscript/cookiealert.js"></script>
    '.tep_get_google_analytics_code().'

    <script src="'.tep_href_link(PATH_TO_LANGUAGE.$language."/jscript/page.js").'"></script>

    <!--THis timout js is used for timout the error or success message-->
    <script src="'.HOST_NAME.'jscript/error_success_message_timeout.js"></script>
    </body>
</html>');
?>