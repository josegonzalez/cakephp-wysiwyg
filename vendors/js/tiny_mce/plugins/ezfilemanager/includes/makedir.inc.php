
<fieldset>
<legend><?php echo TXT_MAKE_DIR_IN?>: <?php echo CURRENT_DIR;?></legend>
<form action="do_makedir.php?type=<?php echo THE_TYPE?>" method="post" enctype="multipart/form-data" id="makedir_form" name="makedir_form" target="all_iframe" onsubmit="return do_makedir();">
<?php echo TXT_NEW_DIR;?>
<br />
<input type='text' name='newdir' id='newdir' class='fieldtext' style='width:250px' />
<br />
<input type='hidden' name='upload_path' id='upload_path' value='<?php echo WORKING_PATH?>'>
<input type="submit" value="<?php echo TXT_MAKE?>"  id='submit1' name='submit1' />
</form>
<div id='makedir_noticearea' class='messagenotice' style='visibility:hidden'></div>
</fieldset>
<script type="text/javascript">
function do_makedir(){
var ext = document.makedir_form.newdir.value;
  if(ext == '') {
    alert('<?php echo TXT_FILE_NO?>');
    return false; 
	}
  else {
document.getElementById('makedir_noticearea').innerHTML = '<?php echo TXT_CREATING?>';
document.getElementById('makedir_noticearea').style.visibility = 'visible';
 return true; 
}
  return false;
}

</script>