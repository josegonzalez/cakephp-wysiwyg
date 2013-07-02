<?php
/**
 * markItUp! Helpers
 * @author Jay Salvat
 * @version 1.1
 *
 * Download markItUp! at:
 * http://markitup.jaysalvat.com
 * Download jQuery at:
 * http://jquery.com
 */
App::uses('WysiwygAppHelper', 'Wysiwyg.View/Helper');

class MarkitupHelper extends WysiwygAppHelper {

/**
 * Generates a form textarea element complete with label and wrapper div with markItUp! applied.
 * @param  string $fieldName This should be "Modelname.fieldname"
 * @param  array $settings
 * @return string  An <textarea /> element.
 */
	protected function _build($field = null, $options = array()) {
		$options = array_merge(array(
			'bufferScript' => false,
			'scriptPath' => 'markitup/jquery.markitup.js',
			'settings' => false,
		), $options);

		$this->_initialize($options);
		$domId = $this->domId($field);

		$initOptions = array_diff_key($options, array(
			'bufferScript' => true,
			'scriptPath' => true,
		));

		if (!empty($initOptions)) {
			if (isset($initOptions['settings'])) {
				if ($initOptions['settings']) {
					$initOptions = $initOptions['settings'];
				} else {
					$initOptions = 'mySettings';
				}
			} else {
				$initOptions = json_encode($initOptions);
			}
		} else {
			$initOptions = 'mySettings';
		}

		$script = <<<SCRIPT
$(document).ready(function() {
	jQuery("#{$domId}").markItUp({$initOptions});
});
SCRIPT;


		if (!empty($options['bufferScript'])) {
			$this->Js->buffer($script);
			return '';
		}

		return $this->Html->scriptBlock($script, array('safe' => true));
	}

/**
 * Adds jQuery and markItUp! scripts to the page
 */
	protected function _initialize($options) {
		if ($this->_initialized) {
			return;
		}

		$options = array_merge(array(
			'scriptPath' => 'markitup/jquery.markitup.js',
			'setPath' => '/js/markitup/sets/default',
			'skinPath' => '/js/markitup/skins/markitup',
		), $options);

		if (!$options['scriptPath']) {
			return;
		}

		$this->_initialized = true;
		$this->Html->script('jquery.js', false);
		$this->Html->script($options['scriptPath'], false);
		$this->Html->script($options['setPath'] . '/set.js', false);
		$this->Html->css($options['skinPath'] . '/style.css', null, array('inline' => false));
		$this->Html->css($options['setPath'] . '/style.css', null, array('inline' => false));
	}

}
