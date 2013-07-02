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

	protected function _initialize($options) {
		if ($this->_initialized) {
			return;
		}

		$options = array_merge(array(
			'scriptPath' => 'nicedit/nicEdit.js',
		), $options);

		if (!$options['scriptPath']) {
			return;
		}

		$this->_initialized = true;
		$this->Html->script($options['scriptPath'], false);
		$css = <<<CSS
form div.nicEdit-main,
form div.nicEdit-panelContain,
form div.nicEdit-panelContain div {
	clear: none;
	margin-bottom: 0;
	padding: 0;
}
CSS;
		$out = $this->Html->tag('style', $css);
		$this->_View->append('css', $out);
	}

/**
 * Adds the nicedit.js file and constructs the options
 *
 * @param string $field Name of a field, like this "Modelname.fieldname"
 * @param array $options Array of NicEdit attributes for this textarea
 * @return string JavaScript code to initialise the NicEdit area
 * @link http://wiki.nicedit.com/w/page/515/Configuration%20Options NicEdit Configuration Options
 */
	protected function _build($field = null, $options = array()) {
		$options = array_merge(array(
			'bufferScript' => false,
			'scriptPath' => 'nicedit/nicEdit.js',
		), $options);

		$this->_initialize($options);

		$domId = $this->domId($field);
		$initOptions = json_encode(array_diff_key($options, array(
			'bufferScript' => true,
			'scriptPath' => true,
		)));

		if (!isset($options['fullPanel'])) {
			$options['fullPanel'] = true;
		}

		$script = <<<SCRIPT
var area1_{$domId};
function makePanel_{$domId}() {
	area1_{$domId} = new nicEditor({$initOptions}).panelInstance(
		'{$domId}',
		{hasPanel : true}
	);
}
bkLib.onDomLoaded(function() { makePanel_{$domId}(); });
SCRIPT;

		if (!empty($options['bufferScript'])) {
			$this->Js->buffer($script);
			return '';
		}

		return $this->Html->scriptBlock($script, array('safe' => true));
	}

}
