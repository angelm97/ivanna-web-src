<?php
/**********************************************************
**********# Name          : Shambhu Prasad Patnaik  #**********
**********# Company       : Aynsoft Pvt. Ltd.   #**********
**********# Copyright (c) www.aynsoft.com 2005  #**********
**********************************************************/

class tableBlock 
{
	var $table_border = '0';
	var $table_width = '100%';
	var $table_cellspacing = '0';
	var $table_cellpadding = '3';
	var $table_parameters = '';
	var $table_row_parameters = '';
	var $table_data_parameters = '';
	function __construct() 	{
	}
	function tableBlock($contents) 
	{
		$tableBox_string = '';
		$form_after_tr='';
		$form_set = false;
		if (isset($contents['form'])) 
		{
		 // only added for not showing a blank line
			$form_after_tr = $contents['form'] . "\n";
			$form_set = true;
			array_shift($contents);
		}
		$tableBox_string .= '<table border="' . $this->table_border . '" width="' . $this->table_width . '" cellspacing="' . $this->table_cellspacing . '" cellpadding="' . $this->table_cellpadding . '"';
		if (tep_not_null($this->table_parameters)) 
			$tableBox_string .= ' ' . $this->table_parameters;
		$tableBox_string .= '>' . "\n";
		$tableBox_string .= $form_after_tr;
		for ($i=0, $n=sizeof($contents); $i<$n; $i++) 
		{
			$tableBox_string .= '  <tr';
			if (tep_not_null($this->table_row_parameters)) 
				$tableBox_string .= ' ' . $this->table_row_parameters;
			if (isset($contents[$i]['params']) && tep_not_null($contents[$i]['params'])) 
				$tableBox_string .= ' ' . $contents[$i]['params'];
			$tableBox_string .= '>' . "\n";
   if (isset($contents[$i][0]) && is_array($contents[$i][0])) 
			{
				for ($x=0, $y=sizeof($contents[$i]); $x<$y; $x++) 
				{
					if (isset($contents[$i][$x]['text']) && tep_not_null(isset($contents[$i][$x]['text']))) 
					{
						$tableBox_string .= '    <td';
						if (isset($contents[$i][$x]['align']) && tep_not_null($contents[$i][$x]['align'])) 
							$tableBox_string .= ' align="' . $contents[$i][$x]['align'] . '"';
						if (isset($contents[$i][$x]['params']) && tep_not_null(isset($contents[$i][$x]['params']))) 
						{
							$tableBox_string .= ' ' . $contents[$i][$x]['params'];
						} 
						elseif (tep_not_null($this->table_data_parameters)) 
						{
							$tableBox_string .= ' ' . $this->table_data_parameters;
						}
						$tableBox_string .= '>&nbsp;&nbsp;';
						if (isset($contents[$i][$x]['form']) && tep_not_null($contents[$i][$x]['form'])) 
							$tableBox_string .= $contents[$i][$x]['form'];
						$tableBox_string .= $contents[$i][$x]['text'];
						if (isset($contents[$i][$x]['form']) && tep_not_null($contents[$i][$x]['form'])) 
							$tableBox_string .= '</form>';
						$tableBox_string .= '</td>' . "\n";
					}
				}
			} 
			else 
			{
				$tableBox_string .= '    <td';
				if (isset($contents[$i]['align']) && tep_not_null($contents[$i]['align'])) 
					$tableBox_string .= ' align="' . $contents[$i]['align'] . '"';
				if (isset($contents[$i]['params']) && tep_not_null($contents[$i]['params'])) 
				{
					$tableBox_string .= ' ' . $contents[$i]['params'];
				} 
				elseif (tep_not_null($this->table_data_parameters)) 
				{
					$tableBox_string .= ' ' . $this->table_data_parameters;
				}
				$tableBox_string .= '>&nbsp;&nbsp;' . $contents[$i]['text'] . '</td>' . "\n";
			}
			$tableBox_string .= '  </tr>' . "\n";
		}
		if ($form_set == true) 
			$tableBox_string .= '</form>' . "\n";		
		$tableBox_string .= '</table>' . "\n";	
		return $tableBox_string;
	}
}
?>