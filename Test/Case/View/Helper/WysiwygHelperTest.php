<?php
App::uses('Controller', 'Controller');
App::uses('View', 'View');
App::uses('WysiwygHelper', 'Wysiwyg.View/Helper');

class WysiwygHelperTest extends CakeTestCase {

	public function setUp() {
		parent::setUp();

		$Controller = new Controller();
		$View = new View($Controller);
		$this->Wysiwyg = new WysiwygHelper($View);
	}

	public function testWysiwygHelperIsLoaded() {
		$this->assertNotNull($this->Wysiwyg);
	}

	public function testWysiwygHelperObjectType() {
		$this->assertInstanceOf("WysiwygHelper", $this->Wysiwyg);
	}

	public function testDefaultSettings() {
		$this->assertEquals(array('_editor' => 'tinymce'), $this->Wysiwyg->getSettings());
	}

	public function testDefaultEditorIsSet() {
		$this->assertEquals('Tinymce', $this->Wysiwyg->helper);
	}

	public function testChangeEditorNoSettings() {
		$this->Wysiwyg->changeEditor('ck');
		$this->assertEquals('Ck', $this->Wysiwyg->helper);
	}

	public function testChangeEditorWithSettings() {
		$this->Wysiwyg->changeEditor('ck', array('_css' => array('foo', 'bar')));
		$this->assertEquals(array('_css' => array('foo', 'bar')), $this->Wysiwyg->getSettings());
	}

	public function textInvalidEditorException() {
		$this->setExpectedException('MissingHelperException');
		$this->Wysiwyg->changeEditor('bastet');
	}

	public function tearDown() {
		parent::tearDown();
	}

}
