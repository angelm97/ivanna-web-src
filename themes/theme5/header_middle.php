<?
/*-----------------------SEARCH CODE---------------------------------------------------------*/
$job_search_form=tep_draw_form('search_job', FILENAME_JOB_SEARCH,'','post').tep_draw_hidden_field('action','search');
$key=tep_draw_input_field('keyword','','class="form-control form-control-lg form-lg-theme6" placeholder="Keywords"',false);
$locat= LIST_TABLE(COUNTRIES_TABLE,TEXT_LANGUAGE."country_name","priority","name='country' class='form-control form-control-lg form-lg-theme6'","All Locations","",DEFAULT_COUNTRY_ID);
$experience_1=experience_drop_down('name="experience" class="form-control form-control-lg form-lg-theme6"', 'Experience', '', $experience);

$button= '<button type="submit" class="btn btn-lg btn-danger-theme6 btn-block px-4"><i class="fa fa-search text-white" aria-hidden="true"></i></button>';
/********************************  SEARCH CODE ENDS********************************************* */

if(strtolower($_SERVER['PHP_SELF'])=="/".PATH_TO_MAIN.FILENAME_INDEX)
{
 define('HEADER_MIDDLE_HTML','<!-- Main jumbotron for a primary marketing message or call to action -->

                <div class="container-fluid bg-banner">
				<div class="row">

					<div class="container">
					<div class="col-md-8">
						<!-- Job Section -->
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <h class="font-weight-bold display-4 theme4-display">Search From 25,000 Jobs!</h3>
                            </div>

                        </div>
					'.$job_search_form.'
					<div class="row">
					<div class="col-md-8 mpr-0">'.$key.' </div>
					<!--<div class="col-md-5 mpr-0">'.$locat.' </div>-->
					<div class="col-md-2">'.$button.'</div>


					</form>
					</div>
					</div>
					</div>
                    <!-- /.row -->

            </div>
        </div>
');
}
else
{
 define('HEADER_MIDDLE_HTML','');
}
?>
