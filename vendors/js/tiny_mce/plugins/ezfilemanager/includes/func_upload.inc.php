<?php
//UPLOAD FUNCTIONS
	/**
	 * $Id: fileErrors   013 19-09-2008 Naz $
	 * Returns the PHP File Upload error number
	 * 
	*/
function fileErrors($id,$what){
echo "<script type=\"text/javascript\">
x=parent.document.getElementById('".$what."_noticearea').innerHTML;

parent.document.getElementById('".$what."_noticearea').innerHTML = x+' :".TXT_ERROR." ".$id."'</script>".clear_msg($what);
}
	/**
	 * $Id: checkUploadFileSize 013 19-09-2008 Naz $
	 * If the script times-out or Fille too big the $_FILES["filename"]["size"]=0
	 * Check if within allowed upload size limit
	 * 
	*/
function checkUploadFileSize($what,$thefileid){
global $ezfilemanager;
	if($_FILES["filename".$thefileid.""]["size"]<=0)
	{
echo "<script type=\"text/javascript\">
parent.document.getElementById('".$what."_noticearea').innerHTML = '".TXT_ERROR." [".TXT_FILE_BIG."/".TXT_FILE_NO."]'</script>".clear_msg($what);
return true;
	}else if($_FILES["filename".$thefileid.""]["size"]<=$ezfilemanager['maxsize'][$_POST['type']])
		{
		return false;
		}else{
			echo "<script type=\"text/javascript\">
parent.document.getElementById('".$what."_noticearea').innerHTML = '".TXT_ERROR." ".TXT_FILE_BIG." [".$_FILES["filename".$thefileid.""]["size"]."/".$ezfilemanager['maxsize'][$_POST['type']]."]'</script>".clear_msg($what);
return true;
	}
}
	/**
	 * $Id: checkAllowedType 013 19-09-2008 Naz $
	 * Check if within allowed upload file types
	 * 
	*/
function checkAllowedType($TheFileType,$what,$thefileid){
global $ezfilemanager;
		if(in_array($TheFileType, $ezfilemanager['filetype'][$_POST['type']])){
		return false;
		}else{
		echo "<script type=\"text/javascript\">
parent.document.getElementById('".$what."_noticearea').innerHTML = 'bb".TXT_ERROR." ".TXT_FILE_INVALID." [".$_FILES["filename".$thefileid.""]["type"]."]'</script>".clear_msg($what);
return true;
		}
}	
	/**
	 * $Id: checkFileChar 012 013 19-09-2008 Naz $
	 * Check if within allowed upload file characters
	 * 
	*/		
function checkFileChar($ThenewFileName,$TheuploadFileName,$what){
	if (eregi(VALID_FILE_CHAR, $ThenewFileName) || eregi(VALID_FILE_CHAR, $TheuploadFileName))
	{
	echo "<script type=\"text/javascript\">
parent.document.getElementById('".$what."_noticearea').innerHTML = '".TXT_ERROR." ".TXT_FILE_CHRACTERS." [".htmlentities($ThenewFileName)."][".htmlentities($TheuploadFileName)."]'</script>".clear_msg($what);
return true;
	}else{
	return false;
	}
}
	/**
	 * $Id: checkIfFileExist 013 19-09-2008 Naz $
	 * Check if file exists
	 * 
	*/		
function checkIfFileExist($ThenewFileName,$what){
	if(is_file($_POST['upload_path'] . $ThenewFileName))
	{
	echo"<script type=\"text/javascript\">
parent.document.getElementById('".$what."_noticearea').innerHTML = '".TXT_ERROR." ".TXT_FILE_EXIST." [".htmlentities($ThenewFileName)."]'</script>".clear_msg($what);
return true;
	}else{
	return false;
	
	}
}
	/**
	 * $Id: UploadOK 012 013 19-09-2008 Naz $
	 * If upload OK, show message and refresh window
	 * 
	*/		
function UploadOK($ThenewFileName,$what){
	chmod($_POST['upload_path']  . $ThenewFileName, 0644);//remove ,0644 if creates problem 
	echo "<script type=\"text/javascript\">
parent.document.getElementById('".$what."_noticearea').innerHTML = '".$ThenewFileName . " ".TXT_FILE_UPLOADED."'</script>";
	
}
	/**
	 * $Id: uploadFailed 012 013 19-09-2008 Naz $
	 * If upload failed, probably dir not writable
	 * show message and then clear the message
	 * 
	*/	
function uploadFailed($what){
	echo "<script type=\"text/javascript\">
parent.document.getElementById('".$what."_noticearea').innerHTML = '".TXT_ERROR." ".TXT_NON_WRITABLE."'</script>".clear_msg($what);
}
//MAKE DIR FUNCTIONS
	/**
	 * $Id: checkIfDirExist 012 26-08-2008 Naz $
	 * Check if dir allready exists
	 * show message and then clear the message
	 * 
	*/	
