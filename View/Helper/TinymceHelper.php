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

/**
 * Adds the tiny_mce.js file and constructs the options
 *
 * @param string $fieldName Name of a field, like this "Modelname.fieldname", "Modelname/fieldname" is deprecated
 * @param array $options Array of HTML attributes.
 * @param array $tinyoptions Array of TinyMCE attributes for this textarea
 * @return string JavaScript code to initialise the TinyMCE area
 */
	protected function _build($field, $options = array()) {
		$field = $this->_field($field);

		if (!$this->_initialized) {
			$this->_initialized = true;
			$this->Html->link('tiny_mce/tiny_mce_src.js', false);
		}

		// Ties the options to the field
		$options['editor_selector'] = "data[{$field['modelName']}][{$field['fieldName']}]";
		$options['elements'] = $this->_name($field);

		$options = array_merge(array(
			'mode' => 'textareas',
			'theme' => 'advanced',
			'skin' => 'default',
			'theme_advanced_buttons1' => 'bold,italic,underline,separator,strikethrough,justifyleft,justifycenter,justifyright,justifyfull,bullist,numlist,undo,redo,link,unlink,image',
			'theme_advanced_buttons2' => '',
			'theme_advanced_buttons3' => '',
			'theme_advanced_toolbar_location' => 'top',
			'theme_advanced_toolbar_align' => 'left',
			'theme_advanced_statusbar_location' => 'bottom',
			'plugins' => 'inlinepopups',
		), $options);

		return $this->Html->scriptBlock('tinyMCE.init(' . json_encode($options) . ');');
	}

/**
 * Creates a TinyMCE textarea.
 *
 * @param string $fieldName Name of a field, like this "Modelname.fieldname", "Modelname/fieldname" is deprecated
 * @param array $options Array of HTML attributes.
 * @param array $tinyoptions Array of TinyMCE attributes for this textarea
 * @return string An HTML textarea element with TinyMCE
 */
	public function input($field, $options = array(), $tinyoptions = array()) {
		$options['type'] = 'textarea';
		$this->_field($field);
		$selector = "data[{$this->_modelFieldPair['model']}][{$this->_modelFieldPair['field']}]";

		if (isset($options['class'])) {
			$options['class'] .= ' ' . $selector;
		} else {
			$options['class'] = $selector;
		}

		return $this->Form->input($field, $options) . $this->_build($field, $tinyoptions);
	}

/**
 * Creates a TinyMCE textarea.
 *
 * @param string $fieldName Name of a field, like this "Modelname.fieldname", "Modelname/fieldname" is deprecated
 * @param array $options Array of HTML attributes.
 * @param array $tinyoptions Array of TinyMCE attributes for this textarea
 * @return string An HTML textarea element with TinyMCE
 */
	public function textarea($field, $options = array(), $tinyoptions = array()) {
		$options['type'] = 'textarea';
		$this->_field($field);
		$selector = "data[{$this->_modelFieldPair['model']}][{$this->_modelFieldPair['field']}]";

		if (isset($options['class'])) {
			$options['class'] .= ' ' . $selector;
		} else {
			$options['class'] = $selector;
		}

		return $this->Form->textarea($field, $options) . $this->_build($field, $tinyoptions);
	}

}