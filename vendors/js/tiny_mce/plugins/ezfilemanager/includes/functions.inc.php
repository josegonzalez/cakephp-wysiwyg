<?php
	/**
	 * $Id: truncate_filename 011 18-08-2008 Naz $
	 * Truncate filename to FILE_CHAR_TO_SHOW defined in config.inc.php
	*/
function truncate_filename($str){
	if (strlen($str) > FILE_CHAR_TO_SHOW)
		{
		return substr($str,0,FILE_CHAR_TO_SHOW).'...';
		}else{
		return $str;
		}
}

	/**
	 * $Id: bytestostring 011 18-08-2008 Naz $
	 * Crude and dirty bites conversion to KB or MB
	*/
function bytestostring($size, $precision = 2) {
if ($size <= 0){
return false; //just play it safe
}elseif ($size < 1024000){//if smaller than 1MB
return number_format($size/1024, $precision)." KB";
}else{
return number_format($size/1024000, $precision)." MB";
}
}

	/**
	 * $Id: basic_hack_block 014 25-09-2008 Naz $
	 * basic security to block non existant folders and back_browsing (../../etc)
	 * See HACK_PATH_CHAR in config
	*/
function basic_hack_block(){
if (preg_match(HACK_PATH_CHAR, $_GET['thedir']) > 0  || !is_dir(WORKING_PATH)) {
echo '<a href="'.$_SERVER['PHP_SELF'].'?sa='.STAND_ALONE.'"><img src="img/folder_up.gif" width="16" height="16" alt="'.TXT_BROWSE.'" border="0" /></a>';
		die(TXT_ERROR.' '.TXT_HACK." [".get_dir_name()."]");
		}
}
	/**
	 * $Id: basic_upload_hack_block 014 25-09-2008 Naz $
	 * basic security to block uploading outside of working path (../../etc)
	 * Remove from the upload the working-path and do the check
	 * See HACK_PATH_CHAR in config
	*/
function basic_upload_hack_block($what){
$path_to_check = str_replace($_POST['upload_path'], "", WORKING_PATH);
if (preg_match(HACK_PATH_CHAR, $path_to_check) > 0) {
echo "<script type=\"text/javascript\">
parent.document.getElementById('".$what."_noticearea').innerHTML = '".TXT_ERROR.' '.TXT_HACK."';
</script>";
	die(TXT_ERROR.' '.TXT_HACK);
		}
}
	/**
	 * $Id: get_files 013 19-09-2008 Naz $
	 * Crude and dirty function
	 * Must be improved
	*/
function get_files(){
global $file,$dir_name,$dir_name_path,$dir_time,$ezfilemanager;
	$dh = opendir(WORKING_PATH);
	$files = array();
while (($filename = readdir($dh)) !== false)
{	//$filename[0] dont show hidden files
	if($filename != "." && $filename != ".." && $filename[0] != ".")
	{//If it is directory put name and path into array		
	if (is_dir(WORKING_PATH.$filename))
	{
	$dir_name[]=$filename;
	$dir_time[]=filemtime(WORKING_PATH.$filename).'/.';
	$dir_name_path[]=str_replace(CHANGE_PATH, "",str_replace("//","/",WORKING_PATH)).$filename;
	}
	else
	{	//If it is file put name and other info into array	
	    //Put into $file_info array the icon, type and preview
		$file_info = get_file_mime(WORKING_PATH.$filename);
		//If browsing image directory;
		if(THE_TYPE==image)
			{
		//If it is image, add to $file array the file info (width,height,name,type,size etc);
			if($imginfo = getimagesize(WORKING_PATH.$filename))
				{
			$file['width'][] = $imginfo[0]."px";
			$file['height'][] = "x".$imginfo[1]."px";
			$file['type'][] = $imginfo['mime'];
			$file['name'][] = $filename;
		    $file['modified'][] = filemtime(WORKING_PATH.$filename);
		    $file['size'][] = filesize(WORKING_PATH.$filename);
			$file['preview'][]=$file_info['preview'];
			$file['icon'][]=$file_info['icon'];
				}
			}
			else // it is not img, add to $file array the file info (name,type,size etc);
			{
		//Get the file extension and add to $file array the file info only if the extension 
		//is in our Permitted file extensions in ezfilemanager array
		preg_match("|\.([a-z0-9]{2,4})$|i", $filename, $fileSuffix);
		if (in_array($fileSuffix[1], $ezfilemanager['filetype'][THE_TYPE]))
				{
			$file['name'][] = $filename;
		    $file['modified'][] = filemtime(WORKING_PATH.$filename);
		    $file['size'][] = filesize(WORKING_PATH.$filename);
			$file['type'][] = $file_info['type'];
			$file['preview'][]=$file_info['preview'];
			$file['icon'][]=$file_info['icon'];
				}
			}
	}
	}
}
closedir($dh);
}
	/**
	 * $Id: do_delete 012 013 19-09-2008 Naz $
	 * Delete files or reculsively delete directories (all content)
	 * Must be improved
	*/
