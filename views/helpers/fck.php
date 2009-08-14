<?php
/**
 * FCKHelper is a helper for FCKEditor.
 * This helper REQUIRES the FCKEditor.
 *
 * @author: Jose Diaz-Gonzalez
 * @version: 1.0
 * @email: support@savant.be
 * @site: http://josediazgonzalez.com
 */
class FckHelper extends AppHelper {
// Take advantage of other helpers
	var $helpers = array('Html', 'Form', 'Javascript');
// Check if the tiny_mce.js file has been added or not
	var $_script = false;

/**
 * Adds the fckeditor.js file and constructs the options
 *
 * @param string $fieldName Name of a field, like this "Modelname.fieldname"
 * @param array $fckoptions Array of FckEditor attributes for this textarea
 * @return string JavaScript code to initialise the FckEditor area
 */
	function _build($field, $fckOptions = array()) {
		$fckOptions = array_merge(
			array(
				'basepath' => $this->Html->base,
				'fckPath' => '/js/fckeditor/',
				'content' => '',
				'toolbarSet' => 'Default',
				'skinPath' => 'editor/skins/',
				'skin' => 'default'),
			$fckOptions);

		if (!$this->_script) {
			// We don't want to add this every time, it's only needed once
			$this->_script = true;
			$this->Javascript->link('fckeditor/fckeditor.js', false);
		}

		return $this->Javascript->codeBlock(
			"window.onload = function() {
				var oFCKeditor = new FCKeditor('data[" . strtok($field, '.') . "][" . strtok('.') . "]');
				oFCKeditor.BasePath = \"" . $fckOptions['basepath'] . $fckOptions['fckPath'] . "\";
				oFCKeditor.Config['SkinPath'] = \"" . $fckOptions['fckPath'] . $fckOptions['skinPath'] . $fckOptions['skin'] . '/' . "\";
				oFCKeditor.Value = \"" . $fckOptions['content'] . "\";
				oFCKeditor.ToolbarSet = \"" . $fckOptions['toolbarSet'] . "\";
				oFCKeditor.ReplaceTextarea();
			}
			", array('safe' => false, 'inline' => false)
		);
	}

/**
* Creates an fckeditor input field
*
* @param string $field - used to build input name for views, 
* @param array $options Array of HTML attributes.
* @param array $fckOptions Array of FckEditor attributes for this textarea
* @return string An HTML input element with FckEditor
*/
	function input($field = null, $options = array(), $fckOptions = array()){
		return $this->Form->input($field, $options) . $this->_build($field, $fckOptions);
	}

/**
* Creates an fckeditor textarea
*
* @param string $field - used to build input name for views, 
* @param array $options Array of HTML attributes.
* @param array $fckOptions Array of FckEditor attributes for this textarea
* @return string An HTML textarea element with FckEditor
*/
	function textarea($field = null, $options = array(), $fckOptions = array()){
		return $this->Form->textarea($field, $options) . $this->_build($field, $fckOptions);
	}
}
?>