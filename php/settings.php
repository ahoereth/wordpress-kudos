<?php
class kudos_settings {

	/**
	 * Initializes the functions for creating the options page (with menu item and
	 * styles) and options settings.
	 *
	 * @since 1.0
	 */
	public function __construct() {
		add_action( 'admin_menu', 				array( &$this, 'menu' ) );
		add_action( 'admin_init', 				array( &$this, 'register' ) );
	}

	/**
	 * Adds the options page (with menu item) and adds the action for enqueuing
	 * the settings.css
	 *
	 * @since 1.0
	 */
	public function menu(){
		$hook = add_options_page( 'Kudos Settings', 'Kudos', 'manage_options', 'kudos', array( &$this, 'page' ) );

    add_action('admin_print_scripts-'.$hook, array( &$this, 'enqueue' ));
	}

	/**
	 * Enqueues the settings.css
	 *
	 * @since 1.0
	 */
	public function enqueue(){
		wp_enqueue_style( 'kudos_settings', KUDO_URL . 'css/settings.css', array(), FVP_VERSION, FALSE );
		wp_enqueue_script('kudos_settings', KUDO_URL .  'js/settings.js',  array('jquery'), FVP_VERSION, FALSE );
	}

	/**
	 * Registers the 'kudos' setting, initializes the settings section and it's
	 * fields.
	 *
	 * @since 1.0
	 */
	public function register(){
		register_setting( 'kudos', 'kudos', array( &$this, 'save' ));

		// settings section without title and without description text
		add_settings_section('kudos-section', '', '', 'kudos');

		add_settings_field('kudos-position', 	__('Postion', 									'kudos'), array( &$this, 'position' ), 'kudos', 'kudos-section');
		add_settings_field('kudos-margins', 	__('Margins', 									'kudos'), array( &$this, 'margins' 	), 'kudos', 'kudos-section');
		add_settings_field('kudos-php', 			__('PHP-Functions', 						'kudos'), array( &$this, 'php' 			), 'kudos', 'kudos-section');
		add_settings_field('kudos-refresh', 	__('AJAX Counter Refresh-Rate', 'kudos'), array( &$this, 'refresh' 	), 'kudos', 'kudos-section');
		add_settings_field('kudos-lifetime', 	__('Cookie Lifetime', 					'kudos'), array( &$this, 'lifetime' ), 'kudos', 'kudos-section');
		add_settings_field('kudos-defaults',  __('Defaults', 									'kudos'), array( &$this, 'defaults' ), 'kudos', 'kudos-section');
	}

	/**
	 * Prints the structure for the settings page.
	 *
	 * @since 1.0
	 */
	public function page(){ ?>

	<div class="wrap">
	    <?php screen_icon(); ?>
	    <h2>Kudos Settings</h2>
	    <form method="post" action="options.php">

		<?php
			settings_fields('kudos');
			do_settings_sections('kudos');
			submit_button();
		?>

	    </form>
	</div>

<?php	}

