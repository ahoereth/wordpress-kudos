<?php
/**
 * Function used for updating the options when the plugin was upgraded.
 */
function kudos_upgrade() {
	$options = $options_org = get_option( 'kudos' );

	if( !isset($options['version']) )
		$version = '0';
	else
		$version = $options['version'];

	if( $version != KUDO_VER ) {
		switch( $version ) {
			case '0':
				$notice = 'initial_activation';

				$options['position'] 	  = 'c_tr'; // (off,t_l,t_r,c_tl,c_tc,c_tr,c_bl,c_bc,c_br)
				$options['excerpt' ] 		= false;
				$options['margins' ][0] = $options['margins'][0]  = 0;
				$options['margins' ][2] = $options['margins'][3]  = 30;
				$options['refresh' ] 	  = 5000;
				$options['lifetime'] 	  = 1460;
				$options['counter' ] 		= true;
				$options['text' 	 ] 		= 'Kudos';
				$options['hover' 	 ] 		= "Don't//move!";

			case '1':
				$options['unkudo'  ]	 	= true;

			// *************************************************************
			// required on every upgrade
			$options['version'] = KUDO_VER;
			break;
		}
	}

	if( $options != $options_org )
		update_option( 'kudos', $options );

}

?>