<?php
include_once('RCCWP_ManagementPage.php');
include_once('RCCWP_CreateCustomWritePanelPage.php');
include_once('RCCWP_CreateCustomFieldPage.php');
include_once('RCCWP_CustomFieldPage.php');

class RCCWP_Menu
{
	function AttachManagementMenuItem()
	{
		$page_group = 'RCCWP_ManagementPage';
		$page_type = 'View';
		
		if (isset($_REQUEST['create-custom-write-panel']))
		{
			$page_group = 'RCCWP_CreateCustomWritePanelPage';
			$page_type = 'Main';
		}
		else if (isset($_REQUEST['create-custom-field']))
		{
			$page_group = 'RCCWP_CreateCustomFieldPage';
			$page_type = 'Main';
		}
		else if (isset($_REQUEST['continue-create-custom-field']))
		{
			$current_field = RCCWP_CustomField::GetCustomFieldTypes((int)$_REQUEST['custom-field-type']);
			if ($current_field->has_options == "true" || $current_field->has_properties == "true")
			{
				$page_group = 'RCCWP_CreateCustomFieldPage';
				$page_type = 'SetOptions';
			}
			else if ($current_field->has_options == "false")
			{
				RCCWP_CustomField::Create(
					$_POST['custom-write-panel-id'],
					$_POST['custom-field-name'],
					$_POST['custom-field-description'],
					$_POST['custom-field-order'],
					$_POST['custom-field-type'],
					$_POST['custom-field-options']);	
				
				$page_group = 'RCCWP_CustomWritePanelPage';
				$page_type = 'View';
			}
		}
		else if (isset($_REQUEST['finish-create-custom-field']))
		{
			$page_group = 'RCCWP_CustomWritePanelPage';
			$page_type = 'View';
		}
		else if (isset($_REQUEST['finish-create-custom-write-panel']))
		{
			$page_group = 'RCCWP_ManagementPage';
			$page_type = 'View';
		}
		else if (isset($_REQUEST['edit-custom-write-panel']))
		{
			$page_group = 'RCCWP_CustomWritePanelPage';
			$page_type = 'Edit';
		}
		else if (isset($_REQUEST['cancel-edit-custom-write-panel']))
		{
			$page_group = 'RCCWP_CustomWritePanelPage';
			$page_type = 'View';
		}
		else if (isset($_REQUEST['submit-edit-custom-write-panel']))
		{
			$page_group = 'RCCWP_CustomWritePanelPage';
			$page_type = 'View';
		}
		else if (isset($_REQUEST['cancel-edit-custom-field']))
		{
			$page_group = 'RCCWP_CustomWritePanelPage';
			$page_type = 'View';
		}
		else if (isset($_REQUEST['submit-edit-custom-field']))
		{
			$page_group = 'RCCWP_CustomWritePanelPage';
			$page_type = 'View';
		}
		else if (isset($_REQUEST['edit-custom-field']))
		{
			$page_group = 'RCCWP_CustomFieldPage';
			$page_type = 'Edit';
		}
		else if (isset($_REQUEST['view-custom-write-panel']))
		{
			$page_group = 'RCCWP_CustomWritePanelPage';
			$page_type = 'View';
		}
		else if (isset($_REQUEST['assign-custom-write-panel']))
		{
			$page_group = 'RCCWP_ManagementPage';
			$page_type = 'AssignCustomWritePanel';
		}
		
		add_management_page(__('Custom Write Panel'), __('Custom Write Panel'), 'manage_options', __FILE__, array($page_group, $page_type));	
	}
	
	function AttachOptionsMenuItem()
	{
		include_once('RCCWP_OptionsPage.php');
		add_options_page(__('Custom Write Panel Options'), __('Custom Write Panel'), 'manage_options', 'RCCWP_OptionsPage.php', array('RCCWP_OptionsPage', 'Main'));	
	}
	
	function AttachCustomWritePanelMenuItems()
	{
		$customWritePanels = RCCWP_Application::GetCustomWritePanels();
		if (isset($_REQUEST['post']))
		{
			global $submenu;
			global $CUSTOM_WRITE_PANEL;
			if (isset($CUSTOM_WRITE_PANEL))
				$submenu['edit.php'][5] = array(__($CUSTOM_WRITE_PANEL->name), 'edit_posts', 'edit.php');
		}
		else
		{
			include_once('RCCWP_Options.php');
			$assignToRole = RCCWP_Options::Get('assign-to-role');
				
			foreach ($customWritePanels as $panel)
			{
				if ($assignToRole <> 1 || current_user_can($panel->capability_name))
				{
					add_submenu_page('post-new.php', __($panel->name), __($panel->name), 'publish_posts', 'post-new.php?custom-write-panel-id=' . $panel->id);
				}
			}
		}
		
		RCCWP_Menu::SetCurrentCustomWritePanelMenuItem();
	}
	
	function DetachWpWritePanelMenuItems()
	{
		include_once('RCCWP_Options.php');
		global $submenu;

		$options = RCCWP_Options::Get();
		
		if ($options['hide-write-post'] == '1')
			unset($submenu['post-new.php'][5]);
		
		if ($options['hide-write-page'] == '1')
			unset($submenu['post-new.php'][10]);	
	}
	
	function SetCurrentCustomWritePanelMenuItem()
	{
		// wp-admin/menu.php
		global $submenu_file;
		global $menu;
		
		include_once('RCCWP_Options.php');
		$options = RCCWP_Options::Get();
		
		if ($options['default-custom-write-panel'] != '')
		{
			include_once('RCCWP_CustomWritePanel.php');
			
			$customWritePanel = RCCWP_CustomWritePanel::Get((int)$options['default-custom-write-panel']);
			if ($options['assign-to-role'] <> 1 || current_user_can($customWritePanel->capability_name))
			{
				$menu[5][2] = 'post-new.php?custom-write-panel-id=' . (int)$options['default-custom-write-panel'];
			}
		}
		
		if ($_REQUEST['custom-write-panel-id'])
		{
			$submenu_file = 'post-new.php?custom-write-panel-id=' . (int)$_REQUEST['custom-write-panel-id'];
		}
		else if (isset($_REQUEST['post']))
		{
		}
	}
}
?>