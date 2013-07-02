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

	protected function _initialize($options) {
		if ($this->_initialized) {
			return;
		}

		$options = array_merge(array(
			'scriptPath' => 'jwysiwyg/jquery.wysiwyg.js',
			'cssPath' => '/js/jwysiwyg/jquery.wysiwyg.css',
		), $options);

		if (!$options['scriptPath']) {
			return;
		}

		$this->_initialized = true;
		$this->Html->script($options['scriptPath'], false);
		$this->Html->css($options['cssPath'], null, array('inline' => false));
	}

/**
 * Adds the jwysiwyg.js file and constructs the options
 *
 * @param string $field Name of a field, like this "Modelname.fieldname"
 * @param array $options Array of FckEditor attributes for this textarea
 * @return string JavaScript code to initialise the FckEditor area
 */
	protected function _build($field = null, $options = array()) {
		$options = array_merge(array(
			'bufferScript' => false,
			'scriptPath' => 'jwysiwyg/jquery.wysiwyg.js',
		), $options);

		$this->_initialize($options);

		$domId = $this->domId($field);
		$initOptions = json_encode(array_diff_key($options, array(
			'bufferScript' => true,
			'scriptPath' => true,
		)));

		$script = <<<SCRIPT
jQuery(function () {
	jQuery('#{$domId}').wysiwyg({$initOptions});
});
SCRIPT;

		if (!empty($options['bufferScript'])) {
			$this->Js->buffer($script);
			return '';
		}

		return $this->Html->scriptBlock($script, array('safe' => true));

	}

}
