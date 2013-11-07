<?php
class RCCWP_Post
{	
	function GetCustomWritePanel()
	{
		if (isset($_GET['post']))
		{
			$customWritePanelId = get_post_meta((int)$_GET['post'], RC_CWP_POST_WRITE_PANEL_ID_META_KEY, true);
			
			if (empty($customWritePanelId))
			{
				$customWritePanelId = (int)$_REQUEST['custom-write-panel-id'];
			}
		}
		else if (isset($_REQUEST['custom-write-panel-id']))
		{
			$customWritePanelId = (int)$_REQUEST['custom-write-panel-id'];
		}
		
		if (isset($customWritePanelId))
		{
			include_once('RCCWP_Application.php');
			$customWritePanel = RCCWP_Application::GetCustomWritePanels($customWritePanelId);
		}
		
		return $customWritePanel;
	}
	
	function SetCustomWritePanel($postId)
	{
		if(!wp_verify_nonce($_REQUEST['rc-custom-write-panel-verify-key'], 'rc-custom-write-panel'))
			return $postId;
        		
		if (!current_user_can('edit_post', $postId))
			return $postId;
		
		$customWritePanelId = $_POST['rc-cwp-custom-write-panel-id'];
		if (isset($customWritePanelId))
		{
			if (!empty($customWritePanelId))
			{
				if (!update_post_meta($postId, RC_CWP_POST_WRITE_PANEL_ID_META_KEY, $customWritePanelId))
				{
					add_post_meta($postId, RC_CWP_POST_WRITE_PANEL_ID_META_KEY, $customWritePanelId);
				}
			}
			else
			{
				delete_post_meta($postId, RC_CWP_POST_WRITE_PANEL_ID_META_KEY);
			}
		}
	}
	
	function SetMetaValue($postId)
	{
		global $wpdb;
		
		if(!wp_verify_nonce($_REQUEST['rc-custom-write-panel-verify-key'], 'rc-custom-write-panel'))
			return $postId;
		
		if (!current_user_can('edit_post', $postId))
			return $postId;
		
		$customWritePanelId = $_POST['rc-cwp-custom-write-panel-id'];
		if (isset($customWritePanelId))
		{
			if (!empty($customWritePanelId))
			{
				$customFieldCount = count($customFieldKeys);
				$customFieldKeys = (array)$_POST['rc_cwp_meta_keys'];
				foreach ($customFieldKeys as $key)
				{
					$rawCustomFieldName = $key;
					
					if (isset($rawCustomFieldName))
					{
						if (!empty($rawCustomFieldName))
						{
							$customFieldName = $wpdb->escape(stripslashes(trim(RC_Format::GetFieldName($rawCustomFieldName))));
							$customFieldValue = $_POST[$rawCustomFieldName];
							
							delete_post_meta($postId, $customFieldName);
							if (is_array($customFieldValue))
							{
								foreach ($customFieldValue as $value)
								{
									$value = stripslashes(trim($value));
									add_post_meta($postId, $customFieldName, $value);
								}
							}
							else
							{
								$value = stripslashes(trim($customFieldValue));
								add_post_meta($postId, $customFieldName, $value);
							}
						}
						else
						{
							delete_post_meta($postId, $customFieldName);
						}
					}
				}
			}
			else
			{
				
			}
		}
	}
}
?>