function checkIfDirExist($Thenew_directory,$what){
	if(is_dir($_POST['upload_path'] . $Thenew_directory))
	{
	die("<script type=\"text/javascript\">
parent.document.getElementById('".$what."_noticearea').innerHTML = '".TXT_ERROR." ".TXT_DIR_EXIST." [".htmlentities($Thenew_directory)."]'</script>".clear_msg($what));
	}
}
	/**
	 * $Id: checkDirChar 012 26-08-2008 Naz $
	 * Check the new dir characters
	 * show message and then clear the message
	 * 
	*/	
function checkDirChar($Thenew_directory,$what){
	if (eregi(VALID_DIR_CHAR, $Thenew_directory))
	{
	die("<script type=\"text/javascript\">
parent.document.getElementById('".$what."_noticearea').innerHTML ='".TXT_ERROR." ".TXT_FILE_CHRACTERS." [".htmlentities($Thenew_directory)."]'</script>".clear_msg($what));
	}else{
	return true;
	}
}
	/**
	 * $Id: MakeDir 012 26-08-2008 Naz $
	 * If everything OK, try to make the new dir
	 * If failes, probably non writable dir
	 * show message and then clear the message
	 * 
	*/	
function MakeDir($Thenew_directory,$what){
if (@mkdir($_POST['upload_path'] . $Thenew_directory, 0755))//remove ,0755 if creates problem
	{
	echo "<script type=\"text/javascript\">
parent.document.getElementById('".$what."_noticearea').innerHTML = '".htmlentities($Thenew_directory) . " ".TXT_DIR_CREATED."'</script>";
	echo "<script type='text/javascript'>setTimeout(\"parent.do_refresh()\", 1000);</script>";
	}else{
 	uploadFailed();
	}
}
	/**
	 * $Id: noDirName 012 26-08-2008 Naz $
	 * If no new dir name has been entered
	 * show message and then clear the message
	 * 
	*/	
function noDirName($what){
	die("<script type=\"text/javascript\">
parent.document.getElementById('".$what."_noticearea').innerHTML = '".TXT_ERROR." ".TXT_DIR_NO."'</script>".clear_msg($what));
	
}
//RENAME FUNCTIONS
	/**
	 * $Id: checkNewNameChar 012 26-08-2008 Naz $
	 * Check if within allowed upload file characters
	 * 
	*/	
function checkNewNameChar($what){
if (eregi(VALID_DIR_CHAR, $_POST['rename_to']))
	{
	die("<script type=\"text/javascript\">
parent.document.getElementById('".$what."_noticearea').innerHTML = '".TXT_ERROR." ".TXT_FILE_CHRACTERS." [".htmlentities($_POST['rename_to'])."]'</script>".clear_msg($what));
	}else{
	return true;
	}
}
	/**
	 * $Id: checkRename 012 26-08-2008 Naz $
	 * Check if rename file/dir exist
	 * show message and then clear the message
	 * 
	*/	
function checkRename($new_name,$what){
if (is_dir($new_name) || is_file($new_name))
	{
	die("<script type=\"text/javascript\">
parent.document.getElementById('".$what."_noticearea').innerHTML = '".TXT_ERROR." ".TXT_FILE_EXIST."'</script>".clear_msg($what));
	}else{
	return false;
	}
}


	/**
	 * $Id: doRename 012 26-08-2008 Naz $
	 * Rename files/dir
	 * show message and then clear the message
	 * 
	*/	
function doRename($old_name,$new_name,$what){
if (@rename($old_name,$new_name))
	{
	echo "<script type='text/javascript'>setTimeout(\"parent.do_refresh()\", 1000);</script>";
	}else{
 	die("<script type=\"text/javascript\">
parent.document.getElementById('".$what."_noticearea').innerHTML = '".TXT_ERROR." ".TXT_NON_WRITABLE."'</script>".clear_msg($what));
	}
}

	/**
	 * $Id: noRenameName 012 26-08-2008 Naz $
	 * If no new file name has been entered
	 * show message and then clear the message
	 * 
	*/	
function noRenameName($what){
	die("<script type=\"text/javascript\">
parent.document.getElementById('".$what."_noticearea').innerHTML = '".TXT_ERROR." ".TXT_FILE_NO."'</script>".clear_msg($what));
	
}
	/**
	 * $Id: clear_msg 012 26-08-2008 Naz $
	 * Clears the ID messages (upload/rename/makedir)
	 * clear the message
	 * 
	*/	
function clear_msg($thearea){
return "<script type='text/javascript'>setTimeout(\"parent.do_clear_notice('".$thearea."_noticearea')\", 3000);</script>";

}

?>