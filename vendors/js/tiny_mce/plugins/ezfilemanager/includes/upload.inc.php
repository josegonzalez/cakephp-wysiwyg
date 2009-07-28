<?php
if (!defined('LANG'))
die();
?>
<fieldset>
<legend><?php echo TXT_UPLOAD_TO?>: <?php echo CURRENT_DIR;?></legend>
<div class='uploadlist'>
<form action="do_upload.php?type=<?php echo THE_TYPE?>" method="post" enctype="multipart/form-data" name="upload_form" id="upload_form" name="upload_form" target="all_iframe" onsubmit="return do_upload(this);">
<span id='uploaddiv1'>
<?php echo TXT_SELECT_FILE." (".bytestostring($ezfilemanager['maxsize'][THE_TYPE]).")";?>
<br />
<input type="file" name="filename1" id="filename1"   class='fieldtextfile'  onchange="updateFileName(this,'1')" />&nbsp;
<br>
<?php echo TXT_RENAME?><br />
<input id="newfilename1" name="newfilename1" type="text" size="35" class='fieldtext' maxlength="200" style="width: 180px" value="" />
<?php for ($i = 2; $i <= MAX_SIM_UPLOAD; $i++) {
echo "<span id='uploaddiv".($i)."'></span>";

}
?>
</span>

<br />
<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $ezfilemanager['maxsize'][THE_TYPE]?>">
<input type='hidden' name='type' id='type' value='<?php echo THE_TYPE?>' />
<input type='hidden' name='upload_path' id='upload_path' value='<?php echo WORKING_PATH?>' />
<input type="submit" value="<?php echo TXT_UPLOAD?>"  id='submit1' name='submit1'  class="button" />
<input type="hidden" name="numfiles"  id="numfiles" value="1" />
<?php if (MAX_SIM_UPLOAD>1){?>
<input type="button" name="addupload"  id='addupload' value="<?php echo TXT_UPLOAD_ADD;?>" class="button" onclick="addnewupload();" />
<input type='button' name='remupload' id='remupload' value='X' class='buttonremove' onClick='remove_upload();'>
<?php }?>
</form>
<div id='upload_noticearea' class='messagenotice' style='visibility:hidden'></div></div>
</fieldset><div class='thenotice'>
<?php echo allowedFileNotice();?>
</div>

<script type="text/javascript">
function addnewupload(){

var html = "";
var file_to_upload=(parseInt(document.forms['upload_form'].numfiles.value)+1);
var spanid = "uploaddiv"+(parseInt(document.forms['upload_form'].numfiles.value)+1);
if (file_to_upload<=<?php echo MAX_SIM_UPLOAD ?>){
html += '<hr /><?php echo TXT_SELECT_FILE." (".bytestostring($ezfilemanager['maxsize'][THE_TYPE]).")";?>
<br />';
	html += '<input type="file" name="filename'+file_to_upload+'" id="filename'+file_to_upload+'"   class="fieldtextfile"  onchange="updateFileName(this,\''+file_to_upload+'\')" />';
	html += '<br /><?php echo TXT_RENAME?>';
	html += '<br /><input id="newfilename'+file_to_upload+'" name="newfilename'+file_to_upload+'" type="text" size="35" class="fieldtext" maxlength="200" style="width: 180px" value="" />';
document.forms['upload_form'].numfiles.value = file_to_upload;
document.getElementById('remupload').style.visibility = 'visible';
x=document.getElementById(spanid);
x.innerHTML=html;
if (file_to_upload==<?php echo MAX_SIM_UPLOAD ?>){
document.getElementById('addupload').style.visibility = 'hidden';
document.getElementById('addupload').style.width = '1px';
}
}else{
alert('max limit');
}

}
function remove_upload() {
var file_to_remove=document.forms['upload_form'].numfiles.value;
if (file_to_remove>1){
var file_to_upload=(parseInt(document.forms['upload_form'].numfiles.value)-1);
document.forms['upload_form'].numfiles.value = file_to_upload;
try {
x=document.getElementById('uploaddiv'+file_to_remove);
x.innerHTML="";
} catch (e) { }
}
if (file_to_remove==2)
document.getElementById('remupload').style.visibility = 'hidden';
if (file_to_remove<=<?php echo MAX_SIM_UPLOAD ?>){
document.getElementById('addupload').style.visibility = 'visible';
document.getElementById('addupload').style.width = '';
}

}//

function updateFileName(thefile,theid) {
	var uploadfileName = thefile.value;
	var renameto="newfilename"+theid;
	var pos = uploadfileName.lastIndexOf('/');
	pos = pos == -1 ? uploadfileName.lastIndexOf('\\') : pos;
	
	if (pos > 0) {
		uploadfileName = uploadfileName.substring(pos+1);
		if ((pos = uploadfileName.lastIndexOf('.')) != -1)
			uploadfileName = uploadfileName.substring(0, pos);
    	document.getElementById(renameto).value =  uploadfileName;
		
	}else{
	
	if ((pos = uploadfileName.lastIndexOf('.')) != -1)
			uploadfileName = uploadfileName.substring(0, pos);
	document.getElementById(renameto).value = uploadfileName;
	}
}
function do_upload(theform){
var tmp = <?php echo make_java_array();?>;
var files = document.getElementById('numfiles').value;
for (x=1; x<=files; x++) 
{
	var  thefilname="filename"+x;
	var ext = document.getElementById(thefilname).value
	ext = ext.substring(ext.length-3,ext.length);
 	ext = ext.toLowerCase();
		if(ext == '') 
		{
		alert('<?php echo TXT_UPLOAD?> '+ x +': <?php echo TXT_FILE_NO?>');
  		return false; 
		}
		var validExt=tmp.find(ext); 
		  if(!validExt) 
		{
		alert('<?php echo TXT_UPLOAD?> '+ x +': <?php echo TXT_FILE_INVALID?> ['+ext+']');
		return false; 
		}

}
        document.getElementById('upload_noticearea').innerHTML = '<?php echo TXT_UPLOADING?>';
		document.getElementById('upload_noticearea').style.visibility = 'visible';
   		return true; 
}
Array.prototype.find = function(searchStr) {  
var returnArray = false;  
for (i=0; i<this.length; i++) {    
if (typeof(searchStr) == 'function') {      
if (searchStr.test(this[i])) {        
if (!returnArray) { returnArray = [] }        
returnArray.push(i);      }    
} else {      
if (this[i]===searchStr) {        
if (!returnArray) { returnArray = [] }        
returnArray.push(i);      
}    
}  
}  
return returnArray;
}
</script>