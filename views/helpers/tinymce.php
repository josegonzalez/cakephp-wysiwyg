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
class TinymceHelper extends AppHelper {
/**
 * Helper dependencies
 *
 * @var array
 */
	var $helpers = array('Form', 'Javascript');

/**
 * Default options for the editor
 *
 * @var boolean
 */
	var $_defaults = array(
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
		);

/**
 * Whether helper has been initialized once or not
 *
 * @var boolean
 */
	var $_initialized = false;

/**
 * Holds the default model for the helper
 *
 * @var string
 */
	var $__defaultModel = null;

/**
 * Holds the model/field pair for the current element
 *
 * @var array
 */
	var $__modelFieldPair = null;

/**
 * Adds the tiny_mce.js file and constructs the options
 *
 * @param string $fieldName Name of a field, like this "Modelname.fieldname", "Modelname/fieldname" is deprecated
 * @param array $options Array of HTML attributes.
 * @param array $tinyoptions Array of TinyMCE attributes for this textarea
 * @return string JavaScript code to initialise the TinyMCE area
 */
	function _build($field, $options = array()) {
		$selector = "data[{$this->__modelFieldPair['model']}][{$this->__modelFieldPair['field']}]";

		if (!$this->_initialized) {
			// We don't want to add this every time, it's only needed once
			$this->_initialized = true;
			$this->Javascript->link('tiny_mce/tiny_mce_src.js', false);
		}

		// Ties the options to the field
		$options['editor_selector'] = $selector;
		$options['elements'] = $this->_name($field);
		$options = Set::merge($this->_defaults, $options);

		return $this->Javascript->codeBlock('tinyMCE.init(' . $this->Javascript->object($options) . ');');
	}

/**
 * Creates a TinyMCE textarea.
 *
 * @param string $fieldName Name of a field, like this "Modelname.fieldname", "Modelname/fieldname" is deprecated
 * @param array $options Array of HTML attributes.
 * @param array $tinyoptions Array of TinyMCE attributes for this textarea
 * @return string An HTML textarea element with TinyMCE
 */
	function input($field, $options = array(), $tinyoptions = array()) {
		$options['type'] = 'textarea';
		$this->__field($field);
		$selector = "data[{$this->__modelFieldPair['model']}][{$this->__modelFieldPair['field']}]";

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
	function textarea($field, $options = array(), $tinyoptions = array()) {
		$options['type'] = 'textarea';
		$this->__field($field);
		$selector = "data[{$this->__modelFieldPair['model']}][{$this->__modelFieldPair['field']}]";

		if (isset($options['class'])) {
			$options['class'] .= ' ' . $selector;
		} else {
			$options['class'] = $selector;
		}

		return $this->Form->textarea($field, $options) . $this->_build($field, $tinyoptions);
	}

/**
 * Returns the modelname and fieldname for the current string
 *
 * @return mixed Array containing modelName and/or fieldName, null in all other cases
 * @author Jose Diaz-Gonzalez
 **/
	function __field($field = null) {
		if (empty($field)) {
			return null;
		}

		$firstToken = strtok($field, '.');
		$secondToken = strtok('.');
		if($secondToken === false) {
			$modelName = $this->__defaultModel();
			$fieldName = $firstToken;
		} else {
			$modelName = $firstToken;
			$fieldName = $secondToken;
		}
		$this->__modelFieldPair = array('model' => $modelName, 'field' => $fieldName);
		return $this->__modelFieldPair;
	}

/**
 * Gets the default model of the paged sets
 *
 * @return string Model name or the inflected controller name if the model isn't initialized. Null in all other cases
 */
	function __defaultModel() {
		if ($this->__defaultModel != null) {
			return $this->__defaultModel;
		} else {
			if (!empty($this->params['controller'])) {
				$this->__defaultModel = Inflector::classify($this->params['controller']);
			}
		}
		return $this->__defaultModel;
	}
}
?>