<?
$social_footer_button='';
 if(tep_not_null(MODULE_FACEBOOK_FOOTER_LINK))
 $social_footer_button.='<a href="'.MODULE_FACEBOOK_FOOTER_LINK.'" class="icoFacebook" title="Facebook"><i class="fa fa-facebook"></i></a>';

 if(tep_not_null(MODULE_LINKEDIN_FOOTER_LINK))
 $social_footer_button.='<a href="'.MODULE_LINKEDIN_FOOTER_LINK.'" class="icoLinkedin" title="Linkedin"><i class="fa fa-linkedin"></i></a>';

 if(tep_not_null(MODULE_TWITTER_FOOTER_LINK))
 $social_footer_button.='<a href="'.MODULE_TWITTER_FOOTER_LINK.'" class="icoTwitter" title="Twitter"><i class="fa fa-twitter"></i></a>';

 if(tep_not_null(MODULE_GOOGLEPLUS_FOOTER_LINK))
 $social_footer_button.='<a href="'.MODULE_GOOGLEPLUS_FOOTER_LINK.'" class="icoGoogle-plus" title="Google-plus"><i class="fa fa-google-plus"></i></a>';
//////////////////////

define('FOOTER_HTML','	<div class="container-fluid bg-white theme6-mobile-mt">
<div class="container">
            <!-- Footer -->
            <footer>
                <div class="container">
                    <div class="row">
                        <div class="col-md-3 mobile-col-md-3">
                            <img src="'.tep_href_link('img/'.DEFAULT_SITE_LOGO).'" class="footer-logo">
                            <p class="copyright">&copy; '.date("Y").'<a href="'.tep_href_link('').'"> '.SITE_TITLE.' </a></p>
                        </div>
                        <div class="col">
                            <ul class="list-unstyled text-small">
                                <li class="font-weight-bold mb-2">JOB SEEKER</li>
								<li>'.(check_login("jobseeker")?'<a href="'.tep_href_link(FILENAME_JOBSEEKER_CONTROL_PANEL).'">Control Panel</a>':'<a href="'.tep_href_link(FILENAME_JOBSEEKER_REGISTER1).'">Register Now</a>').'</li>
								<li><a href="'.tep_href_link(FILENAME_JOB_SEARCH).'">Search Jobs</a></li>
								<li>'.(check_login("jobseeker")?'<a href="'.tep_href_link(FILENAME_LOGOUT).'">Logout</a>':'<a href="'.tep_href_link(FILENAME_JOBSEEKER_LOGIN).'">Login</a>').'</li>
								<li><a href="'.tep_href_link(FILENAME_JOBSEEKER_LIST_OF_APPLICATIONS).'">View Applications</a></li>
								<li><a href="'.tep_href_link(FILENAME_JOB_ALERT_AGENT).'">Job Alerts</a></li>
								<li><a href="'.tep_href_link(FILENAME_JOBSEEKER_RESUME1).'">Post Resume</a></li>                            </ul>
                        </div>
                        <div class="col-md-3 mobile-col-md-3">
                            <ul class="list-unstyled text-small">
                                <li class="font-weight-bold mb-2">EMPLOYER</li>
								<li><a href="'.tep_href_link(FILENAME_RECRUITER_POST_JOB).'">Post a Job</a></li>
								<li><a href="'.tep_href_link(FILENAME_RECRUITER_SEARCH_RESUME).'">Search Resume</a></li>
								<li>'.(check_login("recruiter")?'<a href="'.tep_href_link(FILENAME_LOGOUT).'">Logout</a>':'<a href="'.tep_href_link(FILENAME_RECRUITER_LOGIN).'">Login</a>').'</li>
								<li>'.(check_login("recruiter")?'<a href="'.tep_href_link(FILENAME_RECRUITER_CONTROL_PANEL).'">Control Panel</a>':'<a href="'.tep_href_link(FILENAME_RECRUITER_REGISTRATION).'">Register Now</a>').'</li>
								<li><a href="'.tep_href_link(FILENAME_RECRUITER_SAVE_RESUME).'">Resume Alerts</a></li>
								<li><a href="'.tep_href_link(FILENAME_RECRUITER_SEARCH_APPLICANT).'">Applicant Tracking</a></li>
                            </ul>
                        </div>
                        <div class="col-md-3 mobile-col-md-3 mobile-margin-top">
                            <ul class="list-unstyled text-small">
                                <li class="font-weight-bold mb-2">INFORMATION</li>
								<li><a href="'.tep_href_link(FILENAME_ABOUT_US).'">About Us</a></li>
								<li><a href="'.tep_href_link(FILENAME_TERMS).'">Terms & Conditions</a></li>
								<li><a href="'.tep_href_link(FILENAME_PRIVACY).'">Privacy Policy</a></li>
								<li><a href="'.tep_href_link(FILENAME_ARTICLE).'">Resources</a></li>
								<li><a href="'.tep_href_link(FILENAME_SITE_MAP).'">Sitemap</a></li>
								<li><a href="'.tep_href_link(FILENAME_CONTACT_US).'">Contact Us</a></li>
                            </ul>
                        </div>
                        <div class="col mobile-col-md-3">
                            <ul class="social-network social-circle">
                                <li class="font-weight-bold mb-2 theme6-mobile-mb">GET SOCIAL</li>
                                <br>
                                <li>
									'.$social_footer_button.'
                                    <a href="'.tep_href_link(FILENAME_INDUSTRY_RSS).'" class="icoRss" title="Rss"><i class="fa fa-rss"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
            </footer>
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

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn\'t work if you view the page via file:// -->
        <!--[if lt IE 9]>
                <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
                <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->


        <script language="javascript" type="text/javascript" src="'.tep_href_link("themes/theme6/tab.js").'"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

        <script src="'.HOST_NAME.'themes/theme3/js/main.js"></script>

        <script src="'.HOST_NAME.'jscript/cookiealert.js"></script>
        '.tep_get_google_analytics_code().'

        <script src="'.tep_href_link(PATH_TO_LANGUAGE.$language."/jscript/page.js").'"></script>

        <!--THis timout js is used for timout the error or success message-->
        <script src="'.HOST_NAME.'jscript/error_success_message_timeout.js"></script>
</body>
</html>
');
?>