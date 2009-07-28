<?php
require_once("includes/config.inc.php");
require_once("includes/functions.inc.php"); 
require_once("includes/func_upload.inc.php");
require_once('langs/'.LANG.'.inc.php');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" <!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN'
	'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo LANG?>" lang="<?php echo LANG?>"> 
<head>
<title><?php echo TXT_UPLOADING?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<style type="text/css">
body{
background:#BB0000;
color: #fff;
margin: 0px;
font-family: Verdana, Arial, Helvetica, sans-serif;
font-size:10px;
	}
</style>

<body>

<div id='_noticearea' style='margin:0px;padding:4px'><?basic_upload_hack_block("rename");?></div>

<?php
for ($i = 1; $i <= $_POST['numfiles']; $i++) {
if($_FILES["filename".$i.""]["name"])
{
		$uploadFileName = $newFileName =strtolower(str_replace(" ", "_",$_FILES["filename".$i.""]["name"]));
		preg_match("|\.([a-z0-9]{2,4})$|i", $uploadFileName,$fileSuffix);
		$file_ext=strtolower($fileSuffix[0]);
		if ($_POST['type']==image){
		$TheFileType = $_FILES["filename".$i.""]["type"];
		}else{
		$TheFileType=strtolower($fileSuffix[1]);
		}
		if($_POST["newfilename".$i.""])
		$newFileName = strtolower($_POST["newfilename".$i.""]).$file_ext;
		$newFileName = str_replace(" ", "_",$newFileName);
		$newFileLocation = $_FILES["filename".$i.""]["tmp_name"];
	if ($_FILES['userfile']['error']) {
    	fileErrors($_FILES["file"]["error"],"upload");
  	}else{
	if (checkAllowedType($TheFileType,"upload",$i)) continue;
	if (checkUploadFileSize("upload",$i)) continue;
	if (checkIfFileExist($newFileName,"upload")) continue;
 	if (checkFileChar($newFileName,$uploadFileName,"upload")) continue;
			if (copy($newFileLocation, $_POST['upload_path']  . $newFileName)){
			UploadOK($newFileName,"upload"); 
			define('DID_UPLOAD',true);
			}else{
			UploadFailed($newFileName,"upload");
 			
 }
  				}
  	}else{
			fileErrors($_FILES["file"]["error"],"upload");
		
	}
	if (defined('DID_UPLOAD'))
	echo "<script type='text/javascript'>setTimeout(\"parent.do_refresh()\", 1000);</script>";
	
}		
?>
</body>
</html>