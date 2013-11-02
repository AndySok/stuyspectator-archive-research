<?php
class RCCWP_Processor
{
	function Main()
	{
		global $CUSTOM_WRITE_PANEL;
		
		if (isset($_POST['edit-with-no-custom-write-panel']))
		{
			wp_redirect('post.php?action=edit&post=' . $_POST['post-id'] . '&no-custom-write-panel=' . $_POST['custom-write-panel-id']);
		}
		else if (isset($_POST['edit-with-custom-write-panel']))
		{
			wp_redirect('post.php?action=edit&post=' . $_POST['post-id'] . '&custom-write-panel-id=' . $_POST['custom-write-panel-id']);
		}
		
		if (RCCWP_Application::InWritePostPanel())
		{
			include_once('RCCWP_Menu.php');
			include_once('RCCWP_WritePostPage.php');
			
			$CUSTOM_WRITE_PANEL = RCCWP_Post::GetCustomWritePanel();
			
			if (isset($CUSTOM_WRITE_PANEL))
			{
				include_once('RCCWP_Options.php');
				$assignToRole = RCCWP_Options::Get('assign-to-role');
				
				if ($assignToRole <> 1 || current_user_can($CUSTOM_WRITE_PANEL->capability_name))
				{
					ob_start(array('RCCWP_WritePostPage', 'ApplyCustomWritePanelAssignedCategories'));
					ob_start(array('RCCWP_WritePostPage', 'RelocateWpSubmitButtons'));
					
					add_action('admin_head', array('RCCWP_WritePostPage', 'ApplyCustomWritePanelStandardFields'));
					add_action('admin_head', array('RCCWP_WritePostPage', 'HideCustomWritePanelExternalFields'));
						
					add_action('simple_edit_form', array('RCCWP_WritePostPage', 'CustomFieldCollectionInterface'));
					add_action('edit_form_advanced', array('RCCWP_WritePostPage', 'CustomFieldCollectionInterface'));
				}
			}
			else if (!isset($_REQUEST['no-custom-write-panel']) && isset($_REQUEST['post']))
			{
				include_once('RCCWP_Options.php');
				$promptEditingPost = RCCWP_Options::Get('prompt-editing-post');
				if ($promptEditingPost == 1)
				{
					wp_redirect('edit.php?page=' . urlencode(RC_CWP_PLUGIN_DIR . DIRECTORY_SEPARATOR . 'RCCWP_Menu.php') . '&assign-custom-write-panel=' . (int)$_GET['post']);
				}
			}
		}
		
		if (isset($_POST['finish-create-custom-write-panel']))
		{
			include_once('RCCWP_CustomWritePanel.php');
			
			$hiddenExtFields = explode("\n", $_POST['custom-write-panel-ext-fields']);
			array_walk($hiddenExtFields, array(RC_Format, TrimArrayValues));
			
			$customWritePanelId = RCCWP_CustomWritePanel::Create(
				$_POST['custom-write-panel-name'],
				$_POST['custom-write-panel-description'],
				$_POST['custom-write-panel-standard-fields'],
				$hiddenExtFields,
				$_POST['custom-write-panel-categories'],
				$_POST['custom-write-panel-order']);
				
			RCCWP_CustomWritePanel::AssignToRole($customWritePanelId, 'administrator');
		}
		else if (isset($_POST['submit-edit-custom-write-panel']))
		{
			include_once('RCCWP_CustomWritePanel.php');
			
			$hiddenExtFields = explode("\n", $_POST['custom-write-panel-ext-fields']);
			array_walk($hiddenExtFields, array(RC_Format, TrimArrayValues));
			
			RCCWP_CustomWritePanel::Update(
				$_POST['custom-write-panel-id'],
				$_POST['custom-write-panel-name'],
				$_POST['custom-write-panel-description'],
				$_POST['custom-write-panel-standard-fields'],
				$hiddenExtFields,
				$_POST['custom-write-panel-categories'],
				$_POST['custom-write-panel-order']);
			
			RCCWP_CustomWritePanel::AssignToRole($_POST['custom-write-panel-id'], 'administrator');
		}
		else if (isset($_POST['finish-create-custom-field']))
		{
			include_once('RCCWP_CustomField.php');
			
			$current_field = RCCWP_CustomField::GetCustomFieldTypes((int)$_REQUEST['custom-field-type']);
			
			if ($current_field->has_properties)
			{
				$custom_field_properties = array();
				if (in_array($current_field->name, array('Textbox', 'Listbox')))
				{
					$custom_field_properties['size'] = $_POST['custom-field-size'];
				}
				else if (in_array($current_field->name, array('Multiline Textbox')))
				{
					$custom_field_properties['height'] = $_POST['custom-field-height'];
					$custom_field_properties['width'] = $_POST['custom-field-width'];
				}
			}
			
			RCCWP_CustomField::Create(
				$_POST['custom-write-panel-id'],
				$_POST['custom-field-name'],
				$_POST['custom-field-description'],
				$_POST['custom-field-order'],
				$_POST['custom-field-type'],
				$_POST['custom-field-options'],
				$_POST['custom-field-default-value'],
				$custom_field_properties
				);
		}
		else if (isset($_POST['submit-edit-custom-field']))
		{
			include_once('RCCWP_CustomField.php');
			
			$current_field = RCCWP_CustomField::GetCustomFieldTypes((int)$_POST['custom-field-type']);
			
			if ($current_field->has_properties)
			{
				$custom_field_properties = array();
				if (in_array($current_field->name, array('Textbox', 'Listbox')))
				{
					$custom_field_properties['size'] = $_POST['custom-field-size'];
				}
				else if (in_array($current_field->name, array('Multiline Textbox')))
				{
					$custom_field_properties['height'] = $_POST['custom-field-height'];
					$custom_field_properties['width'] = $_POST['custom-field-width'];
				}
			}
			
			RCCWP_CustomField::Update(
				$_POST['custom-field-id'],
				$_POST['custom-field-name'],
				$_POST['custom-field-description'],
				$_POST['custom-field-order'],
				$_POST['custom-field-type'],
				$_POST['custom-field-options'],
				$_POST['custom-field-default-value'],
				$custom_field_properties
				);
		}
		else if (isset($_POST['update-custom-write-panel-options']))
		{
			if ($_POST['uninstall-custom-write-panel'] == 'uninstall')
			{
				RCCWP_Application::Uninstall();
				wp_redirect('options-general.php');
			}
			else
			{
				include_once('RCCWP_Options.php');
				RCCWP_Options::Update(
					$_POST['hide-write-post'],
					$_POST['hide-write-page'],
					$_POST['prompt-editing-post'],
					$_POST['assign-to-role'],
					$_POST['default-custom-write-panel']);
			}
		}
		else if (isset($_GET['delete-custom-write-panel']))
		{
			include_once('RCCWP_CustomWritePanel.php');
			RCCWP_CustomWritePanel::Delete($_GET['delete-custom-write-panel']);
			wp_redirect('edit.php?page=' . urlencode(RC_CWP_PLUGIN_DIR . DIRECTORY_SEPARATOR . 'RCCWP_Menu.php'));
		}
		else if (isset($_GET['delete-custom-field']))
		{
			include_once('RCCWP_CustomField.php');
			RCCWP_CustomField::Delete($_REQUEST['delete-custom-field']);
			wp_redirect('edit.php?page=' . urlencode(RC_CWP_PLUGIN_DIR . DIRECTORY_SEPARATOR . 'RCCWP_Menu.php') . '&view-custom-write-panel=' . $_REQUEST['custom-write-panel-id'] . '&custom-write-panel-id=' . $_REQUEST['custom-write-panel-id']);
		}
	}
	
	function FlushAllOutputBuffer() 
	{ 
		while (@ob_end_flush()); 
	} 
	
	function Redirect($location)
	{
		global $post_ID;
		
		if (!empty($_REQUEST['rc-cwp-custom-write-panel-id']))
		{
			if (strstr($location, 'post-new.php?posted='))
			{
				$location = $_REQUEST['_wp_http_referer'] . '&posted=' . $post_ID;
			}
		}
		return $location;
	}
}
?>