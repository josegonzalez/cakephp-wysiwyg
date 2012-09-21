<?php
/**
 * markItUp! Helpers
 * @author Jay Salvat
 * @version 1.1
 *
 * Download markItUp! at:
 * http://markitup.jaysalvat.com
 * Download jQuery at:
 * http://jquery.com
 */
App::uses('WysiwygAppHelper', 'Wysiwyg.View/Helper');

class MarkitupHelper extends WysiwygAppHelper {

/**
 * Creates an nicedit input field
 *
 * @param string $field - used to build input name for views,
 * @param array $options Array of HTML attributes.
 * @param array $nicOptions Array of Nicedit attributes for this input field
 * @return string An HTML input field element with Nicedit
 */
	public function input($field = null, $options = array()) {
		return $this->Form->input($field, $options) . $this->editor($field, $options);
	}

/**
 * Creates an nicedit textarea
 *
 * @param string $field - used to build input name for views,
 * @param array $options Array of HTML attributes.
 * @param array $nicOptions Array of Nicedit attributes for this textarea
 * @return string An HTML textarea element with Nicedit
 */
	public function textarea($field = null, $options = array()) {
		return $this->Form->textarea($field, $options) . $this->editor($field, $options);
	}

/**
 * Generates a form textarea element complete with label and wrapper div with markItUp! applied.
 * @param  string $fieldName This should be "Modelname.fieldname"
 * @param  array $settings
 * @return string  An <textarea /> element.
 */
	public function editor($field, $options = array()) {
		$config = $this->_build($options);
		$options = $config['settings'];
		$id = '#' . parent::domId($field);
		return $this->Html->scriptBlock('
			$(document).ready(function() {
				jQuery("' . $id . '").markItUp(
					' . $options['settings'] . ', {
						previewParserPath:"' . $options['parser'] . '"
					});
				});
			');
	}

/**
 * Link to build markItUp! on a existing textfield
 * @param  string $title The content to be wrapped by <a> tags
 * @param  string $fieldName This should be "Modelname.fieldname" or specific domId as #id
 * @param  array  $settings
 * @param  array  $htmlAttributes Array of HTML attributes
 * @param  string $confirmMessage JavaScript confirmation message
 * @return string An <a /> element
 */
	public function create($title, $fieldName = "", $settings = array(), $htmlAttributes = array(), $confirmMessage = false) {
		$id = ($fieldName{0} === '#') ? $fieldName : '#' . parent::domId($fieldName);

		$config = $this->_build($settings);
		$settings = $config['settings'];
		$htmlAttributes = am($htmlAttributes, array('onclick' => 'jQuery("' . $id . '").markItUpRemove(); jQuery("' . $id . '").markItUp(' . $settings['settings'] . ', { previewParserPath:"' . $settings['parser'] . '" }); return false;'));
		return $this->Html->link($title, "#", $htmlAttributes, $confirmMessage, false);
	}

/**
 * Link to destroy a markItUp! editor from a textfield
 * @param string  $title The content to be wrapped by <a> tags
 * @param string  $fieldName This should be "Modelname.fieldname" or specific domId as #id
 * @param array   $htmlAttributes Array of HTML attributes
 * @param string  $confirmMessage JavaScript confirmation message
 * @return string An <a /> element
 */
	public function destroy($title, $fieldName = "", $htmlAttributes = array(), $confirmMessage = false) {
		$id = ($fieldName{0} === '#') ? $fieldName : '#' . parent::domId($fieldName);
		$htmlAttributes = am($htmlAttributes, array('onclick' => 'jQuery("' . $id . '").markItUpRemove(); return false;'));
		return $this->Html->link($title, "#", $htmlAttributes, $confirmMessage, false);
	}

/**
 * Link to add content to the focused textarea
 * @param string  $title The content to be wrapped by <a> tags
 * @param string  $fieldName This should be "Modelname.fieldname" or specific domId as #id
 * @param mixed   $content String or array of markItUp! options (openWith, closeWith, replaceWith, placeHolder and more. See markItUp! documentation for more details : http://markitup.jaysalvat.com/documentation
 * @param array   $htmlAttributes Array of HTML attributes
 * @param string  $confirmMessage JavaScript confirmation message
 * @return string An <a /> element
 */
	public function insert($title, $fieldName = null, $content = array(), $htmlAttributes = array(), $confirmMessage = false) {
		if (isset($fieldName)) {
			$content['target'] = ($fieldName{0} === '#') ? $fieldName : '#' . parent::domId($fieldName);
		}
		if (!is_array($content)) {
			$content['replaceWith'] = $content;
		}
		$properties = '';
		foreach ($content as $k => $v) {
			$properties .= $k . ':"' . addslashes($v) . '",';
		}
		$properties = substr($properties, 0, -1);

		$htmlAttributes = am($htmlAttributes, array('onclick' => '$.markItUp( { ' . $properties . ' } ); return false;'));
		return $this->Html->link($title, "#", $htmlAttributes, $confirmMessage, false);
	}

/**
 * Parser to use in the preview
 * @param string  $content The content to be parsed
 * @return string Parsed content
 */
	public function parse($content, $parser = '') {
		// This Helper is designed to be used with several kinds of parser
		// in a same project.
		// Drop your favorite parsers in the /vendor/ folder and edit lines below.
		switch ($parser) {
			case 'bbcode':
				// App::import('Vendor', 'bbcode', array('file' => 'myFavoriteBbcodeParser'));
				// $parsed = myFavoriteBbcodeParser($content);
				break;
			case 'textile':
				// App::import('Vendor', 'textile', array('file' => 'myFavoriteTextileParser'));
				// $parsed = myFavoriteTextileParser($content);
				break;
			case 'markdown':
				// App::import('Vendor', 'markdown', array('file' => 'myFavoriteMarkDownParser'));
				// $parsed = myFavoriteMarkDownParser($content);
				break;
			default:
				// App::import('Vendor', 'favorite', array('file' => 'myFavoriteFavoriteParser'));
				// $parsed = myFavoriteFavoriteParser($content);
		}
		return $content;
	}

/**
 * Adds jQuery and markItUp! scripts to the page
 */
	public function beforeRender() {
		$this->Html->script('markitup/jquery.markitup.js', false);
	}

/**
 * Private function.
 * Builds the settings array and add includes
 */
	protected function _build($settings) {
		$settings = array_merge(array(
			'set' => 'bbcode',
			'skin' => 'markitup',
			'settings' => 'mySettings',
			'parser' => ''
			), $settings);

		if ($settings['parser']) {
			$settings['parser'] = $this->Html->url($settings['parser']);
		}
		$this->Html->script('markitup/sets/' . $settings['set'] . '/set.js', false);
		$this->Html->css('/js/markitup/skins/' . $settings['skin'] . '/style.css', null, null, false);
		$this->Html->css('/js/markitup/sets/' . $settings['set'] . '/style.css', null, null, false);

		return array('settings' => $settings, 'default' => $default);
	}

}