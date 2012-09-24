<?php
/**
 * Wysiwyg App Helper class file.
 *
 * Base WysiwygHelper class
 *
 * Copyright 2009-2012, Jose Diaz-Gonzalez (http://josediazgonzalez.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2009-2012, Jose Diaz-Gonzalez (http://josediazgonzalez.com)
 * @link          http://github.com/josegonzalez/cakephp-wysiwyg-plugin
 * @package       Wysiwyg.View.Helper
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('AppHelper', 'View/Helper');

/**
 * Wysiwyg App Helper class
 *
 * WysiwygAppHelper encloses all methods needed while working with HTML pages.
 *
 * @package       Wysiwyg.View.Helper
 * @link http://github.com/josegonzalez/cakephp-wysiwyg-plugin
 * @property FormHelper $Form
 * @property HtmlHelper $Html
 * @property JsHelper $Js
 */

class WysiwygAppHelper extends AppHelper {

/**
 * Helper dependencies
 *
 * @var array
 */
	public $helpers = array('Form', 'Html', 'Js');

/**
 * Whether helper has been initialized once or not
 *
 * @var boolean
 */
	protected $_initialized = false;

/**
 * Holds the default model for the helper
 *
 * @var string
 */
	protected $_defaultModel = null;

/**
 * Holds the model/field pair for the current element
 *
 * @var array
 */
	protected $_modelFieldPair = array();

/**
 * Creates an fckeditor input field
 *
 * @param string $field - used to build input name for views,
 * @param array $options Array of HTML attributes.
 * @param array $fckOptions Array of FckEditor attributes for this input field
 * @return string An HTML input element with FckEditor
 */
	public function input($fieldName = null, $options = array(), $helperOptions = array()) {
		return $this->Form->input($fieldName, $options) . $this->_build($fieldName, $helperOptions);
	}

/**
 * Creates an fckeditor textarea
 *
 * @param string $field - used to build input name for views,
 * @param array $options Array of HTML attributes.
 * @param array $fckOptions Array of FckEditor attributes for this textarea
 * @return string An HTML textarea element with FckEditor
 */
	public function textarea($fieldName = null, $options = array(), $helperOptions = array()) {
		return $this->Form->textarea($fieldName, $options) . $this->_build($fieldName, $helperOptions);
	}

/**
 * Returns the modelname and fieldname for the current string
 *
 * @return mixed Array containing modelName and/or fieldName, null in all other cases
 * @author Jose Diaz-Gonzalez
 **/
	protected function _field($field = null) {
		if (isset($this->_modelFieldPair[$field])) {
			return $this->_modelFieldPair[$field];
		}

		if (empty($field)) {
			return null;
		}

		$firstToken = strtok($field, '.');
		$secondToken = strtok('.');
		if ($secondToken === false) {
			$modelName = $this->_defaultModel();
			$fieldName = $firstToken;
		} else {
			$modelName = $firstToken;
			$fieldName = $secondToken;
		}
		return $this->_modelFieldPair[$field] = compact('modelName', 'fieldName');
	}

/**
 * Gets the default model of the paged sets
 *
 * @return string Model name or the inflected controller name if the model isn't initialized. Null in all other cases
 */
	protected function _defaultModel() {
		if ($this->_defaultModel != null) {
			return $this->_defaultModel;
		}

		if (!empty($this->params['controller'])) {
			$this->_defaultModel = Inflector::classify($this->params['controller']);
		}

		return $this->_defaultModel;
	}

}