<?php
//error_reporting(0); //Uncomment to see PHP Errors
	/**
	 * Eazy file manager platform for TinyMCE
	 * ezfilemanager v.08
	 * @author Nazaret Armenagian (Naz)
	 * @link www.webnaz.net
	 * @since August-2008
	 * Usual and unnecessary GNU General Public License should follow
	 */

	/**
	 * Uncomment to set script time out if you wish
	 * This might not work if it's more than the default PHP max_execution_time, 
	 * you might be able to use php.ini or htaccess file
	 * but check with your hosting provider for info
	 * use echo ini_get('max_execution_time') to see your default exec. time
	 * but some hosts disable ini_get
	 * read more http://www.php.net/manual/en/ini.php
	 */
//@set_time_limit(20*60); // 20 minutes execution time 

	/**
	 * Define lang (translate langs/en.inc.php for other langs)
	 * Default en
	 * Enable-disable check for directory permisions
	 * Enable-disable delete/rename/upload
	 * Define valid characters for Files and Directories
	 * Define valid characters for path (hack_block)
	 * Enable-disable delete/rename/upload
	 * Use PHP regex for Valid Chars
	 * Define Paths and URL
	 * Important Paths and URL must end with trailing slash /
	 * Some other definitions, date, chop long names etc
	 */
define('LANG','en');
define('CHECK_IF_WRITABLE',true); //do checks to see if dir is writable (true/false)
define('ENABLE_RENAME',true); //allow file/dir renaming  (true/false)
define('ENABLE_DELETE',true);  //allow file/dir deleting  (true/false)
define('ENABLE_NEW_DIR',true);  //allow new dir creation  (true/false)
define('MAX_SIM_UPLOAD','3');  //Max number of simultaneous uploads, 0 disables upload
define('VALID_DIR_CHAR','[^0-9a-zA-Z_-]'); //makedir allow alphanumeric(upper/lower) and _- 
define('VALID_FILE_CHAR','[^0-9a-zA-Z_.-]');//upload allow alphanumeric(upper/lower) and ._- 
define('HACK_PATH_CHAR','/[;\\\\\\.&,:><]/i');// deny ;,:,\,,>,<,.,& characters in path/upload
define('IMG_EXT','[\'jpeg\', \'jpg\', \'gif\', \'png\']');// Used for javascript validation
define('DATE_FORMAT','d/m/Y H:i');
define('FILE_CHAR_TO_SHOW','25');//filename will be truncated to 25chars if it's longer
define("WN_URL","http://www.yourdomain.com/");//your domain url
define('WN_PATH','/home/username/public_html/');//domain root absolute path 
define("IMG_PATH",WN_PATH."images/");//Image dir url 
define('IMG_URL',WN_URL.'images/');//Image dir absolute path 
define('FILE_PATH',WN_PATH.'docs/');//File dir url 
define('FILE_URL',WN_URL.'docs/');//File dir absolute path 
define('MEDIA_PATH',WN_PATH.'media/');//Media dir url 
define('MEDIA_URL',WN_URL.'media/');//Media dir absolute path 
	/**
	 * ezfilemanager array
	 * Add Max File upload size  to ezfilemanager array
	 * Set Max File upload size limit in B
	 * This will not work if your settings are more than the default PHP settings, 
	 * or if the script times out, see set_time_limit above
	 * you might be able to use php.ini or htaccess file
	 * but again check with your hosting provider for info
	 * use echo ini_get('upload_max_filesize') to see your default upload size limit
	 * but some hosts disable ini_get
	 * Probably its 2M, multiply by 1012000 to convert to B
	 * 1024B=1KB 1024000B=1000KB=1M 
	 */
$ezfilemanager = array();
$ezfilemanager['maxsize']['image'] = 61440; // Image file maximum size 61440=60KB
$ezfilemanager['maxsize']['media'] = 2048000; // Media file maximum size 2048000=2M
$ezfilemanager['maxsize']['file']  = 1228800; // Other file maximum size 1228800=1.2M
	/** 
	 * Add Permitted file extensions  to ezfilemanager array
	 * for image, media and docs/other types
	 */
$ezfilemanager['filetype']['image'] = array('image/pjpeg', 'image/jpeg', 'image/gif', 'image/x-png', 'image/png');
$ezfilemanager['filetype']['media'] =  array('swf','mp3','mov','avi','mpg','qt','mp4');
$ezfilemanager['filetype']['file']  = array('html','pdf','ppt','txt','doc','rtf','xml','xsl','dtd','zip','rar');

/** NOTHING NEEDS TO BE MODIFIED BELOW THIS LINE */
/**
	 * ezfilemanager_mime_types array
	 * got the idea from http://tinymce.moxiecode.com/punbb/viewtopic.php?id=2984
	 * Holds the extension type,icon, the long type info, and preview 
	 * Add the extension array eg array("exe", "com")
	 * Add the icon eg exe.gif
	 * Add the long type eg exe or application/exe
	 * Add to enable preview true or false eg true
	 * You dont need the last aray (gif,jpg,..) but keep it just in case
	 * no need to modify ezfilemanager_mime_types array
	 */
$ezfilemanager_mime_types = array(
	//Format: array ('type_1','type_2') ,icon, the long type info, and preview (true/false) 
	array(array("exe", "com"), "exe.gif", "exe", false),
	array(array("zip", "gzip", "rar", "gz", "tar"), "archive.gif", "archive", false),
	array(array("htm", "html", "php", "jsp", "asp"), "html.gif", "html", true),
	array(array("mov", "mpg", "avi", "asf", "mpeg", "wmv","mp4","qt"), "movie.gif", "movie", false),
	array(array("aif", "aiff", "wav", "mp3"), "audio.gif", "sound", false),
	array(array("swf"), "swf.gif", "Flash file", true),
	array(array("ppt", "pps"), "powerpoint.gif", "powerpoint", false),
	array(array("rtf"), "rtf.gif", "document", false),
	array(array("css"), "css.gif", "css", true),
	array(array("js", "json"), "script.gif", "script", false),
	array(array("doc"), "word.gif", "word", false),
	array(array("pdf"), "pdf.gif", "pdf", false),
	array(array("xls"), "excel.gif", "excel", false),
	array(array("txt"), "txt.gif", "txt", true),
	array(array("xml", "xsl", "dtd"), "xml.gif", "xml", true),
	array(array("gif", "jpg", "jpeg", "png", "bmp", "tif"), "image.gif", "image", true)
	);
	/** 
	 * Add File upload paths/url to ezfilemanager array
	 * Do not modify
	 */
$ezfilemanager['path']['image'] = IMG_PATH;
$ezfilemanager['url']['image'] = IMG_URL; 
$ezfilemanager['path']['media'] = MEDIA_PATH; 
$ezfilemanager['url']['media'] = MEDIA_URL; 
$ezfilemanager['path']['file']  = FILE_PATH;
$ezfilemanager['url']['file']  = FILE_URL; 
	/**
	 * set the standalone, type, working path and absolute URL parameters
	 * Do not modify
	 */
define("STAND_ALONE",$_GET['sa']);	 
define("THE_TYPE",$_GET['type']);	
define('CHANGE_URL',$ezfilemanager['url'][THE_TYPE]);
define('CHANGE_PATH',$ezfilemanager['path'][THE_TYPE]);
define('WORKING_PATH',$ezfilemanager['path'][THE_TYPE].$_GET['thedir']);
if (!defined('LANG'))
define('LANG','en');
?>