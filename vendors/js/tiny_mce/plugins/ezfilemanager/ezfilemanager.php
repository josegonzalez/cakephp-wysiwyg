<?php
require_once("includes/config.inc.php");
require_once("includes/functions.inc.php"); 
require_once('langs/'.LANG.'.inc.php');
define("CURRENT_DIR",get_dir_name().check_directory());	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" <!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN'
	'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo LANG?>" lang="<?php echo LANG?>"> 
<head>
<title><?php echo TXT_BROWSER?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<script language="JavaScript" src="js/mctabs.js" type="text/javascript"></script>
<?php
//make sure the tiny_mce_popup.js path is correct
if (!STAND_ALONE){//Not necessary but will stop javascript errors?>
<script type="text/javascript" src="../../tiny_mce_popup.js"></script>
<?php }?>
<script src="js/ezfilemanager.js" type="text/javascript"></script>
<link href="css/ezbrowser.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php if (THE_TYPE){
basic_hack_block();

?>
<div class="tabs">
			<ul>
				<li id="dir_tab" class="current"><span><a href="javascript:mcTabs.displayTab('dir_tab','dir_panel');" onmousedown="clear_rename();return false;"><?php echo TXT_BROWSE?></a></span></li>
   <?php if (MAX_SIM_UPLOAD){?>
				<li id="upload_tab"><span><a href="javascript:mcTabs.displayTab('upload_tab','upload_panel');" onmousedown="clear_rename();return false;"><?php echo TXT_UPLOAD?></a></span></li>
<?php }?>
	<?php if (ENABLE_NEW_DIR){?>
				<li id="makedir_tab"><span><a href="javascript:mcTabs.displayTab('makedir_tab','makedir_panel');" onmousedown="clear_rename();return false;"><?php echo TXT_NEW_DIR?></a></span></li>
<?php }?>
			</ul>
		</div>
<div class="panel_wrapper">
			<div id="dir_panel"  class="panel current">
			<?php require_once("includes/directory_list.inc.php"); ?>
			</div>
  <?php if (MAX_SIM_UPLOAD){?>
				<div id="upload_panel" class="panel">
				<?php require_once("includes/upload.inc.php"); ?>
				</div>
	<?php }?>			
		<?php if (ENABLE_NEW_DIR){?>
			<div id="makedir_panel" class="panel">
			<?php require_once("includes/makedir.inc.php"); ?>
			</div>
			<?php }?>
</div>
<script type='text/javascript'>
function do_refresh(){
window.location="<?php echo request_uri();?>";
}
function do_clear_notice(thearea){
document.getElementById(thearea).innerHTML= '';
document.getElementById(thearea).style.visibility = 'hidden';
}
</script>
<?php
}else{//When no type is defined
require_once("includes/selectdir.inc.php"); 
}?>
</body>
</html>