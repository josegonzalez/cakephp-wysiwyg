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
 * @param array $options Array of NicEdit attributes for this textarea
 * @return string JavaScript code to initialise the NicEdit area
 * @link http://wiki.nicedit.com/w/page/515/Configuration%20Options NicEdit Configuration Options
 */
	protected function _build($field = null, $options = array()) {
		$defaults = array(
			'nicEditPath' => 'nicedit/nicEdit.js',
			'bufferScript' => false,
			'fullPanel' => true,
			'iconsPath' => $this->url('/js/nicedit/nicEditorIcons.gif'),
		);
		$helperOptionKey = array(
			'nicEditPath' => true,
			'bufferScript' => true,
		);

		$options = array_merge($defaults, $options);

		if (!$this->_initialized) {
			$this->_initialized = true;
			$this->Html->script($options['nicEditPath'], false);
		}

		$initOptions = array_diff_key($options, $helperOptionKey);
		$initOptions = json_encode($initOptions);
		$domId = $this->domId($field);

		$script = "var area1;
			function makePanel() {
				area1 = new nicEditor({$initOptions}).panelInstance(
					'{$domId}',
					{hasPanel : true}
				);
			}
			bkLib.onDomLoaded(function() { makePanel(); });";

		if (isset($options['bufferScript'])) {
			$this->Js->buffer($script);
			return '';
		}

		return $this->Html->scriptBlock($script, array('safe' => true));
	}

}