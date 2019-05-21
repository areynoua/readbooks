=== Comments Like Dislike ===
Contributors: Happy Coders
Donate link: http://wphappycoders.com/
Tags: comments like dislike, comments, comments like, comments dislike, comment, like dislike, like, dislike
Requires at least: 4.5
Tested up to: 5.1
Stable tag: 1.0.7
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Like Dislike for WordPress Comments

== Description ==
<strong>Comments Like Dislike</strong> is the <strong>Free</strong> WordPress Plugin to enable Like and Dislike Icons for default WordPress Comments. Choose Thumbs Up or Thumbs Down, Smiley or Frown, Right or Wrong icons or your own custom like dislike icons, choice is yours.

<strong>Comments Like Dislike</strong> increases the interaction with the WordPress native comments by enabling likes and dislikes buttons along with the count.

= See full features list below: =
* Status
    - Enable or Disable Comments Like Dislike for comments
* Like Dislike Position
    - After Comment
    - Before Comment
* Like Dislike Display
    - Display Both Like and Dislike
    - Display Like Only
    - Display Dislike Only
* Like Dislike Restriction
    - Cookie Restriction
    - IP Restriction
    - No Restriction
* Like Dislike Order
    - Like Dislike
    - Dislike Like 
* 4 Pre Available Icon Templates
    - Thumbs Up Thumbs Down
    - Heart or Heart Beat
    - Right or Wrong
    - Smiley or Frown
* Custom Like Dislike Icon Upload feature
* Icon Color Configuration
* Count Color Configuration
    

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/comments-like-dislike` directory, or install the plugin through the WordPress plugins screen directly.
1. Activate the plugin through the 'Plugins' screen in WordPress
1. Use the Comments Like Dislike settings page inside the Comments Menu to configure the plugin



== Frequently Asked Questions ==
= What does this plugin do ? = 
This plugin provides the ability to add the like and dislike buttons for WordPress native comments.

= I have enabled the plugin but like and dislike icons are not being displayed. What may be the reason ? =
Our plugin uses comment_text filter to append like and dislike icons . So if your active theme's comments template doesn't use comment_text filter to display comments text then our plugin won't be able to display like and dislike icons.

= Is there any hooks available to extend the plugin ? = 
Our plugin does contains many actions and filters which are described inside the Help Section




== Screenshots ==

1. Like Dislike Icon Template 1
2. Like Dislike Icon Template 2
3. Like Dislike Icon Template 3
4. Like Dislike Icon Template 4
5. Like Dislike Icon Custom Template
6. Like Dislike Basic Settings
7. Like Dislike Design Settings

== Changelog ==
= 1.0.7 = 
* Stripped quotes from the settings
* Added user logged in restriction 
* Added cld_before_ajax_process action
* Added cld_after_ajax_process action

= 1.0.6 = 
* Removed 0 for 0 likes and dislikes
* Replace click with on for ajax comments
* Fixed the conflict for auto approve comment
* Font awesome updated to v5.2.0

= 1.0.5 = 
* Fixed a typo in settings
* Added likes and dislike columns in admin comments listing page

= 1.0.4 = 
* WordPress 4.8 Compatibility Adjustments

= 1.0.3 = 
* Added like and dislike hover text configuration option in backend

= 1.0.2 = 
* Fixed bug for comments like dislike implementation in backend comments section
* Added separate class for already liked or disliked comments

= 1.0.1 = 
* Fixed small bug regarding the count color implementation
* Compatibility check for WordPress 4.7
* Added review link in the About Us section

= 1.0.0 =
* Initial plugin commit to wordpress.org repository



== Upgrade Notice ==
= 1.0.0 = 





