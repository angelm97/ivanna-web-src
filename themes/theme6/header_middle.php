<?
/*-----------------------SEARCH CODE---------------------------------------------------------*/
$job_search_form=tep_draw_form('search_job', FILENAME_JOB_SEARCH,'','post').tep_draw_hidden_field('action','search');
$job_search_form2=tep_draw_form('search_job2', FILENAME_JOB_SEARCH,'','post').tep_draw_hidden_field('action','search');
$key=tep_draw_input_field('keyword','','class="form-control theme6-form-control" placeholder="Enter keywords"',false);
$locat= LIST_TABLE(COUNTRIES_TABLE,TEXT_LANGUAGE."country_name","priority","name='country' class='form-control2'","All Locations","",DEFAULT_COUNTRY_ID);
$cat_array=tep_get_categories(JOB_CATEGORY_TABLE);
array_unshift($cat_array,array("id"=>0,"text"=>"All Category"));
$industry_sector= tep_draw_pull_down_menu('job_category[]', $cat_array, '', 'class="form-control"');
$button= ' <button type="submit" class="btn btn-warning px-4"><i class="fa fa-search" aria-hidden="true"></i></button>';

/********************************  SEARCH CODE ENDS********************************************* */

// if(strtolower($_SERVER['PHP_SELF'])=="/".PATH_TO_MAIN.FILENAME_INDEX)
// {
 define('HEADER_MIDDLE_HTML','
<div class="container-fluid pt-3 pb-2 mb-3 theme6-mobile-mb" style="margin-top: -16px;background-color: #fafafa;border-bottom: 1px solid #eceff1;">
<div class="container">
    <div class="row">
        <div class="col-md-3 float-left mpl-0">
			<a class="navbar-brand" href="'.tep_href_link("").'"><img class="logo" src="'.tep_href_link('img/'.DEFAULT_SITE_LOGO).'" alt="Job Board Logo"></a>
		</div>

		<div class="col-md-6 p-0">
			'.$job_search_form2.'
            <div class="input-group">
                '.$key.'
                <div class="input-group-append">
                '.$button.'
                </div>
            </div>
                </form>
		</div>

			<div class="col-md-3 float-right text-right mobile-float-left theme6-mobile-padding-left">

					<div class="btn-group">
						  <button class="btn btn-outline-secondary dropdown-toggle mr-2" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Job Seeker
						  </button>
						  <div class="dropdown-menu" aria-labelled by="dropdownMenuButton">
							'.(check_login("jobseeker")?'<a class="dropdown-item" href="'.tep_href_link(FILENAME_LOGOUT).'">LOGOUT</a>':'<a class="dropdown-item" href="'.tep_href_link(FILENAME_JOBSEEKER_LOGIN).'">LOGIN</a>').'
							<a class="dropdown-item" href="'.tep_href_link(FILENAME_JOBSEEKER_REGISTER1).'">REGISTER</a>
                            <a class="dropdown-item" href="'.tep_href_link(FILENAME_JOBSEEKER_RESUME1).'">POST RESUME</a>
                            <a class="dropdown-item" href="'.tep_href_link(FILENAME_JOB_SEARCH).'">SEARCH JOB</a>
						  </div>
					</div>

					<div class="btn-group">
						  <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Employer <b class="caret"></b>
						  </button>
						  <div class="dropdown-menu" aria-labelled by="dropdownMenuButton">
							'.(check_login("recruiter")?'<a class="dropdown-item" href="'.tep_href_link(FILENAME_LOGOUT).'">LOGOUT</a>':'<a class="dropdown-item" href="'.tep_href_link(FILENAME_RECRUITER_LOGIN).'">LOGIN</a>').'
                            <a class="dropdown-item" href="'.tep_href_link(FILENAME_RECRUITER_REGISTRATION).'">REGISTER</a>
                            <a class="dropdown-item" href="'.tep_href_link(FILENAME_RECRUITER_POST_JOB).'">POST JOB</a>
                            <a class="dropdown-item" href="'.tep_href_link(FILENAME_RECRUITER_SEARCH_RESUME).'">SEARCH RESUME</a>
						  </div>
					</div>

					<!--<div class="btn-group">
					<a href="'.tep_href_link(FILENAME_RECRUITER_POST_JOB).'" class="btn btn-success"><i class="fa fa-pencil" aria-hidden="true"></i> Ppost job</a>
					</div>-->



		</div>
    </div>
</div>
</div>


 ');

?>
