<?php
class RCCWP_Application
{
	function GetCustomWritePanels($writePanelId = null)
	{
		global $wpdb;
	
		$sql = "SELECT id, name, description, display_order, capability_name FROM " . RC_CWP_TABLE_WRITE_PANELS;
		
		if (isset($writePanelId))
		{
			$sql .=	" WHERE id = " . (int)$writePanelId;
			$results = $wpdb->get_row($sql);
		}
		else
		{
			$sql .= " ORDER BY display_order ASC";
			$results = $wpdb->get_results($sql);
			if (!isset($results)) 
				$results = array();
		}
		
		return $results;
	}

	function GetWpCategories()
	{
		global $wpdb;
		$sql = "SELECT cat_ID, cat_name FROM $wpdb->categories ORDER BY cat_name";
		$results = $wpdb->get_results($sql);
		if (!isset($results))
			$results = array();
		return $results;
	}

	function GetWpDefaultCategory()
	{

	}

	function GetWpStandardFields($standardFieldId = null)
	{
		global $wpdb;
	
		if (isset($standardFieldId))
		{
			$sql = "SELECT id, name, css_id, default_inclusion FROM " . RC_CWP_TABLE_STANDARD_FIELDS .
				" WHERE id = " . (int)$standardFieldId;
			$results = $wpdb->get_row($sql);	
		}
		else
		{
			$sql = "SELECT id, name, css_id, default_inclusion FROM " . RC_CWP_TABLE_STANDARD_FIELDS . " ORDER BY name";
			$results = $wpdb->get_results($sql);
			if (!isset($results))
				$results = array();
		}
		return $results;
	}
	
	function GetWpStandardFieldCssIds()
	{
		$results = RCCWP_Application::GetWpStandardFields();
		$ids = array();
		foreach ($results as $r)
		{
			$ids[] = $r->css_id;
		}
		return $ids;
	}

	function Install()
	{
		global $wpdb;
		
		include_once('RCCWP_Options.php');
		
		if (get_option(RC_CWP_OPTION_KEY) === false)
			RCCWP_Options::Update(0, 0, 0, 0, 0);
		
		// include upgrade-functions for maybe_create_table;
		if (!function_exists('maybe_create_table')) {
			require_once(ABSPATH . '/wp-admin/upgrade-functions.php');
		}

		$sql1 = "CREATE TABLE " . RC_CWP_TABLE_WRITE_PANELS . " (
			id int(11) NOT NULL auto_increment,
			name varchar(50) NOT NULL,
			description varchar(255),
			display_order tinyint,
			capability_name varchar(50) NOT NULL,
			PRIMARY KEY (id) )";
		
