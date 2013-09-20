[![Build Status](https://travis-ci.org/josegonzalez/cakephp-wysiwyg.png?branch=master)](https://travis-ci.org/josegonzalez/cakephp-wysiwyg) [![Coverage Status](https://coveralls.io/repos/josegonzalez/cakephp-wysiwyg/badge.png?branch=master)](https://coveralls.io/r/josegonzalez/cakephp-wysiwyg?branch=master) [![Total Downloads](https://poser.pugx.org/josegonzalez/cakephp-wysiwyg/d/total.png)](https://packagist.org/packages/josegonzalez/cakephp-wysiwyg) [![Latest Stable Version](https://poser.pugx.org/josegonzalez/cakephp-wysiwyg/v/stable.png)](https://packagist.org/packages/josegonzalez/cakephp-wysiwyg)

# Wysiwyg Helpers Plugin 2.0

Include Wysiwyg Editors quickly and easily

## Background

I've been on a small refactoring spree as part of my work on Marcy Avenue. I realize, after years of working with Joomla and Wordpress, that people prefer different WYSIWYG editors. So to alleviate this, I am attempting to build a set of CakePHP helpers for each of the major WYSIWYG editors on the market, and as many small ones as possible.

The plugin also allows you to automatically change from one WYSIWYG Editor to another when using the WysiwygHelper and configuring it in the controller. You may also change the Editor within the view.

## Requirements

* CakePHP 2.x

## Installation

Download the JS distribution of your editor of choice and install it in your js folder.

_[Using [Composer](http://getcomposer.org/)]_

Add the plugin to your project's `composer.json` - something like this:

	{
		"require": {
			"josegonzalez/cakephp-wysiwyg": "dev-master"
		}
	}

Because this plugin has the type `cakephp-plugin` set in it's own `composer.json`, composer knows to install it inside your `/Plugins` directory, rather than in the usual vendors file. It is recommended that you add `/Plugins/Upload` to your .gitignore file. (Why? [read this](http://getcomposer.org/doc/faqs/should-i-commit-the-dependencies-in-my-vendor-directory.md).)

_[Manual]_

* Download this: [https://github.com/josegonzalez/cakephp-wysiwyg/zipball/master](https://github.com/josegonzalez/cakephp-wysiwyg/zipball/master)
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

> The default editor is Tinymce

To use any of these helpers, you should create a folder in the `web/js` folder which is named the lowercase version of your editor of choice. This folder should contain the entire distribution of files necessary for your editor to be in use. For example, the `NiceditHelper` requires the `web/js/nicedit/nicEdit.js` and `web/js/nicedit/nicEditorIcons.gif` files.

To configure where these files exist, please see the helper code.

* CKEditor (Wysiwyg.Ck)
* Jwysiwyg (Wysiwyg.Jwysiwyg)
* Markitup (Wysiwyg.Markitup)
* Nicedit (Wysiwyg.Nicedit)
* TinyMCE (Wysiwyg.Tinymce)

### Using the Generic WyswigHelper

Add the following to the controller where you'd like to use your preferred editor. You can omit the parameters if you like, the default editor is `tinymce`:

    public $helpers = array('Wysiwyg.Wysiwyg' => array('editor' => 'Ck'));

Replace your textarea inputs with either of the following:

    echo $this->Wysiwyg->input('ModelName.fieldName', $inputOptions, $helperOptions);
    echo $this->Wysiwyg->textarea('ModelName.fieldName', $inputOptions, $helperOptions);

Array Options for the FormHelper are contained in the second parameter, while the third parameter contains and array of options for the editor

You can also change the editor within the view. Changes come into affect for the proceeding editor:

    $this->Wysiwyg->changeEditor('Nicedit', $helperOptions);

At this point, everything should theoretically work.

### Other Helpers

If hardcoding your editor, you can do the following in your Controller:

    <?php
    class AppController extends Controller {

      public $helpers = array('Wysiwyg.Nicedit');

    }

Then usage in your views is as follows:

    echo $this->Nicedit->input("ModelName.fieldName");

    echo $this->Nicedit->textarea("ModelName.fieldName");

### Settings

Most editors take a javascript object as settings. The WysiwygHelper allows you to specify optional settings in three ways.

#### Special settings

The following are special settings that are used internally by the `Wysiwyg` plugin

- `_buffer`: A boolean for whether we should buffer input transformation js
- `_css`: An array of css files to buffer
- `_cssText`: A text string containing relevant css
- `_editor`: The editor class. Used only when you specify the `Wysiwyg.Wysiwyg` helper
- `_scripts`: An array of scripts to buffer

These will be ignored when passing settings onto the wysiwyg javascript you are configuring.

#### Via Controller Setup

This mode results in all non-special settings being set as defaults for every instantiation of the Wysiwyg editor areas.

    <?php
    class AppController extends Controller {
        public $helpers = array(
            'Wysiwyg.Wysiwyg' => array(
                '_editor' => 'Tinymce',
                'theme_advanced_toolbar_align' => 'right',
            )
        );
    }

#### Via ->changeEditor()

The second argument on `Wysiwyg->changeEditor()` can also be used to completely override any already set defaults:

    echo $this->Wysiwyg->changeEditor('Tinymce', $helperOptions);

#### Via ->updateSettings()

A call `->updateSettings()` can be used to completely override any already set defaults:

    echo $this->Wysiwyg->updateSettings($helperOptions);

    echo $this->Tinymce->updateSettings($helperOptions);

You can also retrieve currently set editor settings by calling `->getSettings()`:

    $settings = $this->Wysiwyg->getSettings();

#### Via Helper Call

Both `->input()` and `->textarea()` calls accept a third argument array, `$helperOptions`, which may be used to configure the helper. These are merged onto any defaults that have been specified:

    echo $this->Wysiwyg->input('Post.body', $inputOptions, $helperOptions);

    echo $this->Wysiwyg->textarea('Post.body', $inputOptions, $helperOptions);

## TODO:

* <del>Better code commenting</del>
* Figure out how to include the JS distributions
* <del>Enable file-uploading using whatever is native to the editor</del>
* <del>Refactor where possible</del>
* <del>Create a WysiwygHelper that will auto-create the type of helper you want based upon settings given to the view~~~
* Tests

## License

The MIT License (MIT)

Copyright (c) 2009 Jose Diaz-Gonzalez

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
