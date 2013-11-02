    <?php
    /*
    Bad Behavior - detects and blocks unwanted Web accesses
    Copyright (C) 2005-2006 Michael Hampton

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    As a special exemption, you may link this program with any of the
    programs listed below, regardless of the license terms of those
    programs, and distribute the resulting program, without including the
    source code for such programs: ExpressionEngine

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 675 Mass Ave, Cambridge, MA 02139, USA.

    Please report any problems to badbots AT ioerror DOT us
    */

    ###############################################################################
    ###############################################################################
    /*

    SAMPLE CODE - SCREENER:
    -----------------------
    <?php
    //Bad Behavior - This include_once statement MUST be the very first item at the
    //top of your page, or it will generate an WARNING and the following functions
    //may not work: bb2_insert_head(), bb2_insert_stats(), bb2_db_viewer()
    // NOTE: It MUST be the very first item on the page or you will get an error.
    //       It needs to be BEFORE all tags (before <html>, <head>, <!DOCTYPE>, etc).
    include_once('/home/path-to/bad-behavior/bad-behavior-generic-mysql.php');
    ?>

    <?php
    //Bad Behavior - This code should appear in the <HEAD> section of your page
    // and will add the required JavaScript to your page.
    if (function_exists('bb2_insert_head')) {
      bb2_insert_head();
    }
    ?>


    SAMPLE CODE - STATS:
    --------------------
    <?php
    //Bad Behavior - This include_once statement MUST be the very first item at the
    //top of your page, or it will generate an WARNING and the following functions
    //may not work: bb2_insert_head(), bb2_insert_stats(), bb2_db_viewer()
    // NOTE: It MUST be the very first item on the page or you will get an error.
    //       It needs to be BEFORE all tags (before <html>, <head>, <!DOCTYPE>, etc).
    include_once('/home/path-to/bad-behavior/bad-behavior-generic-mysql.php');
    ?>

    <?php
    //Bad Behavior - This code can appear anywhere in your page (usually in your
    // footer) and will show how many blocks Bad Behavior has made (if you have
    // display_stats=true in the config file). 
    if (function_exists('bb2_insert_stats')) {
      bb2_insert_stats();
    }
    ?>


    SAMPLE CODE - SIMPLE DB VIEWER:
    -------------------------------
    See the file: bad-behavior-simple-db-viewer.php

    */
    ###############################################################################
    ###############################################################################

    ///////////////////////////////////////////////////////////////////////////////
    //Settings for email and database access
    //Change these as appropriate
    define('BB2_EMERG_EMAIL','victor@stuyspectator.com'); //Change this
    define('BB2_DB_TABLE', 'phplist_bad_behavior'); // Choose your table
    define('BB2_DB_NAME', 'stuyspec_plst1'); // The name of the database
    define('BB2_DB_USER', 'stuyspec_plst1'); // Your DB username
    define('BB2_DB_PASSWORD', 'VyJ3VIbXb25Q'); // Your DB user password
    define('BB2_DB_HOST', 'localhost'); //Probably can leave this as localhost
    define('BB2_CWD', dirname(__FILE__)); //Do not change this

    ///////////////////////////////////////////////////////////////////////////////
    // More settings you can adjust for Bad Behavior.
    // Most of these are unused in non-database mode.
    // More details below...
    $bb2_settings_defaults = array(
       'log_table' => BB2_DB_TABLE,
       'display_stats' => true,
       'strict' => false,
       'verbose' => false,
       'logging' => true,
       'httpbl_key' => '',
       'httpbl_threat' => '25',
       'httpbl_maxage' => '30',
    );
    // Here is what the settings above mean...
    //
    // - log_table
    //   Leave this as BB2_DB_TABLE (do NOT change it). Make your change up above
    //   in the line that says: define('BB2_DB_TABLE', 'phplist_bad_behavior')
    //   Change 'phplist_bad_behavior' to whatever table you want to use.
    //   This table will be created automatically if it does not already exist.
    //
    // - display_stats
    //   TRUE=Display stats on page that has the bb2_insert_stats() function on it.
    //   FALSE=Do not display stats.
    //   Default is TRUE
    //
    // - strict
    //   TRUE=Strict checking (blocks more spam but may block some people)
    //   FALSE=Recommended setting
    //   
    // - verbose
    //   TRUE=This will log EVERY access attempt to webpage, including valid
    //        permitted ones. Good for testing to see if logging is working,
    //        but can cause your DB table to become huge fairly quickly.
    //   FALSE=Log only denied access attempts or permitted ones that were
    //         questionable. This is the recommended default setting.
    //
    // - logging
    //   TRUE=Log info to database table.
    //   FALSE=Do not log anything.
    //
    // - httpbl_key
    //   To use Bad Behavior's http:BL features you must have an http:BL Access Key.
    //   Sign up for a free account to get a key here:
    //   http://www.projecthoneypot.org/httpbl_configure.php?rf=24694
    //
    // - httpbl_threat
    //   Minimum Threat Level (25 is recommended)
    //
    // - httpbl_maxage
    //   Maximum Age of Data (30 is recommended)


    ///////////////////////////////////////////////////////////////////////////////
    //Open and connect to DB
    $dblinkid = mysql_connect(BB2_DB_HOST, BB2_DB_USER, BB2_DB_PASSWORD); //Connect to DB
    define('BB2_DB_LINK_ID', $dblinkid); //Setup the Resource Link ID so it's available in other functions.
    if (!BB2_DB_LINK_ID) {
      die('Could not connect to DB: ' . mysql_error()); //Not pretty but at least you know there is a problem!
    }

    $dbselect = mysql_select_db(BB2_DB_NAME, BB2_DB_LINK_ID); //Choose connection Table in DB
    if (!$dbselect) {
      die ('Can not use selected DB: ' . mysql_error()); //Not pretty but at least you know there is a problem!
    }

    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    ///////////////////////////////////////////////////////////////////////////////
    // Bad Behavior callback functions.
    ///////////////////////////////////////////////////////////////////////////////
    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    // Return current time in the format preferred by your database.
    function bb2_db_date() {
       return gmdate('Y-m-d H:i:s');   // Example is MySQL format
    }

    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    // Escape a string for database usage
    // TO DO: Figure out what this should do and how to implement it
    function bb2_db_escape($string) {
       return $string;   // No-op ... see TO DO
    }

    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    // Return affected rows from most recent query.
    function bb2_db_affected_rows() {
      return mysql_affected_rows(BB2_DB_LINK_ID);
    }

    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    // Return the number of rows in a particular query.
    function bb2_db_num_rows($link) {
      return mysql_num_rows($link);
    }

    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    // Run a query and return the results, if any.
    // Will return FALSE if an error occurred.
    // Bad Behavior will use the return value here in other callbacks.
    // WRITE operations will return TRUE for successful and FALSE for nothing written
    // READ operations will return an associative array of the result set, or FALSE if no rows were returned
    //  It will return array[0] with first row, then array[1] with second row, etc.
    function bb2_db_query($query) {
      $link = mysql_query($query, BB2_DB_LINK_ID);

      if (!$link) { //If it's 0/FALSE then there was some kind of error
        //die('There was a problem with $query: '.mysql_error()); //Uncomment this line for debugging
        return false; //Return false if there is an error
      }

      if ($link === TRUE) { //If it's exactly TRUE then it was a succesful WRITE operation
        $affected_rows = bb2_db_affected_rows(); //how many affected rows in a WRITE query?
        if ($affected_rows >= 1) {
          return true; //Something was succesfully written
        } else {
          return false; //Nothing was written
        } 
      } else { //If it's not 0/FALSE and it's not exactly TRUE then it was a READ operation
        $number_of_rows = bb2_db_num_rows($link); //number of rows read the READ query?
        if ($number_of_rows == '0') {
          return false; //No rows were found for query
        }
      }

      $result = bb2_db_rows($link); //Go get all the rows and put them an array

      return $result;
    }

    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    // Return all rows in a particular READ query.
    // Will contain an array of all rows generated by calling mysql_fetch_assoc()
    // and appending the result of each call to an array. It will return array[0]
    // with first row, then array[1] with second row, etc.
    function bb2_db_rows($linkid) {
      $i = 0;
      while ($row = mysql_fetch_assoc($linkid)) { //Get each row from query
        $result[$i] = $row;
        $i++;
      }
      if (empty($result)) {
        $result = $linkid; //If there were no rows, then just return the id
      }
     
      return $result;
    }

    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    // Return emergency contact email address.
    function bb2_email() {
       return BB2_EMERG_EMAIL;
    }

    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    // Retrieve settings
    // Currently they are hard coded in this file.
    // TO DO: Retrieve from DB... need to implement bb2_write_settings() first.
    function bb2_read_settings() {
       global $bb2_settings_defaults;
       return $bb2_settings_defaults;
    }

    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    // Write settings to database
    // Currently not implemented. Settings are hard coded in this file.
    // TO DO: Add another table to DB to store these settings in?
    function bb2_write_settings($settings) {
       return false;
    }

    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    // Installation
    // Will automatically create the table if it does not exist yet.
    function bb2_install() {
      $settings = bb2_read_settings();
      if (!$settings['logging']) return;
       bb2_db_query(bb2_table_structure($settings['log_table']));
    }

    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    // Screener
    // See example at top of this file
    function bb2_insert_head() {
       global $bb2_javascript;
       echo $bb2_javascript;
    }

    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    // Display stats (optional)
    // See example at top of this file
    function bb2_insert_stats($force = false) {
       $settings = bb2_read_settings();
       if ($force || $settings['display_stats']) {
          $blocked = bb2_db_query("SELECT COUNT(*) FROM ".$settings['log_table']." WHERE `key` NOT LIKE '00000000'");
          $totals = bb2_db_query("SELECT COUNT(*) FROM ".$settings['log_table']);
        if ($blocked !== FALSE) {
             echo '<p><a href="http://www.bad-behavior.ioerror.us/">Bad Behavior</a> has blocked <strong>'.$blocked[0]['COUNT(*)'].'</strong> access attempts to date. ('.$totals[0]['COUNT(*)'].' db entries).</p>';
          }
      }
    }

    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    // Return the top-level relative path of wherever we are (for cookies)
    // You should provide in $url the top-level URL for your site.
    // TO DO: What is this actually used for? Seems to work fine if you leave it as '/'
    function bb2_relative_path() {
      return '/';
    }

    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    // Calls inward to Bad Behavor itself.
    require_once(BB2_CWD . "/bad-behavior/version.inc.php");
    require_once(BB2_CWD . "/bad-behavior/core.inc.php");

    bb2_install(); //Check if table exists and create it if it does not

    bb2_start(bb2_read_settings());


    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //SIMPLE DB VIEWER
    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //Simple display of what's in DB
    //See bad-behavior-simple-db-viewer.php for sample of how to use it
    // VALID OPTIONS FOR THIS FUNCTIONS ARE:
    //  $what:  0=ALL entries  1=Permitted entries only  2=Denied entries only
    //  $page_num:  Any integer 1 or greater.
    //  $per_page:  Number of entries per page to display. Any integer 1 or greater.
    //  $sort_by:  'date' or 'request_uri' or 'key'
    //  $order_by: 'ASC' or 'DESC'
    // RETURN VALUES:
    //  Function will return an array($limit_start, $limit_end, $total_count, $page_num, $display)
    //  $limit_start: This is the first record number that it is displaying
    //  $limit_end:  This is the last record number that it is displaying
    //  $total_count: This is the total number of entries in the database
    //  $page_num: The actual page number that was displayed
    //  $display: This contains the html for the <table> that will be displayed
    function bb2_simple_db_viewer($what=0, $page_num=1, $per_page=25, $sort_by='date', $order='DESC') {
      if ($what !== 0 && $what !== 1 && $what !== 2) {
        $what = 0;
      }
      if ($page_num < 1) {
        $page_num = 1;
      }
      if ($per_page < 1) {
        $per_page = 1;
      }
      if ($sort_by !== 'date' && $sort_by !== 'request_uri' && $sort_by !== 'key') {
        $sort_by='date';
      }
      if ($order !== 'ASC' && $order !== 'DESC') {
        $order='DESC';
      }
     
      $where = '';
      if ($what == 1) {
        $where = "WHERE `key` = '00000000' ";
      } elseif ($what == 2) {
        $where = "WHERE `key` NOT LIKE '00000000' ";
      }

      $total_result = bb2_db_query("SELECT COUNT(*) FROM ".BB2_DB_TABLE." ".$where);
      $total_count = $total_result[0]['COUNT(*)'];

      $orderby = "ORDER BY `".$sort_by."` ".$order." ";
     
      $limit_start = ($page_num * $per_page) - $per_page;
      if ($limit_start > $total_count) {
        $limit_start = $total_count-1;
      }

      if ($per_page > $total_count) { //
        $per_page = $total_count;
      }
     
      $limit_end = $limit_start + $per_page;
     
      if ($limit_end > $total_count) {
        $limit_end = $total_count;
      }

      for ($i=$page_num; $i>1; $i--) { //Make sure the page number requested actually exists
        if ( ( ($page_num * $per_page) - $per_page) > $total_count) {
          $page_num--;
        }
      }

      $limit = "LIMIT ".$limit_start.", ".$per_page;

      $query = "SELECT * FROM `".BB2_DB_TABLE."` ".$where.$orderby.$limit;
      $result = bb2_db_query($query);
     
      //Display string of table to return
      $display .= '<br><span style="color: red;">Query... '.$query.'</span>';
      $display .= '<br><table border="1" style="color: #555555; font-size: small; background-color: white;">';
      $display .= '<tr style="color: black; font-weight: bold; text-decoration: underline; text-align: center; background-color: #888888;"><td>ID</td><td>IP</td><td>DATE</td><td>METHOD</td><td>URI</td><td>PROTOCOL</td><td>HEADERS</td><td>AGENT</td><td>ENTITY</td><td>KEY</td></tr>';
     
      $alternate_rows = 'even';
      if ($result) { //Make sure it found some rows
        foreach ($result as $array) {

          if (empty($array['request_entity'])) { //This field can be blank alot, so put a space in it.
            $array['request_entity'] = '&nbsp;';
          }

          if ($array['key'] == '00000000') { //Assumes that only 00000000 is permitted. Check with Michael
            $array['key'] = 'Permitted<br>'.$array['key'];
          } else {
            $array['key'] = 'DENIED<br>'.$array['key'];
          }

          if ($alternate_rows == 'even') { //Alternating colors for each row
            $alternate_rows = 'odd';
            $row_color = '#FFFFFF';
          } else {
            $alternate_rows = 'even';
            $row_color = '#DDDDDD';
          }
     
          $display .= '<tr style="background-color: '.$row_color.';"><td>'.$array['id'].'</td><td>'.$array['ip'].'</td><td>'.$array['date'].'</td><td>'.$array['request_method'].'</td><td>'.$array['request_uri'].'</td><td>'.$array['server_protocol'].'</td><td>'.$array['http_headers'].'</td><td>'.$array['user_agent'].'</td><td>'.$array['request_entity'].'</td><td>'.$array['key'].'</td></tr>';
        }
       
        $limit_start++; //Since record 0 is actually the 1st record, we will add one to make the first record=1
     
      } else { //No rows found
        $total_count = 0;
        $display .= '<tr style="background-color: '.$row_color.';"><td colspan="10">No records exist in that range</td>';
      }

      $display .= '</table>';
     
      //This returns all the info you need to display
      // RETURN VALUES:
      //  Function will return an array($limit_start, $limit_end, $total_count, $page_num, $display)
      //  $limit_start: This is the first record number that it is displaying
      //  $limit_end:  This is the last record number that it is displaying
      //  $total_count: This is the total number of entries in the database
      //  $page_num: The actual page number that was displayed
      //  $display: This contains the html for the <table> that will be displayed
      $return_array = array($limit_start, $limit_end, $total_count, $page_num, $display);

    return $return_array;
    }

    ?>