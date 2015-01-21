=== Omnomnom ===
Contributors: sgrant
Donate link: http://scotchfield.com
Tags: translation, substring, replace, omnomnom, fun
Requires at least: 4.0
Tested up to: 4.1
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Replace substrings in your WordPress text with something else.

== Description ==

Omnomnom is a string substitution tool that, by default, searches out
instances of "om" and replaces them with "om-nom-nom". See the screenshots
for examples.

Any text that passes through the translation filter will be checked,
along with post titles and content.

That's all! Munch up. :) Om-nom-nom.

== Installation ==

Place all the files in a directory inside of wp-content/plugins (for example,
omnomnom), and activate the plugin.

You can find the admin page under Settings, titled Omnomnom.

== Frequently Asked Questions ==

= Where can I change the default strings? =

Log in to the dashboard as an admin, click on the Settings link on the
sidebar, and look for the Omnomnom option. If it's not there, make
sure that the plugin is installed and activated on the Plugins page.

= Why am I getting a warning with a custom string? =

The replacement string is converted into a PHP regular expression. Slashes
and other characters may cause problems. You might try removing
non-alphanumeric characters like slashes or brackets. If that doesn't work,
try a simpler string, or reset to the default.

== Screenshots ==

1. A demonstration of the plugin modifying a post title, content, and the
comments text (com-nom-noments, rather).
2. A view of the dashboard with the plugin enabled. Custom-nom-nomize Your
Site, indeed.
3. A view of the admin page, where the strings can be modified.

== Changelog ==

= 1.0 =
* First release!

== Upgrade Notice ==

= 1.0 =
First public release.
