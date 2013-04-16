# Kudos - WordPress Plugin #
Brings Kudos, an unobtrusive alternative to Facebook's like, to your WordPress blog.

[On WordPress.org](http://wordpress.org/extend/plugins/kudos/)

## Description ##

Kudos, as seen on the svbtle.com blogging network, are an unobtrusive and playful
way for your readers to show their appreciation. To give kudos for a post the visitor
simply hovers the Kudo-Button: A small animation starts for as long as the visitor does leave his cursor on the Kudo. When the animation is finished and the Kudo-Button is filled the count goes up by one. By clicking the then filled button the visitor can take his Kudo off the post again.

See the plugin in action on [yrnxt.com](http://yrnxt.com/category/wordpress/kudos/).

[Dustin Curtis](http://dcurt.is/codename-svbtle), creator of svbtle.com and inventor of Kudos, describes Kudos like this:

	Each post has one unusual feedback mechanism which has no external repercussions: Kudos.


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

## Changelog ##

### 1.0: 2013-04-16 ###
* Release