	/**
	 * Prints the settings for Kudo positioning. A big table containing radios
	 * for setting row and column of the desired position. Also contains a pointer
	 * to the available PHP functions (described in php()).
	 *
	 * @since 1.0
	 */
	public function position() {
		$options  = get_option( 'kudos' );
		$position = isset($options['position']) ? $options['position'] : 'c_tr';
		$excerpt  = isset($options['excerpt' ]) &&
							is_bool($options['excerpt' ]) ? $options['excerpt' ] : false; ?>


<p><?php _e('Define where the plugin displays the Kudos in each post.','kudo'); ?></p>
<table class="kudos-radios">
	<tr class="kudos-top">
		<td class="kudos-left">
			<?php _e('Left','kudos'); ?>
		</td>
		<td>
			<?php _e('Center','kudos'); ?>
		</td>
		<td>
			<?php _e('Right','kudos'); ?>
		</td>
		<td colspan="2">
			<input type="radio" name="kudos[position]" id="kudos-position-off"  value="off"  <?php checked( 'off', 	$position, true ) ?>/>
		</td>
		<td class="kudos-left">
			<label for="kudos-position-off">Disable</label>
		</td>
	</tr>
	<tr>
		<td class="kudos-left">
			<input type="radio" name="kudos[position]" id="kudos-position-c_tl" value="c_tl" <?php checked( 'c_tl', 	$position, true ) ?>/>
		</td>
		<td>
			<input type="radio" name="kudos[position]" id="kudos-position-c_tc" value="c_tc" <?php checked( 'c_tc', 	$position, true ) ?>/>
		</td>
		<td class="kudos-default">
			<input type="radio" name="kudos[position]" id="kudos-position-c_tr" value="c_tr" <?php checked( 'c_tr', 	$position, true ) ?>/>
		</td>
		<td colspan="2">
			<label for="kudos-position-c_tr">Top</label><br />
		</td>
		<td>
			<label for="kudos-excerpt">Excerpt</label>
		</td>
	</tr>
	<tr>
		<td class="kudos-left">
			<input type="radio" name="kudos[position]" id="kudos-position-c_bl" value="c_bl" <?php checked( 'c_bl', 	$position, true ) ?>/>
		</td>
		<td>
			<input type="radio" name="kudos[position]" id="kudos-position-c_bc" value="c_bc" <?php checked( 'c_bc', 	$position, true ) ?>/>
		</td>
		<td>
			<input type="radio" name="kudos[position]" id="kudos-position-c_br" value="c_br" <?php checked( 'c_br', 	$position, true ) ?>/>
		</td>
		<td colspan="2">
			<label for="kudos-position-c_br">Bottom</label><br />
		</td>
		<td style="border-top-width: 0;">
			<input type="checkbox" name="kudos[excerpt]" id="kudos-excerpt" value="true" <?php checked( true, $excerpt, true ) ?>/>
		</td>
	</tr>
	<tr>
		<td class="kudos-left">
			<input type="radio" name="kudos[position]" id="kudos-position-t_l"  value="t_l"  <?php checked( 't_l', 	$position, true ) ?>/>
		</td>
		<td>
			&nbsp;
		</td>
		<td>
			<input type="radio" name="kudos[position]" id="kudos-position-t_r"  value="t_r" <?php checked( 't_r', 	$position, true ) ?>/>
		</td>
		<td colspan="3">
			<label for="kudos-position-t_r">Title <i>(experimental)</i></label><br />
		</td>
	</tr>
</table>
<p class="description">
	<?php printf(__('You can also %sdisable%s the auto integration and make use of the PHP-Functions below.','kudo'),'<label for="kudos-position-off"><u>','</u></label>'); ?><br />
	<?php _e('By default Kudos are displayed in the content\'s top right, but not in the excerpts.','kudos'); ?><br />
	<?php printf(__('The Title-Options are experimental, because they might result in Kudos being displayed in navigations etc. You can fix this using CSS addressing something like %s, while %s is the css class of your navigation.','kudos'),'<code>.navigation .kudos-box{ display: none; }</code>', '<code>.navigation</code>'); ?>
</p>

<?php
	}

