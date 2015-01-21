<?php
/**
 * Plugin Name: Omnomnom
 * Plugin URI: http://scotchfield.com/
 * Description: Replace any instance of om with omnomnom.
 * Version: 0.1
 * Author: Scott Grant
 * Author URI: http://scotchfield.com/
 * License: GPL2
 */
class WP_Omnomnom {

	/**
	 * Store reference to singleton object.
	 */
	private static $instance = null;

	/**
	 * Regex to match, and replacement to use. Om-nom-nom.
	 */
	const STR_FIND = '/om/',
	      STR_REPLACE = 'om-nom-nom';

	/**
	 * Instantiate, if necessary, and add hooks.
	 */
	public function __construct() {
		if ( isset( self::$instance ) ) {
			wp_die( esc_html__( 'The WP_Omnomnom class has already been instantiated.', self::DOMAIN ) );
		}

		self::$instance = $this;

		add_action( 'the_post', array( $this, 'the_post_nom' ) );

		add_filter( 'gettext', array( $this, 'gettext_nom' ) );
	}

	/**
	 * Replace any instances found in posts.
	 */
	public function the_post_nom( $post ) {
		if ( isset( $post->omnomnom ) ) {
			return;
		}

		$post->post_title = preg_replace( self::STR_FIND, self::STR_REPLACE, $post->post_title );
		$post->post_content = preg_replace( self::STR_FIND, self::STR_REPLACE, $post->post_content );

		$post->omnomnom = true;
	}

	/**
	 * Replace any instances found in translated text.
	 */
	public function gettext_nom( $translated_text ) {
		return preg_replace( self::STR_FIND, self::STR_REPLACE, $translated_text );
	}
}

$wp_nomnomnom = new WP_Omnomnom();
