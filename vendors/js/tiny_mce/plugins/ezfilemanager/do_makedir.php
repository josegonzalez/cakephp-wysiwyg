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
<title><?php echo TXT_NEW_DIR?></title>
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

<div id='_noticearea' style='margin:0px;padding:4px'>
<?php basic_upload_hack_block("makedir");?>
</div>
<?php
	$new_directory=trim($_POST['newdir']);
	$new_directory = strtolower($new_directory);
	$new_directory = str_replace(" ", "_",$new_directory);
if (!empty($new_directory)){
	checkIfDirExist($new_directory,"makedir");//Check if Dir exists
	checkDirChar($new_directory,"makedir");//Check new dir chars
	MakeDir($new_directory,"makedir");//Make the new Dir
	}else{
	noDirName();
	}
?>
</body>
</html>