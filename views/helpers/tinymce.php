<?php
/**
 * TinyMCEHelper is a helper for TinyMCE
 * This helper REQUIRES the TinyMCE installation.
 * Based on David Boyer's helper at http://bakery.cakephp.org/articles/view/tinymce-helper-1
 * 
 * @author: Jose Diaz-Gonzalez
 * @version: 1.1
 * 
 */
class TinyMceHelper extends AppHelper {
	// Take advantage of other helpers
	var $helpers = array('Javascript', 'Form');
	// Check if the tiny_mce.js file has been added or not
	var $_script = false;
	// This keeps track of the times the helper was used
	var $used = 0;

	/**
	 * Adds the tiny_mce.js file and constructs the options
	 *
	 * @param string $fieldName Name of a field, like this "Modelname.fieldname", "Modelname/fieldname" is deprecated
	 * @param array $tinyoptions Array of TinyMCE attributes for this textarea
	 * @return string JavaScript code to initialise the TinyMCE area
	 */
	function _build($fieldName, $tinyoptions = array()) {
		if (!$this->_script) {
			// We don't want to add this every time, it's only needed once
			$this->_script = true;
			$this->Javascript->link('tiny_mce/tiny_mce_src.js', false);
		}
		// Ties the options to the field
		$tinyoptions['mode'] = 'textareas';
		$tinyoptions['elements'] = $this->__name($fieldName);
		$tinyoptions['skin'] = 'o2k7';
		$tinyoptions['theme'] = 'advanced';
		$tinyoptions['file_browser_callback'] = 'fileBrowserCallBack';
		$tinyoptions['plugins'] = 'advhr,preview';
		$tinyoptions['theme_advanced_buttons3_add'] = 'advhr,preview';
		$tinyoptions['extended_valid_elements'] = 'hr[class|width|size|noshade]';
		
		echo $this->Javascript->codeBlock(
			"function fileBrowserCallBack(field_name, url, type, win) {
				browserField = field_name;
				browserWin = win;
				window.open('".Helper::url(array('controller' => 'images', 'action' => 'tinymce'))."', 'browserWindow', 'modal,width=600,height=400,scrollbars=yes');
			}"
		);
		return $this->Javascript->codeBlock('tinyMCE.init(' . $this->Javascript->object($tinyoptions) . ');');
	}

	/**
	 * Creates a TinyMCE textarea.
	 *
	 * @param string $fieldName Name of a field, like this "Modelname.fieldname", "Modelname/fieldname" is deprecated
	 * @param array $options Array of HTML attributes.
	 * @param array $tinyoptions Array of TinyMCE attributes for this textarea
	 * @return string An HTML textarea element with TinyMCE
	 */
	function textarea($fieldName, $options = array(), $tinyoptions = array()) {
		$options['type'] = 'textareas';
		$selector = "mceTextArea{$this->used}";
		$tinyoptions = array(
			'editor_selector' => $selector,
			'mode' => "specific_textareas"
		);
		$options['class'] = (isset($options['class'])) ? $options['class'].$selector : $options['class'] = $selector;
		return $this->Form->textarea($fieldName, $options) . $this->_build($fieldName, $tinyoptions);
	}

	/**
	 * Creates a TinyMCE textarea.
	 *
	 * @param string $fieldName Name of a field, like this "Modelname.fieldname", "Modelname/fieldname" is deprecated
	 * @param array $options Array of HTML attributes.
	 * @param array $tinyoptions Array of TinyMCE attributes for this textarea
	 * @return string An HTML textarea element with TinyMCE
	 */
	function input($fieldName, $options = array(), $tinyoptions = array()) {
		$options['type'] = 'textarea';
		$selector = "mceInputArea{$this->used}";
		$tinyoptions = array(
			'editor_selector' => $selector,
			'mode' => "specific_textareas"
		);
		$options['class'] = (isset($options['class'])) ? $options['class'].$selector : $options['class'] = $selector;
		return $this->Form->input($fieldName, $options) . $this->_build($fieldName, $tinyoptions);
	}
}
?>