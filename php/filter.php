<?php
class kudos_filter {

	/**
	 * Initializes the different function for filtering the title, content and
	 * excerpt depending on which options have been set.
	 *
	 * @since 1.0
	 */
	public function __construct() {
		$options = get_option('kudos');
		switch( substr($options['position'],0,1) ) {
			case 't':
				add_filter( 	'the_title', 	 array( &$this, 'title' 	));
				break;
			default:
			case 'c':
				add_filter( 	'the_content', 			array( &$this, 'content'));
				if (isset($options['excerpt']) && $options['excerpt'])
					add_filter( 'get_the_excerpt', 	array( &$this, 'excerpt'));
				break;
		}
	}

	/**
	 * Function filtering the content. Depending on the position set in the
	 * settings it adds the kudos to the beginning or end of the content and
	 * specifies the proper class for floating etc.
	 *
	 * @since 1.0
	 *
	 * @param  string $content content before filtering
	 * @return string 				 content + Kudos
	 */
	public function content($content) {
		if (is_feed())
			return $content;

		$post_id = get_the_ID();
		$options = get_option('kudos');

		if (!isset($options['position']))
			$options['position'] = 'c_ml';

		switch ($options['position']){
			case 'c_tl':
				$tmplt = get_kudos( $post_id, array( 'class' => 'kudo-c_tl' ) );
				return $tmplt.$content;
				break;
			case 'c_tc':
				$tmplt = get_kudos( $post_id, array( 'class' => 'kudo-c_tc' ) );
				return $tmplt.$content;
				break;
			case 'c_tr':
				$tmplt = get_kudos( $post_id, array( 'class' => 'kudo-c_tr' ) );
				return $tmplt.$content;
				break;
			case 'c_bl':
				$tmplt = get_kudos( $post_id, array( 'class' => 'kudo-c_bl' ) );
				return $content.$tmplt;
				break;
			case 'c_bc':
				$tmplt = get_kudos( $post_id, array( 'class' => 'kudo-c_bc' ) );
				return $content.$tmplt;
				break;
			case 'c_br':
				$tmplt = get_kudos( $post_id, array( 'class' => 'kudo-c_br' ) );
				return $content.$tmplt.'<br style="clear: both;" />';
				break;
			case 'c_ml': // planned for future version
			case 'c_mr': // planned for future version
			default:
				return $content;
				break;
		}
	}

	/**
	 * Used for filtering post excerpts and adding the kudos.
	 *
	 * @since 1.0
	 *
	 * @uses $this->content
	 * @param  string $excerpt excerpt before filtering
	 * @return string          excerpt + Kudos
	 */
	public function excerpt($excerpt){
		return $this->content($excerpt);
	}

	/**
	 * Used for filtering the post titles and adding Kudos to the left or right of
	 * the title text.
	 *
	 * @since 1.0
	 *
	 * @param  string $title title before filtering
	 * @return string        title + Kudos
	 */
	public function title($title) {
		$post_id = get_the_ID();
		$options = get_option('kudos');

		if (!isset($options['position']))
			$options['position'] = 't_r';

		switch ($options['position']){
			case 't_l':
				$tmplt = get_kudos( $post_id, array( 'class' => 'kudo-t_l' ) );
				return $tmplt.$title.'<br style="clear: both;">';
				break;
			case 't_r':
				$tmplt = get_kudos( $post_id, array( 'class' => 'kudo-t_r' ) );
				return $title.$tmplt.'<br style="clear: both;">';
				break;
			default:
				return $title;
				break;
		}
	}

}
