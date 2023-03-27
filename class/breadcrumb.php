<?
/**********************************************************
**********# Name          : Shambhu Prasad Patnaik  #**********
**********# Company       : Aynsoft Pvt. Ltd.   #**********
**********# Copyright (c) www.aynsoft.com 2005  #**********
**********************************************************/
class breadcrumb 
{
 var $_trail;
 function __construct() 
 {
  $this->reset();
 }
 function reset() 
 {
  $this->_trail = array();
 }
 function add($title, $link = '') 
 {
  $this->_trail[] = array('title' => $title, 'link' => $link);
 }
 function trail($separator = ' - ') 
 {
  $trail_string = '';
  for ($i=0, $n=sizeof($this->_trail); $i<$n; $i++) 
  {
   if (isset($this->_trail[$i]['link']) && tep_not_null($this->_trail[$i]['link'])) 
   {
    $trail_string .= '<a href="' . $this->_trail[$i]['link'] . '" class="headerNavigation">' . $this->_trail[$i]['title'] . '</a>';
   } 
   else 
   {
    $trail_string .= $this->_trail[$i]['title'];
   }
   if (($i+1) < $n) 
    $trail_string .= $separator;
  }
  return $trail_string;
 }
}
?>