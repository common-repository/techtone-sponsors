<?php
/**
 * Plugin Name: TECHTONE - Sponsors
 * Plugin URI: http://techtone.ca
 * Description: Present your sponsors in a more efficient and easy way, With a simple shorcode
 * Version: 1.3
 * Author: TECHTONE
 * Text Domain: TTS
 * Path Domain: /lang/
 * Author URI: http://techtone.ca
 * License: GPL2
 *
 *
 * TTS stands for Techtone Sponsors
 *
 */
if ( !defined('ABSPATH')) {
	die('Oops!!! We have no clue how you got here?!?');
}


if ( !class_exists('TTS')) {

	class TTS{

		/**
		 * Plugin Version
		 */
		const VER = '1.0';

		/**
		 * Hold the class after construction
		 * @var bool
		 */
		public static $_instance = false;

		/**
		 * Call instance for preventing class duplicates and stack overflow
		 *
		 * @return bool|TTS (Self)
		 */
		public static function instance(){

			if ( !self::$_instance ) {
				self::$_instance = new self();
			}

			return self::$_instance;

		}

		/**
		 * TTS constructor.
		 *
		 * Init and set TTS
		 *
		 */

		public function __construct() {

			$this->define_constants();
			$this->require_extensions();
			$this->set_hooks();

		}

		public function require_extensions(){
		    $this->_require('admin/functions.php');
		    $this->_require('classes/globals.php');
		    $this->_require('shortcodes/sponsors.php');
		}

		protected final function set_hooks(){
			load_plugin_textdomain('TTS', false, basename( dirname( TTS_MAIN_FILE ) ) . '/inc/lang/' );
			register_activation_hook( TTS_MAIN_FILE , array($this, 'TTS_first_boot') );
            add_action('wp_enqueue_scripts', function(){
                wp_enqueue_style('bootstrap', plugin_dir_url( TTS_MAIN_FILE ) . 'inc/style/bootstrap.min.css');
                wp_enqueue_style('TTS', plugin_dir_url( TTS_MAIN_FILE ) . 'inc/style/TTS.css');
            });
            add_filter( 'single_template', array($this, 'TTS_get_single_sponsors_template') );
		}

		public function TTS_get_single_sponsors_template($single_template){
            global $post;

            if( file_exists( TTS_PATH."template/single-{$post->post_type}.php" ) ){
                $single_template = TTS_PATH."template/single-{$post->post_type}.php";
            }

            return $single_template;
        }

		public function TTS_first_boot(){
			require_once TTS_PATH.'classes/init.php';
		}

		public function define_constants(){
			$this->define( 'TTS_PATH', __DIR__.'/' );
			$this->define( 'TTS_MAIN_FILE', __FILE__ );
		}

		private final function define($name, $val){
			if ( !defined( $name ) ) {
				define( $name, $val );
			}
		}

		public function _require($fileName){
		    if ( !$fileName ){
		        return false;
            }
            if ( file_exists(TTS_PATH.$fileName)) {
                require TTS_PATH.$fileName ;
                return;
            }
            return false;
        }

	}

}

function TTS(){
	return TTS::instance();
}

$_GLOBALS['TTS'] = TTS();