<?php
/**
 * FCKHelper is a helper for FCKEditor.
 * This helper REQUIRES the FCKEditor installation files.
 *
 * @package       cake
 * @subpackage    cake.app.plugins.wysiwyg.views.helpers
 * @author:       Jose Diaz-Gonzalez
 * @version:      1.1
 * @email:        support@savant.be
 * @site:         http://josediazgonzalez.com
 */
App::uses('WysiwygAppHelper', 'Wysiwyg.View/Helper');

class FckHelper extends WysiwygAppHelper {

/**
 * Adds the fckeditor.js file and constructs the options
 *
 * @param string $field Name of a field, like this "Modelname.fieldname"
 * @param array $options Array of FckEditor attributes for this textarea
 * @return string JavaScript code to initialise the FckEditor area
 */
	protected function _build($field, $options = array()) {
		$options = array_merge(array(
			'basepath' => $this->Html->base,
			'fckPath' => '/js/fckeditor/',
			'content' => '',
			'toolbarSet' => 'Default',
			'skinPath' => 'editor/skins/',
			'skin' => 'default'
			), $options);

		if (!$this->_initialized) {
			$this->_initialized = true;
			$this->Html->script('fckeditor/fckeditor.js', array('inline' => false));
		}

		$field = $this->_field($field);
		return $this->Html->scriptBlock("window.onload = function() {
				public oFCKeditor = new FCKeditor('data[{$field['modelName']}][{$field['fieldName']}]');
				oFCKeditor.BasePath = \"{$options['basepath']}{$options['fckPath']}\";
				oFCKeditor.Config['SkinPath'] = \"{$options['fckPath']}{$options['skinPath']}{$options['skin']}/\";
				oFCKeditor.Value = \"{$options['content']}\";
				oFCKeditor.ToolbarSet = \"{$options['toolbarSet']}\";
				oFCKeditor.ReplaceTextarea();
			}", array('safe' => false, 'inline' => false)
		);
	}

}