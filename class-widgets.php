<?php
/**
 * Widgets class.
 *
 * @category   Class
 * @package    ElementorAwesomesauce
 * @subpackage WordPress
 * @author     Ben Marshall <me@benmarshall.me>
 * @copyright  2020 Ben Marshall
 * @license    https://opensource.org/licenses/GPL-3.0 GPL-3.0-only
 * @link       link(https://www.benmarshall.me/build-custom-elementor-widgets/,
 *             Build Custom Elementor Widgets)
 * @since      1.0.0
 * php version 7.3.9
 */

namespace ElementorAwesomesauce;

// Security Note: Blocks direct access to the plugin PHP files.
defined( 'ABSPATH' ) || die();

/**
 * Class Plugin
 *
 * Main Plugin class
 *
 * @since 1.0.0
 */
class Widgets {

	/**
	 * Instance
	 *
	 * @since 1.0.0
	 * @access private
	 * @static
	 *
	 * @var Plugin The single instance of the class.
	 */
	private static $instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return Plugin An instance of the class.
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	* widget_scripts
	*
	* Load required plugin core files.
	*
	* @access public
	*/
	public function widget_scripts() {
	$plugin = get_plugin_data( __FILE__, false, false );

	// wp_register_script( 'menheer-plugin', plugin_dir_url( __FILE__ ) . 'assets/js/awesomesauce.js', array( 'jquery' ), $plugin['Version'] );
		// wp_register_script( 'your-script', MYPLUGIN__PLUGIN_DIR_PATH . 'assets/js/awesomesauce.js', array( 'jquery' ) );
		// wp_register_script( 'your-script', plugins_url( '/assets/js/awesomesauce.js', ELEMENTOR_AWESOMESAUCE ), array(), '1.0.0' );
	}

	/**
	 * Include Widgets files
	 *
	 * Load widgets files
	 *
	 * @since 1.0.0
	 * @access private
	 */
	private function include_widgets_files() {
		require_once( __DIR__ . '/widgets/class-awesomesauce.php' );
		require_once( __DIR__ . '/widgets/post-tabs-grid.php' );
    require_once( __DIR__ . '/widgets/post-tabs-list.php' );
    require_once( __DIR__ . '/widgets/post-grid.php' );
    require_once( __DIR__ . '/widgets/video-playlist.php' );
    require_once( __DIR__ . '/widgets/category-list-images.php' );
    require_once( __DIR__ . '/widgets/post-list.php' );
    require_once( __DIR__ . '/widgets/post-block.php' );
    require_once( __DIR__ . '/widgets/post-carousel.php' );
    require_once( __DIR__ . '/widgets/comments.php' );
    require_once( __DIR__ . '/widgets/post-list-with-numbers.php' );
	}

	/**
	 * Register Widgets
	 *
	 * Register new Elementor widgets.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function register_widgets() {
		// It's now safe to include Widgets files.
		$this->include_widgets_files();

		// Register the plugin widget classes.
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Awesomesauce() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\PostTabsGrid() );
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\PostTabsList() );
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\PostGrid() );
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\VideoPlaylist() );
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\CategoryListImages() );
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\PostList() );
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\PostBlock() );
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\PostCarousel() );
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Comments() );
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\PostListWithNumbers() );
	}

	/**
	 *  Plugin class constructor
	 *
	 * Register plugin action hooks and filters
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {
		// Register the widgets.
		add_action( 'elementor/widgets/widgets_registered', array( $this, 'register_widgets' ) );
	}
}

// Instantiate the Widgets class.
Widgets::instance();
