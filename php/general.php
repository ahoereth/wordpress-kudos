<?php
class kudos {

	/**
	 * Enqueue all scripts and styles
	 *
	 * @since 1.0
	 */
	public function enqueue($hook_suffix) {
		// just required on post.php
		if( !is_admin() ) {
			$options = get_option( 'kudos' );

			wp_enqueue_style( 'kudos', KUDO_URL . 'css/kudos.css', array(), KUDO_VER, false );

			wp_enqueue_script( 'jquery' );
			wp_enqueue_script( 'jquery.cookie', KUDO_URL . 'js/jquery.cookie.js', array('jquery'), KUDO_VER, false );
			wp_enqueue_script( 'kudos', KUDO_URL . 'js/kudos.js', array( 'jquery', 'jquery.cookie' ), KUDO_VER, false );

			wp_localize_script( 'kudos', 'kudosdata', array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'nonce' 	=> wp_create_nonce( 'kudos-nonce' ),
				'refresh' => isset($options['refresh' ]) ? $options['refresh' ] : 5000,
				'lifetime'=> isset($options['lifetime']) ? $options['lifetime'] : 1460
			) );

		}
	}

	/**
	 * [shortcode description]
	 * @param  [type] $atts    [description]
	 * @param  [type] $content [description]
	 * @return [type]          [description]
	 */
	public function shortcode( $atts, $content = null ) {
   extract( shortcode_atts( array(
   		'class' 	=> 'kudo-c_tr',
   		'style' 	=> null,
   		'counter' => true,
      'text' 		=> null,
      'hover' 	=> null
      ), $atts ) );

		return get_kudos(null, array(
			'class' 	=> $class,
			'style' 	=> $style,
			'counter' => $counter,
			'text' 		=> $text,
			'hover' 	=> $hover
		));
	}

}
