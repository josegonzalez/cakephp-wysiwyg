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
<title><?php echo TXT_RENAME?></title>
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
<?php basic_upload_hack_block("rename");?>
</div>
<?php
if (!empty($_POST['rename_to'])){
if (DIRECTORY_SEPARATOR == "\\")
$_POST['upload_path'] = str_replace("/", DIRECTORY_SEPARATOR, $_POST['upload_path']);
$old_name=$_POST['upload_path'].$_POST['rename_from'];
$new_name=$_POST['upload_path'].strtolower($_POST['rename_to']).$_POST['ext'];
checkNewNameChar("rename");//Check new name chars
checkRename($new_name,"rename");//Check if new name exists
doRename($old_name,$new_name,"rename");//rename
	}else{
	noRenameName("rename");
	}
?>
</body>
</html>