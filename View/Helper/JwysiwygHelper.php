<?php
/**
 * JwysiwygHelper is a helper for jWysiwyg
 * This helper REQUIRES the jwysiwyg + jquery installation files.
 * Get jwysiwyg from : http://code.google.com/p/jwysiwyg/
 *
 * @package       cake
 * @subpackage    cake.app.plugins.wysiwyg.views.helpers
 * @author:       Jose Diaz-Gonzalez
 * @author:       Rachman Chavik
 * @version:      1.1
 * @email:        support@savant.be
 * @site:         http://josediazgonzalez.com
 */
App::uses('WysiwygAppHelper', 'Wysiwyg.View/Helper');

class JwysiwygHelper extends WysiwygAppHelper {

/**
 * Adds the jwysiwyg.js file and constructs the options
 *
 * @param string $field Name of a field, like this "Modelname.fieldname"
 * @param array $options Array of FckEditor attributes for this textarea
 * @return string JavaScript code to initialise the FckEditor area
 */
	protected function _build($field = null, array $options = array()) {
		$options = json_encode($options);

		if (!$this->_initialized) {
			$this->_initialized = true;
			$this->Html->script('jwysiwyg/jquery.wysiwyg', false);
		}

		$field = $this->_field($field);
		return $this->Html->scriptBlock("jQuery(function () {
			jQuery('#{$field['modelName']}{$field['fieldName']}').wysiwyg({$options});
		});", array('safe' => false, 'inline' => false));
	}

}