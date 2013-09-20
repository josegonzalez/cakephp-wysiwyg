<?php
/**
 * All Wysiwyg plugin tests
 */
class AllWysiwygTest extends CakeTestCase {

/**
 * Suite define the tests for this suite
 *
 * @return void
 */
	public static function suite() {
		$suite = new CakeTestSuite('All Wysiwyg test');

		$path = CakePlugin::path('Wysiwyg') . 'Test' . DS . 'Case' . DS;
		$suite->addTestDirectoryRecursive($path);

		return $suite;
	}

}
