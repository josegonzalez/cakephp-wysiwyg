<?php
/**
 * Wysiwyg is a helper for outputting .
 * This helper REQUIRES the installation files for the wysiwyg helpers you will use
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

App::uses('WysiwygAppHelper', 'Wysiwyg.View/Helper');

class WysiwygHelper extends WysiwygAppHelper {

/**
 * Helper dependencies
 *
 * @public array
 */
	public $helpers = array();

/**
 * Default Helper to use
 *
 * @public string
 **/
	public $helper = '';

/**
 * Array of whether a certain helper has been imported yet
 *
 */
	public $importedHelpers = array(
		'Ck' => false,
		'Jwysiwyg' => false,
		'Nicedit' => false,
		'Markitup' => false,
		'Tinymce' => false
	);

/**
 * Sets the $this->helper to the helper configured in the session
 *
 * @param View $View The View this helper is being attached to.
 * @param array $settings Configuration settings for the helper.
 * @return void
 **/
	public function __construct(View $View, $settings = array()) {
		parent::__construct($View, $settings);
		$this->changeEditor($this->_helperOptions['_editor']);
	}

/**
 * Overrides helper settings
 *
 * @param array $helperOptions Each type of wysiwyg helper takes different options.
 * @return void
 **/
	public function updateSettings($helperOptions = array()) {
		$this->_helperOptions = $helperOptions;
	}

/**
 * Retrieves current helper settings
 *
 * @return array current helper settings
 **/
	public function getSettings() {
		return $this->_helperOptions;
	}

/**
 * Changes the editor on the fly
 *
 * @param string $editor String name of editor, excluding the word 'Helper'
 * @param array $helperOptions Each type of wysiwyg helper takes different options.
 * @return void
 * @throws MissingHelperException
 **/
	public function changeEditor($editor, $helperOptions = array()) {
		$this->helper = ucfirst($editor);

		if (!empty($helperOptions)) {
			$this->updateSettings($helperOptions);
		}

		if (!isset($this->importedHelpers[$this->helper])) {
			throw new MissingHelperException(sprintf("Missing Wysiwyg.%s Helper", $this->helper));
		}

		if (!$this->importedHelpers[$this->helper]) {
			$class = 'Wysiwyg.' . $this->helper;
			$helpers = ObjectCollection::normalizeObjectArray(array($class));
			foreach ($helpers as $properties) {
				list($plugin, $class) = pluginSplit($properties['class']);
				$this->{$class} = $this->_View->Helpers->load($properties['class'], $properties['settings']);
			}

			$this->importedHelpers[$this->helper] = true;
		}
	}

/**
 * Returns the appropriate input field element
 *
 * @param string $field - used to build input name for views,
 * @param array $options Array of HTML attributes.
 * @param array $editorOptions Array of editor attributes for this input field
 * @return string
 */
	public function input($field = null, $options = array(), $editorOptions = array()) {
		return $this->{$this->helper}->input($field, $options, $editorOptions);
	}

/**
 * Returns the appropriate textarea element
 *
 * @param string $field - used to build input name for views,
 * @param array $options Array of HTML attributes.
 * @param array $editorOptions Array of editor attributes for this textarea
 * @return string
 */
	public function textarea($field = null, $options = array(), $editorOptions = array()) {
		return $this->{$this->helper}->textarea($field, $options, $editorOptions);
	}

}
