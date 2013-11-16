<?php
include_once('RCCWP_Application.php');

class RCCWP_ManagementPage
{
	function AssignCustomWritePanel()
	{
		$postId = (int)$_GET['assign-custom-write-panel'];
		$customWritePanels = RCCWP_Application::GetCustomWritePanels();
		$customWritePanelOptions = RCCWP_Options::Get();
		$message = 'The Post that you\'re about to edit is not associated with any Custom Write Panel.';
		?>
		
		<div id="message" class="updated"><p><?php _e($message); ?></p></div>
		
		<div class="wrap">
		<h2><?php _e('Assign Custom Write Panel'); ?></h2>
		
		<form action="" method="post" id="assign-custom-write-panel-form">
		
		<table class="optiontable">
		<tbody>
		<tr valign="top">
			<th scope="row">Custom Write Panel:</th>
			<td>
				<select name="custom-write-panel-id" id="custom-write-panel-id">
					<option value="">(None)</option>
				<?php
				$defaultCustomWritePanel = $customWritePanelOptions['default-custom-write-panel'];
				foreach ($customWritePanels as $panel) :
					$selected = $panel->id == $defaultCustomWritePanel ? 'selected="selected"' : '';
				?>
					<option value="<?=$panel->id?>" <?=$selected?>><?=$panel->name?></option>
				<?php
				endforeach;
				?>
				</select>
			</td>
		</tr>
		</tbody>
		</table>
		
		<input type="hidden" name="post-id" value="<?=$postId?>" />
		<p class="submit" >
			<input name="edit-with-no-custom-write-panel" type="submit" value="Don't Assign Custom Write Panel" />
			<input name="edit-with-custom-write-panel" type="submit" value="Edit with Custom Write Panel" />
		</p>
		
		</form>
		
		</div>
		
		<?php
	}
	
	function GetCustomFieldEditUrl($customWritePanelId, $customFieldId)
	{
		$url = '?page=' . RC_CWP_PLUGIN_DIR . DIRECTORY_SEPARATOR . 'RCCWP_Menu.php&edit-custom-field=' . $customFieldId . '&custom-write-panel-id=' . $customWritePanelId;
		return $url;
	}
	
	function GetCustomFieldDeleteUrl($customWritePanelId, $customFieldId)
	{
		$url = '?page=' . RC_CWP_PLUGIN_DIR . DIRECTORY_SEPARATOR . 'RCCWP_Menu.php&delete-custom-field=' . $customFieldId . '&custom-write-panel-id=' . $customWritePanelId;
		return $url;
	}
	
	function GetCustomWritePanelEditUrl($customWritePanelId)
	{
		$url = '?page=' . RC_CWP_PLUGIN_DIR . DIRECTORY_SEPARATOR . 'RCCWP_Menu.php&view-custom-write-panel=' . $customWritePanelId . '&custom-write-panel-id=' . $customWritePanelId;
		return $url;
	}
	
	function GetCustomWritePanelDeleteUrl($customWritePanelId)
	{
		$url = '?page=' . RC_CWP_PLUGIN_DIR . DIRECTORY_SEPARATOR . 'RCCWP_Menu.php&delete-custom-write-panel=' . $customWritePanelId . '&custom-write-panel-id=' . $customWritePanelId;
		return $url;
	}
	
	function View()
	{
		$customWritePanels = RCCWP_Application::GetCustomWritePanels();
		?>

		<div class="wrap">
		<h2><?php _e('Custom Write Panel'); ?></h2>

		<table cellpadding="3" cellspacing="3" width="100%">
		<thead>
		<tr>
			<th scope="col"><?php _e('Order'); ?></th>
			<th scope="col"><?php _e('Name'); ?></th>
			<th scope="col"><?php _e('Description'); ?></th>
			<th colspan="2" style="text-align:center"><?php _e('Action'); ?></th>
		</tr>
		</thead>
		<tbody>
		<?php
		foreach ($customWritePanels as $panel) :
			$class = $class == '' ? 'alternate' : '';
		?>
		<tr class="<?=$class?>">
			<td align="right"><?=$panel->display_order ?></td>
			<td><?=$panel->name ?></td>
			<td><?=$panel->description ?></td></td>
			<td><a href="<?php echo RCCWP_ManagementPage::GetCustomWritePanelEditUrl($panel->id); ?>" class="edit"><?php _e('View') ?></a></td>
			<td><a href="<?php echo RCCWP_ManagementPage::GetCustomWritePanelDeleteUrl($panel->id); ?>" class="delete"><?php _e('Delete'); ?></a></td>
		</tr>
		<?php
		endforeach;
		?>
		</tbody>
		</table>

		</div>

		<div class="wrap">
		<form action="" method="post" id="main-management-form">
		<p class="submit">
			<!--
			<input name="custom-write-panel-options" type="submit" id="custom-write-panel-options" value="<?php _e('Go to Options'); ?>" />
			-->
			<input name="create-custom-write-panel" type="submit" id="create-custom-write-panel" value="<?php _e('Create Custom Write Panel'); ?>" />
		</p>
		</form>
		</div>

		<?php 
	}
}
?>