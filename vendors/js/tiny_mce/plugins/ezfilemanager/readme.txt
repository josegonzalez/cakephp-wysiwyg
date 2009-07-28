Eazy file manager platform for TinyMCE or stand-alone file management utility.

@ezFilemanager 1.0
@author Webnaz Creations (Naz)
@link www.webnaz.net

Usual and unnecessary GNU General Public License should follow.  
If you want to be the first to read the License, see <http://www.gnu.org/licenses/>.
But please report any security issues asap.

ezFilemanager features:
==========================
- It is an online file management utility
- It can be installed as stand-alone file management utility
- Integrates with TinyMCE as Plugin.
- Integrates as a custom file browser within TinyMCE for image, media and link popup.
- Browse directories.
- Display file information such as type, size and dimensions (images only).
- Preview files (iframe zoom +- for iE only, we dont need zoom for FF)
- Download files
- Rename files directories
- Delete files (single/multiple).
- Delete Directories (even non empty).
- Upload files (based on type permission for image/media/links).
- Upload dynamicaly multiple files simultaneously
- Rename files before uploading
- Enable/Disable file/directory delete
- Enable/Disable file/directory rename
- Enable/Disable file upload
- Check if directory is writable
- Create Directories.
- Restrict max upload size for image/media/links.
- Restrict characters to use for uploaded files and new Directories.
- Multilingual.(Translated to English,French,Greek)
- Security to block non existant folders and back_browsing (../../etc).
- Some other user definable settings, see includes/config.inc.php.
- Almost every single function is fully commented and dated


Version Notes
=============
ezFilemanager v0.8a 25-09-2008 
   Fixed hack_block, preg_match ignores your default path
   hack_block, preg_match tries to block upload path manipulations.
   All uploaded files are converted to lowercase
   
ezFilemanager v0.8 19-09-2008 
   Added option to dynamicaly upload multiple files
   Added option to disable file/directory delete
   Added option to disable file/directory rename
   Added option to disable file upload
   Added javascript file type validation
   Added date modified for directories
   Added some minor security features
   Added French translation (Thanx to Frodon Saquet)
   Moved hack_block preg_match to config
   Fixed $_SERVER['REQUEST_URI'] for IIS
   Fixed some problems for secure sites (https)
   Fixed some javascript errors
   Fixed some FF and Safari css errors 
   
ezFilemanager v0.7 28-08-2008 
   Added iframe preview (type configured from config.inc.php)
   Added file download option
   Added file/directory rename option
   Added option to rename file before uploading
   Added option to check if directory is writable
   Added the option to browse the three directories(image,media,files) in stand-alone mode
   Directory browsing will show only the allowed upload files (configured in config.inc.php)
   Modified the file upload/directory create PHP and javascript functions
   Modified the insert link in TinyMCE popup
   Modified and simplified mime_type function
   Modified and simplified file upload/makedir PHP function
   Modified and simplified both hack_block functions
   Modified the lang files
   Fixed some javascripts and css errors
  
ezFilemanager v0.5 18-08-2008 
   looking for bugs and suggestion
   
Installation
============
Copy the ezFilemanager folder and contents to your TinyMCE plugins directory.
|_ezfilemanager
	|_css
	|_img
		|_icons
	|_includes
	|_js
	|_langs
Make sure your directory permissions are correct
Read the comments

1) Stand-alone Installation
Copy the ezFilemanager folder and contents to any directory or to your TinyMCE plugins dir.
Edit ezFilemanager configuration, mainly paths and URL (includes/config.inc.php)
Point your browser to http://www.yourdomain.com/installed_dir/ezfilemanager/ezfilemanager.php
	
2) Plugin Installation within TinyMCE
Copy the ezFilemanager folder and contents to your TinyMCE plugins directory. 
Edit ezFilemanager configuration, mainly paths and URL (includes/config.inc.php)
Add plugin to TinyMCE plugin option list. example: plugins : "ezfilemanager". 
Add the button, example: theme_advanced_buttons3 : "ezfilemanager".
Set Relative URLS to false, example:relative_urls : false,
Example snippet
in your TinyMCE init:
	tinyMCE.init({
		mode : 'textareas',
		theme : 'advanced',
		plugins : "ezfilemanager,.......",
		theme_advanced_buttons3_add_before : 'separator,ezfilemanager',
		relative_urls : false,
		..........
	});


3) As a File browser within TinyMCE Popups (for image, media and link popups)
Copy the ezFilemanager folder and contents to your TinyMCE plugins directory.
Open includes/config.inc.php and edit ezFilemanager configuration, mainly paths and URL
Add the file_browser_callback, example: file_browser_callback : "ezfilemanager",
Set Relative URLS to false, example:relative_urls : false, 
Add the ezfilemanage javascript function, example: see below

<script language='javascript' type='text/javascript'>
	tinyMCE.init({
		mode : 'textareas',
		theme : 'advanced',
		plugins :
        .........,
		relative_urls : false,
		
		//Add the following at the bottom just before the </script> closing tag
function ezfilemanager (field_name, url, type, win) {
//Change the var pluginPath to reflect your installation path
var PluginPath = "/functions/tiny_mce/plugins/ezfilemanager/ezfilemanager.php"; 
       if (PluginPath.indexOf("?") < 0) 
	   		{
            PluginPath = PluginPath + "?type=" + type;
       		}
       else {
            PluginPath = PluginPath + "&type=" + type;
       		}

       tinyMCE.activeEditor.windowManager.open({
           file : PluginPath,
           title : '',
           width : 650, 
           height : 440,
           resizable : "yes",
           scrollbars : "yes",
           inline : "yes", 
           close_previous : "no"
       		}, {
           window : win,
           input : field_name
       		});
       return false;
     }

If I have done my homework, and you have done the necessary configuration changes, all should work, otherwise feel free to use **** words against me, or contact we through www.webnaz.net

By the way, neither English, French nor Greek is my mother language, so dont complain for errors.