<?
/*-----------------------SEARCH CODE---------------------------------------------------------*/
$job_search_form=tep_draw_form('search_job', FILENAME_JOB_SEARCH,'','post').tep_draw_hidden_field('action','search');
$key=tep_draw_input_field('keyword','','class="form-control form-control-lg theme9-form-size form-control-outline" placeholder="Keywords"',false);
$locat= LIST_TABLE(COUNTRIES_TABLE,TEXT_LANGUAGE."country_name","priority","name='country' class='form-control form-control-lg theme9-form-size form-control-outline'","All Locations","",DEFAULT_COUNTRY_ID);
//$experience_1=experience_drop_down('name="experience" class="form-control"', 'Experience', '', $experience);
$cat_array=tep_get_categories(JOB_CATEGORY_TABLE);
array_unshift($cat_array,array("id"=>0,"text"=>"All Category"));
$industry_sector= tep_draw_pull_down_menu('job_category[]', $cat_array, '', 'class="form-control form-control-lg theme9-form-size form-control-outline"');
$button= '<button type="submit" class="btn brn-lg theme8-btn-warning btn-block">Find</button>';
/********************************  SEARCH CODE ENDS********************************************* */

if(strtolower($_SERVER['PHP_SELF'])=="/".PATH_TO_MAIN.FILENAME_INDEX)
{
 define('HEADER_MIDDLE_HTML','

<div class="container-fluid home-banner">
            <div class="container text-center">
                <div class="row">
				<div class="col-md-12">
                    <div class="col-md-12 mx-auto">
                        <h2 class="mobile-heading-size pb-3 text-white">Start your job search here.</h2>
                        '.$job_search_form.'
						<div class="row mb-3">
							<div class="col-md-4 mpr-0">'.$key.'</div>
							<div class="col-md-3 mpr-0">'.$locat.'</div>
							<div class="col-md-3 mpr-0">'.$industry_sector.'</div>
							<div class="col-md-2">'.$button.'</div>
						</div>
					</form>
					<a href="'.tep_href_link(FILENAME_JOB_SEARCH).'" class="text-white">Advanced Search</a>
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
