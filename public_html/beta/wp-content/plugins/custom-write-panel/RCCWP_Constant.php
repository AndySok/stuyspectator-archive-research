<?php
define('RC_CWP_DEBUG_MODE', TRUE);
define('RC_CWP_PLUGIN_DIR', dirname(plugin_basename(__FILE__)));
define('RC_CWP_POST_WRITE_PANEL_ID_META_KEY', '_rc_cwp_write_panel_id');
define('RC_CWP_OPTION_KEY', 'rc_custom_write_panel');

define('RC_CWP_TABLE_WRITE_PANELS', $table_prefix . 'rc_cwp_write_panels');
define('RC_CWP_TABLE_CUSTOM_FIELD_TYPES', $table_prefix . 'rc_cwp_custom_field_types');
define('RC_CWP_TABLE_PANEL_CUSTOM_FIELD', $table_prefix . 'rc_cwp_panel_custom_field');
define('RC_CWP_TABLE_CUSTOM_FIELD_OPTIONS', $table_prefix . 'rc_cwp_custom_field_options');
define('RC_CWP_TABLE_PANEL_CATEGORY', $table_prefix . 'rc_cwp_panel_category');
define('RC_CWP_TABLE_STANDARD_FIELDS', $table_prefix . 'rc_cwp_standard_fields');
define('RC_CWP_TABLE_PANEL_STANDARD_FIELD', $table_prefix . 'rc_cwp_panel_standard_field');
define('RC_CWP_TABLE_CUSTOM_FIELD_PROPERTIES', $table_prefix . 'rc_cwp_custom_field_properties');
define('RC_CWP_TABLE_PANEL_HIDDEN_EXTERNAL_FIELD', $table_prefix . 'rc_cwp_panel_hidden_external_field');

if (!defined('DIRECTORY_SEPARATOR'))
{
	if (strpos(php_uname('s'), 'Win') !== false )
		define('DIRECTORY_SEPARATOR', '\\');
	else 
		define('DIRECTORY_SEPARATOR', '/');
}
?>