<?php

class kudos_help{
	private $settings;
	private $functions;
	private $shortcode;

	public function __construct($settings_instance){
		$this->settings = $settings_instance;

		add_action( 'admin_init', 										array( &$this, 'init' ) );
		add_action( 'admin_menu', array( &$this, 'load' ), 20 );
		if (get_bloginfo('version') < 3.3)
			add_filter( 'contextual_help', 	array( &$this, 'pre33' ), 10, 3 );
	}

	/**
	 * Required to delay the add_action until we can access the options page hook
	 * @return [type] [description]
	 */
	public function load(){
		add_action( 'load-'.$this->settings->hook, array( &$this, 'tabs' ) );
	}

	/**
	 * Initializes the help texts.
	 *
	 * @since 1.1
	 */
	public function init() {
		$this->functions = '
<p>'.sprintf(__('You can make use of the following functions in your code to integrate Kudos into your theme:','kudos')).'</p>
<ul class="kudos-code">
	<li><code>kudos()</code>&nbsp;-&nbsp;'.sprintf(__('Use in %sThe Loop%s; Echos the current post\'s Kudos button with default settings.','kudos'), '<a href="http://codex.wordpress.org/The_Loop" target="_blank">', '</a>').'</li>
	<li><code>get_kudos( $post_id, $attr )</code>&nbsp;-&nbsp;'.sprintf(__('Returns the Kudos button. If %s is provided it needs to be an associative array containing any of the following keys:','kudos'),'<code>$attr</code>').'
		<ul>
			<li><code class="kudos-float">class</code>&nbsp;'.	__('Additional values for the HTML class attribute.','kudos').'</li>
			<li><code class="kudos-float">style</code>&nbsp;'.	__('Value for the HTML style attribute.','kudos').'</li>
			<li><code class="kudos-float">counter</code>&nbsp;'.__('Boolean defining if the kudos counter should be printed.','kudos').'</li>
			<li><code class="kudos-float">text</code>&nbsp;'.		__('Text to display below the count number. Pass an empty string to hide.','kudos').'</li>
			<li><code class="kudos-float">hover</code>&nbsp;'.	__('Text to display on mouse hover. Empty string for no changing text.','kudos').'</li>
		</ul>
	</li>
	<li><code>kudos_count( $post_id, $text, $hover )</code>&nbsp;-&nbsp;'.__('Echos the Kudos-Counter. Use this for live-incrementing.','kudos').'</li>
	<li><code>get_kudos_count( $post_id )</code>&nbsp;-&nbsp;'.__('Returns the Kudos-Count as static integer.','kudos').'</li>
</ul>
<p>'.sprintf(__('All parameters are optional. For %s, %s and %s you can set the defaults at the bottom of this page.','kudos'),
	'<code>$counter</code>','<code>$text</code>',
	'<code>$hover</code>').'</p>
<p class="description"><strong>'.__('Note','kudos').':</strong>&nbsp;
'.sprintf(__('When updating your theme your changes will most likely be overwrite, so consider using a %sChild Theme%s and wrapping the functions in %s conditionals.','kudos'),
'<a href="http://codex.wordpress.org/Child_Themes" target="_blank">','</a>',
'<a href="http://codex.wordpress.org/Managing_Plugins#Hiding_Plugins_When_Deactivated" target="_blank">function_exists()</a>').'</p>'."\n";

		$this->shortcode ='
<ul class="kudos-code">
	<li><code>[kudos]</code>:&nbsp;'.__('Displays Kudos for the current post. Of interest when auto positioning is disabled.','kudos').'
		<ul>
			<li><code class="kudos-float">class</code>&nbsp;Default: <code>kudo-c_tr</code></li>
	   	<li><code class="kudos-float">style</code>&nbsp;Any CSS you would like.</li>
	   	<li><code class="kudos-float">counter</code>&nbsp;Boolean, true or false</li>
	    <li><code class="kudos-float">text</code>&nbsp;Text below counter</li>
	    <li><code class="kudos-float">hover</code>&nbsp;Text displayed on hover</li>
	  </ul>
  </li>
</ul>
<p>'.__('<code>counter</code>, <code>text</code> and <code>hover</code> by default are set to the values you can specify at the end of this page. Set css margins using the settings below.','kudos').'</p>
<p>'.__('Example usage:','kudos').'<code>[kudos class=kudo-c_tl]</code>'."\n";
	}

	/**
	 * Adds help tabs to contextual help. WordPress 3.3+
	 *
	 * @see http://codex.wordpress.org/Function_Reference/add_help_tab
	 *
	 * @since 1.1
	 */
	public function tabs() {
		$screen = get_current_screen();
		if( ($screen->id != $this->settings->hook) || (get_bloginfo('version') < 3.3) )
			return;

		// PHP FUNCTIONS HELP TAB
		$screen->add_help_tab( array(
			'id' 			=> 'kudos_functions',
			'title'   => 'Kudos: '.__('PHP-Functions','kudos'),
			'content' => $this->functions
		));

		// SHORTCODE HELP TAB
		$screen->add_help_tab( array(
			'id' 			=> 'kudos_shortcode',
			'title'   => 'Kudos: Shortcode',
			'content' => $this->shortcode
		));
	}

	/**
	 * Adds help text to contextual help. WordPress 3.3-
	 *
	 * @see http://wordpress.stackexchange.com/a/35164
	 *
	 * @since 1.1
	 */
	public function pre33( $contextual_help, $screen_id, $screen ) {
		if( $screen->id != $this->settings->hook )
			return $contextual_help;

		$contextual_help  = '<hr /><h3>Kudos: '.__('PHP-Functions','kudos').'</h3>';
		$contextual_help .= $this->functions;
		$contextual_help .= '<h3>Kudos: Shortcode</h3>';
		$contextual_help .= $this->shortcode;

		return $contextual_help;
	}

}
