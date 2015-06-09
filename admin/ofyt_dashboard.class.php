<?php

/*
*  ofyt_FRAMERENAME_dashboard
*
*  Dashboard Controller Class. Manages the views and models...
*
*  Example: <?php $ofyt_FRAMERENAME_dashboard = new ofyt_FRAMERENAME_dashboard(); ?>
*
*  @type	function
*  @date	09/06/15
*  @since	1.0.1
*
*  @param	N/A
*  @return	(object)
*/

class ofyt_FRAMERENAME_dashboard{

    // Variables
    var $view = 'dashboard';
    var $dash_title = "Dashboard";
    var $data = array();

    /*
	*  __construct
	*
	*  Initialize filters, action, variables and includes
	*
	*  @type	function
	*  @date	09/06/15
	*  @since	1.0.1
	*
	*  @param	n/a
	*  @return	n/a
	*/

    function __construct(){

        // actions
        add_action('admin_menu', array($this, 'admin_menu'));
        add_action('admin_enqueue_scripts',	array($this, 'admin_enqueue_scripts'), 0);
        add_action('admin_init', array($this, 'admin_setup_ajax'));

    }

    /*
	*  admin_menu
	*
	*  This function will add the Events menu item to the WP admin
	*
	*  @type	action (admin_menu)
	*  @date	09/06/15
	*  @since	1.0.1
	*
	*  @param	n/a
	*  @return	n/a
	*/

    function admin_menu(){

        // bail early if no admin_visible
        if( !ofyt_FRAMERENAME_helper()->ofyt_get_setting('admin_visible') ) {
            return;
        }

        // Add parent menu item
        add_menu_page( 'Frame FRAMERENAME Dashboard', 'Frame FRAMERENAME Dashboard', ofyt_FRAMERENAME_helper()->ofyt_get_setting('capability'), 'ofyt_FRAMERENAME_dashboard', array(&$this, 'html'), false, null);

    }

    /*
	*  html
	*
	*  Load the page view html
	*
	*  @type	function
	*  @date	09/06/15
	*  @since	1.0.1
	*
	*  @param	n/a
	*  @return	n/a
	*/

    function html(){

        ofyt_FRAMERENAME_helper()->ofyt_get_view($this->view, $this->load_view_data());

    }

    /*
	*  load_view_data
	*
	*  Load the data for the view
	*
	*  @type	function
	*  @date	09/06/15
	*  @since	1.0.1
	*
	*  @param	n/a
	*  @return	$data array()
	*/

    function load_view_data(){

        $total_items = 50;

        $this->data = array(
            'title'=>$this->dash_title,
            'data'=>array(

            )
        );

        $r = $this->data;

        return $r;

    }

    /*
	*  admin_enqueue_scripts
	*
	*  This function enques the admin styles and scripts
	*
	*  @type	action (admin_menu)
	*  @date	09/06/15
	*  @since	1.0.1
	*
	*  @param	n/a
	*  @return	n/a
	*/

    function admin_enqueue_scripts(){

        if( ofyt_FRAMERENAME_helper()->ofyt_onAdmin('ofyt_FRAMERENAME_dashboard') ) {

            wp_enqueue_script("ofyt_FRAMERENAME_script_bootstrap");
            wp_enqueue_script("ofyt_FRAMERENAME_colorbox_js");
            wp_enqueue_script("ofyt_FRAMERENAME_script_manager");

            wp_enqueue_style("ofyt_FRAMERENAME_get_bootstrap");
            wp_enqueue_style("ofyt_FRAMERENAME_colorbox_css");
            wp_enqueue_style("ofyt_FRAMERENAME_admin_styles");

        }

    }

    /*
    *  admin_setup_ajax
    *
    *  This function sets up the ajax actions for WordPress
    *
    *  @type	function
    *  @date	09/06/15
    *  @since	1.0.1
    *
    *  @param	n/a
    *  @return	n/a
    */

    function admin_setup_ajax(){

        add_action( 'wp_ajax_template', array(&$this, 'ofyt_ajax_template') );

    }

    /*
    *  ofyt_ajax_template
    *
    *  This function is the ajax call back to the ofyt ajax template
    *
    *  @type	function
    *  @date	09/06/15
    *  @since	1.0.1
    *
    *  @param	n/a
    *  @return	n/a
    */

    function ofyt_ajax_template(){

        parse_str($_POST['data'], $postdata);

        $response = array(
            'status'    => true,
            'data'      => $postdata,
            'insert_id' => 0
        );

        echo json_encode($response);

        wp_die();

    }

}

// Init the class
new ofyt_FRAMERENAME_dashboard();