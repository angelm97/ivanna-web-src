<?
class Pagination_class1{
	var $result;
	var $anchors;
	var $total;
	var $show_view;
	function __construct($qry,$starting,$recpage,$keyword,$location,$word1,$country,$state,$job_category,$experience,$job_post_day,$search_zip_code,$zip_code,$radius,$map_view,$job_skill='')
	{
		$rst		=	tep_db_query($qry) ;//or die(mysql_error());
		$numrows	=	tep_db_num_rows($rst);
		$qry		 .=	" limit $starting, $recpage";
		$this->result	=	tep_db_query($qry);// or die(mysql_error());
		$next		=	$starting+$recpage;
		$var		=	((intval($numrows/$recpage))-1)*$recpage;
		$page_showing	=	intval($starting/$recpage)+1;
		$total_page	=	ceil($numrows/$recpage);
		$map_view = $map_view;
		if($numrows % $recpage != 0){
			$last = ((intval($numrows/$recpage)))*$recpage;
		}else{
			$last = ((intval($numrows/$recpage))-1)*$recpage;
		}
		$previous = $starting-$recpage;
		$anc = "<ul id='pagination-flickr'>";
		if($previous < 0){
			$anc .= "<li class='previous-off'>".tep_db_output(INFO_TEXT_PAGE_FIRST)."</li>";
			$anc .= "<li class='previous-off'>".tep_db_output(INFO_TEXT_PAGE_PREVIOUS)."</li>";
		}else{
			$anc .= "<li class='next'><a href='javascript:jobsearch_pagination(0,\"".$keyword."\",\"".$location."\",\"".$word1."\",\"".$country."\",\"".$state."\",\"".$job_category[0]."\",\"".$experience."\",\"".$job_post_day."\",\"".$search_zip_code."\",\"".$zip_code."\",\"".$radius."\",\"".HOST_NAME."\",\"".$map_view."\",\"".$job_skill."\");'>".tep_db_output(INFO_TEXT_PAGE_FIRST)."</a></li>";
			$anc .= "<li class='next'><a href='javascript:jobsearch_pagination($previous,\"".$keyword."\",\"".$location."\",\"".$word1."\",\"".$country."\",\"".$state."\",\"".$job_category[0]."\",\"".$experience."\",\"".$job_post_day."\",\"".$search_zip_code."\",\"".$zip_code."\",\"".$radius."\",\"".HOST_NAME."\",\"".$map_view."\",\"".$job_skill."\");'>".tep_db_output(INFO_TEXT_PAGE_PREVIOUS)."</a></li>";
		}

		################If you dont want the numbers just comment this block###############
		$norepeat = 4;//no of pages showing in the left and right side of the current page in the anchors
		$j = 1;
		$anch = "";
		for($i=$page_showing; $i>1; $i--){
			$fpreviousPage = $i-1;
			$page = ceil($fpreviousPage*$recpage)-$recpage;
			$anch = "<li><a href='javascript:jobsearch_pagination($page,\"".$keyword."\",\"".$location."\",\"".$word1."\",\"".$country."\",\"".$state."\",\"".$job_category[0]."\",\"".$experience."\",\"".$job_post_day."\",\"".$search_zip_code."\",\"".$zip_code."\",\"".$radius."\",\"".HOST_NAME."\",\"".$map_view."\",\"".$job_skill."\");'>$fpreviousPage </a></li>".$anch;
			if($j == $norepeat) break;
			$j++;
		}
		$anc .= $anch;
		$anc .= "<li class='active'>".$page_showing."</li>";
		$j = 1;
		for($i=$page_showing; $i<$total_page; $i++){
			$fnextPage = $i+1;
			$page = ceil($fnextPage*$recpage)-$recpage;
			$anc .= "<li><a href='javascript:jobsearch_pagination($page,\"".$keyword."\",\"".$location."\",\"".$word1."\",\"".$country."\",\"".$state."\",\"".$job_category[0]."\",\"".$experience."\",\"".$job_post_day."\",\"".$search_zip_code."\",\"".$zip_code."\",\"".$radius."\",\"".HOST_NAME."\",\"".$map_view."\",\"".$job_skill."\");'>$fnextPage</a></li>";
			if($j==$norepeat) break;
			$j++;
		}
		############################################################
		if($next >= $numrows){
			$anc .= "<li class='previous-off'>".tep_db_output(INFO_TEXT_PAGE_NEXT)."</li>";
			$anc .= "<li class='previous-off'>".tep_db_output(INFO_TEXT_PAGE_LAST)."</li>";
		}else{
			$anc .= "<li class='next'><a href='javascript:jobsearch_pagination($next,\"".$keyword."\",\"".$location."\",\"".$word1."\",\"".$country."\",\"".$state."\",\"".$job_category[0]."\",\"".$experience."\",\"".$job_post_day."\",\"".$search_zip_code."\",\"".$zip_code."\",\"".$radius."\",\"".HOST_NAME."\",\"".$map_view."\",\"".$job_skill."\");'>".tep_db_output(INFO_TEXT_PAGE_NEXT)."</a></li>";
			$anc .= "<li class='next'><a href='javascript:jobsearch_pagination($last,\"".$keyword."\",\"".$location."\",\"".$word1."\",\"".$country."\",\"".$state."\",\"".$job_category[0]."\",\"".$experience."\",\"".$job_post_day."\",\"".$search_zip_code."\",\"".$zip_code."\",\"".$radius."\",\"".HOST_NAME."\",\"".$map_view."\",\"".$job_skill."\");'>".tep_db_output(INFO_TEXT_PAGE_LAST)."</a></li>";
		}
			$anc .= "</ul>";
		$this->anchors = $anc;

		$this->total = "Page : $page_showing  of  $total_page";
		if($map_view==1)
		$this->show_view = "<a href='javascript:jobsearch_pagination(".($starting).",\"".$keyword."\",\"".$location."\",\"".$word1."\",\"".$country."\",\"".$state."\",\"".$job_category[0]."\",\"".$experience."\",\"".$job_post_day."\",\"".$search_zip_code."\",\"".$zip_code."\",\"".$radius."\",\"".HOST_NAME."\",0,\"".$job_skill."\");'>Grid View</a>";
		else
		$this->show_view = "<a href='javascript:jobsearch_pagination(".($starting).",\"".$keyword."\",\"".$location."\",\"".$word1."\",\"".$country."\",\"".$state."\",\"".$job_category[0]."\",\"".$experience."\",\"".$job_post_day."\",\"".$search_zip_code."\",\"".$zip_code."\",\"".$radius."\",\"".HOST_NAME."\",1,\"".$job_skill."\");'>Map View</a>";
	}
	}
?>