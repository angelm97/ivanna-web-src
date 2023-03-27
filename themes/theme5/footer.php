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
        <div class="row">

            <div class="col-lg-4 mobile-col-md-3">

                    <div class="mb-2">JOB SEEKER</div>

                <p>'.(check_login("jobseeker")?'<a href="'.tep_href_link(FILENAME_JOBSEEKER_CONTROL_PANEL).'">Dashboard</a>':'<a href="'.tep_href_link(FILENAME_JOBSEEKER_REGISTER1).'">Register Now</a>').'</p>
                <p><a href="'.tep_href_link(FILENAME_JOB_SEARCH).'">Search Jobs</a></p>
                <p><a href="'.tep_href_link(FILENAME_JOBSEEKER_RESUME1).'">Post Resume</a></p>
				<p>'.(check_login("jobseeker")?'<a href="'.tep_href_link(FILENAME_JOB_ALERT_AGENT).'">Job Alerts</a>':'<a href="'.tep_href_link(FILENAME_JOBSEEKER_LOGIN).'">Job Alerts</a>').'</p>
                 <p>'.(check_login("jobseeker")?'<a href="'.tep_href_link(FILENAME_JOBSEEKER_LIST_OF_APPLICATIONS).'">View Applications</a>':'<a href="'.tep_href_link(FILENAME_JOBSEEKER_LOGIN).'">View Applications</a>').'</p>
                <p>'.(check_login("jobseeker")?'<a href="'.tep_href_link(FILENAME_LOGOUT).'">Logout</a>':'<a href="'.tep_href_link(FILENAME_JOBSEEKER_LOGIN).'">Login</a>').'
            </div>

            <div class="col-lg-4 mobile-col-md-3">

                    <div class="mb-2">EMPLOYER</div>

                <p>'.(check_login("recruiter")?'<a href="'.tep_href_link(FILENAME_RECRUITER_CONTROL_PANEL).'">Dashboard</a>':'<a href="'.tep_href_link(FILENAME_RECRUITER_REGISTRATION).'">Register Now</a>').'</p>
                <p><a href="'.tep_href_link(FILENAME_RECRUITER_POST_JOB).'">Post a Job</a></p>
                <p><a href="'.tep_href_link(FILENAME_RECRUITER_SEARCH_RESUME).'">Find the Right Talent</a></p>
                <p><a href="'.tep_href_link(FILENAME_RECRUITER_SAVE_RESUME).'">Resume Alerts</a></p>
                <p><a href="'.tep_href_link(FILENAME_RECRUITER_REGISTRATION).'">Start Your Business</a></p>
                <p>'.(check_login("recruiter")?'<a href="'.tep_href_link(FILENAME_LOGOUT).'">Logout</a>':'<a href="'.tep_href_link(FILENAME_RECRUITER_LOGIN).'">Login</a>').'</p>
            </div>

            <div class="col-lg-4 mobile-col-md-3 mobile-margin-top">

                    <div class="mb-2">INFORMATION</div>

                <p><a href="'.tep_href_link(FILENAME_ABOUT_US).'">About Us</a></p>
                <p><a href="'.tep_href_link(FILENAME_TERMS).'">Terms & Conditions</a></p>
                <p><a href="'.tep_href_link(FILENAME_PRIVACY).'">Privacy Policy</a></p>
                <p><a href="'.tep_href_link(FILENAME_ARTICLE).'">Resources</a></p>
                <p><a href="'.tep_href_link(FILENAME_SITE_MAP).'">Sitemap</a></p>
                <p><a href="'.tep_href_link(FILENAME_CONTACT_US).'">Contact Us</a></p>
            </div>
        </div>        </footer>    </div>		<div class="container-fluid footer-vg-theme5 pt-4">			<div class="container text-center">		        <div class="row">            <div class="col-md-12">                                    <div>Follow Us</div>                    '.$social_footer_button.' <a href="mailto:info@ejobsitesoftware.com"><i id="social-em" class="fa fa2 fa-envelope-square fa-3x social"></i></a> <a href="'.tep_href_link(FILENAME_INDUSTRY_RSS).'"><i id="social-em" class="fa fa2 fa-rss-square fa-3x social"></i></a>                            </div>            <div class="col-md-12">                                    <p class="copyright">&copy; <a href="'.tep_href_link('').'"> '.SITE_TITLE.' </a></p>                            </div>        </div>		</div>	</div>
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
        <script src="'.HOST_NAME.'jscript/cookiealert.js"></script>
        '.tep_get_google_analytics_code().'

        <script src="'.tep_href_link(PATH_TO_LANGUAGE.$language."/jscript/page.js").'"></script>

        <!--THis timout js is used for timout the error or success message-->
        <script src="'.HOST_NAME.'jscript/error_success_message_timeout.js"></script>


</body>
</html>');

?>