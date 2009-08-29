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
	var $helpers = array('Form', 'Wysiwyg.Fck', 'Wysiwyg.Nicedit', 'Wysiwyg.Markitup', 'Wysiwyg.Tinymce');

/**
 * Default Helper to use
 *
 * @var string
 **/
	var $helper = 'Tinymce';

/**
 * Sets the $this->helper to the helper configured in the session
 *
 * @return void
 * @author Jose Diaz-Gonzalez
 **/
	function __construct($options) {
		if(!empty($options) && isset($options['editor'])) {
			$this->helper = ucfirst($options['editor']);
		}
	}

/**
 * Changes the editor on the fly
 *
 * @param string $editor String name of editor, excluding the word 'Helper'
 * @return void
 * @author Jose Diaz-Gonzalez
 **/
	function changeEditor($editor) {
		$this->helper = $editor;
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

		return $this->$editorHelper->input($field, $options, $editorOptions);
	}

/**
* Returns the appropriate textarea element
* @param string $field - used to build input name for views,
* @param array $options Array of HTML attributes.
* @param array $editorOptions Array of editor attributes for this textarea
* @return string
* @author Jose Diaz-Gonzalez
*/
	function textarea($field, $options = array(), $editorOptions = array()) {
		$editorHelper = $this->helper;

		return $this->$editorHelper->textarea($field, $options, $editorOptions);
	}

	function parse($content, $parser = '') {
		$editorHelper = $this->helper;

		return $this->$editorHelper->parse($content, $parser);
	}
}
?>