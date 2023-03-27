<?
/*-----------------------SEARCH CODE---------------------------------------------------------*/
$job_search_form=tep_draw_form('search_job', FILENAME_JOB_SEARCH,'','post').tep_draw_hidden_field('action','search');
$all_job_form=tep_draw_form('all_job', FILENAME_JOB_SEARCH,'','post').tep_draw_hidden_field('action','search');
$key=tep_draw_input_field('keyword','','class="form-control form-control-lg form-control-outline" placeholder="Keyword"',false);
$locat= LIST_TABLE(COUNTRIES_TABLE,TEXT_LANGUAGE."country_name","priority","name='country' class='form-control form-control-lg'","All Locations","",DEFAULT_COUNTRY_ID);
$experience_1=experience_drop_down('name="experience" class="form-control form-control-lg form-control-outline"', 'Experience', '', $experience);
$cat_array=tep_get_categories(JOB_CATEGORY_TABLE);
array_unshift($cat_array,array("id"=>0,"text"=>"All Category"));
$industry_sector_1=tep_draw_pull_down_menu('job_category[]', $cat_array, '', 'class="form-control form-control-lg form-control-outline"');

$button= '<button type="submit" class="btn brn-lg theme7-btn-warning btn-block px-4 py-2"> Search </button>';
/********************************  SEARCH CODE ENDS********************************************* */

if(strtolower($_SERVER['PHP_SELF'])=="/".PATH_TO_MAIN.FILENAME_INDEX)
{
 define('HEADER_MIDDLE_HTML','


 <div class="container-fluid home-slider mb-4">
            <div class="container">
                <div class="row">
				<div class="col-md-12 theme7-bg-white mt-4 px-4 pb-4">
				<div class="row pt-4 mobile-padding-zero">
				<div class="col-md-9 pr-4">

				'.$job_search_form.'
				<div class="row">
					<div class="col-md-12 mb-3 mmt"><h1 class="display-6 text-white">Find A Job at India\'s No.1 Job Site</h1></div>
					<div class="col-md-6 mpr-0">'.$key.'</div>
					<div class="col-md-4 mpr-0">'.$industry_sector_1.'</div>
					<div class="col-md-2">'.$button.'</div>
				</div>
				</form>

				<div class="mt-3">
				<a class="badge badge-pill theme7-badge-light mr-2" href="'.tep_href_link(FILENAME_JOB_SEARCH).'">Advanced Search</a>
				<!--<button class="badge badge-pill theme7-badge-light mr-2" type="submit">All Jobs</button>--></form>
				<a class="badge badge-pill theme7-badge-light mr-2" href="'.tep_href_link(FILENAME_JOBSEEKER_COMPANY_PROFILE).'">Jobs by Company</a>
				<a class="badge badge-pill theme7-badge-light mr-2" href="'.tep_href_link(FILENAME_JOB_SEARCH_BY_INDUSTRY).'">Jobs by Category</a>
				<a class="badge badge-pill theme7-badge-light" href="'.tep_href_link(FILENAME_JOB_SEARCH_BY_LOCATION).'">Jobs by Location</a>
				</div>

				</div>

				<div class="col-md-3 pr-2 pr-0 border-left">
					<div class="mt-2 ml-auto">
					<a class="text-white" href="'.tep_href_link(FILENAME_JOBSEEKER_RESUME5).'">
					Upload your CV
					</a>
					<div><a href="'.tep_href_link(FILENAME_JOBSEEKER_REGISTER1).'" class="mt-3 btn theme7-btn-outline-warning btn-lg" role="button">Register with us</a></div>
					</div>
				'.$all_job_form.'
				  </div>
				</div>



				</div>

                </div>
            </div>
</div>



 ');
}
else
{
 define('HEADER_MIDDLE_HTML','');
}
?>
