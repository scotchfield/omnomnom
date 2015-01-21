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
	 * The domain for localization.
	 */
	const DOMAIN = 'wp-omnomnom';

	/**
	 * Default regex to match, and replacement to use. Om-nom-nom.
	 */
	const STR_FIND = 'om';
	const STR_REPLACE = 'om-nom-nom';

	/**
	 * Instantiate, if necessary, and add hooks.
	 */
	public function __construct() {
		if ( isset( self::$instance ) ) {
			wp_die( esc_html__( 'The WP_Omnomnom class has already been instantiated.', self::DOMAIN ) );
		}

		self::$instance = $this;

		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		add_action( 'the_post', array( $this, 'the_post_nom' ) );

		add_filter( 'gettext', array( $this, 'gettext_nom' ) );

		$this->update_strings();
	}

	/**
	 * Get strings from options and sanitize for display.
	 */
	private function update_strings() {
		$this->str_find = esc_html( get_option( 'omnomnom_find', self::STR_FIND ) );
		$this->str_replace = esc_html( get_option( 'omnomnom_replace', self::STR_REPLACE ) );
	}

	/**
	 * Add a link to a simple omnomnom settings page.
	 */
	public function admin_menu() {
		$page = add_options_page(
			'Omnomnom Settings',
			'Omnomnom',
			'manage_options',
			self::DOMAIN,
			array( $this, 'plugin_settings_page' )
		);
	}

	/**
	 * Show a simple form and check for admin-submitted updates to the strings. Nom anything.
	 */
	public function plugin_settings_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', self::DOMAIN ) );
		}

		if ( isset( $_POST[ 'omnomnom-update' ] ) && wp_verify_nonce( $_POST[ 'wp_nonce' ], 'omnomnom-update' ) ) {

			if ( isset( $_POST[ 'str_find' ] ) ) {
				update_option( 'omnomnom_find', $_POST[ 'str_find' ] );
			}
			if ( isset( $_POST[ 'str_replace' ] ) ) {
				update_option( 'omnomnom_replace', $_POST[ 'str_replace' ] );
			}

			$this->update_strings();

			echo( '<h1>Okay, updated! Omnomnom.</h1>' );

		}

?>
<div class="wrap">
  <h2>Omnomnom</h2>
  <hr>
  <form method="post" action="options-general.php?page=<?php echo( self::DOMAIN ); ?>">
    <input type="hidden" name="wp_nonce" value="<?php
        echo( wp_create_nonce( 'omnomnom-update' ) ); ?>">
  <table class="form-table">
    <tr valign="top">
      <th scope="row">Replace this:</th>
      <td><input name="str_find" id="str_find" value="<?php echo( $this->str_find ) ?>"
                 class="regular-text" type="text" placeholder="<?php echo( self::STR_FIND ) ?>">
      </td>
    </tr>
    <tr valign="top">
      <th scope="row">With this:</th>
      <td><input name="str_replace" id="str_replace" value="<?php echo( $this->str_replace ) ?>"
                 class="regular-text" type="text" placeholder="<?php echo( self::STR_REPLACE ) ?>">
      </td>
    </tr>
  </table>
  <p class="submit">
    <input name="omnomnom-update" id="omnomnom-update"
           class="button button-primary" value="Update" type="submit">
  </p>
  </form>
<?php
	}

	/**
	 * Replace any instances found in posts.
	 */
	public function the_post_nom( $post ) {
		if ( isset( $post->omnomnom ) ) {
			return;
		}

		$regex_find = '/' . $this->str_find . '/';
		$post->post_title = preg_replace( $regex_find, $this->str_replace, $post->post_title );
		$post->post_content = preg_replace( $regex_find, $this->str_replace, $post->post_content );

		$post->omnomnom = true;
	}

	/**
	 * Replace any instances found in translated text.
	 */
	public function gettext_nom( $translated_text ) {
		$regex_find = '/' . $this->str_find . '/';
		return preg_replace( $regex_find, $this->str_replace, $translated_text );
	}
}

$wp_nomnomnom = new WP_Omnomnom();
