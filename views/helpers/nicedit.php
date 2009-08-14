<?php
/**
 * NicEditHelper is a helper for NicEdit
 * This helper REQUIRES the NicEdit installation files.
 *
 * @package       cake
 * @subpackage    cake.app.plugins.wysiwyg.views.helpers
 * @author:       Jose Diaz-Gonzalez
 * @version:      1.1
 * @email:        support@savant.be
 * @site:         http://josediazgonzalez.com
 */
class NiceditHelper extends AppHelper {
/**
 * Helper dependencies
 *
 * @var array
 */
	var $helpers = array('Form', 'Javascript');

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
 * Adds the nicedit.js file and constructs the options
 *
 * @return void
 */
	function _build($field = null, $options = array()) {
		$modelFieldPair = $this->__field($field);

		if (!$this->_initialized) {
			// We don't want to add this every time, it's only needed once
			$this->_initialized = true;
			$this->Javascript->link('nicedit/nicEdit.js', false);
		}

		return $this->Javascript->codeBlock(
			"
			var area1;
			function makePanel() {
				area1 = new nicEditor({fullPanel : true}).panelInstance(
					'" . $modelFieldPair['model'] . $modelFieldPair['field'] . "',
					{hasPanel : true}
				);
			}
			bkLib.onDomLoaded(function() { makePanel(); });",
			array('safe' => false));
	}

/**
* Creates an nicedit input field
*
* @param string $field - used to build input name for views, 
* @param array $options Array of HTML attributes.
* @param array $nicOptions Array of Nicedit attributes for this input field
* @return string An HTML input field element with Nicedit
*/
	function input($field = null, $options = array(), $nicOptions = array()) {
		return $this->Form->input($field, $options) . $this->_build($field, $nicOptions);
	}

/**
* Creates an nicedit textarea
*
* @param string $field - used to build input name for views, 
* @param array $options Array of HTML attributes.
* @param array $nicOptions Array of Nicedit attributes for this textarea
* @return string An HTML textarea element with Nicedit
*/
	function textarea($field = null, $options = array(), $nicOptions) {
		return $this->Form->textarea($field, $options) . $this->_build($field, $nicOptions);
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
			$fieldName = ucfirst($firstToken);
		} else {
			$modelName = $firstToken;
			$fieldName = ucfirst($secondToken);
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