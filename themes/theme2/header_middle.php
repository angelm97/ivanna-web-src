<?
/*-----------------------SEARCH CODE---------------------------------------------------------*/
$job_search_form=tep_draw_form('search_job', FILENAME_JOB_SEARCH,'','post').tep_draw_hidden_field('action','search');
$key=tep_draw_input_field('keyword','','class="form-control form-control-lg" placeholder="Enter keywords"',false);
$locat= LIST_TABLE(COUNTRIES_TABLE,TEXT_LANGUAGE."country_name","priority","name='country' class='form-control form-control-lg'","All Locations","",DEFAULT_COUNTRY_ID);
$experience_1=experience_drop_down('name="experience" class="form-control form-control-lg"', 'Experience', '', $experience);

$button= '<button class="btn theme10-btn-success btn-block px-4 y-padding-2" type="submit" id="button-addon2"><i class="fa fa-search" aria-hidden="true" style="font-size:20px;"></i></button>';
/********************************  SEARCH CODE ENDS********************************************* */

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$jobs_query = tep_db_query("select distinct job_id from " . JOB_TABLE );
$no_of_jobs= tep_db_num_rows($jobs_query);

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if(strtolower($_SERVER['PHP_SELF'])=="/".PATH_TO_MAIN.FILENAME_INDEX)
{
 define('HEADER_MIDDLE_HTML','
<div class="header">

	  <div class="overlay"></div>


      <div class="container">
        <div class="d-flex h-100 text-center align-items-center pt-4 mobile-padding-top">
          <div class="w-100 text-white pt-5 mobile-padding-top-zero">
            <h1 class="display-5 text-uppercase font-weight-bold mb-3 mobile-font-24px">LOOKING FOR A JOB?</h1>
				<div class="col-md-8 mx-auto">
				<!-- Job Section -->
                    '.$job_search_form.'

				<div class="row">
				<div class="col-md-6 mpr-0">'.$key.'</div>
				<div class="col-md-4 mpr-0">'.$locat.'</div>
				<div class="col-md-2">'.$button.'</div>
				</div>


				<div>

				  <div>

				  </div>
				</div>
            </form>
            <!-- /.row -->
			</div>


			<div class="col-md-8 mx-auto for-mobile">
			<div class="row mt-3">
			<div class="col-md-6 float-right text-right">
			<p class="lead mb-0  badge badge-info mobile-float-left">We have '.$no_of_jobs.' job offers for you!</p>
			</div>
			<div class="col-md-6 float-left text-left">
			<p class="lead mb-0  badge badge-info mobile-float-left">Or browse job offers by <a class="text-white" href="'.tep_href_link(FILENAME_JOB_SEARCH_BY_INDUSTRY).'">Category</a></p>
			</div>
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
 define('HEADER_MIDDLE_HTML','
    ');
}
?>
