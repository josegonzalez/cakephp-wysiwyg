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

}
