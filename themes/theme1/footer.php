<?
$social_footer_button='';
 if(tep_not_null(MODULE_FACEBOOK_FOOTER_LINK))
 $social_footer_button.='<li>
                        <a href="'.MODULE_FACEBOOK_FOOTER_LINK.'
                        " class="icoFacebook" title="Facebook"><i class="fa fa-facebook"></i>
                        </a>
                        </li>';

 if(tep_not_null(MODULE_LINKEDIN_FOOTER_LINK))
 $social_footer_button.='<li>
                        <a href="'.MODULE_LINKEDIN_FOOTER_LINK.'
                        " class="icoLinkedin" title="Linkedin"><i class="fa fa-linkedin"></i>
                        </a>
                        </li>';

 if(tep_not_null(MODULE_TWITTER_FOOTER_LINK))
 $social_footer_button.='<li>
                        <a href="'.MODULE_TWITTER_FOOTER_LINK.'
                        " class="icoTwitter" title="Twitter"><i class="fa fa-twitter"></i>
                        </a>
                        </li>';

 if(tep_not_null(MODULE_GOOGLEPLUS_FOOTER_LINK))
 $social_footer_button.='<li>
                        <a href="'.MODULE_GOOGLEPLUS_FOOTER_LINK.'
                        " class="icoGoogle-plus" title="Google-plus"><i class="fa fa-google-plus"></i>
                        </a>
                        </li>';


