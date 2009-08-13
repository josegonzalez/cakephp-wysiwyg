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
	var $helpers = array('Javascript');

	function input() {
		return $this->_edit();
	}

	function textarea() {
		return $this->_edit();
	}

	/**
	 * Adds the nicedit.js file and constructs the options
	 *
	 * @return void
	 */
	function _edit() {
		$value = $this->Javascript->link('nicedit/nicEdit.js');
		$value .= $this->Javascript->codeBlock('bkLib.onDomLoaded(nicEditors.allTextAreas);', array('safe' => false));
		return $value;
	}

}
?>