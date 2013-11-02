<?php
class RCCWP_WritePostPage
{
	function ApplyCustomWritePanelAssignedCategories($content)
	{
		global $CUSTOM_WRITE_PANEL;
		
		$assignedCategoryIds = RCCWP_CustomWritePanel::GetAssignedCategoryIds($CUSTOM_WRITE_PANEL->id);
		foreach ($assignedCategoryIds as $categoryId)
		{
			$toReplace = 'id="in-category-' . $categoryId . '"';
			$replacement = $toReplace . ' checked="checked"';
			$content = str_replace($toReplace, $replacement, $content);
		}
		
		return $content;
	}
	
	function ApplyCustomWritePanelStandardFields()
	{
		global $CUSTOM_WRITE_PANEL;
		
		$displayCssIds = RCCWP_CustomWritePanel::GetStandardFieldCssIds($CUSTOM_WRITE_PANEL->id);
		$wpCssIds = RCCWP_Application::GetWpStandardFieldCssIds();
		
		$hideCssIds = array_diff($wpCssIds, $displayCssIds);
		
		if (empty($hideCssIds))
			return;
		
		if (in_array('postdiv', $hideCssIds))
		{
			array_push($hideCssIds, 'postdivrich');
		}
		
		array_walk($hideCssIds, create_function('&$item1, $key', '$item1 = "#" . $item1;'));
		$hideCssIdString = implode(', ', $hideCssIds);
		?>
		
		<style type="text/css"><?=$hideCssIdString?> {display: none !important;}</style>
		
		<?php
	}
	
	function HideCustomWritePanelExternalFields()
	{
		global $CUSTOM_WRITE_PANEL;
		
		$hideCssIds = RCCWP_CustomWritePanel::GetHiddenExternalFieldCssIds($CUSTOM_WRITE_PANEL->id);
		if (empty($hideCssIds))
			return;
			
		array_walk($hideCssIds, create_function('&$item1, $key', '$item1 = "#" . $item1;'));
		$hideCssIdString = implode(', ', $hideCssIds);
		?>
		
		<style type="text/css"><?=$hideCssIdString?> {display: none !important;}</style>
		
		<?php	
	}
	
	function CustomFieldCollectionInterface()
	{
		global $CUSTOM_WRITE_PANEL;
		
		if (!isset($CUSTOM_WRITE_PANEL))
			return;
		
		$customFields = array();
		$customFields = RCCWP_CustomWritePanel::GetCustomFields($CUSTOM_WRITE_PANEL->id);
		?>
		
		<table class="editform">
		
		<?php
		foreach ($customFields as $field)
		{
			RCCWP_WritePostPage::CustomFieldInterface($field);
		}
		?>
		
		</table>
		<input type="hidden" name="rc-custom-write-panel-verify-key" id="rc-custom-write-panel-verify-key" value="<?=wp_create_nonce('rc-custom-write-panel')?>" />
		<input type="hidden" name="rc-cwp-custom-write-panel-id" value="<?=$CUSTOM_WRITE_PANEL->id?>" />
		<!-- rc_cwp_submit_buttons -->
		
		<?php
	}
	
	function CustomFieldInterface($customField)
	{
		switch ($customField->type)
		{
			case 'Textbox' :
				RCCWP_WritePostPage::TextboxInterface($customField);
				break;
			case 'Multiline Textbox' :
				RCCWP_WritePostPage::MultilineTextboxInterface($customField);
				break;
			case 'Checkbox' :
				RCCWP_WritePostPage::CheckboxInterface($customField);
				break;
			case 'Checkbox List' :
				RCCWP_WritePostPage::CheckboxListInterface($customField);
				break;
			case 'Radiobutton List' :
				RCCWP_WritePostPage::RadiobuttonListInterface($customField);
				break;
			case 'Dropdown List' :
				RCCWP_WritePostPage::DropdownListInterface($customField);
				break;
			case 'Listbox' :
				RCCWP_WritePostPage::ListboxInterface($customField);
				break;
			default:
				;
		}
	}
	
