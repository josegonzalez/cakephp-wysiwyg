# Wysiwyg Helpers Plugin 2.0

Include Wysiwyg Editors quickly and easily

## Background

I've been on a small refactoring spree as part of my work on Marcy Avenue. I realize, after years of working with Joomla and Wordpress, that people prefer different WYSIWYG editors. So to alleviate this, I am attempting to build a set of CakePHP helpers for each of the major WYSIWYG editors on the market, and as many small ones as possible.

The plugin also allows you to automatically change from one WYSIWYG Editor to another when using the WysiwygHelper and configuring it in the controller. You may also change the Editor within the view.

## Requirements

* CakePHP 2.x

## Installation

For 1.3 support, please see the [1.3 branch](https://github.com/josegonzalez/cakephp-wysiwyg-helper/tree/1.3).

Download the JS distribution of your editor of choice and install it in your js folder.

_[Manual]_

* Download this: [https://github.com/josegonzalez/cakephp-wysiwyg-helper/zipball/master](https://github.com/josegonzalez/cakephp-wysiwyg-helper/zipball/master)
* Unzip that download.
* Copy the resulting folder to `app/Plugin`
* Rename the folder you just copied to `Wysiwyg`

_[GIT Submodule]_

In your app directory type:

    git submodule add git://github.com/josegonzalez/cakephp-wysiwyg-helper.git Plugin/Wysiwyg
    git submodule init
    git submodule update


_[GIT Clone]_

In your plugin directory type

    git clone git://github.com/josegonzalez/cakephp-wysiwyg-helper.git Wysiwyg

### Enable plugin

In 2.0 you need to enable the plugin your `app/Config/bootstrap.php` file:

    CakePlugin::load('Wysiwyg');

If you are already using `CakePlugin::loadAll();`, then this is not necessary.

## Usage

### Available Helpers

* Wysiwyg (Wysiwyg.Wysiwyg)
* FCKEditor (Wysiwyg.Fck)
* Nicedit (Wysiwyg.Nicedit)
* Markitup (Wysiwyg.Markitup)
* TinyMCE (Wysiwyg.Tinymce)

### Using the Generic WyswigHelper

Add the following to the controller where you'd like to use your preferred editor. You can omit the parameters if you like, the default editor is `tinymce`:

    public $helpers = array('Wysiwyg.Wysiwyg' => array('editor' => 'fck'));

Replace your textarea inputs with either of the following:

    $this->Wysiwyg->input("ModelName.fieldName");
    $this->Wysiwyg->textarea("ModelName.fieldName");

Array Options for the FormHelper are contained in the second parameter, while the third parameter contains and array of options for the editor

You can also change the editor within the view. Changes come into affect for the proceeding editor:

    $this->Wysiwyg->changeEditor('nicedit');

At this point, everything should theoretically work.

### Other Helpers

If hardcoding your editor, you can do the following in your Controller:

    <?php
    class AppController extends Controller {

      public $helpers = array('Wysiwyg.Nicedit');
    }

Then usage in your views is as follows:

    $this->Nicedit->input("ModelName.fieldName");
    $this->Nicedit->textarea("ModelName.fieldName");

## TODO:

* ~~~Better code commenting~~~
* Figure out how to include the JS distributions
* Enable file-uploading using whatever is native to the editor
* ~~~Refactor where possible~~~
* ~~~Create a WysiwygHelper that will auto-create the type of helper you want based upon settings given to the view~~~
* Tests

## License

Copyright (c) 2009-2012 Jose Diaz-Gonzalez

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