function do_delete(){
if(isset($_POST['dodelete']) && ENABLE_DELETE==1){
// Delete any checked files
	if(isset($_POST['file_to_del']))
	{
	foreach($_POST['file_to_del'] as $file => $val)
		{
			if (file_exists(WORKING_PATH.$file)) 
			{
			chmod(WORKING_PATH.$file, 0777); 
			@unlink(WORKING_PATH.$file);
			}
		}
	}	
// Delete any checked directories and its content
	if(isset($_POST['dir_to_del']))
	{
		foreach($_POST['dir_to_del'] as $dir => $val)
		{
		delete_directory(CHANGE_PATH.$dir);//do the delete_directory recursive del function
		}
	}

}//end if(isset($_POST['dodelete']))

}
	/**
	 * $Id: delete_directory 011 18-08-2008 Naz $
	 * Reculsively delete directories (all content)
	*/
function delete_directory($dir) {    
if (substr($dir, strlen($dir)-1, 1) != '/')        
$dir .= '/';     
if ($handle = opendir($dir))
    {        
	while ($obj = readdir($handle))
	   {            
		if ($obj != '.' && $obj != '..')
			{
				if (is_dir($dir.$obj))                
				{                    
				if (!delete_directory($dir.$obj))                        
					return false;                
				}                
					elseif (is_file($dir.$obj))                
						{ 
						chmod($dir.$obj, 0777); //remove if you have problems
						if (!unlink($dir.$obj))
						return false;                
						}            
			}        
		}         
	closedir($handle); 
	chmod($dir, 0777);  //remove if you have problems
	if (!@rmdir($dir))   
	return false;        
	return true;    
	}else{   
		return true; 
		}
}
	/**
	 * $Id: get_file_mime 012 26-08-2008 Naz $
	 * Return the icons/type/preview of files
	 */
function get_file_mime($file_name) {
	global $ezfilemanager_mime_types;
   preg_match("|\.([a-z0-9]{2,4})$|i", $file_name, $fileSuffix);
	// Match file extension with icon, type and preview
	foreach ($ezfilemanager_mime_types as $type) {
		foreach ($type[0] as $the_extension) {
			if (strtolower($fileSuffix[1]) == $the_extension)
				return array("icon" => $type[1], "type" => $type[2], "preview" => $type[3]);
		}
	}
	// If it is not in our $ezfilemanager_mime_types array
	return array("icon" => "unknown.gif", "type" => "Unknown", "preview" => false);
}	
	/**
	 * $Id: check_if_writable 012 26-08-2008 Naz $
	 * Return true if the dir is writable
	 */
function check_if_writable($dir_to_check) {
		// if windows OS
		// is_writeable does not make a real UID/GID check on Windows.
		
		$dir_to_check = substr($dir_to_check, 0, -1);// remove trailing slash
		if (DIRECTORY_SEPARATOR == "\\") 
			{
			$dir_to_check = str_replace("/", DIRECTORY_SEPARATOR, $dir_to_check);
			   
				if (is_dir($dir_to_check)) 
					{
			$tmp_file = time().md5(uniqid('abcd'));
				if (@touch($dir_to_check . '\\' . $tmp_file)) {
					unlink($dir_to_check . '\\' . $tmp_file);
					return true;
					}
			
			} 
			return false;
		}
		// Not windows OS
		return is_writeable($dir_to_check);
	}
	/**
	 * $Id: check_directory 012 26-08-2008 Naz $
	 * check if the working dir is writable
	 * If not writable retun error msg
	 */
function check_directory(){
	if (CHECK_IF_WRITABLE){
		if (!check_if_writable(WORKING_PATH))
			{
		return "<span class='error'>: ".TXT_NON_WRITABLE."</span>";
		return false;
			}
			}else{
			return false;
			}
	}
	/**
	 * $Id: get_dir_name 012 26-08-2008 Naz $
	 * Get the name of the working Directory
	 */	
function get_dir_name(){
	$path = substr(WORKING_PATH, 0, -1);
	$dirname = substr(strrchr($path, "/"), 1);
	return $dirname;
	}
	/**
	 * $Id: previewLink 012 26-08-2008 Naz $
	 * Prepare the preview link based on $ezfilemanager_mime_types array
	 */	