	function CheckboxInterface($customField)
	{
		$customFieldId = '';
		$customFieldName = attribute_escape($customField->name);
		$inputName = RC_Format::GetInputName($customField->name);
		
		if (isset($_REQUEST['post']))
		{
			$customFieldId = $customField->id;
			$value = RCCWP_CustomField::GetCustomFieldValue($_REQUEST['post'], $customField->name);
			$checked = $value == 'true' ? 'checked="checked"' : '';
		}
		?>
		
		<tr>
		<td>
		<label for="<?=$inputName?>"><?=$customFieldName?></label><br />
		<input type="hidden" name="<?=$inputName?>" value="false" />
		<input tabindex="3" class="checkbox" name="<?=$inputName?>" value="true" id="<?=$inputName?>" type="checkbox" <?=$checked?> />
		<input type="hidden" name="rc_cwp_meta_ids[]" value="<?=$customFieldId?>" />
		<input type="hidden" name="rc_cwp_meta_keys[]" value="<?=$inputName?>" />
		</td>
		</tr>
		
		<?php
	}
	
	function CheckboxListInterface($customField)
	{
		$customFieldId = '';
		$customFieldName = attribute_escape($customField->name);
		$inputName = RC_Format::GetInputName($customField->name);
		
		$values = array();
		if (isset($_REQUEST['post']))
		{
			$customFieldId = $customField->id;
			$values = RCCWP_CustomField::GetCustomFieldValues($_REQUEST['post'], $customField->name);
		}
		else
		{
			$values = $customField->default_value;
		}
		?>
		
		<tr>
		<td>
		<label for="<?=$inputName?>"><?=$customFieldName?></label><br />
		
		<?php
		foreach ($customField->options as $option) :
			$option = attribute_escape(trim($option));
			$checked = in_array($option, (array)$values) ? 'checked="checked"' : '';
		?>
		
			<label for="" class="selectit">
				<input tabindex="3" id="<?=$option?>" name="<?=$inputName?>[]" value="<?=$option?>" type="checkbox" <?=$checked?>/>
				<?=attribute_escape($option)?>
			</label><br />
		
		<?php
		endforeach;
		?>
			<input type="hidden" name="rc_cwp_meta_ids[]" value="<?=$customFieldName?>" />
			<input type="hidden" name="rc_cwp_meta_keys[]" value="<?=$inputName?>" />
		</td>
		</tr>
		
		<?php
	}
	
	function DropdownListInterface($customField)
	{
		$customFieldId = '';
		$customFieldName = attribute_escape($customField->name);
		$inputName = RC_Format::GetInputName($customField->name);
		
		if (isset($_REQUEST['post']))
		{
			$customFieldId = $customField->id;
			$value = attribute_escape(RCCWP_CustomField::GetCustomFieldValue($_REQUEST['post'], $customField->name));
		}
		else
		{
			$value = $customField->default_value[0];
		}
		?>
		
		<tr>
		<td>
		<label for="<?=$inputName?>"><?=$customFieldName?></label><br />
		<select tabindex="3" name="<?=$inputName?>">
			<option value="">--Select--</option>
		
		<?php
		foreach ($customField->options as $option) :
			$option = attribute_escape(trim($option));
			$selected = $option == $value ? 'selected="selected"' : '';
		?>
		
			<option value="<?=$option?>" <?=$selected?>><?=$option?></option>
		
		<?php
		endforeach;
		?>
		
		</select>	
		<input type="hidden" name="rc_cwp_meta_ids[]" value="<?=$customFieldId?>" />
		<input type="hidden" name="rc_cwp_meta_keys[]" value="<?=$inputName?>" />
		</td>
		</tr>
		
		<?php
	}
	
	function ListboxInterface($customField)
	{
		$customFieldId = '';
		$customFieldName = attribute_escape($customField->name);
		$inputName = RC_Format::GetInputName($customField->name);
		$inputSize = (int)$customField->properties['size'];
		
		if (isset($_REQUEST['post']))
		{
			$customFieldId = $customField->id;
			$values = RCCWP_CustomField::GetCustomFieldValues($_REQUEST['post'], $customField->name);
		}
		else
		{
			$values = $customField->default_value;
		}
		?>
		
		<tr>
		<td>
		<label for="<?=$inputName?>"><?=$customFieldName?></label><br />
		<select tabindex="3" id="<?=$inputName?>" name="<?=$inputName?>[]" multiple size="<?=$inputSize?>">
		
		<?php
		foreach ($customField->options as $option) :
			$option = attribute_escape(trim($option));
			$selected = in_array($option, (array)$values) ? 'selected="selected"' : '';
		?>
			
			<option value="<?=$option?>" <?=$selected?>><?=$option?></option>
			
		<?php
		endforeach;
		?>
		
		</select>
		<input type="hidden" name="rc_cwp_meta_ids[]" value="<?=$customFieldId?>" />
		<input type="hidden" name="rc_cwp_meta_keys[]" value="<?=$inputName?>" />
		</td>
		</tr>
		
		<?php
	}
	
