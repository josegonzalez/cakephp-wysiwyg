<?php
/**
 * NicEditHelper is a helper for NicEdit
 * This helper REQUIRES the NicEdit installation files.
 *
 * @package       cake
 * @subpackage    cake.app.plugins.wysiwyg.views.helpers
 * @author:       Jose Diaz-Gonzalez
 * @version:      1.1
 * @email:        support@savant.be
 * @site:         http://josediazgonzalez.com
 */

App::uses('WysiwygAppHelper', 'Wysiwyg.View/Helper');

class NiceditHelper extends WysiwygAppHelper {

/**
 * Adds the nicedit.js file and constructs the options
 *
 * @param string $field Name of a field, like this "Modelname.fieldname"
 * @param array $options Array of FckEditor attributes for this textarea
 * @return string JavaScript code to initialise the FckEditor area
 */
	public function _build($field = null, $options = array()) {
		if (!$this->_initialized) {
			$this->_initialized = true;
			$this->Html->script('nicedit/nicEdit.js', false);
		}

		$field = $this->_field($field);
		return $this->Html->scriptBlock("public area1;
			function makePanel() {
				area1 = new nicEditor({fullPanel : true}).panelInstance(
					'{$field['modelName']}{$field['fieldName']}',
					{hasPanel : true}
				);
			}
			bkLib.onDomLoaded(function() { makePanel(); });
		", array('safe' => false));
	}

}