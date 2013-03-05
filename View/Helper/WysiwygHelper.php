<?php
/**
 * Wysiwyg is a helper for outputting .
 * This helper REQUIRES the installation files for the wysiwyg helpers you will use
 *
 * @package       cake
 * @subpackage    cake.app.plugins.wysiwyg.views.helpers
 * @author:       Jose Diaz-Gonzalez
 * @version:      0.1
 * @email:        support@savant.be
 * @site:         http://josediazgonzalez.com
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
		'Form' => false,
		'Fck' => false,
		'Jwysiwyg' => false,
		'Nicedit' => false,
		'Markitup' => false,
		'Tinymce' => false
	);

/**
 * Array of defaults configuration for editors, specified when
 * importing Wysiwyg in your controller. For example:
 *
 * public $helpers = array(
 *     'editor' =>  'Tinymce',
 *     'editorDefaults' => array(
 *         'theme_advanced_toolbar_align' => 'right',
 *         )
 *     );
 */
	protected $_editorDefaults = array();

/**
 * Sets the $this->helper to the helper configured in the session
 *
 * @return void
 * @author Jose Diaz-Gonzalez
 **/
	public function __construct(View $View, $options) {
		$this->_View = $View;
		$this->request = $View->request;
		$options = array_merge(array('editor' => 'tinymce'), $options);
		if (isset($options['editorDefaults'])) {
			$this->_editorDefaults = $options['editorDefaults'];
		}
		$this->changeEditor($options['editor']);
	}

/**
 * Changes the editor on the fly
 *
 * @param string $editor String name of editor, excluding the word 'Helper'
 * @return void
 * @author Jose Diaz-Gonzalez
 **/
	public function changeEditor($editor) {
		$this->helper = ucfirst($editor);
		$prefix = '';
		if ($editor !== 'Form') {
			$prefix = 'Wysiwyg.';
		}
		if (!$this->importedHelpers[$this->helper]) {
			$this->importedHelpers[$this->helper] = true;
			$this->helpers[] = $prefix . $this->helper;
			$this->_helperMap = ObjectCollection::normalizeObjectArray($this->helpers);
		}
	}

/**
 * Returns the appropriate input field element
 *
 * @param string $field - used to build input name for views,
 * @param array $options Array of HTML attributes.
 * @param array $editorOptions Array of editor attributes for this input field
 * @return string
 * @author Jose Diaz-Gonzalez
 */
	public function input($field = null, $options = array(), $editorOptions = array()) {
		$editorHelper = $this->helper;
		$editorOptions = Set::merge($this->_editorDefaults, $editorOptions);

		return $this->$editorHelper->input($field, $options, $editorOptions);
	}

/**
 * Returns the appropriate textarea element
 *
 * @param string $field - used to build input name for views,
 * @param array $options Array of HTML attributes.
 * @param array $editorOptions Array of editor attributes for this textarea
 * @return string
 * @author Jose Diaz-Gonzalez
 */
	public function textarea($field = null, $options = array(), $editorOptions = array()) {
		$editorHelper = $this->helper;
		$editorOptions = Set::merge($this->_editorDefaults, $editorOptions);

		return $this->$editorHelper->textarea($field, $options, $editorOptions);
	}

}
