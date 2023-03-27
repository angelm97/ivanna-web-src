<?
$social_footer_button='';
 if(tep_not_null(MODULE_FACEBOOK_FOOTER_LINK))
 $social_footer_button.='<a href="'.MODULE_FACEBOOK_FOOTER_LINK.'"><img src="'.HOST_NAME.'themes/theme7/images/fb.jpg" alt="Facebook" class="social-icon"></a>';

 if(tep_not_null(MODULE_LINKEDIN_FOOTER_LINK))
 $social_footer_button.='<a href="'.MODULE_LINKEDIN_FOOTER_LINK.'"><img src="'.HOST_NAME.'themes/theme7/images/linkedin.jpg" alt="Linkedin" class="social-icon"></a>';

 if(tep_not_null(MODULE_TWITTER_FOOTER_LINK))
 $social_footer_button.='<a href="'.MODULE_TWITTER_FOOTER_LINK.'"><img src="'.HOST_NAME.'themes/theme7/images/twitter.jpg" alt="Twitter" class="social-icon"></a>';

 if(tep_not_null(MODULE_GOOGLEPLUS_FOOTER_LINK))
 $social_footer_button.='<a href="'.MODULE_GOOGLEPLUS_FOOTER_LINK.'"><img src="'.HOST_NAME.'themes/theme7/images/googleplus.jpg" alt="GooglePlus" class="social-icon"></a>';
//////////////////////
define('FOOTER_HTML','
<div class="container-fluid footer-container theme7-bg-footer border-top mt-4">
    <!-- Footer -->
    <footer class="container py-5">
        <div class="row">
            <div class="col-lg-3 mobile-col-md-3">
                    <div class="mb-3 font-weight-bold text-white">Job Seeker</div>
                    <div class="mb-2">'.(check_login("jobseeker")?'<a href="'.tep_href_link(FILENAME_JOBSEEKER_CONTROL_PANEL).'">Control Panel</a>':'<a href="'.tep_href_link(FILENAME_JOBSEEKER_REGISTER1).'">Register Now</a>').'</div>
                    <div class="mb-2"><a href="'.tep_href_link(FILENAME_JOB_SEARCH).'">Search Jobs</a></div>
                    <div class="mb-2">'.(check_login("jobseeker")?'<a href="'.tep_href_link(FILENAME_LOGOUT).'">Logout</a>':'<a href="'.tep_href_link(FILENAME_JOBSEEKER_LOGIN).'">Login</a>').'</div>
                    <div class="mb-2"><a href="'.tep_href_link(" blog/").'">Blog </a> </div>
					<div class="mb-2"><a href="'.tep_href_link(FILENAME_JOB_ALERT_AGENT).'">Job Alerts</a></div>
			</div>
            <div class="col-lg-3 mobile-col-md-3">
                    <div class="mb-3 font-weight-bold text-white">Employer</div>
                    <div class="mb-2"><a href="'.tep_href_link(FILENAME_RECRUITER_POST_JOB).'">Post a Job</a></div>
                    <div class="mb-2"><a href="'.tep_href_link(FILENAME_RECRUITER_SEARCH_RESUME).'">Search Resume</a></div>
                    <div class="mb-2">'.(check_login("recruiter")?'<a href="'.tep_href_link(FILENAME_LOGOUT).'">Logout</a>':'<a href="'.tep_href_link(FILENAME_RECRUITER_LOGIN).'">Login</a>').'</div>
                    <div class="mb-2">'.(check_login("recruiter")?'<a href="'.tep_href_link(FILENAME_RECRUITER_CONTROL_PANEL).'">Control Panel</a>':'<a href="'.tep_href_link(FILENAME_RECRUITER_REGISTRATION).'">Register Now</a>').'</div>
                    <div class="mb-2"><a href="'.tep_href_link(FILENAME_RECRUITER_SAVE_RESUME).'">Resume Alerts</a></div>
                    <div class="mb-2"><a href="'.tep_href_link(FILENAME_RECRUITER_SEARCH_APPLICANT).'">Applicant Tracking</a></div>

            </div>

            <div class="col-lg-3 mobile-col-md-3 mobile-margin-top">
                    <div class="mb-3 font-weight-bold text-white">Information</div>
                    <div class="mb-2"><a href="'.tep_href_link(FILENAME_ABOUT_US).'">About Us</a></div>
                    <div class="mb-2"><a href="'.tep_href_link(FILENAME_TERMS).'">Terms & Conditions</a></div>
                    <div class="mb-2"><a href="'.tep_href_link(FILENAME_PRIVACY).'">Privacy Policy</a></div>
                    <div class="mb-2"><a href="'.tep_href_link(FILENAME_ARTICLE).'">Resources</a></div>
                    <div class="mb-2"><a href="'.tep_href_link(FILENAME_SITE_MAP).'">Sitemap</a></div>
                    <div class="mb-2"><a href="'.tep_href_link(FILENAME_CONTACT_US).'">Contact Us</a></div>

            </div>

            <div class="col-lg-3 mobile-col-md-3 mobile-margin-top">
                <div class="mb-3 font-weight-bold text-white">Follow Us</div>
                '.$social_footer_button.'
                <a href="'.tep_href_link(FILENAME_INDUSTRY_RSS).'"><img src="'.HOST_NAME.'themes/theme7/images/rss.jpg" alt="rss" class="social-icon"></a>

            </div>
        </div>
    </footer>
</div>
<div class="container-fluid footer-sub-container theme7-bg-subfooter">
    <!-- Footer -->
	<footer class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="py-2">&copy; Copyright 2020 - <a href="'.tep_href_link('').'"> '.SITE_TITLE.' </a></div>
            </div>
        </div>
    </footer>
</div>

<!-- jQuery -->
<script src="'.HOST_NAME.'jscript/jquery-3.5.1.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="'.HOST_NAME.'jscript/bootstrap.bundle.min.js"></script>

<!-- Script to Activate the Carousel --><script>
    $(\'.carousel\').carousel({
    interval: 5000 //changes the speed
    });
</script>
<script language="javascript" type="text/javascript" src="'.tep_href_link("themes/theme7/tab.js").'"></script>

<script src="'.HOST_NAME.'jscript/cookiealert.js"></script>
'.tep_get_google_analytics_code().'

<script src="'.tep_href_link(PATH_TO_LANGUAGE.$language."/jscript/page.js").'"></script>

<!--THis timout js is used for timout the error or success message-->
<script src="'.HOST_NAME.'jscript/error_success_message_timeout.js"></script>

</body>


</html>');

?>