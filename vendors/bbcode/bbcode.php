<?php
class Bbcode {
// ----------------------------------------------------------------------------
// markItUp! BBCode Parser
// v 1.0.5
// Dual licensed under the MIT and GPL licenses.
// ----------------------------------------------------------------------------
// Copyright (C) 2009 Jay Salvat
// http://www.jaysalvat.com/
// http://markitup.jaysalvat.com/
// ----------------------------------------------------------------------------
// Permission is hereby granted, free of charge, to any person obtaining a copy
// of this software and associated documentation files (the "Software"), to deal
// in the Software without restriction, including without limitation the rights
// to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
// copies of the Software, and to permit persons to whom the Software is
// furnished to do so, subject to the following conditions:
// 
// The above copyright notice and this permission notice shall be included in
// all copies or substantial portions of the Software.
// 
// THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
// IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
// FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
// AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
// LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
// OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
// THE SOFTWARE.
// ----------------------------------------------------------------------------
// Thanks to Arialdo Martini, Mustafa Dindar for feedbacks.
// ----------------------------------------------------------------------------

	var $emoticonsDir = "/images/emoticons/";

	function BBCode2Html($text) {
		$text = trim($text);

		// BBCode [code]
		if (!function_exists('escape')) {
			function escape($s) {
				global $text;
				$text = strip_tags($text);
				$code = $s[1];
				$code = htmlspecialchars($code);
				$code = str_replace("[", "&#91;", $code);
				$code = str_replace("]", "&#93;", $code);
				return '<pre><code>'.$code.'</code></pre></p>';
			}	
		}
		$text = preg_replace_callback('/\[code\](.*?)\[\/code\]/ms', "escape", $text);

		// Smileys to find...
		$in = array( 	':)',
						':D',
						':o',
						':p',
						':(',
						';)'
		);
		// And replace them by...
		$out = array(	'<img alt=":)" src="'. $this->emoticonsDir .'emoticon-happy.png" />',
						'<img alt=":D" src="'. $this->emoticonsDir .'emoticon-smile.png" />',
						'<img alt=":o" src="'. $this->emoticonsDir .'emoticon-surprised.png" />',
						'<img alt=":p" src="'. $this->emoticonsDir .'emoticon-tongue.png" />',
						'<img alt=":(" src="'. $this->emoticonsDir .'emoticon-unhappy.png" />',
						'<img alt=";)" src="'. $this->emoticonsDir .'emoticon-wink.png" />'
		);
		$text = str_replace($in, $out, $text);

		// BBCode to find...
		$in = array( 	'/\[model\=(.*?)\](.*?)\[\/model\]/ms',
						'/\[model\](.*?)\[\/model\]/ms',
						'/\[controller\=(.*?)\](.*?)\[\/controller\]/ms',
						'/\[controller\](.*?)\[\/controller\]/ms',
						'/\[view\=(.*?)\](.*?)\[\/view\]/ms',
						'/\[view\](.*?)\[\/view\]/ms',
						'/\[behavior\=(.*?)\](.*?)\[\/behavior\]/ms',
						'/\[behavior\](.*?)\[\/behavior\]/ms',
						'/\[component\=(.*?)\](.*?)\[\/component\]/ms',
						'/\[component\](.*?)\[\/component\]/ms',
						'/\[helper\=(.*?)\](.*?)\[\/helper\]/ms',
						'/\[helper\](.*?)\[\/helper\]/ms',
						'/\[sql\](.*?)\[\/sql\]/ms',
						'/\[code\="?(.*?)"?\](.*?)\[\/code\]/ms',
						'/\[code\](.*?)\[\/code\]/ms',
						'/\[b\](.*?)\[\/b\]/ms',
						'/\[i\](.*?)\[\/i\]/ms',
						'/\[u\](.*?)\[\/u\]/ms',
						'/\[s\](.*?)\[\/s\]/ms',
						'/\[sub\](.*?)\[\/sub\]/ms',
						'/\[sup\](.*?)\[\/sup\]/ms',
						'/\[indent\](.*?)\[\/indent\]/ms',
						'/\[p\](.*?)\[\/p\]/ms',
						'/\[email\](.*?)\[\/email\]/ms',
						'/\[color\="?(.*?)"?\](.*?)\[\/color\]/ms',
						'/\[size\="?(.*?)"?\](.*?)\[\/size\]/ms',
						'/\[size\=?(.*?)?\](.*?)\[\/size\]/ms',
						'/\[font\="?(.*?)"?\](.*?)\[\/font\]/ms',
						'/\[align\="?(.*?)"?\](.*?)\[\/align\]/ms',
						'/\[h1\](.*?)\[\/h1\]/ms',
						'/\[h2\](.*?)\[\/h2\]/ms',
						'/\[h3\](.*?)\[\/h3\]/ms',
						'/\[h4\](.*?)\[\/h4\]/ms',
						'/\[h5\](.*?)\[\/h5\]/ms',
						'/\[h6\](.*?)\[\/h6\]/ms',
						'/\[url\="?(.*?)"?\](.*?)\[\/url\]/ms',
						'/\[img\=(.*?)\](.*?)\[\/img\]/ms',
						'/\[img\](.*?)\[\/img\]/ms',
						'/\[quote](.*?)\[\/quote\]/ms',
						'/\[list\=(.*?)\](.*?)\[\/list\]/ms',
						'/\[list\](.*?)\[\/list\]/ms',
						'/\[ulist\](.*?)\[\/ulist\]/ms',
						'/\[\*\]\s?(.*?)\n/ms',
						'/\[li\](.*?)\[\/li\]/ms'
		);
		// And replace them by...
		$out = array(	'<p><h4>[b]\1 Model Class:[/b]</h4></p><pre lang="php"><?php\2?></pre>',
						'<p><h4>[b]Model Class:[/b]</h4></p><pre lang="php"><?php\1?></pre>',
						'<p><h4>[b]\1Controller Class:[/b]</h4></p><pre lang="php"><?php\2?></pre>',
						'<p><h4>[b]Controller Class:[/b]</h4></p><pre lang="php"><?php\1?></pre>',
						'<p><h4>[b]\1 View file:[/b]</h4></p><pre lang="php">\2</pre>',
						'<p><h4>[b]View file:[/b]</h4></p><pre lang="php">\1</pre>',
						'<p><h4>[b]\1Behavior Class:[/b]</h4></p><pre lang="php"><?php\2?></pre>',
						'<p><h4>[b]Behavior Class:[/b]</h4></p><pre lang="php"><?php\1?></pre>',
						'<p><h4>[b]\1Component Class:[/b]</h4></p><pre lang="php"><?php\2?></pre>',
						'<p><h4>[b]Component Class:[/b]</h4></p><pre lang="php"><?php\1?></pre>',
						'<p><h4>[b]\1Helper Class:[/b]</h4></p><pre lang="php"><?php\2?></pre>',
						'<p><h4>[b]Helper Class:[/b]</h4></p><pre lang="php"><?php\1?></pre>',
						'<p><h4>[b]SQL:[/b]</h4></p><pre lang="sql">\1</pre>',
						'<pre lang="\1">\2</pre>',
						'<pre lang="php">\1</pre>',
						'<strong>\1</strong>',
						'<em>\1</em>',
						'<u>\1</u>',
						'<del>\1</del>',
						'<sub>\1</sub>',
						'<sup>\1</sup>',
						'<blockquote>\1</blockquote>',
						'<p>\1</p>',
						'<a href="mailto:\1">\1</a>',
						'<span style="color:\1">\2</span>',
						'<span style="font-size:\1pt">\2</span>',
						'<span style="font-size:\1pt">\2</span>',
						'<span style="font-family:\1">\2</span>',
						'<div style="text-align:\1">\2</div>',
						'<h1>\1</h1>',
						'<h2>\1</h2>',
						'<h3>\1</h3>',
						'<h4>\1</h4>',
						'<h5>\1</h5>',
						'<h6>\1</h6>',
						'<a href="\1">\2</a>',
						'<img src="\2" alt="\1" />',
						'<img src="\1" alt="\1" />',
						'<blockquote>\1</blockquote>',
						'<ol start="\1">\2</ol>',
						'<ol>\1</ol>',
						'<ul>\1</ul>',
						'<li>\1</li>',
						'<li>\1</li>'
		);
		$text = preg_replace($in, $out, $text);
		$text = preg_replace('/(.*?)<\/p><br \/>/', '\\1</p>', $text);

		// paragraphs
		$text = str_replace("\r", "", $text);
		//$text = "<p>".ereg_replace("(\n){2,}", "</p><p>", $text)."</p>";
		$text = nl2br($text);

		// clean some tags to remain strict
		// not very elegant, but it works. No time to do better ;)
		if (!function_exists('removeBr')) {
			function removeBr($s) {
				return str_replace("<br />", "", $s[0]);
			}
		}
		$text = preg_replace_callback('/<pre>(.*?)<\/pre>/ms', "removeBr", $text);
		$text = preg_replace('/<p><pre>(.*?)<\/pre><\/p>/ms', "<p><pre>\\1</pre></p>", $text);

		$text = preg_replace_callback('/<pre lang="(.*?)">(.*?)<\/pre>/ms', "removeBr", $text);
		$text = preg_replace('/<pre lang="(.*?)">(.*?)<\/pre>/ms', "<pre lang=\"\\1\">\\2</pre>", $text);

		$text = preg_replace_callback('/<code>(.*?)<\/code>/ms', "removeBr", $text);
		$text = preg_replace('/<p><code>(.*?)<\/code><\/p>/ms', "<code>\\1</code>", $text);


		$text = preg_replace_callback('/<ul>(.*?)<\/ul>/ms', "removeBr", $text);
		$text = preg_replace('/<p><ul>(.*?)<\/ul><\/p>/ms', "<ul>\\1</ul>", $text);
	
		return $text;
	}
}
?>