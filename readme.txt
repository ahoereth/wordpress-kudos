=== Featured Video Plus ===
Contributors: a.hoereth
Plugin Name: Kudos
Plugin URI: http://yrnxt.com/category/wordpress/kudos/
Tags: svbtle, svbtle.com, kudos, ajax, like, vote, star, favorite, plus
Author: Alexander Höreth
Author URI: http://yrnxt.com/
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=a%2ehoereth%40gmail%2ecom
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Requires at least: 3.1
Tested up to: 3.6
Stable tag: 1.0

Brings Kudos, an unobtrusive alternative to Facebook's like, to your WordPress blog.

== Description ==

Kudos, as seen on the svbtle.com blogging network, are an unobtrusive and playful
way for your readers to show their appreciation. To give kudos for a post the visitor
simply hovers the Kudo-Button: A small animation starts for as long as the visitor does leave his cursor on the Kudo. When the animation is finished and the Kudo-Button is filled the count goes up by one. By clicking the then filled button the visitor can take his Kudo off the post again.

See the plugin in action on [yrnxt.com](http://yrnxt.com).

Dustin Curtis, creator of svbtle.com and inventor of Kudos, describes Kudos like this:

	Each post has one unusual feedback mechanism which has no external repercussions: Kudos.
	- source: [dcurt.is](http://dcurt.is/codename-svbtle)

By default Kudos are displayed in the top right of your post contents. You can
customize the positioning and texts at `Settings -> Kudos`. More customizations
will be added in upcoming updates.

Beside the default automatic insertion into your posts you can make use of the PHP-Functions and shortcode to display the Kudos more individually:

	[kudos]

	kudos()
	get_kudos( $post_id, $attr )
	kudos_count( $post_id, $text, $hover )
	get_kudos_count( $post_id )

For more information on those take a look into the settings.

This plugin makes use of [Masukomi's Kudos](https://github.com/masukomi/kudos) implementation.
If you like Kudos and the overall look of Svbtle take a look at [wp-svbtle](https://github.com/gravityonmars/wp-svbtle).

== Installation ==

1. Visit your WordPress Administration interface and go to Plugins -> Add New
2. Search for "*Kudos*", and click "*Install Now*" below the plugin's name
3. When the installation finished, click "*Activate Plugin*"

By default the Kudos are displayed in the top left of your content. Take a look
into `Settings -> Kudos` for customizations.

== Changelog ==

= 1.0 =
* Release


== Upgrade Notice ==

== Screenshots ==

1. Kudos-Button in the top right of a post in the twentythirteen theme.
2. Triggered Kudos-Button in the top left of a post in the twentytwelve theme.
3. Settings -> Kudos

== Frequently Asked Questions ==
