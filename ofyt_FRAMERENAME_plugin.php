<?php /**
 * Plugin Name: OFyt FRAMERENAME Plugin Framework
 * Description: Plugin FRAMERENAME framework
 * Plugin URI: http://ofyt.co.za
 * Version: 1.0.1
 * Author: Philip Jonas
 * Author URI: http://ofyt.co.za
 * Text Domain: ofyt_FRAMERENAME_plugin
 * License:GPL2
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Register the activation and deactivation hooks
register_activation_hook( __FILE__, array( 'ofyt_FRAMERENAME_install', 'install' ) );
register_deactivation_hook( __FILE__, array( 'ofyt_FRAMERENAME_install', 'uninstall' ) );

// Check if the root class exists
if( ! class_exists('ofyt_FRAMERENAME_plugin') ) :

    class ofyt_FRAMERENAME_plugin{

        // Variables
        var $settings;

        // Init blank constructor
        function __construct(){
            // Do nothings
        }

        /*
        *  initialize
        *
        *  The main activation function that sets all the root options for the plugin
        *
        *  @type	function
        *  @date	09/06/15
        *  @since	1.0.1
        *
        *  @param	N/A
        *  @return	(object)
        */

        function initialize(){

            // Init vars
            $this->settings = array(

                // basic
                'name'				=> __('OFyt Frame', 'ofyt_FRAMERENAME_plugin'),
                'prefix'			=> 'ofyt_FRAMERENAME',
                'version'			=> '1.0.1',

                // urls
                'basename'			=> plugin_basename( __FILE__ ),
                'path'				=> plugin_dir_path( __FILE__ ),
                'dir'				=> plugin_dir_url( __FILE__ ),

                // options
                'capability'		=> 'manage_options',
                'admin_visible'		=> true
            );

            // Include API Helper classes
            include_once('api/helper.class.php');
            include_once('api/ofyt_db_controller.class.php');

            // Load admin pages
            if(is_admin()){
                include_once('admin/ofyt_dashboard.class.php');
            }

            // actions
            add_action('init',  array($this, 'wp_init'), 10, 1 );

        }


        /*
        *  wp_init
        *
        *  Wordpress init function, when wordpress is loaded, this function is called and registers all the js and css
        *
        *  @type	function
        *  @date	09/06/15
        *  @since	1.0.1
        *
        *  @param	N/A
        *  @return	(object)
        */
        function wp_init(){

            // Register JS Scripts
            $scripts = array(

                array(
                    'handle'    => 'ofyt_FRAMERENAME_script_manager',
                    'src'       => ofyt_FRAMERENAME_helper()->ofyt_get_dir( 'assets/js/ofyt_script_manager.js' ),
                    'deps'      => array('jquery-core')
                ),
                array(
                    'handle'    => 'ofyt_FRAMERENAME_script_bootstrap',
                    'src'       => ofyt_FRAMERENAME_helper()->ofyt_get_dir( 'assets/js/bootstrap.min.js' ),
                    'deps'      => array('jquery-core')
                ),
                array(
                    'handle'    => 'ofyt_FRAMERENAME_colorbox_js',
                    'src'       => ofyt_FRAMERENAME_helper()->ofyt_get_dir( 'assets/js/colorbox.js' ),
                    'deps'      => array('jquery-core')
                )

            );

            foreach( $scripts as $script ) {
                wp_register_script( $script['handle'], $script['src'], $script['deps'], ofyt_FRAMERENAME_helper()->ofyt_get_setting('version') );
            }

            // Register Styles
            $styles = array(

                array(
                    'handle'    => 'ofyt_FRAMERENAME_admin_styles',
                    'src'       => ofyt_FRAMERENAME_helper()->ofyt_get_dir( 'assets/css/ofyt_admin.css' ),
                    'deps'      => false
                ),
                array(
                    'handle'    => 'ofyt_FRAMERENAME_get_bootstrap',
                    'src'       => ofyt_FRAMERENAME_helper()->ofyt_get_dir( 'assets/css/bootstrap.min.css' ),
                    'deps'      => false
                ),
                array(
                    'handle'    => 'ofyt_FRAMERENAME_colorbox_css',
                    'src'       => ofyt_FRAMERENAME_helper()->ofyt_get_dir( 'assets/css/colorbox.css' ),
                    'deps'      => false
                )

            );

            foreach( $styles as $style ) {
                wp_register_style( $style['handle'], $style['src'], $style['deps'], ofyt_FRAMERENAME_helper()->ofyt_get_setting('version') );
            }

        }

    }

    /*
    *  ofytpluginframe
    *
    *  The main function responsible for returning the one true ofytpluginframe Instance to functions everywhere.
    *  Use this function like you would a global variable, except without needing to declare the global.
    *
    *  Example: <?php $ofytpluginframe = new ofytpluginframe(); ?>
    *
    *  @type	function
    *  @date	09/06/15
    *  @since	1.0.1
    *
    *  @param	N/A
    *  @return	(object)
    */

    function ofyt_FRAMERENAME_plugin() {

        global $ofyt_FRAMERENAME_plugin;

        if( !isset($ofyt_FRAMERENAME_plugin) ) {
            $ofyt_FRAMERENAME_plugin = new ofyt_FRAMERENAME_plugin();
            $ofyt_FRAMERENAME_plugin->initialize();
        }

        return $ofyt_FRAMERENAME_plugin;

    }

    // initialize
    ofyt_FRAMERENAME_plugin();

endif;

/*
*  ofyt_ofytpluginframe_install
*
*  This is the main class that handles the install and un-install of the plugin, creating and removing tables
*
*  @type	hook class
*  @date	13/05/15
*  @since	1.0.1
*
*  @param	N/A
*  @return	(object)
*/

class ofyt_ofytpluginframe_install{

    /*
    *  install
    *
    *  This function creates the needed tables for the plugin
    *
    *  @type	function
    *  @date	13/05/15
    *  @since	1.0.1
    *
    *  @param	N/A
    *  @return	(object)
    */

    static function install() {

        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

        // Create entries table
       /* $tablename = $wpdb->prefix."tablename";
        $sql_entries_table = "
            CREATE TABLE IF NOT EXISTS  $tablename (
              table_id INT(11) NOT NULL AUTO_INCREMENT,
              UNIQUE KEY entry_id (entry_id)
            ) $charset_collate;
        ";
        dbDelta($sql_entries_table);*/


    }

    /*
    *  uninstall
    *
    *  Uninstalls settings when you remove the plugin
    *
    *  @type	function
    *  @date	13/05/15
    *  @since	1.0.1
    *
    *  @param	N/A
    *  @return	(object)
    */
    static function uninstall() {

    }

}
?>