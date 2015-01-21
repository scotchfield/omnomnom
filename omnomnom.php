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

	const STR_FIND = 'om',
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

	// todo: this will break forms! better way, please.. omnomnom..
	public function the_post_nom( $post ) {
		if ( isset( $post->omnomnom ) ) {
			return;
		}

		$nom_obj = explode( self::STR_FIND, $post->post_title );
		$post->post_title = implode( self::STR_REPLACE, $nom_obj );

		$nom_obj = explode( self::STR_FIND, $post->post_content );
		$post->post_content = implode( self::STR_REPLACE, $nom_obj );

		$post->omnomnom = true;
	}

	public function gettext_nom( $translated_text ) {
		$nom_obj = explode( self::STR_FIND, $translated_text );
		return implode( self::STR_REPLACE, $nom_obj );
	}
}

$wp_nomnomnom = new WP_Omnomnom();
