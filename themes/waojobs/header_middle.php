<?
/*-----------------------SEARCH CODE---------------------------------------------------------*/
$job_search_form=tep_draw_form('search_job', FILENAME_JOB_SEARCH,'','post').tep_draw_hidden_field('action','search');
$key=tep_draw_input_field('keyword','','class="form-control form-control-lg form-lg-theme6" placeholder="Busca por palabras clave"',false);
$locat= LIST_TABLE(COUNTRIES_TABLE,TEXT_LANGUAGE."country_name","priority","name='country' class='form-control form-control-lg form-lg-theme6'","All Location","",DEFAULT_COUNTRY_ID);
$experience_1=experience_drop_down('name="experience" class="form-control form-control-lg form-lg-theme6"', 'Experience', '', $experience);

$button= '<button type="submit" class="btn btn-lg btn-danger-theme6 btn-block px-4"><i class="fa fa-search text-white" aria-hidden="true"></i></button>';
/********************************  SEARCH CODE ENDS********************************************* */

if(strtolower($_SERVER['PHP_SELF'])=="/".PATH_TO_MAIN.FILENAME_INDEX)
{
 define('HEADER_MIDDLE_HTML','<!-- Main jumbotron for a primary marketing message or call to action -->

 <div class="container-fluid d-none d-lg-block">
	<div class="row">
		<div class="col jobseeker-bg">
			<h2><span class="text-white text-shadow">Busco</span> <span class="text-yellow2 text-shadow">Trabajo</span> </h2>
			<p class="text-white para-xl">Cumple tus sueños</p>
			<a href="'.tep_href_link(FILENAME_JOBSEEKER_REGISTER1).'" style="background: #17cbaa !important; " class="btn-no-bg">Regístrate aquí</a>
		</div>
		
		<div class="col employer-bg" style=" background: #17cbaa url(https://cuchumilempleos.com/themes/waojobs/images/recruiter.png) no-repeat center top !important;">
		<h2><span class="text-white text-shadow">Busco</span> <span class="text-yellow text-shadow">Talento</span> </h2>
		<p class="text-white para-xl">Crece tu empresa</p>
		<a href="'.tep_href_link(FILENAME_RECRUITER_LOGIN).'" style="background: #0D134A !important; " class="btn-no-bg2">Publica tu oportunidad</a>
		</div>
	</div>
 </div>

 <!-- next div only show on mobile view -->

 <div class=" d-block d-md-block d-lg-none" ">
	<div class="">
		<div class="col jobseeker-bg">
			<h2><span class="text-white text-shadow">Busco</span> <span class="text-yellow2 text-shadow">Trabajo</span> </h2>
			<p class="text-white para-xl">Cumple tus sueños</p>
			<a href="'.tep_href_link(FILENAME_JOBSEEKER_REGISTER1).'"  style="background: #17cbaa !important; " class="btn-no-bg">Regístrate aquí</a>
		</div>

		<div class="col employer-bg"  style=" background: #17cbaa url(https://cuchumilempleos.com/themes/waojobs/images/recruiter.png) no-repeat center top !important;">
		<h2><span class="text-white text-shadow">Busco</span> <span class="text-yellow text-shadow">Talento</span> </h2>
		<p class="text-white para-xl">Crece tu empresa</p>
		<a href="'.tep_href_link(FILENAME_RECRUITER_LOGIN).'" style="background: #0D134A !important; " class="btn-no-bg2">Publica tu oportunidad</a>
		</div>
	</div>
 </div>


                <div class="container-fluid bg-banner shadow-sm">
				<div class="row">

					<div class="container">
					<div class="col-md-10 m-ml">
						<!-- Job Section -->
                        <div class="row">
                            <div class="col-md-12 mb-3">
								<!--<div class="para-xl">Encuentra tu próxima oportunidad laboral</div>-->
                                <h3 style="color: #2a9dfa !important" class="font-weight-bold theme4-display">Encuentra tu próxima oportunidad laboral</h3>
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
