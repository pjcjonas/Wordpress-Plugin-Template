<?php
if( ! class_exists('ofyt_db_controller') ) :

    class ofyt_db_controller {

        function __construnct(){
            // DO NOTHING
        }

        /*
        *  get_latest_row
        *
        *  Requests the latest entry from the DB
        *
        *  EXAMPLE: ofyt_db_controller()->get_latest_row('tablename');
        *
        *  @type	function
        *  @date	15/05/15
        *  @since	1.0.1
        *
        *  @param	N/A
        *  @return	(object)
        */

        function get_latest_row($table_name){

            global $wpdb;

            $table = $wpdb->prefix.$table_name;

            $r = $wpdb->get_row(
                "SELECT * FROM $table ORDER BY date_created DESC ",
                ARRAY_A
            );

            return $r;

        }

        /*
        *  get_rows
        *
        *  Requests the latest entry from the DB
        *
        *  EXAMPLE: ofyt_db_controller()->get_rows($table_name, $offset = 0, $count = 10, $where = "", $equals = null);
        *
        *  @type	function
        *  @date	15/05/15
        *  @since	1.0.1
        *
        *  @param	N/A
        *  @return	(object)
        */

        function get_rows($table_name, $offset = 0, $count = 10, $equals = array()){

            global $wpdb;

            $table = $wpdb->prefix.$table_name;

            $whereClause = "WHERE";
            $whereCount = 0;

            foreach($equals as $e){
                if($whereCount > 0){
                    $whereClause .= " AND";
                }
                $whereClause .= " ".$e['col']." = ".$e['val'];
                $whereCount++;
            }

            if($whereCount > 0){
                $whereClause .= " AND";
            }

            $whereClause .= " deleted = 0";
            /**/

            // Get the requested data set
            $r = $wpdb->get_results("
                SELECT * FROM $table
                $whereClause
                ORDER BY entry_id ASC
                LIMIT $count OFFSET $offset
            ");

            // Get total items in data set
            $p = $wpdb->get_var( "
              SELECT COUNT(*) FROM $table
              $whereClause
            " );

            $arrData = array(
                'response_data' => $r,
                'total_items' => $p
            );

            return $arrData;
        }

        /*
        *  insert_row
        *
        *  Inserts a rows into a table based on the data
        *
        *  EXAMPLE: ofyt_db_controller()->insert_row('tablename', $data=array());
        *
        *  @type	function
        *  @date	15/05/15
        *  @since	1.0.1
        *
        *  @param	N/A
        *  @return	(object)
        */

        function insert_row($table_name=null, $data=array()){

            global $wpdb;

            if(!$table_name){
                return false;
            }

            $table = $wpdb->prefix.$table_name;

            $r = $wpdb->insert(
                $table,
                $data
            );

            return $wpdb->insert_id;

        }

        /*
        *  update_row
        *
        *  Updates a row value
        *
        *  EXAMPLE: ofyt_db_controller()->update_row('tablename', "where_col", "where_val", "update_col", "update_value");
        *
        *  @type	function
        *  @date	15/05/15
        *  @since	1.0.1
        *
        *  @param	N/A
        *  @return	(object)
        */

        function update_row($table_name=null, $where_col="", $where_val="", $update_data){

            global $wpdb;

            $table = $wpdb->prefix.$table_name;

            $wpdb->update(
                $table,
                $update_data,
                array( $where_col => $where_val )
            );

        }

    }

    /*
    *  ofyt_db_controller
    *
    *  The main database controller class for performing database tasks
    *
    *  Example: <?php $ofyt_db_controller = new ofyt_db_controller(); ?>
    *
    *  @type	function
    *  @date	15/05/15
    *  @since	1.0.1
    *
    *  @param	N/A
    *  @return	(object)
    */

    function ofyt_db_controller() {

        global $ofyt_db_controller;

        if( !isset($ofyt_db_controller) ) {
            $ofyt_db_controller = new ofyt_db_controller();
        }

        return $ofyt_db_controller;

    }

    // initialize
    ofyt_db_controller();

endif;