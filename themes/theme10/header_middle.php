<?
/*-----------------------SEARCH CODE---------------------------------------------------------*/
$job_search_form=tep_draw_form('search_job', FILENAME_JOB_SEARCH,'','post').tep_draw_hidden_field('action','search');
$key=tep_draw_input_field('keyword','','class="form-control form-control-lg theme10-form-control" type="search" placeholder="Enter Keywords"',false);
$locat= LIST_TABLE(COUNTRIES_TABLE,TEXT_LANGUAGE."country_name","priority","name='country' class='form-control form-control-lg  theme10-form-control'","All Locations","",DEFAULT_COUNTRY_ID);
$experience_1=experience_drop_down('name="experience" class="form-control form-control-lg theme10-form-control"', 'Experience', '', $experience);

$button= '<button type="submit" class="btn btn-lg theme10-btn-danger px-5 theme10-btn btn-customs btn-block"><i class="fa fa-search" aria-hidden="true"></i></button>';
/********************************  SEARCH CODE ENDS********************************************* */





if(strtolower($_SERVER['PHP_SELF'])=="/".PATH_TO_MAIN.FILENAME_INDEX)
{
 define('HEADER_MIDDLE_HTML','


 <div id="carouselExampleCaptions" class="carousel slide for-mobile" data-ride="carousel" style="margin:-93px 0 0 0;z-index:-1;">
 <!--<ol class="carousel-indicators">
    <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
    <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
    <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
  </ol>-->
  <div class="carousel-inner theme10-carousel">
    <div class="carousel-item active">
      <img src="themes/theme10/images/slider1.jpg" class="d-block w-100" alt="...">
      <div class="carousel-caption d-none d-md-block">
        <h2 class="display-5">Find the career you deserve</h2>
        <p>Your job search starts and ends with us.</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="themes/theme10/images/slider2.jpg" class="d-block w-100" alt="...">
      <div class="carousel-caption d-none d-md-block">
        <h2 class="display-5">The Easiest Way to Get Your New Job</h2>
        <p>Your job search starts and ends with us.</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="themes/theme10/images/slider3.jpg" class="d-block w-100" alt="...">
      <div class="carousel-caption d-none d-md-block">
        <h2 class="display-5">Find your dream Job</h2>
        <p>Your job search starts and ends with us.</p>
      </div>
    </div>
  </div>
  <!--<a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>-->
</div>




<div class="container-fluid margin-top-minus theme10-margin-top-minus">
<div class="container">
'.$job_search_form.'
<div class="row">
<div class="col-md-8">
<div class="row">
					<div class="col-md-6 mpr-0">'.$key.'</div>
					<div class="col-md-4 mpr-0">'.$locat.' '.$industry_sector.'</div>
					<div class="col-md-2">'.$button.'</div>

					</div>
					</div>
					</form>
				</div>

				</div>
			</div>
			</div>
			</div>');
}
else
{
 define('HEADER_MIDDLE_HTML','');
}
?>