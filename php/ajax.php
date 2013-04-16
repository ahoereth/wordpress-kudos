<?php
class kudos_ajax {

	/**
	 * Initializes the AJAX functions with the wp_ajax and wp_ajax_nopriv
	 * (no privileges) hooks.
	 *
	 * @since 1.0
	 */
	public function __construct() {
		add_action( 'wp_ajax_kudo', 				 			array( &$this, 'kudo' 		 ));
		add_action( 'wp_ajax_nopriv_kudo',   			array( &$this, 'kudo' 		 ));

		add_action( 'wp_ajax_unkudo', 			 			array( &$this, 'unkudo' 	 ));
		add_action( 'wp_ajax_nopriv_unkudo', 			array( &$this, 'unkudo' 	 ));

		add_action( 'wp_ajax_kudocounts', 			 	array( &$this, 'kudocounts'));
		add_action( 'wp_ajax_nopriv_kudocounts', 	array( &$this, 'kudocounts'));
	}

	/**
	 * Fired when a kudo is triggered for incrementing the post's kudo count.
	 *
	 * @since 1.0
	 *
	 * Expects:
	 * $_POST['nonce'] - WP Security Nonce
	 * $_POST['id']		 - post id of target post
	 *
	 * Returns:
	 * success 	- boolean
	 * time 		- int; time of response
	 * count 		- int; Kudos count
	 * message 	- string; short message of error / success
	 */
	public function kudo() {
		header( "Content-Type: application/json" );

		if (!isset( $_POST['nonce'] ) ||
				!wp_verify_nonce( $_POST['nonce'], 'kudos-nonce' ))
			exit( json_encode( array(
				'success' => false,
				'time' 		=> time(),
				'count' 	=> 0,
				'message' => 'invalid nonce'
			) ) );

		// increment kudo count in database
		$count = get_post_meta($_POST['id'], '_kudos', true);
		if( empty($count) || $count < 0 ) $count = 0;
		update_post_meta( $_POST['id'], '_kudos', ++$count );

		// return results
		echo json_encode( array(
			'success' => true,
			'time' 		=> time(),
			'count' 	=> $count,
			'message' => 'count incremented'
		) );
		exit;
	}

	/**
	 * Fired when an complete kudo is clicked for decrementing the post's kudo
	 * count.
	 *
	 * @since 1.0
	 *
	 * Expects:
	 * $_POST['nonce'] - WP Security Nonce
	 * $_POST['id']		 - post id of target post
	 *
	 * Returns:
	 * success 	- boolean
	 * time 		- int; time of response
	 * count 		- int; Kudos count
	 * message 	- string; short message of error / success
	 */
	public function unkudo() {
		header( "Content-Type: application/json" );

		if (!isset( $_POST['nonce'] ) ||
				!wp_verify_nonce( $_POST['nonce'], 'kudos-nonce' )) {
			exit( json_encode( array(
				'success' => false,
				'time' 		=> time(),
				'count' 	=> 0,
				'message' => 'invalid nonce'
			) ) );
		}

		// decrement kudo count in database
		$count = get_post_meta($_POST['id'], '_kudos', true);
		if( empty($count) || $count <= 0) $count = 1;
		if( $count == 1 )
			delete_post_meta( $_POST['id'], '_kudos' );
		else
			update_post_meta( $_POST['id'], '_kudos', --$count );

		// return results
		echo json_encode( array(
			'success' => true,
			'time' 		=> time(),
			'count' 	=> $count,
			'message' => 'count decremented'
		) );
		exit;
	}

	/**
	 * Used for auto updating kudo counts without reloading the page.
	 *
	 * @since 1.0
	 *
	 * Expects:
	 * $_POST['nonce']
	 * $_POST['ids']
	 *
	 * Returns
	 * success 	- boolean
	 * time 		- int; time of response
	 * counts 	- assoc int array; post_id => count pairs
	 * message 	- string; short message of error / success
	 */
	public function kudocounts() {
		header( "Content-Type: application/json" );

		// check nonce
		if (!isset( $_POST['nonce'] ) ||
				!wp_verify_nonce( $_POST['nonce'], 'kudos-nonce' )) {
			exit( json_encode( array(
				'success' => false,
				'message' => 'invalid nonce'
			) ) );
		}

		$counts = array();
		foreach( $_POST['ids'] as $id )
			$counts[$id] = get_kudos_count( $id );

		// return results
		echo json_encode( array(
			'success' => true,
			'time' => time(),
			'counts' => $counts
		) );
		exit;
	}

}
