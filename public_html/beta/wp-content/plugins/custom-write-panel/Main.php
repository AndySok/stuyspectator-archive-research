<?php
/*
Plugin Name: Custom Write Panel
Plugin URI: http://rhymedcode.net/projects/custom-write-panel
Description: Custom Write Panel allows user to create customized write panel.
Author: Joshua Sigar
Version: 1.0.0a12
Author URI: http://rhymedcode.net
*/

if (is_admin())
{
	include_once('RCCWP_Constant.php');
	include_once('RCCWP_Application.php');
	
	register_activation_hook(dirname(__FILE__) . '/Main.php', array('RCCWP_Application', 'Install'));

	if (get_option(RC_CWP_OPTION_KEY) !== false)
	{
		include_once('RCCWP_Menu.php');

		//register_deactivation_hook(dirname(__FILE__) . '/Main.php', array('RCCWP_Application', 'Uninstall'));

		add_action('admin_menu', array('RCCWP_Menu', 'AttachCustomWritePanelMenuItems'));
		add_action('admin_menu', array('RCCWP_Menu', 'DetachWpWritePanelMenuItems'));

		include_once('RCCWP_Processor.php');
		add_action('init', array('RCCWP_Processor', 'Main'));
		add_action('admin_menu', array('RCCWP_Menu', 'AttachManagementMenuItem'));
		add_action('admin_menu', array('RCCWP_Menu', 'AttachOptionsMenuItem'));

		include_once('RCCWP_Post.php');	
		add_action('edit_post', array('RCCWP_Post', 'SetCustomWritePanel'));
		add_action('save_post', array('RCCWP_Post', 'SetCustomWritePanel'));
		add_action('publish_post', array('RCCWP_Post', 'SetCustomWritePanel'));

		add_action('edit_post', array('RCCWP_Post', 'SetMetaValue'));
		add_action('save_post', array('RCCWP_Post', 'SetMetaValue'));
		add_action('publish_post', array('RCCWP_Post', 'SetMetaValue'));
		
		add_filter('wp_redirect', array('RCCWP_Processor', 'Redirect'));

		add_action('shutdown', array('RCCWP_Processor', 'FlushAllOutputBuffer')); 
	}
}

?>