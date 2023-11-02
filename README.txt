=== Plugin Name ===
Contributors: Como Creative LLC
Tags: pipeline
Requires at least: 5.0.0
Tested up to: 5.3.2
Stable tag: 5.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Plugin to enable Development Pipeline Charts
== Description ==
Plugin to enable Development Pipeline Charts
A few notes about the sections above:
*   "Contributors" is a comma separated list of wp.org/wp-plugins.org usernames
*   "Tags" is a comma separated list of tags that apply to the plugin
*   "Requires at least" is the lowest version that the plugin will work on
*   "Tested up to" is the highest version that you've *successfully used to test the plugin*. Note that it might work on
higher versions... this is just the highest one you've verified.
*   Stable tag should indicate the Subversion "tag" of the latest stable version, or "trunk," if you use `/trunk/` for
stable.
    Note that the `readme.txt` of the stable tag is the one that is considered the defining one for the plugin, so
if the `/trunk/readme.txt` file says that the stable tag is `4.3`, then it is `/tags/4.3/readme.txt` that'll be used
for displaying information about the plugin.  In this situation, the only thing considered from the trunk `readme.txt`
is the stable tag pointer.  Thus, if you develop in trunk, you can update the trunk `readme.txt` to reflect changes in
your in-development version, without having that information incorrectly disclosed about the current stable version
that lacks those changes -- as long as the trunk's `readme.txt` points to the correct stable tag.
    If no stable tag is provided, it is assumed that trunk is stable, but you should specify "trunk" if that's where
you put the stable version, in order to eliminate any doubt.
== Installation ==
This section describes how to install the plugin and get it working.
e.g.
1. Upload `como-pipeline.php` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Place `<?php do_action('Como_Pipeline_hook'); ?>` in your templates
== Frequently Asked Questions ==
= A question that someone might have =
An answer to that question.
= What about foo bar? =
Answer to foo bar dilemma.
== Screenshots ==
1. This screen shot description corresponds to screenshot-1.(png|jpg|jpeg|gif). Note that the screenshot is taken from
the /assets directory or the directory that contains the stable readme.txt (tags or trunk). Screenshots in the /assets
directory take precedence. For example, `/assets/screenshot-1.png` would win over `/tags/4.3/screenshot-1.png`
(or jpg, jpeg, gif).
2. This is the second screen shot
== Changelog ==
= 1.0 =
* A change since the previous version.
* Another change.
= 0.5 =
* List versions from most recent at top to oldest at bottom.
== Upgrade Notice ==
= 1.0 =
1.0.7 Added ID and Class attributes to shortcode and Product Link Text field to admin.
1.0.8 - Added ability to use HTML code in text fields
1.0.9 - Revisions to Display Templates and Admin Display
1.1.0 - Reduced delay time on pipeline progress animations
1.1.1 - Added Custom Columns to Trial Admin
1.1.2 - Minor admin language adjustments
1.1.3 - Added alternate column names and abbreviations 
1.1.4 - Added Footnote to shortcode
1.1.5 - Corrected errors thrown by unnedded Datepicker script
1.1.6 - Fixed issue with saving repeaters with empty fields
1.1.7 - Added text field for candidates that can be used for popups
1.1.8 - Added Bootstrap scripts to admin if needed
1.1.9 - Fixed issue with repeaters not saving correctly if any fields are empty
1.2.0 - Fixed issue with repeaters not saving correctly over two Trials
1.2.3 - Fixed link to Bootstrap stylesheet for admin (if needed)
1.2.4 - Fixed custom Trial Repeater image field saving issue  
1.2.5 - Added Read Only Columns to Settings and made some adjustments to fiel order for Trials
1.2.6 - Fixed Shortcode Loop Attribute
1.2.7 - Added "No Candidates" message to settings
1.2.8 - Fixed missing column and row atts for Candidate textarea field
1.2.9 - Added Candidate subtitle text field
1.3.0 - Added Trial Type text field
1.3.1 - Changed Trial Type and Indication fields to Select fields, Added Abbreviation fields to custom taxonomies, Added log fields to Trials 
1.3.2 - Added Textarea option to custom Columns
1.3.3 - Corrected php errors for version 8.0
1.3.4 - Updates to fix php 8.1 "Automatic conversion of false to array is deprecated" errors
1.3.5 - Added Category and Method taxonomies
1.3.6 - Updated taxonomies to not be publicly queriable
1.3.7 - Fixed Trial-Logo missing field error
= 0.5 =
This version fixes a security related bug.  Upgrade immediately.
== Arbitrary section ==
You may provide arbitrary sections, in the same format as the ones above.  This may be of use for extremely complicated
plugins where more information needs to be conveyed that doesn't fit into the categories of "description" or
"installation."  Arbitrary sections will be shown below the built-in sections outlined above.
== A brief Markdown Example ==
Ordered list:
1. Some feature
1. Another feature
1. Something else about the plugin
Unordered list:
* something
* something else
* third thing
Here's a link to [WordPress](http://wordpress.org/ "Your favorite software") and one to [Markdown's Syntax Documentation][markdown syntax].
Titles are optional, naturally.
[markdown syntax]: http://daringfireball.net/projects/markdown/syntax
            "Markdown is what the parser uses to process much of the readme file"
Markdown uses email style notation for blockquotes and I've been told:
> Asterisks for *emphasis*. Double it up  for **strong**.
`<?php code(); // goes in backticks ?>`