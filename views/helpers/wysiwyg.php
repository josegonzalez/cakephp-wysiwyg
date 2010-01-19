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
class WysiwygHelper extends AppHelper {
/**
 * Helper dependencies
 *
 * @var array
 */
	var $helpers = array();

/**
 * Default Helper to use
 *
 * @var string
 **/
	var $helper = '';

/**
* Array of whether a certain helper has been imported yet
* 
*/
	var $importedHelpers = array(
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
* var $helpers = array(
*     'editor' =>  'Tinymce',
*     'editorDefaults' => array(
*         'theme_advanced_toolbar_align' => 'right',
*         )
*     );
*/
	var $_editorDefaults = array();

/**
 * Sets the $this->helper to the helper configured in the session
 *
 * @return void
 * @author Jose Diaz-Gonzalez
 **/
	function __construct($options) {
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
	function changeEditor($editor) {
		$this->helper = ucfirst($editor);
		if ($editor !== 'Form') {
			$editor = 'Wysiwyg.' . $this->helper;
		}
		if (!$this->importedHelpers[$this->helper] and App::import('Helper', $editor)) {
			$this->importedHelpers[$this->helper] = true;
			$this->helpers[] = $editor;
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
	function input($field, $options = array(), $editorOptions = array()) {
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
	function textarea($field, $options = array(), $editorOptions = array()) {
		$editorHelper = $this->helper;
		$editorOptions = Set::merge($this->_editorDefaults, $editorOptions);

		return $this->$editorHelper->textarea($field, $options, $editorOptions);
	}
}
?>