	function MultilineTextboxInterface($customField)
	{
		$customFieldId = '';
		$customFieldName = attribute_escape($customField->name);
		$inputName = RC_Format::GetInputName($customField->name);
		$inputHeight = (int)$customField->properties['height'];
		$inputWidth = (int)$customField->properties['width'];
		
		if (isset($_REQUEST['post']))
		{
			$customFieldId = $customField->id;
			$value = attribute_escape(RCCWP_CustomField::GetCustomFieldValue($_REQUEST['post'], $customField->name));
		}
		?>
		
		<tr>
		<td>
		<label for="<?=$inputName?>"><?=$customFieldName?></label><br />
		<textarea tabindex="3" id="<?=$inputName?>" name="<?=$inputName?>" rows="<?=$inputHeight?>" cols="<?=$inputWidth?>"><?=$value?></textarea>
		<input type="hidden" name="rc_cwp_meta_ids[]" value="<?=$customFieldId?>" />
		<input type="hidden" name="rc_cwp_meta_keys[]" value="<?=$inputName?>" />
		</td>
		</tr>
		
		<?php
	}
	
	function TextboxInterface($customField)
	{
		$customFieldId = '';
		$customFieldName = attribute_escape($customField->name);
		$inputName = RC_Format::GetInputName($customField->name);
		$inputSize = (int)$customField->properties['size'];
		
		if (isset($_REQUEST['post']))
		{
			$customFieldId = $customField->id;
			$value = attribute_escape(RCCWP_CustomField::GetCustomFieldValue($_REQUEST['post'], $customField->name));
		}
		?>
		
		<tr>
		<td>
		<label for="<?=$inputName?>"><?=$customFieldName?></label><br />
		<input tabindex="3" id="<?=$inputName?>" name="<?=$inputName?>" value="<?=$value?>" type="text" size="<?=$inputSize?>" />
		<input type="hidden" name="rc_cwp_meta_ids[]" value="<?=$customFieldId?>" />
		<input type="hidden" name="rc_cwp_meta_keys[]" value="<?=$inputName?>" />
		</td>
		</tr>
		
		<?php
	}
	
	function RadiobuttonListInterface($customField)
	{
		$customFieldId = '';
		$customFieldName = attribute_escape($customField->name);
		$inputName = RC_Format::GetInputName($customField->name);
		
		if (isset($_REQUEST['post']))
		{
			$value = attribute_escape(RCCWP_CustomField::GetCustomFieldValue($_REQUEST['post'], $customField->name));
		}
		else
		{
			$value = $customField->default_value[0];
		}
		?>
		
		<tr>
		<td>
		<label for="<?=$inputName?>"><?=$customFieldName?></label><br />
		
		<?php
		foreach ($customField->options as $option) :
			$option = attribute_escape(trim($option));
			$checked = $option == $value ? 'checked="checked"' : '';
		?>
			<label for="" class="selectit">
				<input tabindex="3" id="<?=$option?>" name="<?=$inputName?>" value="<?=$option?>" type="radio" <?=$checked?>/>
				<?=$option?>
			</label><br />
		<?php
		endforeach;
		?>
		<input type="hidden" name="rc_cwp_meta_ids[]" value="<?=$customFieldId?>" />
		<input type="hidden" name="rc_cwp_meta_keys[]" value="<?=$inputName?>" />
		</td>
		</tr>
		
		<?php
	}
	
	function RelocateWpSubmitButtons($content)
	{
		$pattern = '(<p class="submit".*?\/p>)(.*?)(<!-- rc_cwp_submit_buttons -->)';  // all those Save, Publish, etc buttons
		$replacement = '$2$1';
		$content = preg_replace('/' . $pattern . '/s', $replacement, $content);
		return $content;
	}
}
?>