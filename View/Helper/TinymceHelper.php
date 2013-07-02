<?php
/**
 * TinyMCEHelper is a helper for TinyMCE
 * This helper REQUIRES the TinyMCE installation files.
 * Based on David Boyer's helper at http://bakery.cakephp.org/articles/view/tinymce-helper-1
 *
 * @package       cake
 * @subpackage    cake.app.plugins.wysiwyg.views.helpers
 * @author:       Jose Diaz-Gonzalez
 * @version:      1.2
 * @email:        support@savant.be
 * @site:         http://josediazgonzalez.com
 */
App::uses('WysiwygAppHelper', 'Wysiwyg.View/Helper');

class TinymceHelper extends WysiwygAppHelper {


	protected function _initialize($options) {
		if ($this->_initialized) {
			return;
		}

		$options = array_merge(array(
			'scriptPath' => 'tinymce/tinymce.min.js',
		), $options);

		if (!$options['scriptPath']) {
			return;
		}

		$this->_initialized = true;
		$this->Html->script($options['scriptPath'], false);
	}

/**
 * Adds the tiny_mce.js file and constructs the options
 *
 * @param string $fieldName Name of a field, like this "Modelname.fieldname", "Modelname/fieldname" is deprecated
 * @param array $options Array of HTML attributes.
 * @param array $tinyoptions Array of TinyMCE attributes for this textarea
 * @return string JavaScript code to initialise the TinyMCE area
 */
	protected function _build($field, $options = array()) {
		$options = array_merge(array(
			'bufferScript' => false,
			'scriptPath' => 'tinymce/tinymce.min.js',
		), $options);

		$this->_initialize($options);

		$domId = $this->domId($field);
		$options['selector'] = "#{$domId}";
		$initOptions = json_encode(array_diff_key($options, array(
			'bufferScript' => true,
			'scriptPath' => true,
		)));

		$script = 'tinyMCE.init(' . $initOptions . ');';

		if (!empty($options['bufferScript'])) {
			$this->Js->buffer($script);
			return '';
		}

		return $this->Html->scriptBlock($script, array('safe' => true));
	}

}