		$sql2 = "CREATE TABLE " . RC_CWP_TABLE_CUSTOM_FIELD_TYPES . " (
			id tinyint(11) NOT NULL auto_increment,
			name varchar(50) NOT NULL,
			description varchar(100),
			has_options enum('true', 'false') NOT NULL,
			has_properties enum('true', 'false') NOT NULL,
			allow_multiple_values enum('true', 'false') NOT NULL,
			PRIMARY KEY (id) )";
			
		$sql3 = "CREATE TABLE " . RC_CWP_TABLE_PANEL_CUSTOM_FIELD . " (
			id int(11) NOT NULL auto_increment,
			panel_id int(11) NOT NULL,
			name varchar(50) NOT NULL,
			description varchar(255),
			display_order tinyint,
			display_name enum('true', 'false') NOT NULL,
			display_description enum('true', 'false') NOT NULL,
			type tinyint NOT NULL,
			PRIMARY KEY (id) )";
			
		$sql4 = "CREATE TABLE " . RC_CWP_TABLE_CUSTOM_FIELD_OPTIONS . " (
			custom_field_id int(11) NOT NULL,
			options varchar(255),
			default_option varchar(100),
			PRIMARY KEY (custom_field_id) )";
		
		$sql5 = "CREATE TABLE " . RC_CWP_TABLE_PANEL_CATEGORY . "(
			panel_id int(11) NOT NULL,
			cat_id int(11) NOT NULL,
			PRIMARY KEY (panel_id, cat_id) )";
			
		$sql6 = "CREATE TABLE " . RC_CWP_TABLE_STANDARD_FIELDS . "(
			id int(11) NOT NULL,
			name varchar(50) NOT NULL,
			css_id varchar(50) NOT NULL,
			default_inclusion enum('true', 'false') NOT NULL,
			PRIMARY KEY (id) )";
		
		$sql7 = "CREATE TABLE " . RC_CWP_TABLE_PANEL_STANDARD_FIELD . " (
			panel_id int(11) NOT NULL,
			standard_field_id int(11) NOT NULL,
			PRIMARY KEY (panel_id, standard_field_id) )";
		
		$sql8 = "CREATE TABLE " . RC_CWP_TABLE_CUSTOM_FIELD_PROPERTIES . " (
			custom_field_id int(11) NOT NULL,
			properties varchar(255),
			PRIMARY KEY (custom_field_id) )";
		
		$sql9 = "CREATE TABLE " . RC_CWP_TABLE_PANEL_HIDDEN_EXTERNAL_FIELD . " (
			panel_id int(11) NOT NULL,
			css_id varchar(50) NOT NULL,
			PRIMARY KEY (panel_id, css_id) )";
		
		// create the table, as needed
		maybe_create_table(RC_CWP_TABLE_WRITE_PANELS, $sql1);
		maybe_create_table(RC_CWP_TABLE_CUSTOM_FIELD_TYPES, $sql2);
		maybe_create_table(RC_CWP_TABLE_PANEL_CUSTOM_FIELD, $sql3);
		maybe_create_table(RC_CWP_TABLE_CUSTOM_FIELD_OPTIONS, $sql4);	
		maybe_create_table(RC_CWP_TABLE_PANEL_CATEGORY, $sql5);
		maybe_create_table(RC_CWP_TABLE_STANDARD_FIELDS, $sql6);
		maybe_create_table(RC_CWP_TABLE_PANEL_STANDARD_FIELD, $sql7);
		maybe_create_table(RC_CWP_TABLE_CUSTOM_FIELD_PROPERTIES, $sql8);
		maybe_create_table(RC_CWP_TABLE_PANEL_HIDDEN_EXTERNAL_FIELD, $sql9);
		
		$sql6 = "INSERT IGNORE INTO " . RC_CWP_TABLE_CUSTOM_FIELD_TYPES . " VALUES (1, 'Textbox', NULL, 'false', 'true', 'false')";
		$wpdb->query($sql6);
		
		$sql6 = "INSERT IGNORE INTO " . RC_CWP_TABLE_CUSTOM_FIELD_TYPES . " VALUES (2, 'Multiline Textbox', NULL, 'false', 'true', 'false')";
		$wpdb->query($sql6);
		
		$sql6 = "INSERT IGNORE INTO " . RC_CWP_TABLE_CUSTOM_FIELD_TYPES . " VALUES (3, 'Checkbox', NULL, 'false', 'false', 'false')";
		$wpdb->query($sql6);
		
		$sql6 = "INSERT IGNORE INTO " . RC_CWP_TABLE_CUSTOM_FIELD_TYPES . " VALUES (4, 'Checkbox List', NULL, 'true', 'false', 'true')";
		$wpdb->query($sql6);
		
		$sql6 = "INSERT IGNORE INTO " . RC_CWP_TABLE_CUSTOM_FIELD_TYPES . " VALUES (5, 'Radiobutton List', NULL, 'true', 'false', 'false')";
		$wpdb->query($sql6);
		
		$sql6 = "INSERT IGNORE INTO " . RC_CWP_TABLE_CUSTOM_FIELD_TYPES . " VALUES (6, 'Dropdown List', NULL, 'true', 'false', 'false')";
		$wpdb->query($sql6);
		
		$sql6 = "INSERT IGNORE INTO " . RC_CWP_TABLE_CUSTOM_FIELD_TYPES . " VALUES (7, 'Listbox', NULL, 'true', 'true', 'true')";
		$wpdb->query($sql6);
		
		$sql9 = "INSERT IGNORE INTO " . RC_CWP_TABLE_STANDARD_FIELDS . " VALUES (1, 'Title', 'titlediv', 'true')";
		$wpdb->query($sql9);
		
		$sql9 = "INSERT IGNORE INTO " . RC_CWP_TABLE_STANDARD_FIELDS . " VALUES (2, 'Categories', 'categorydiv', 'false')";
		$wpdb->query($sql9);
		
		$sql9 = "INSERT IGNORE INTO " . RC_CWP_TABLE_STANDARD_FIELDS . " VALUES (3, 'Discussion', 'commentstatusdiv', 'false')";
		$wpdb->query($sql9);
		
		$sql9 = "INSERT IGNORE INTO " . RC_CWP_TABLE_STANDARD_FIELDS . " VALUES (4, 'Post Password', 'passworddiv', 'false')";
		$wpdb->query($sql9);
		
		$sql9 = "INSERT IGNORE INTO " . RC_CWP_TABLE_STANDARD_FIELDS . " VALUES (5, 'Post Slug', 'slugdiv', 'false')";
		$wpdb->query($sql9);
		
		$sql9 = "INSERT IGNORE INTO " . RC_CWP_TABLE_STANDARD_FIELDS . " VALUES (6, 'Post Status', 'poststatusdiv', 'false')";
		$wpdb->query($sql9);
		
		$sql9 = "INSERT IGNORE INTO " . RC_CWP_TABLE_STANDARD_FIELDS . " VALUES (7, 'Post Timestamp', 'posttimestampdiv', 'false')";
		$wpdb->query($sql9);
		
		$sql9 = "INSERT IGNORE INTO " . RC_CWP_TABLE_STANDARD_FIELDS . " VALUES (8, 'Upload', 'uploading', 'false')";
		$wpdb->query($sql9);
		
		$sql9 = "INSERT IGNORE INTO " . RC_CWP_TABLE_STANDARD_FIELDS . " VALUES (9, 'Optional Excerpt', 'postexcerpt', 'false')";
		$wpdb->query($sql9);
		
		$sql9 = "INSERT IGNORE INTO " . RC_CWP_TABLE_STANDARD_FIELDS . " VALUES (10, 'Trackbacks', 'trackbacksdiv', 'false')";
		$wpdb->query($sql9);
		
		$sql9 = "INSERT IGNORE INTO " . RC_CWP_TABLE_STANDARD_FIELDS . " VALUES (11, 'Custom Fields', 'postcustom', 'false')";
		$wpdb->query($sql9);
		
		$sql9 = "INSERT IGNORE INTO " . RC_CWP_TABLE_STANDARD_FIELDS . " VALUES (12, 'Post', 'postdiv', 'false')";
		$wpdb->query($sql9);
		
		$sql9 = "INSERT IGNORE INTO " . RC_CWP_TABLE_STANDARD_FIELDS . " VALUES (13, 'Post Author', 'authordiv', 'false')";
		$wpdb->query($sql9);
	}

	function Uninstall()
	{
 		global $wpdb;
 		$sql = "DELETE FROM $wpdb->postmeta WHERE meta_key = '" . RC_CWP_POST_WRITE_PANEL_ID_META_KEY . "'";
 		$wpdb->query($sql);
	 	
		$sql = "DROP TABLE " . RC_CWP_TABLE_WRITE_PANELS;
		$wpdb->query($sql);
		
		$sql = "DROP TABLE " . RC_CWP_TABLE_CUSTOM_FIELD_TYPES;
		$wpdb->query($sql);
		
		$sql = "DROP TABLE " . RC_CWP_TABLE_PANEL_CUSTOM_FIELD;
		$wpdb->query($sql);
		
		$sql = "DROP TABLE " . RC_CWP_TABLE_CUSTOM_FIELD_OPTIONS;
		$wpdb->query($sql);
		
		$sql = "DROP TABLE " . RC_CWP_TABLE_PANEL_CATEGORY;
		$wpdb->query($sql);
		
		$sql = "DROP TABLE " . RC_CWP_TABLE_STANDARD_FIELDS;
		$wpdb->query($sql);
		
		$sql = "DROP TABLE " . RC_CWP_TABLE_PANEL_STANDARD_FIELD;
		$wpdb->query($sql);
		
		$sql = "DROP TABLE " . RC_CWP_TABLE_CUSTOM_FIELD_PROPERTIES;
		$wpdb->query($sql);
		
		delete_option(RC_CWP_OPTION_KEY);
	}
	
	function InCustomWritePanel()
	{
		return RCCWP_Application::InWritePostPanel() && isset($_REQUEST['custom-write-panel-id']);
	}
	
	function InWritePostPanel()
	{
		return (strstr($_SERVER['REQUEST_URI'], '/wp-admin/post-new.php') ||
			strstr($_SERVER['REQUEST_URI'], '/wp-admin/post.php') ||
			strstr($_SERVER['REQUEST_URI'], '/wp-admin/page-new.php') ||
			strstr($_SERVER['REQUEST_URI'], '/wp-admin/page.php'));
	}
}
?>