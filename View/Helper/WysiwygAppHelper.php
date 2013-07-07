<?php
/**
 * Wysiwyg App Helper class file.
 *
 * Base WysiwygHelper class
 *
 * Copyright 2009, Jose Diaz-Gonzalez (http://josediazgonzalez.com)
 *
 * Licensed under The MIT License
 *
 * @copyright     Copyright 2009, Jose Diaz-Gonzalez (http://josediazgonzalez.com)
 * @link          http://github.com/josegonzalez/cakephp-wysiwyg-plugin
 * @package       Wysiwyg
 * @subpackage    Wysiwyg.View.Helper
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
 * Array of defaults configuration for editors, specified when
 * importing Wysiwyg in your controller. For example:
 *
 *   public $helpers = array(
 *     'Wysiwyg.Tinymce' => array(
 *       'theme_advanced_toolbar_align' => 'right',
 *     )
 *   );
 */
	protected $_helperOptions = array();

/**
 * Sets the $this->helper to the helper configured in the session
 *
 * @param View $View The View this helper is being attached to.
 * @param array $settings Configuration settings for the helper.
 * @return void
 **/
	public function __construct(View $View, $settings = array()) {
		parent::__construct($View, $settings);
		$settings = array_merge(array('_editor' => 'tinymce'), (array)$settings);
		$this->_helperOptions = $settings;
	}

/**
 * Creates an fckeditor input field
 *
 * @param string $fieldName This should be "Modelname.fieldname"
 * @param array $options Each type of input takes different options.
 * @param array $helperOptions Each type of wysiwyg helper takes different options.
 * @return string An HTML input element with Wysiwyg Js
 */
	public function input($fieldName, $options = array(), $helperOptions = array()) {
		$helperOptions = Set::merge($this->_helperOptions, $helperOptions);
		return $this->Form->input($fieldName, $options) . $this->_build($fieldName, $helperOptions);
	}

/**
 * Creates an fckeditor textarea
 *
 * @param string $fieldName This should be "Modelname.fieldname"
 * @param array $options Each type of input takes different options.
 * @param array $helperOptions Each type of wysiwyg helper takes different options.
 * @return string An HTML textarea element with Wysiwyg Js
 */
	public function textarea($fieldName, $options = array(), $helperOptions = array()) {
		$helperOptions = Set::merge($this->_helperOptions, $helperOptions);
		return $this->Form->textarea($fieldName, $options) . $this->_build($fieldName, $helperOptions);
	}

/**
 * Initialize the helper css and js for a given input field
 *
 * @param array $options array of css files, javascript files, and css text to enqueue
 * @return void
 **/
	protected function _initialize($options = array()) {
		if ($this->_initialized) {
			return;
		}

		$this->_initialized = true;
		if (!empty($options['_css'])) {
			foreach ((array)$options['_css'] as $css) {
				$this->Html->css($css, null, array('inline' => false));
			}
		}

		if (!empty($options['_cssText'])) {
			$out = $this->Html->tag('style', $options['_cssText']);
			$this->_View->append('css', $out);
		}

		if (!empty($options['_scripts'])) {
			foreach ((array)$options['_scripts'] as $script) {
				$this->Html->script($script, false);
			}
		}
	}

/**
 * Returns a json string containing helper settings
 *
 * @param array $options array of Wysiwyg editor settings
 * @return string json_encoded array of options
 **/
	protected function _initializationOptions($options = array()) {
		$defaults = array(
			'_buffer' => true,
			'_css' => true,
			'_cssText' => true,
			'_scripts' => true,
			'_editor' => true,
		);

		return json_encode(array_diff_key(array_merge(
			$defaults,
			(array)$options
		), $defaults));
	}

}
