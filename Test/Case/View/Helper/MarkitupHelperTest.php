<?php
App::uses('Controller', 'Controller');
App::uses('View', 'View');
App::uses('WysiwygHelper', 'Wysiwyg.View/Helper');

class MarkitupHelperTest extends CakeTestCase {

	public function setUp() {
		parent::setUp();

		$Controller = new Controller();
		$View = new View($Controller);
		$this->Wysiwyg = new WysiwygHelper($View, array('_editor' => 'Markitup'));
	}

	public function testCorrectHelperSet() {
		$this->assertEquals('Markitup', $this->Wysiwyg->helper);
	}

	public function testInputNoSettings() {
		$expected = '<div class="input text"><label for="foo">Foo</label><input name="data[foo]" type="text" id="foo"/></div><script type="text/javascript">jQuery(function () { jQuery(\'#foo\').markItUp(mySettings); });</script>';
		$this->assertEquals($expected, $this->Wysiwyg->input('foo'));
	}

	public function testTextareaNoSettings() {
		$expected = '<textarea name="data[foo]" id="foo"></textarea><script type="text/javascript">jQuery(function () { jQuery(\'#foo\').markItUp(mySettings); });</script>';
		$this->assertEquals($expected, $this->Wysiwyg->textarea('foo'));
	}

	public function tearDown() {
		parent::tearDown();
	}
}
