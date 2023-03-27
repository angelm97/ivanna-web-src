<?
/*-----------------------SEARCH CODE---------------------------------------------------------*/
$job_search_form=tep_draw_form('search_job', FILENAME_JOB_SEARCH,'','post').tep_draw_hidden_field('action','search');
$key=tep_draw_input_field('keyword','','class="form-control form-control-lg mobile-border padding-right-none"  placeholder="'.INFO_KEYWORD.'"',false);
$locat= LIST_TABLE(COUNTRIES_TABLE,TEXT_LANGUAGE."country_name","priority","name='country' class='form-control form-control-lg border-left mobile-border padding-right-none'",ALL_LOCATION,"",DEFAULT_COUNTRY_ID);
$experience_1=experience_drop_down('name="experience" class="form-control form-control-lg mobile-border padding-right-none"', INFO_EXPERIENCE, '', $experience);
$cat_array=tep_get_categories(JOB_CATEGORY_TABLE);
array_unshift($cat_array,array("id"=>0,"text"=>"All Category"));
$industry_sector= tep_draw_pull_down_menu('job_category[]', $cat_array, '', 'class="form-control form-control-lg border-left mobile-border padding-right-none"');

$button= '<button type="submit" class="btn btn-theme1 btn-lg btn-block"><span class="glyphicon glyphicon-search"></span> '.SEARCH_BUTTON.' </button>';
/********************************  SEARCH CODE ENDS********************************************* */

//////////////////// SLIDER CODING STARTS ///////////////////
$now=date("Y-m-d H:i:s");
$queryslider = "select s.id,s.slider_title,s.slider_description,s.slider_image,s.slider_link from ".SLIDER_TABLE." as s  where s.inserted <='$now' order by rand() limit 0,3";
//echo "<br>$queryslider";//exit;
$result_slider1=tep_db_query($queryslider);
$x=tep_db_num_rows($result_slider1);
$count=1;
$slider1='';
while($sliders = tep_db_fetch_array($result_slider1))
{
 $sliderid=$sliders['id'];
//$slider_link=$sliders['slider_link'];
$class=($count=='1'?'carousel-item active':'carousel-item');
  $slider_image='';

$slider1.='<div class="'.$class.'">
	<img src="'.PATH_TO_SLIDER_IMAGE.$sliders["slider_image"].'" class="d-block w-100" alt="...">
      <div class="carousel-caption d-none d-md-block">
      <h5>'.$sliders['slider_title'].'</h5>
      </div>
</div>
';
$count++;
}

//////////////////// SLIDER CODING ENDS /////////////////////////////

if(strtolower($_SERVER['PHP_SELF'])=="/".PATH_TO_MAIN.FILENAME_INDEX)
{
 define('HEADER_MIDDLE_HTML','

<div class="container-fluid slider-bg-theme1 pt-5 pb-5 mb-5">
<div class="container">
<div class="row">
<div class="col-md-12 mb-3">
<h1 class="slider-title-theme1 mb-4 mt-3 mobile-text">Search your dream jobs</h1>
'.$job_search_form.'
<div class="row">
<div class="col-md-4 mpr-0">'.$key.'</div>
<div class="col-md-3 mpr-0">'.$locat.'</div>
<div class="col-md-3 mpr-0">'.$industry_sector.'</div>
<div class="col-md-2">'.$button.'</div>
</div>
</div>
</div>
</div>
</div>
<!--<div id="carouselExampleCaptions" class="carousel slide for-mobile" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
    <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
    <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
  </ol>
  <div class="carousel-inner">
'.$slider1.'
  </div>
  <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>


<div class="search-block-home">
<div class="container">
<div class="row">
	<div class="col-md-9">
	'.$job_search_form.'
	<div class="input-group mb-3">
	  '.$key.' '.$locat.' '.$industry_sector.'
	  <div class="input-group-append">
		'.$button.'
	  </div>
	</div>
	</form>
</div>
</div>
</div>
</div>-->

<!-- End Sarch Block -->

 ');
}
else
{
 define('HEADER_MIDDLE_HTML','');
}
?>