define('FOOTER_HTML',
    '<div class="container-fluid white-bg dark-bg-theme1 border-top border-bottom mt-5 py-3">
<div class="container text-left">
	<div class="row py-4">
		<div class="col-md-3 mobile-col-md-3">
            <img src="'.tep_href_link('img/'.DEFAULT_SITE_LOGO).'" alt="Logo" class="footer-logo">
            <p class="copyright">&copy; '.date("Y").'<a href="'.tep_href_link('').'"> '.SITE_TITLE.' </a></p>
			
			<ul class="social-network social-circle">
                    '.$social_footer_button.'
                    <li><a href="'.tep_href_link(FILENAME_INDUSTRY_RSS).'" class="icoRss" title="Rss"><i class="fa fa-rss"></i></a></li>
            </ul>
        </div>

		<div class="col-md-3 mobile-col-md-3">
        <p><strong>'.JOB_SEEKER.'</strong></p>
        <div>
                '.(check_login("jobseeker")?'<a href="'.tep_href_link(FILENAME_JOBSEEKER_CONTROL_PANEL).'">'.INFO_TEXT_MENU_CONTROL_PANEL.'</a>':'<a href="'.tep_href_link(FILENAME_JOBSEEKER_REGISTER1).'">'.INFO_TEXT_MENU_REGISTER_NOW.'</a>').'
        </div>

            <div>
                <a href="'.tep_href_link(FILENAME_JOB_SEARCH).'">'.INFO_TEXT_MENU_SEARCH_JOBS.'</a>
            </div>

            <div>
                '.(check_login("jobseeker")?'<a href="'.tep_href_link(FILENAME_LOGOUT).'">'.INFO_TEXT_MENU_LOGOUT.'</a>':'<a href="'.tep_href_link(FILENAME_JOBSEEKER_LOGIN).'">'.INFO_TEXT_MENU_LOGIN.'</a>').'
            </div>

            <div>
                '.(check_login("jobseeker")?'<a href="'.tep_href_link(FILENAME_JOBSEEKER_LIST_OF_APPLICATIONS).'">'.INFO_TEXT_MENU_VIEW_APPLICATIONS.'</a>':'<a href="'.tep_href_link(FILENAME_JOBSEEKER_LOGIN).'">'.INFO_TEXT_MENU_VIEW_APPLICATIONS.'</a>').'
            </div>

            <div>
                '.(check_login("jobseeker")?'<a href="'.tep_href_link(FILENAME_JOB_ALERT_AGENT).'">'.JOB_ALERTS.'</a>':'<a href="'.tep_href_link(FILENAME_JOBSEEKER_LOGIN).'">'.JOB_ALERTS.'</a>').'
            </div>


            <div>
            <a href="'.tep_href_link(FILENAME_JOBSEEKER_RESUME1).'">'.INFO_TEXT_MENU_POST_RESUME.'</a>
            </div>

        </div>

        <div class="col-md-3 mobile-col-md-3">

            <p>
            <strong>'.EMPLOYER.'</strong>
            </p>

            <div>
            <a href="'.tep_href_link(FILENAME_RECRUITER_POST_JOB).'">'.INFO_POST_JOB.'</a>
            </div>

            <div>
            <a href="'.tep_href_link(FILENAME_RECRUITER_SEARCH_RESUME).'">'.INFO_TEXT_MENU_SEARCH_RESUME.'</a>
            </div>

            <div>'.(check_login("recruiter")?'<a href="'.tep_href_link(FILENAME_LOGOUT).'">'.INFO_TEXT_MENU_LOGOUT.'</a>':'<a href="'.tep_href_link(FILENAME_RECRUITER_LOGIN).'">'.INFO_TEXT_MENU_LOGIN.'</a>').'
            </div>

            <div>'.(check_login("recruiter")?'<a href="'.tep_href_link(FILENAME_RECRUITER_CONTROL_PANEL).'">'.INFO_TEXT_MENU_CONTROL_PANEL.'</a>':'<a href="'.tep_href_link(FILENAME_RECRUITER_REGISTRATION).'">'.INFO_TEXT_MENU_REGISTER_NOW.'</a>').'
            </div>

            <div>'.(check_login("recruiter")?'<a href="'.tep_href_link(FILENAME_RECRUITER_SAVE_RESUME).'">'.RESUME_ALERTS.'</a>':'<a href="'.tep_href_link(FILENAME_RECRUITER_LOGIN).'">'.RESUME_ALERTS.'</a>').'
            </div>

            <div>'.(check_login("recruiter")?'<a href="'.tep_href_link(FILENAME_RECRUITER_SEARCH_APPLICANT).'">'.INFO_TEXT_MENU_APP_TRACK.'</a>':'<a href="'.tep_href_link(FILENAME_RECRUITER_LOGIN).'">'.INFO_TEXT_MENU_APP_TRACK.'</a>').'
            </div>

        </div>

        <div class="col-md-3 mobile-col-md-3 mobile-margin-top">
            <p>
            <strong>'.INFORMATION.'</strong>
            </p>
            <div>
                <a href="'.tep_href_link(FILENAME_ABOUT_US).'">'.INFO_TEXT_F_ABOUT_US.'</a>
            </div>

            <div>
                <a href="'.tep_href_link(FILENAME_TERMS).'">'.INFO_TEXT_F_TERMS.'</a>
            </div>

            <div>
                <a href="'.tep_href_link(FILENAME_PRIVACY).'">'.INFO_TEXT_F_PRIVACY.'</a>
            </div>

            <div>
                <a href="'.tep_href_link(FILENAME_ARTICLE).'">'.INFO_TEXT_F_ARTICLE.'</a>
            </div>

            <div>
                <a href="'.tep_href_link(FILENAME_SITE_MAP).'">'.INFO_TEXT_F_SITE_MAP.'</a>
            </div>

            <div>
                <a href="'.tep_href_link(FILENAME_CONTACT_US).'">'.INFO_TEXT_F_CONTACT.'</a>
            </div>

        </div>

        
	</div>
	

</div>
</div>


    <script src="'.HOST_NAME.'jscript/jquery-3.5.1.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="'.HOST_NAME.'jscript/bootstrap.bundle.min.js"></script>

    <!--THis page.js is used for ajax or jquery delete operation-->
    <script src="'.tep_href_link(PATH_TO_LANGUAGE.$language."/jscript/page.js").'"></script>

    <!--THis timout js is used for timout the error or success message-->
    <script src="'.HOST_NAME.'jscript/error_success_message_timeout.js"></script>

    <script src="'.HOST_NAME.'jscript/cookiealert.js"></script>
    '.tep_get_google_analytics_code().'

</body>

</html>'
);

?>