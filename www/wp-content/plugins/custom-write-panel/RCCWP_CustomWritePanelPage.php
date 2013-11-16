<?php
include_once('RCCWP_CustomWritePanel.php');

class RCCWP_CustomWritePanelPage
{
	function Content($customWritePanel = null)
	{
		$customWritePanelName = "";
		$customWritePanelDescription = "";
		$write_panel_category_ids = array();
		
		if ($customWritePanel != null)
		{
			$customWritePanelName = $customWritePanel->name;
			$customWritePanelDescription = $customWritePanel->description;
			$customWritePanelDisplayOrder = $customWritePanel->display_order;
			$customWritePanelCategoryIds = RCCWP_CustomWritePanel::GetAssignedCategoryIds($customWritePanel->id);
			$customWritePanelStandardFieldIds = RCCWP_CustomWritePanel::GetStandardFieldIds($customWritePanel->id);
			$customWritePanelHiddenExtFieldCssIds = RCCWP_CustomWritePanel::GetHiddenExternalFieldCssIds($customWritePanel->id);
		?>
		<input type="hidden" name="custom-write-panel-id" value="<?=$_POST['custom-write-panel-id']?>" />
		<?php
		}
		
  		?>
		<table class="optiontable">
		<tbody>
		<tr valign="top">
			<th scope="row">Name:</th>
			<td><input name="custom-write-panel-name" id="custom-write-panel-name" size="40" type="text" value="<?=$customWritePanelName?>" /></td>
		</tr>
		<tr valign="top">
			<th scope="row">Description:</th>
			<td><textarea name="custom-write-panel-description" id="custom-write-panel-description" rows="2" cols="38"><?=$customWritePanelDescription?></textarea></td>
		</tr>
		<tr valign="top">
			<th scope="row">Assigned Categories:</th>
			<td>
				<select multiple size="10" name="custom-write-panel-categories[]" style="width:305px">
					<?php
					$cats = RCCWP_Application::GetWpCategories();
					
					foreach ($cats as $cat) :
						$selected = "";
						if (in_array($cat->cat_ID, $customWritePanelCategoryIds))
						{
							$selected = "selected=\"selected\"";
						}
					?>
						<option value="<?=$cat->cat_ID?>" <?=$selected?>><?=$cat->cat_name ?></option>
					<?php
					endforeach;
					?>
				</select>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row">Standard Fields:</th>
			<td>
				<select multiple size="10" name="custom-write-panel-standard-fields[]" style="width:305px">
					<?php
					$standard_fields = RCCWP_Application::GetWpStandardFields();
					foreach ($standard_fields as $field) :
						$selected = "";
						if ($customWritePanel != null)
						{
							if (in_array($field->id, $customWritePanelStandardFieldIds))
							{
								$selected = "selected=\"selected\"";
							}
						}
						else
						{
							if ($field->default_inclusion == 'true')
							{
								$selected = "selected=\"selected\""; 
							}
						}
					?>
						<option value="<?=$field->id?>" <?=$selected?>><?=$field->name?></option>
					<?php
					endforeach;
					?>
				</select>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row">Hidden External Fields:</th>
			<td>
			<?php
			$extFields = implode("\n", (array)$customWritePanelHiddenExtFieldCssIds);
			?>
			<textarea name="custom-write-panel-ext-fields" id="custom-write-panel-ext-fields" rows="2" cols="38"><?=$extFields?></textarea><br />
			<em>Other plugins may add input fields in write panel. Enter the input fields' css ID here to hide them. Separate each value with a newline.</em>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row">Order:</th>
			<td><input name="custom-write-panel-order" id="custom-write-panel-order" size="2" type="text" value="<?=$customWritePanelDisplayOrder?>" /></td>
		</tr>
		<?php
		if (!isset($customWritePanel)) :
		?>
		<tr>
			<th scope="row">Custom Fields:</th>
			<td>Add custom fields later by editing this custom write panel.</td>
		</tr>
		<?php
		endif;
		?>
		</tbody>
		</table>
		
		<?php
	}
	