function previewLink($filename,$preview=0){
if ($preview){
	return '<a href="'.CHANGE_URL.$_GET['thedir'].$filename.'" target="preview_iframe" onclick="selectURL(\''.CHANGE_URL.$_GET['thedir'].$filename.'\');">' .truncate_filename($filename).'</a>';
		}else{
		return  '<a href="img/preview.gif" target="preview_iframe" onclick="selectURL(\''.CHANGE_URL.$_GET['thedir'].$filename.'\');">' .truncate_filename($filename).'</a>';
		}
}
	/**
	 * $Id: stanaloneNavLinks 012 26-08-2008 Naz $
	 * Prepare the navigation icons for stand alone mode
	 */	
function stanaloneNavLinks(){
if (is_dir(IMG_PATH)){
	$the_nav .='<a href="'.$_SERVER['PHP_SELF'].'?sa=1&amp;type=image" class="navicons"><img src="img/image.gif" width="16" height="16" alt=""></a>';
	}
if (is_dir(MEDIA_PATH)){
	$the_nav .='<a href="'.$_SERVER['PHP_SELF'].'?sa=1&amp;type=media" class="navicons"><img src="img/media.gif" width="16" height="16" alt=""></a>';
	}
if (is_dir(FILE_PATH)){
	$the_nav .='<a href="'.$_SERVER['PHP_SELF'].'?sa=1&amp;type=file" class="navicons"><img src="img/file.gif" width="16" height="16" alt=""></a>';
	}
return $the_nav;
}
	/**
	 * $Id: refreshBackLinks 012 26-08-2008 Naz $
	 * Prepare the refresh and folder back icons
	 */	
function refreshBackLinks(){
	$refersh_back_icon ='<a href="'.$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'].'" title="'.TXT_REFRESH.'" class="navicons"><img src="img/refresh.gif" width="16" height="16" alt="'.TXT_REFRESH.'" /></a><a href="'.$_SERVER['PHP_SELF'].'?type='.THE_TYPE.'&amp;sa='.STAND_ALONE.'" title="'. TXT_BACK.'" class="navicons"><img src="img/folder_up.gif" width="18" height="16"  alt="'.TXT_BACK.'"  /></a>';
if ($pos = strrpos(substr($_GET['thedir'], 0, -1), "/"))
		{
	$refersh_back_icon .='<a href="'. $_SERVER['PHP_SELF'].'?type='.THE_TYPE.'&amp;sa='.STAND_ALONE.'" title="'.TXT_ROOT.'" class="navicons"><img src="img/folder_root.gif" width="18" height="16" alt="'. TXT_ROOT.'" /></a>';
		}
return $refersh_back_icon;
}
	/**
	 * $Id: allowedFileNotice 012 26-08-2008 Naz $
	 * Write notice to the user with the allowed upload files types/extension
	 */	
function allowedFileNotice(){
global $ezfilemanager;
$the_notice = TXT_YOU_CAN." ";
	foreach ($ezfilemanager['filetype'][THE_TYPE] as $value) 
	{
    $the_notice .= ",".$value." ";
	}
return $the_notice .= TXT_FILES;
}
/**
	 * $Id: request_uri 012 013 19-09-2008 Naz $
	 * fix $_SERVER['REQUEST_URI'] for IIS
	 * fix for secure site (https)
	 * 
	*/	
function request_uri(){
$_SERVER['FULL_URL'] = 'http';
$script_name = "";
if ( !isset($_SERVER['REQUEST_URI']) || !$_SERVER[ 'REQUEST_URI' ] )  {  
        if ( !( $_SERVER[ 'REQUEST_URI' ] = @$_SERVER['PHP_SELF'] ) ) { 
            $_SERVER[ 'REQUEST_URI' ] = $_SERVER['SCRIPT_NAME']; 
        } 
        if ( isset( $_SERVER[ 'QUERY_STRING' ] ) ) { 
            $_SERVER[ 'REQUEST_URI' ] .= '?' . $_SERVER[ 'QUERY_STRING' ]; 
        } 
    } 
	if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on') {
    $_SERVER['FULL_URL'] .=  's';
}
$_SERVER['FULL_URL'] .=  '://';
$script_name = $_SERVER['REQUEST_URI'];
$_SERVER['FULL_URL'] .=  $_SERVER['HTTP_HOST'].$script_name;
return $_SERVER['FULL_URL'];
}

	/**
	 * $Id: make_java_array 013 19-09-2008 Naz $
	 * Returns the java array from $ezfilemanager['filetype']
	 * used to validate file type before uploading
	 * 
	*/	
function make_java_array(){
global $ezfilemanager;
if (THE_TYPE==image){
return IMG_EXT;
}else{
foreach ($ezfilemanager['filetype'][THE_TYPE] as $ext) {
$array_content .="'".$ext."',";
}
return "[".substr($array_content, 0, -1)."]";
}
}

?>
