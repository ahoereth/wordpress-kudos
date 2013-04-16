<?php
if( !defined('WP_UNINSTALL_PLUGIN') ) exit();

delete_option( 'kudos' );

$post_types = get_post_types(array("public" => true));
foreach ($post_types as $post_type){
	$allposts = get_posts('numberposts=-1&post_type='.$post_type.'&post_status=any');
	foreach ($allposts as $post)
		delete_post_meta($post->ID, '_kudos');
}
