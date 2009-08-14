I've been on a small refactoring spree as part of my work on Marcy Avenue. I realize, after years of working with Joomla and Wordpress, that people prefer different WYSIWYG editors. So to alleviate this, I am attempting to build a set of CakePHP helpers for each of the major WYSIWYG editors on the market, and as many small ones as possible. The first fully working one is the TinyMCE Helper Plugin.

## Installation
- Clone from github : in your plugin directory type `git clone git://github.com/josegonzalez/cakephp-wysiwyg-helper.git wysiwyg`
- Add as a git submodule : in your plugin directory type `git submodule add git://github.com/josegonzalez/cakephp-wysiwyg-helper.git wysiwyg`
- Download an archive from github and extract it in `/plugins/wysiwyg`

- Also download the JS distribution of your editor of choice and install it in your js folder

## Usage
1. Add the following to the controller where you'd like to use your preferred editor (Tinymce is used here):
	var $helper = array('Wysiwyg.Tinymce')
2. Replace your textarea inputs with either of the following:
	$tinymce->input("Modelname.fieldname");
	$tinymce->textarea("Modelname.fieldname");

At this point, everything should theoretically work.

## TODO:
1. Better code commenting
2. Figure out how to include the JS distributions
3. Enable file-uploading using whatever is native to the editor
4. Refactor if possible
5. Create a WysiwygHelper that will auto-create the type of helper you want based upon settings given to the view