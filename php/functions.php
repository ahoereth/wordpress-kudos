<?php

/**
 * Returns the count of kudos for a given post (by post_id).
 *
 * @since 1.0
 *
 * @param  int $post_id id of post to retrieve kudo count for
 * @return int kudo count
 */
function get_kudos_count( $post_id = null ) {
	$post_id = ( null === $post_id ) ? get_the_ID() : $post_id;

	if (!is_numeric($post_id))
		return 0;

	$count = get_post_meta($post_id, '_kudos', true);
	if(!is_numeric($count)) $count = 0;
	return $count;
}

/**
 * Returns the count of kudos for a given post (by post id) as used in get_kudos
 * and as required for updating count on kudo, unkudo and auto ajax refresh.
 *
 * @since 1.0
 *
 * @param  int 		$post_id 	id of post to retrieve kudo count for
 * @param  string $text 		text displayed below count, empty to hide
 * @return string           kudo-meta html code including current count
 */
function kudos_count( $post_id = null, $text = null, $hover = null ) {
	$post_id = ( null === $post_id ) ? get_the_ID() : $post_id;

	$options = get_option('kudos');
	$text  = isset($text) ? $text : isset($options['text']) ? $options['text'] : 'Kudos';
	$hover = isset($hover)? $hover: isset($options['hover'])? $options['hover']: "Don't//move";

	$metaclass = $beta = "";
	if (!empty($hover)) {
		$beta = '<div class="kudo-meta-beta kudo-dontmove"><span>'.str_replace('//','<br />',esc_html__($hover)).'</span></div>'."\n\t\t";
		$metaclass = " kudo-hideonhover";
	}

	$tmplt = '<div class="kudo-meta kudo-meta-'.$post_id.'">'."\n\t\t\t";
	$tmplt.= '<div class="kudo-meta-alpha'.$metaclass.'">'."\n\t\t\t\t";
	$tmplt.= '<span class="kudo-count">'.get_kudos_count($post_id).'</span>'."\n\t\t\t";


	if (!empty($text))
		$tmplt.= "\t".'<span class="kudo-text">'.str_replace('//','<br />',esc_html__($text)).'</span>'."\n\t\t\t";


	$tmplt.= '</div>'."\n\t\t\t";
	$tmplt.= $beta;
	$tmplt.= '</div>'."\n\t";
	return $tmplt;
}

/**
 * Returns the kudo html code for a specific post for echoing.
 *
 * @since 1.0
 *
 * @param  int  		$post_id 	id of post to retrieve kudo for
 * @param  boolean 	$counter 	if counter should be printed as well
 * @return string           	Kudo html code
 */
function get_kudos( $post_id = null, $attr ){
	extract( $attr );
	//	$class, $style, $counter, $text, $hover
	$post_id = ( null === $post_id ) ? get_the_ID() : $post_id;


	$style = isset($style) && !empty($style) ? trim($style) : "";
	$class = isset($class) && !empty($class) ? " ".trim($class) : "";

	// needs fixing
	$options = get_option('kudos');
	$legals = array('off','t_l','t_r','c_tl','c_tr');
	if (in_array($options['position'],$legals)) {
		$css = 'style="margin:';
		for ($i = 0; $i < 4; $i++)
			$css .= $options['margins'][$i].'px ';
		$css = ' '.trim($css).';'.esc_attr__($style).'"';
	}else
		$css = !empty($style) ? ' style="'.esc_attr__($style).'"':'';

	$tmplt = "\n<!-- Kudos ".KUDO_VER."-->\n";
	$tmplt.= '<div class="kudo-box'.esc_html__($class).'"'.$css.'>'."\n\t";
	$tmplt.= '<figure class="kudo kudoable" data-id="'.$post_id.'">'."\n\t\t";
	$tmplt.= '<a class="kudo-object">'."\n\t\t\t";
	$tmplt.= '<div class="kudo-opening"><div class="kudo-circle">&nbsp;</div></div>'."\n\t\t";
	$tmplt.= '</a>'."\n\t\t";

	if (!isset($counter) || !is_bool($counter)){
		$counter = isset($options['counter']) ? $options['counter'] : true;
	}

	if ($counter)
		$tmplt .= kudos_count( $post_id, isset($text)?$text:null, isset($hover)?hover:null );

	$tmplt.= '</figure>'."\n";
	$tmplt.= '</div>'."\n\n";

	return $tmplt;
}

/**
 * Prints get_kudos.
 *
 * @since 1.0
 *
 * @param  boolean $counter if counter should be printed as well
 */
function kudos() {
	echo get_kudos();
}
