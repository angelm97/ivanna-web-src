<?

$social_footer_button='';
if(tep_not_null(MODULE_FACEBOOK_FOOTER_LINK)) $social_footer_button.='
<a href="'.MODULE_FACEBOOK_FOOTER_LINK.'"><i id="social-fb" class="fa fa-facebook-square fa-3x social"></i></a>';
if(tep_not_null(MODULE_LINKEDIN_FOOTER_LINK)) $social_footer_button.='
<a href="'.MODULE_LINKEDIN_FOOTER_LINK.'"><i id="social-ln" class="fa fa-linkedin-square fa-3x social"></i></a>';
if(tep_not_null(MODULE_TWITTER_FOOTER_LINK)) $social_footer_button.='
<a href="'.MODULE_TWITTER_FOOTER_LINK.'"><i id="social-tw" class="fa fa-twitter-square fa-3x social"></i></a>';
if(tep_not_null(MODULE_GOOGLEPLUS_FOOTER_LINK)) $social_footer_button.='
<a href="'.MODULE_GOOGLEPLUS_FOOTER_LINK.'"><i id="social-gp" class="fa fa-google-plus-square fa-3x social"></i></a>';


///////////****************************************************///////////

define('FOOTER_HTML','
    <div class="container-fluid border-top mt-4 pt-5 pb-3 bg-gray">
	<div class="container text-left">
    <footer>
        <div class="row">
            <div class="col-md-3 for-mobile ">
                <strong>
                    <div>About</div>
                </strong>
                <p>We the fastest growing recruitment and career advancement resources website in the Job sector for employers, recruiters, freelancers and job seekers.</p>
                <button class="btn btn-sm btn-lg btn-info2" onclick="location.href=\''.tep_href_link(FILENAME_JOBSEEKER_LOGIN).'\'" type="submit">GET STARTED</button>
            </div>
            <div class="col-md-3 mobile-col-md-3">
                <strong>
                    <p>Job Seeker</p>
                </strong>
                <p>'
                    .(check_login("jobseeker")?'<a href="'.tep_href_link(FILENAME_JOBSEEKER_CONTROL_PANEL).'">Control Panel</a>':
                    '<a href="'.tep_href_link(FILENAME_JOBSEEKER_REGISTER1).'">Register Now</a>').'</p>

                <p><a href="'.tep_href_link(FILENAME_JOB_SEARCH).'">Search Jobs</a></p>

                <p>'
                    .(check_login("jobseeker")?'<a href="'.tep_href_link(FILENAME_LOGOUT).'">Logout</a>':
                    '<a href="'.tep_href_link(FILENAME_JOBSEEKER_LOGIN).'">Login</a>').'
                    <p> '.(check_login("jobseeker")?'<a href="'.tep_href_link(FILENAME_JOBSEEKER_LIST_OF_APPLICATIONS).'">View Applications</a>':
                        '<a href="'.tep_href_link(FILENAME_JOBSEEKER_LOGIN).'">View Applications</a>').'</p>
                    <p> '.(check_login("jobseeker")?'<a href="'.tep_href_link(FILENAME_JOB_ALERT_AGENT).'">Job Alerts</a>':
                        '<a href="'.tep_href_link(FILENAME_JOBSEEKER_LOGIN).'">Job Alerts</a>').'</p>
            </div>
            <div class="col-md-3 mobile-col-md-3"> <strong>
                    <p>Employer</p>
                </strong>
                <p><a href="'.tep_href_link(FILENAME_RECRUITER_POST_JOB).'">Post a Job</a></p>
                <p><a href="'.tep_href_link(FILENAME_RECRUITER_SEARCH_RESUME).'">Search Resume</a></p>
                <p>'.(check_login("recruiter")?'<a href="'.tep_href_link(FILENAME_LOGOUT).'">Logout</a>':
                    '<a href="'.tep_href_link(FILENAME_RECRUITER_LOGIN).'">Login</a>').'</p>
                <p>'.(check_login("recruiter")?'<a href="'.tep_href_link(FILENAME_RECRUITER_CONTROL_PANEL).'">Control Panel</a>':
                    '<a href="'.tep_href_link(FILENAME_RECRUITER_REGISTRATION).'">Register Now</a>').'</p>
                <p>'.(check_login("recruiter")?'<a href="'.tep_href_link(FILENAME_RECRUITER_SAVE_RESUME).'">Resume Alerts</a>':
                    '<a href="'.tep_href_link(FILENAME_RECRUITER_LOGIN).'">Resume Alerts</a>').'</p>
            </div>
            <div class="col-md-3 mobile-col-md-3 mobile-margin-top"> <strong>
                    <p>Information</p>
                </strong>
                <p><a href="'.tep_href_link(FILENAME_ABOUT_US).'">About Us</a></p>
                <p><a href="'.tep_href_link(FILENAME_TERMS).'">Terms & Conditions</a></p>
                <p><a href="'.tep_href_link(FILENAME_PRIVACY).'">Privacy Policy</a></p>
                <p><a href="'.tep_href_link(FILENAME_ARTICLE).'">Resources</a></p>
                <p><a href="'.tep_href_link(FILENAME_SITE_MAP).'">Sitemap</a></p>
                <p><a href="'.tep_href_link(FILENAME_CONTACT_US).'">Contact Us</a></p>
            </div>
        </div>
    </footer>
</div>
</div>

   <div class="container-fluid py-2 border-top bg-gray">
	<div class="container text-left">
        <div class="row">
            <div class="col-md-9 float-left text-left mt-3">
                <span>&copy; '.date("Y").'<a href="'.tep_href_link('').'"> '.SITE_TITLE.' </a></span>
            </div>
            <div class="col-md-3 float-right text-right">'.$social_footer_button.'
                <a href="mailto:"><i id="social-em" class="fa fa-envelope-square fa-3x social"></i></a>
            </div>
        </div>


		</div>
    </div>

	<!-- /container -->
    <!-- jQuery -->
    <script src="'.HOST_NAME.'jscript/jquery-3.5.1.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="'.HOST_NAME.'jscript/bootstrap.bundle.min.js"></script>
    <script src="'.HOST_NAME.'jscript/cookiealert.js"></script>
    '.tep_get_google_analytics_code().'
    <script src="'.tep_href_link(PATH_TO_LANGUAGE.$language."/jscript/page.js").'"></script>

    <!--THis timout js is used for timout the error or success message-->
    <script src="'.HOST_NAME.'jscript/error_success_message_timeout.js"></script>
    </body>
</html>');
?>