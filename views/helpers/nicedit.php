<?php
/**
 * NicEditHelper is a helper for NicEdit
 * This helper REQUIRES the NicEdit javascript files.
 *
 * @author: Jose Diaz-Gonzalez
 * @version: 1.0
 * @link: 
 */
class NiceditHelper extends AppHelper {
// Take advantage of other helpers
	var $helpers = array('Form', 'Javascript');
// Check if the tiny_mce.js file has been added or not
	var $_script = false;
/**
 * Adds the nicedit.js file and constructs the options
 *
 * @return void
 */
	function _build($field = null, $nicOptions = array()) {
		if (!$this->_script) {
			// We don't want to add this every time, it's only needed once
			$this->_script = true;
			$this->Javascript->link('nicedit/nicEdit.js', false);
		}
		return $this->Javascript->codeBlock(
			"
			var area1;
			function makePanel() {
				area1 = new nicEditor({fullPanel : true}).panelInstance('" . strtok($field, '.') . ucfirst(strtok('.')) . "',{hasPanel : true});
			}
			bkLib.onDomLoaded(function() { makePanel(); });",
			array('safe' => false));
	}

	function input($field = null, $options = array(), $nicOptions = array()) {
		return $this->Form->input($field, $options) . $this->_build($field, $nicOptions);
	}

	function textarea($field = null, $options = array(), $nicOptions) {
		return $this->Form->textarea($field, $options) . $this->_build($field, $nicOptions);
	}
}
?>