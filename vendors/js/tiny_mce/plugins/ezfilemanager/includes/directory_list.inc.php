<?php
if (!defined('LANG'))
die();
do_delete();
get_files();
?>
<div class="topnav">
<?php
//if stand-alone
if (STAND_ALONE){?><div class='standalone'><?php echo stanaloneNavLinks()?></div><?php }?>
<div class='refreshback'><?php echo refreshBackLinks();?></div>
</div>
<fieldset>
<legend><?php echo TXT_BROWSING.': '.CURRENT_DIR;?></legend>
<div class='dirlist'><?php if (ENABLE_DELETE){?>
<form action='?<?php echo $_SERVER['QUERY_STRING']?>' method='post' id='dodelete' name='dodelete' onsubmit='return confirm_del(this)'><?php }?>
<table cellspacing="0" cellpadding="0" align="center" class="browse"><tr><th style='width:16px'><?php if ($pos = strrpos(substr($_GET['thedir'], 0, -1), "/"))$folder_up='&amp;thedir='.substr($_GET['thedir'], 0, $pos).'/';?><a href="<?php echo $_SERVER['PHP_SELF'].'?type='.THE_TYPE.'&amp;sa='.STAND_ALONE.$folder_up;?>" title="<?php echo TXT_BACK;?>"><img src="img/folder_up.gif" width="18" height="16" alt="<?php echo TXT_BACK;?>" /></a></th><th><?php echo TXT_NAME?></th><th><?php echo TXT_SIZE?></th><th><?php echo TXT_TYPE?></th><th><?php echo TXT_DATE?></th>
<?php if (ENABLE_RENAME){?>
<th style='width:16px'>&nbsp;</th>
<?php }?>
<?php if (ENABLE_DELETE){?>
<th style='width:1%'><input type="image" name="submit" src="img/delete.gif" class='delicon' /></th>
<?php }?>
</tr>
<?php
//First show the sub-directories
for($ii=0;$ii<count($dir_name);$ii++)
		{
		$row_color = (@$row_color == "r1") ? "r2" : "r1";	
		echo '<tr class="'.$row_color.'">
			  <td class="icon"><a href="'.$_SERVER['PHP_SELF'].'?type='.THE_TYPE.'&amp;thedir='.$dir_name_path[$ii].'/&amp;sa='.STAND_ALONE.'" title="'.TXT_BROWSE.'"><img src="img/folder.gif" width="16" height="16" alt="'.TXT_BROWSE.'" /></a></td>
			<td colspan="3"><a href="'.$_SERVER['PHP_SELF'].'?type='.THE_TYPE.'&amp;thedir='.$dir_name_path[$ii].'/&amp;sa='.STAND_ALONE.'" title="'.TXT_BROWSE.'">'.$dir_name[$ii].'</a></td>
<td>'.date(DATE_FORMAT,$dir_time[$ii]).'</td>
';
if (ENABLE_RENAME){
echo '<td><a href="img/preview.gif" target="preview_iframe" title="'.TXT_RENAME.'" onclick="makerename(\''.$dir_name_path[$ii].'\',\'\')"><img src="img/rename.gif" width="14" height="14" alt="'.TXT_RENAME.'" /></a></td>';
}
if (ENABLE_DELETE){
			echo '<td><input class="delcheckbox" type="checkbox" name="dir_to_del['.$dir_name_path[$ii].']" value="1" />';
}

echo '</td></tr>';
		}
//Now show the directory files		
for($i=0;$i<count($file['name']);$i++)
		{
		$row_color = (@$row_color == "r1") ? "r2" : "r1";
		preg_match("|\.([a-z0-9]{2,4})$|i", $file['name'][$i],$fileSuffix);
	echo'<tr class="'.$row_color.'">
		<td><img src="img/icons/'.$file['icon'][$i].'" width="16" height="16" alt="'.$file['name'][$i].' '.$file['width'][$i].' '.$file['height'][$i].'" /></td>
		<td>'.previewLink($file['name'][$i],$file['preview'][$i]).'</td>
		<td>'.bytestostring($file['size'][$i],1).'</td>
		<td><span style="margin-left:1px">'.$file['type'][$i].'</span></td>
		<td>'.date(DATE_FORMAT,$file['modified'][$i]).'</td>';
if (ENABLE_RENAME){
		echo '<td><a href="img/preview.gif" target="preview_iframe" title="'.TXT_RENAME.'" onclick="makerename(\''.substr($file['name'][$i], 0, -strlen($fileSuffix[0])).'\',\''.$fileSuffix[0].'\')"><img src="img/rename.gif" width="14" height="14" alt="'.TXT_RENAME.'" /></a></td>';
}
if (ENABLE_DELETE){
echo '<td><input class="delcheckbox" type="checkbox" name="file_to_del['.$file['name'][$i].']" value="1" /></td>';
}
echo '</tr>';
		}
	echo '</table>';
