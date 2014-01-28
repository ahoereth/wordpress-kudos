<?php
/**
Plugin Name: Kudos
Plugin URI: http://yrnxt.com/wordpress/kudos
Description: Svbtle.com style kudos for your blog.
Author: Alexander Höreth
Version: 1.1.1
Author URI: http://yrnxt.com
License: GPL2

    Copyright 2009-2013  Alexander Höreth (email: a.hoereth@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License version 2,
    as published by the Free Software Foundation.

    You may NOT assume that you can use any other version of the GPL.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    The license for this software can likely be found here:
    http://www.gnu.org/licenses/gpl-2.0.html

*/

if (!defined('KUDO_VER'))
	define('KUDO_VER', '1.1.1');

// symlink proof
$pathinfo = pathinfo(dirname(plugin_basename(__FILE__)));
if (!defined('KUDO_NAME'))
	define('KUDO_NAME', $pathinfo['filename']);
if (!defined('KUDO_DIR'))
	define('KUDO_DIR', plugin_dir_path(__FILE__));
if (!defined('KUDO_URL'))
	define('KUDO_URL', plugins_url(KUDO_NAME) . '/');

// include functions which are intended to be used by developers and therefore
// are not wrapped in their own class
include_once( KUDO_DIR . 'php/functions.php' );

// only on backend / administration interface
if (is_admin()){
	// plugin upgrade
	include_once( KUDO_DIR . '/php/upgrade.php' );
	add_action( 'admin_init', 'kudos_upgrade' );

	// init settings
	include_once( KUDO_DIR . 'php/settings.php' );
	$kudos_settings = new kudos_settings();

	// init contextual help
	include_once( KUDO_DIR . 'php/help.php' );
	$kudos_help = new kudos_help($kudos_settings);

	// init AJAX
	// This is also used on frontend, but AJAX is always executed through
	// wp-admin/admin-ajax.php
	include_once( KUDO_DIR . 'php/ajax.php' );
	$kudos_ajax = new kudos_ajax();
}

// only on frontend / page
if (!is_admin()){
	// init filters
	include_once( KUDO_DIR . 'php/filter.php' );
	$kudos_filter = new kudos_filter();

	include_once( KUDO_DIR . 'php/general.php' );
	$kudos = new kudos();

	// init frontend scripts
	add_action( 'wp_enqueue_scripts', array( &$kudos, 'enqueue' ) );

	// init shortcode
	add_shortcode( 'kudos', array( &$kudos, 'shortcode' ) );
}
