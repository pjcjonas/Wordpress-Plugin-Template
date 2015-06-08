<?php

if( ! class_exists('ofyt_FRAMERENAME_helper') ) :

    class ofyt_FRAMERENAME_helper
    {

        function __construnct(){
            // DO NOTHING
        }

#GEN GUID
        function ofyt_genGUID()
        {
            return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff),
                mt_rand(0, 0x0fff) | 0x4000,
                mt_rand(0, 0x3fff) | 0x8000,
                mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
            );
        }

#ADMIN PANEL VIEW PLUGIN CHECK
        function ofyt_onAdmin($current_view)
        {

            if(isset($_GET['page']) && stristr($_GET['page'],$current_view)){ //test if currently on plugin admin page
                return true;
            }
            return false;

        }

#MINIFY CODE
        function ofyt_minify($string)
        {
            $string = preg_replace('!/\*.*?\*/!s', '', $string);
            $string = preg_replace('/\n\s*\n/', "\n", $string);
            $string = preg_replace('/[\n\r \t]/', ' ', $string);
            $string = preg_replace('/ +/', ' ', $string);
            $string = preg_replace('/;}/', '}', $string);
            return $string;
        }

#GET FULL DIRECTORY
        function ofyt_get_dir($path)
        {
            return $this->ofyt_get_setting('dir') . $path;
        }

#GET FULL DIRECTORY
        function ofyt_get_path($path)
        {
            return $this->ofyt_get_setting('path') . $path;
        }

#GET FRIENDLY DATE
        function ofyt_friendly_date($date)
        {
            return date('dMy', strtotime($date));
        }

#FORCE INT
        function ofyt_strtoint($string)
        {
            return $string + 0;
        }

#CHECK VERSION
        function ofyt_checkVersion($string)
        {
            if (preg_match('/\d+(\.\d+)+/', $string)) {
                return true;
            }
            return false;
        }

#CHECK STRING
        function ofyt_checkString($string)
        {
            if (strlen(trim($string)) >= 1) {
                return true;
            }
            return false;
        }

#CHECK EMAIL
        function ofyt_checkEmail($string)
        {
            if (preg_match('/.+@.+\.[a-z]/', $string)) {
                return true;
            }
            return false;
        }

#CHECK INT
        function ofyt_checkInt($string)
        {
            if (is_numeric($string)) {
                return true;
            }
            return false;
        }

#CHECK CONTACT NUMBER
        function ofyt_checkContactNumber($string)
        {
            if (preg_match('/\d/', $string) && strlen($string) > 8) {
                return true;
            }
            return false;
        }

#CHECK PASSWORD
        function ofyt_checkPassword($string)
        {
            if (preg_match('/[A-Z]/', $string) && preg_match('/[a-z]/', $string) && preg_match('/[0-9]/', $string) && strlen($string) >= 8) { //uppercase, lowercase, number, length
                return true;
            }
            return false;
        }

#CHECK DATE
        function ofyt_checkDate($string)
        {
            if (strtotime($string) !== false) {
                return true;
            }
            return false;
        }

#GET BLOG URL
        function ofyt_get_blog_domain()
        {
            if (isset($_SERVER['HTTP_HOST'])) {
                return $_SERVER['HTTP_HOST'];
            }
            return $_SERVER['SERVER_NAME'];
        }

#GET SETTINGS VALUE
        function ofyt_get_setting($name)
        {

            // vars
            $a = null;

            // load from ofyt_events if available
            if (isset(ofyt_FRAMERENAME_plugin()->settings[$name])) {
                $a = ofyt_FRAMERENAME_plugin()->settings[$name];
            }

            // return
            return $a;
        }

#LOAD PAGE VIEW
        function ofyt_get_view($view_name = '', $args = array())
        {

            $path = $this->ofyt_get_path("admin/views/{$view_name}.php");

            if (file_exists($path)) {
                include($path);
            } else {
                echo "view not found <br><strong>" . $path . "</strong>";

            }

        }
    }

    /*
    *  ofyt_FRAMERENAME_helper
    *
    *  The main helper class for performing small tasks
    *
    *  Example: <?php $ofyt_FRAMERENAME_helper = new ofyt_FRAMERENAME_helper(); ?>
    *
    *  @type	function
    *  @date	12/05/15
    *  @since	1.0.1
    *
    *  @param	N/A
    *  @return	(object)
    */

    function ofyt_FRAMERENAME_helper() {

        global $ofyt_FRAMERENAME_helper;

        if( !isset($ofyt_FRAMERENAME_helper) ) {
            $ofyt_FRAMERENAME_helper = new ofyt_FRAMERENAME_helper();
        }

        return $ofyt_FRAMERENAME_helper;

    }

    // initialize
    ofyt_FRAMERENAME_helper();


endif;