	function Edit()
	{
		$customWritePanel = RCCWP_Application::GetCustomWritePanels((int)$_REQUEST['custom-write-panel-id']);
		?>
		<div class="wrap">
		
		<h2>Edit Custom Write Panel</h2>
		
		<form action="" method="post" id="edit-custom-write-panel-form">
		
		<?php
		RCCWP_CustomWritePanelPage::Content($customWritePanel);
		?>
		
		<p class="submit" >
			<input name="cancel-edit-custom-write-panel" type="submit" id="cancel-edit-custom-write-panel" value="<?php _e('Cancel'); ?>" /> 
			<input name="submit-edit-custom-write-panel" type="submit" id="submit-edit-custom-write-panel" value="<?php _e('Update'); ?>" />
		</p>
		</form>
		
		</div>
		
		<?php
	}
	
	function GetAssignedCategoriesString($customWritePanel)
	{
		$results = RCCWP_CustomWritePanel::GetAssignedCategories($customWritePanel);
		$str = '';
		foreach ($results as $r)
		{
			$str .= $r->cat_name . ', ';	
		}
		$str = substr($str, 0, strlen($str) - 2); // deletes last comma and whitespace
		return $str;
	}
	
	function GetStandardFieldsString($customWritePanel)
	{
		$results = RCCWP_CustomWritePanel::GetStandardFields($customWritePanel);
		foreach ($results as $r)
		{
			$str .= $r->name . ', ';	
		}
		$str = substr($str, 0, strlen($str) - 2); // deletes last comma and whitespace
		return $str;
	}
	
	function View($param = 23)
	{
		$customWritePanelId = (int)$_GET['custom-write-panel-id'];
		$customWritePanel = RCCWP_Application::GetCustomWritePanels($customWritePanelId);
		?>

		<div class="wrap">

		<h2>Custom Write Panel Info</h2>

		<form action="" method="post" id="view-write-panel-form">
		
		<input type="hidden" name="custom-write-panel-id" value="<?=$customWritePanelId?>" />
			
  		<fieldset class="options">
		    	
  		<table class="optiontable">
  		<tbody>
  		<tr>
			<th scope="row">Name:</th>
			<td><?=$customWritePanel->name?></td>
		</tr>
		<tr>
			<th scope="row">Description:</th>
			<td><?=$customWritePanel->description?></td>
		</tr>
		<tr>
			<th scope="row">Assigned Categories:</th>
			<td><?=RCCWP_CustomWritePanelPage::GetAssignedCategoriesString($customWritePanelId)?></td>
		</tr>
		<tr>
			<th scope="row">Standard Fields:</th>
			<td><?=RCCWP_CustomWritePanelPage::GetStandardFieldsString($customWritePanelId)?></td>
		</tr>
  		</tbody>
  		</table>
		  
		</fieldset>
		
		<p class="submit" ><input name="edit-custom-write-panel" type="submit" id="edit-custom-write-panel" value="Edit Write Panel" /></p>
		
		<fieldset class="options">
		<legend>Custom Fields</legend>
		
  		<table cellpadding="3" cellspacing="3" width="100%">
  		<thead>
  		<tr>
  			<th scope="col">Order</th>
			<th scope="col">Name</th>
			<th scope="col">Type</th>
			<th scope="col">Description</th>
			<th scope="col" colspan="2">Action</th>
		</tr>
  		</thead>
  		<tbody>
  		<?php
  		$custom_fields = RCCWP_CustomWritePanel::GetCustomFields($customWritePanelId);
  		foreach ($custom_fields as $field) :
  			$class = $class == '' ? 'alternate' : '';
  		?>
  			<tr class="<?=$class?>">
  				<td align="right" width="3"><?=$field->display_order?></td>
  				<td><?=$field->name?></td>
  				<td><?=$field->type?></td>
  				<td><?=$field->description?></td>
  				<td><a href="<?=RCCWP_ManagementPage::GetCustomFieldEditUrl($customWritePanelId, $field->id)?>" class="edit">Edit</a></td>
  				<td><a href="<?=RCCWP_ManagementPage::GetCustomFieldDeleteUrl($customWritePanelId, $field->id)?>" class="delete">Delete</a></td>
  			</tr>
  		<?php
  		endforeach;
  		?>
  		</tbody>
  		</table>
		  
		</fieldset>
		
		<p class="submit" ><input name="create-custom-field" type="submit" id="create-custom-field" value="Create Custom Field" /></p>
		
		</form>

		</div>
		
		<?php
	}
}
?>