if (ENABLE_DELETE){
?><input type='hidden' name='dodelete' id='dodelete' value='1'></form><?php }?></div><div class='preview'><script type="text/javascript">
if (document.all && document.getElementById) 
{ 
var izoom=75;
function do_zoom(){
while (izoom<=100)
{
document.getElementById('preview_iframe').style.zoom = izoom+'%';
izoom=izoom-25;
if (izoom==0){izoom=75;
document.getElementById('preview_iframe').style.zoom = '100%';
}
break;
}
}
document.write('<span  onclick=\"do_zoom()\" style=\"cursor:pointer;\"><img src=\"img/zoom-in.png\" width=\"22\" height=\"22\" alt=\"\"></span>');
}</script>
<iframe src="img/preview.gif" name="preview_iframe" id="preview_iframe" marginwidth="0" marginheight="0" class="thepreview"></iframe>
<form action='' name='previewform' id='previewform' onsubmit='return insert_theurl();return false'><input type='hidden' name='selected_url' id='selected_url'><?php if (!STAND_ALONE){?>
<input type="submit" name="go" id="go" value="<?php echo TXT_INSERT?>" class='insert_link'><?php }?><span id='do_download' name='do_download'></span>
</form>

<div id='do_rename' name='do_rename'><form action="do_rename.php?type=<?php echo THE_TYPE?>" onsubmit='return rename()' name='do_rename' id='do_rename'  method="post"  target="all_iframe">
<input type='text' name='rename_to' id='rename_to' value='' class='fieldtext'><span id='ext' name='ext' style='width:50px'></span>
<br />
<input type='hidden' name='upload_path' id='upload_path' value='<?php echo WORKING_PATH?>'>
<input type='hidden' name='rename_from' id='rename_from' value=''>
<input type='hidden' name='ext' id='ext' value=''>
<input type='submit'  value='<?php echo TXT_RENAME?>'>
</form>
<div id='rename_noticearea' class='messagenotice' style='visibility:hidden'></div>
</div>
</div>
</fieldset>
<iframe  name="all_iframe" id="all_iframe" hspace="0" vspace="0" frameborder="0" style="width: 100%; height: 30px;padding:0px;margin:0px;visibility:hidden;" src=""></iframe>

<script type="text/javascript">
document.getElementById('do_download').style.visibility = 'hidden';
document.getElementById('do_rename').style.visibility = 'hidden';
<?php if (ENABLE_DELETE){?>
function confirm_del(f){
var Frm = document.forms[0]; 
var e, i = 0, checked = false;
while (e = f.elements[i++]) {if (e.type == 'checkbox' && e.checked) checked = true};
if (!checked){
alert('<?php echo TXT_FILE_NO?>');
return false;
}else{
	var delMsg = confirm("<?php echo TXT_QUSTION;?>\n\n<?php echo TXT_DO_CLICK;?>\n\n");
	if (delMsg == true) {
return true;
}
return false;
}
}
<?php }?>
<?php if (ENABLE_RENAME){?>
function makerename(thename,ext){
document.getElementById('do_download').style.visibility = 'hidden';
try {
document.getElementById('go').style.visibility = 'hidden';
} catch (e) { }
document.getElementById('do_download').innerHTML = '';
document.do_rename.rename_to.value = thename;
document.do_rename.rename_from.value = thename+ext;
document.do_rename.ext.value = ext;
document.getElementById('do_rename').style.visibility = 'visible';
document.getElementById('ext').innerHTML=ext;
}


function rename(){
var ext = document.do_rename.rename_to.value;
  if(ext == '') {
    alert('<?php echo TXT_FILE_NO?>');
    return false; 
	}
  else {
document.getElementById('rename_noticearea').innerHTML = '<?php echo TXT_RENAME?>';
document.getElementById('rename_noticearea').style.visibility = 'visible';
 return true; 
}
  return false;
}
<?php }?>
function clear_rename(){
do_clear_notice('rename_noticearea');
document.do_rename.rename_to.value = '';
document.do_rename.rename_from.value = '';
document.do_rename.ext.value = '';
document.getElementById('do_rename').style.visibility = 'hidden';
document.getElementById('ext').innerHTML='';
}

</script>
