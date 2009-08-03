The TinyMCE Helper Plugin includes TinyMCE and allows one to replace any and all textareas with TinyMCE input fields

I was using David Boyer's excellent TinyMCE Helper (http://bakery.cakephp.org/articles/view/tinymce-helper-1) and realized it didn't work in all cases. I implemented all the fixes suggested, compacted some code, and added in the automatic naming of the selector so that it can be implemented upon multiple fields. This is the product.
## Installation
- Clone from github : in your plugin directory type `git clone git://github.com/josegonzalez/tinymce-helper.git tinymce`
- Add as a git submodule : in your plugin directory type `git submodule add git://github.com/josegonzalez/tinymce-helper.git tinymce`
- Download an archive from github and extract it in `/plugins/tinymce`

- Also download TinyMCE and install it in your js folder

## Usage
1. Add the following to the controller where you'd like to use TinyMCE:
	var $helper = array('Tinymce.Tinymce')
2. Replace your textarea inputs with either of the following:
	$tinymce->input("Modelname.fieldname");
	$tinymce->textarea("Modelname.fieldname");

At this point, everything should theoretically work.

## TODO:
1. Better code commenting
2. Figure out how to include the TinyMCE distribution
3. Enable some file-uploading plugin for TinyMCE
4. Refactor if possible