	/**
	 * Prints input fields and description for the Kudos' margins. Hidden via
	 * JS when not if interest.
	 *
	 * @since 1.0
	 */
	public function margins() {
		$options = get_option('kudos');
		$margins = isset($options['margins'])? $options['margins']:array(0,0,30,30);
		for ($i = 0; $i < 4; $i++)
			$margins[$i] = is_numeric($margins[$i]) ? $margins[$i] : 0;
	?>

<p><?php printf(
	__('When auto positioning is set to %stop left%s, %stop right%s or
			%sdisabled%s you can here define margins for around the Kudos.','kudos'),
			'<label for="kudos-position-c_tl"><u>','</u></label>',
			'<label for="kudos-position-c_tr"><u>','</u></label>',
			'<label for="kudos-position-off"><u>','</u></label>'); ?></p>
<div id="kudos-margins">
	<table class="kudos-radios">
		<tr class="kudos-top">
			<td class="kudos-left">
				<label for="kudos-margins-0">Top</label>
			</td>
			<td>
				<label for="kudos-margins-1">Right</label>
			</td>
			<td>
				<label for="kudos-margins-2">Bottom</label>
			</td>
			<td>
				<label for="kudos-margins-3">Left</label>
			</td>
			<td class="kudos-left">
				&nbsp;
			</td>
		</tr>
		<tr>
			<td class="kudos-left">
				<input type="text" name="kudos[margins][0]" id="kudos-margins-0" value="<?php echo $margins[0]; ?>" size="3" maxlength="3" style="text-align: right; width: 2.5em;" />
			</td>
			<td>
				<input type="text" name="kudos[margins][1]" id="kudos-margins-1" value="<?php echo $margins[1]; ?>" size="3" maxlength="3" style="text-align: right; width: 2.5em;" />
			</td>
			<td>
				<input type="text" name="kudos[margins][2]" id="kudos-margins-2" value="<?php echo $margins[2]; ?>" size="3" maxlength="3" style="text-align: right; width: 2.5em;" />
			</td>
			<td>
				<input type="text" name="kudos[margins][3]" id="kudos-margins-3" value="<?php echo $margins[3]; ?>" size="3" maxlength="3" style="text-align: right; width: 2.5em;" />
			</td>
			<td>
				<label for="kudos-margins-0">px</label>
			</td>
		</tr>
	</table>
</div>

<?php	}

	/**
	 * Prints information on the available PHP-Functions.
	 *
	 * @since 1.0
	 */
	public function php(){ ?>

<p><?php printf(__('You can make use of the following functions in your code to
integrate Kudos into your theme:','kudos')); ?></p>
<ul class="kudos-functions">
	<li><code>kudos()</code>&nbsp;-&nbsp;<?php printf(__('Use in %sThe Loop%s; Echos the current post\'s Kudos button with default settings.','kudos'), '<a href="http://codex.wordpress.org/The_Loop" target="_blank">', '</a>'); ?></li>
	<li><code>get_kudos( $post_id, $attr )</code>&nbsp;-&nbsp;<?php printf(__('Returns the Kudos button. If %s is provided it needs to be an associative array containing any of the following keys:','kudos'),'<code>$attr</code>'); ?>
		<ul>
			<li><code>class</code>&nbsp;<?php _e(' additional values for the HTML class attribute.','kudos'); ?></li>
			<li><code>style</code>&nbsp;<?php _e('Value for the HTML style attribute.','kudos'); ?></li>
			<li><code>counter</code>&nbsp;<?php _e('Boolean defining if the kudos counter should be printed.','kudos'); ?></li>
			<li><code>text</code>&nbsp;<?php _e('Text to display below the count number. Pass an empty string to hide.','kudos'); ?></li>
			<li><code>hover</code>&nbsp;<?php _e('Text to display on mouse hover. Empty string for no changing text.','kudos'); ?></li>
		</ul>
	</li>
	<li><code>kudos_count( $post_id, $text, $hover )</code>&nbsp;-&nbsp;<?php _e('Echos the Kudos-Counter. Use this for live-incrementing.','kudos'); ?></li>
	<li><code>get_kudos_count( $post_id )</code>&nbsp;-&nbsp;<?php _e('Returns the Kudos-Count as static integer.','kudos'); ?></li>
	<li><?php printf(__('All parameters are optional. For %s, %s and %s you can set the defaults at the bottom of this page.','kudos'),
	'<code>$counter</code>','<code>$text</code>',
	'<code>$hover</code>'); ?></li>
</ul>
<p class="description"><strong><?php _e('Note','kudos'); ?>:</strong>&nbsp;
<?php printf(__('When updating your theme your changes will most likely be overwrite, so consider using a %sChild Theme%s and wrapping the functions in %s conditionals.','kudos'),
'<a href="http://codex.wordpress.org/Child_Themes" target="_blank">','</a>',
'<a href="http://codex.wordpress.org/Managing_Plugins#Hiding_Plugins_When_Deactivated" target="_blank">function_exists()</a>'); ?></p>

<?php }

	/**
	 * Prints the input field and description for setting the counter AJAX refresh
	 * rate.
	 *
	 * @since 1.0
	 */
	public function refresh() {
		$options = get_option('kudos');
		$refresh = isset($options['refresh']) && is_numeric($options['refresh']) ? $options['refresh'] : 5000; ?>

<input type="text" name="kudos[refresh]" id="kudos-refresh" value="<?php echo $refresh; ?>" size="6" maxlength="6" style="text-align: right; width: 4.5em;" />
<label for="kudos-refresh">&nbsp;ms</label>
<label class="kudos-default">(<?php _e('default', 'kudos'); ?>: <code>5000</code>)</label>
<p class="description"><?php _e('Setting this value to 0 will deactivate the AJAX refresh of Kudo counts while the user is viewing the page. The counts will still be updated when the page is (re-)loaded.', 'kudos'); ?></p>

<?php }

	/**
	 * Prints the input field and description for setting the cookie lifetime.
	 *
	 * @since 1.0
	 */
	public function lifetime() {
		$options  = get_option('kudos');
		$lifetime = isset($options['lifetime']) && is_numeric($options['lifetime']) ? $options['lifetime'] : 1460; ?>

<input type="text" name="kudos[lifetime]" id="kudos-lifetime" value="<?php echo $lifetime; ?>" size="6" maxlength="6" style="text-align: right; width: 4.5em;" />
<label for="kudos-lifetime">&nbsp;days&nbsp;</label>
<label class="kudos-default">(<?php _e('default', 'kudos'); ?>: <code>1460</code>)</label>
<p class="description"><?php printf( __('Cookies are used for saving which kudos have been triggered by the specific visitor. Read more on cookies %shere%s.', 'kudos'), '<a href="http://en.wikipedia.org/wiki/HTTP_cookie" target="_blank">', '</a>'); ?></p>
<p class="description"><strong><?php _e('Note','kudos'); ?>:</strong>&nbsp;<?php _e('Setting this value to 0 deletes cookies when the user leaves your site. This will result in the visitors being able to kudo posts again when they return to your website, which might spoil the counts.', 'kudos'); ?></p>

<?php }

	/**
	 * Prints input fields for setting the default options on displaying a
	 * counter and which strings (inactive and active) to use.
	 *
	 * @since 1.0
	 */
	public function defaults() {
		$options = get_option('kudos');
		$text 	 = isset($options['text'   ]) ? $options['text'   ] : 'Kudos';
		$hover 	 = isset($options['hover'  ]) ? $options['hover'  ] : "Don't//move!";
		$counter = isset($options['counter']) &&
						 is_bool($options['counter']) ? $options['counter'] : true; ?>

<span style="float: left; width: 137px; text-align: right; margin-right: 4px;"><input type="checkbox" name="kudos[counter]" id="kudos-counter" value="true" <?php checked( true, $counter, true ); ?> /></span>
<label for="kudos-counter">&nbsp;Counter</label><br />
<input type="text" name="kudos[text]"  id="kudos-text"  value="<?php echo $text;  ?>" style="width: 136px;" />
<label for="kudos-text">&nbsp;Text&nbsp;</label><br />
<input type="text" name="kudos[hover]" id="kudos-hover" value="<?php echo $hover; ?>" style="width: 136px;" />
<label for="kudos-text">&nbsp;Hover Text&nbsp;</label><br />
<p class="description"><?php _e('No HTML allowed. For line breaks use // (double slash).','kudos'); ?></p>

<?php }

	/**
	 * Called when saving the options of the 'kudos-section' on the 'kudos'
	 * settings page. Saves all data into the 'kudos' option.
	 *
	 * @since 1.0
	 *
	 * @param array $input contains all form post data
	 * @return array for saving into $options['kudos']
	 */
	public function save($input) {
		$options = get_option('kudos');

		$options['lifetime'] = is_numeric($input['lifetime']) ? $input['lifetime'] : 1460;
		$options['refresh' ] = is_numeric($input['refresh' ]) ? $input['refresh' ] : 50000;

		$legals = array('off','t_l','t_r','c_tl','c_tc','c_tr','c_bl','c_bc','c_br');
		$options['position' ] = in_array($input['position'],$legals) ? $input['position'] : 'c_tr';
		$options['excerpt'] 	= isset($input['excerpt']) ? true : false;

		for ($i = 0; $i < 2; $i++)
			$options['margins'][$i] = is_numeric($input['margins'][$i]) ? $input['margins'][$i] : 0;
		for ($i = 2; $i < 4; $i++)
			$options['margins'][$i] = is_numeric($input['margins'][$i]) ? $input['margins'][$i] : 30;

		$options['counter'] = isset($input['counter']) ? true : false;
		$options['text' ] 	= esc_html__($input['text' ]);
		$options['hover'] 	= esc_html__($input['hover']);

		return $options;
	}

}
