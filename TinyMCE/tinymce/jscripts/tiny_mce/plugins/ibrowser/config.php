<?
include_once("../../../../../../classinc/main_config.php");

// base url for images
$tinyMCE_base_url = HOST_NAME.PATH_TO_UPLOAD_IMAGE;

// allowed extentions for uploaded image files
$tinyMCE_valid_imgs = array('gif', 'jpg', 'jpeg', 'png');

// allow upload in image library
$tinyMCE_upload_allowed = true;

// allow delete in image library
$tinyMCE_img_delete_allowed = true;

// image libraries
$tinyMCE_imglibs = array(
  array(
    'value'   => '',
    'text'    => 'Uploaded Images',
  ),
);

$arr = array();
getDirList(PATH_TO_MAIN_PHYSICAL_UPLOAD_IMAGE, $arr);
foreach($arr as $t)
{
 $tName = substr($t,strlen($config['image_uploads_path'])+1);
 array_push($tinyMCE_imglibs, array('value'=>$tName.'', 'text'=>$tName));
}

//Recursively build a list of directories in a directory, return 'em as an array
function getDirList($dirName, &$dirList)
{
 $d = opendir($dirName);
 while($thisFile = readdir($d))
 {
  if ($thisFile[0] != ".")
  {
   if (is_dir($dirName."".$thisFile))
   {
    array_push($dirList, $dirName."".$thisFile);
    getDirList($dirName."".$thisFile, $dirList);
   }
  }
 }
 closedir($d);
}
?>