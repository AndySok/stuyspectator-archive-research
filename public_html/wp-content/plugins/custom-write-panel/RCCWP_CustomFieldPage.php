<?php
class RCCWP_CustomFieldPage
{
	function Edit()
	{
		$custom_field = RCCWP_CustomField::Get((int)$_GET['edit-custom-field']);
  		?>
	  	
  		<div class="wrap">
	  	
  		<h2>Edit Custom Field</h2>
	  	
  		<form action="" method="post" id="edit-custom-field-form">
  		<input type="hidden" name="custom-field-id" value="<?=$custom_field->id?>"
		<fieldset class="options">
		
		<table class="optiontable">
		<tbody>
		<tr valign="top">
			<th scope="row">Name:</th>
			<td><input name="custom-field-name" id="custom-field-name" size="40" type="text" value="<?=$custom_field->name?>" /></td>
		</tr>
		<tr valign="top">
			<th scope="row">Description:</th>
			<td><textarea name="custom-field-description" id="custom-field-description" rows="2" cols="38"><?=$custom_field->description?></textarea></td>
		</tr>
		<tr valign="top">
			<th scope="row">Order:</th>
			<td>
				<input name="custom-field-order" id="custom-field-order" size="2" type="text" value="<?=$custom_field->display_order?>" /></td>
			</td>
		</tr>
		
		<?php if (in_array($custom_field->type, array('Textbox', 'Listbox'))) : ?>
		<tr valign="top">
			<th scope="row">Size:</th>
			<td><input type="text" name="custom-field-size" id="custom-field-size" size="2" value="<?=$custom_field->properties['size']?>" /></td>
		</tr>	
		<?php endif; ?>
		
		<?php if (in_array($custom_field->type, array('Multiline Textbox'))) : ?>
		<tr valign="top">
			<th scope="row">Height:</th>
			<td><input type="text" name="custom-field-height" id="custom-field-height" size="2" value="<?=$custom_field->properties['height']?>" /></td>
		</tr>	
		<tr valign="top">
			<th scope="row">Width:</th>
			<td><input type="text" name="custom-field-width" id="custom-field-width" size="2" value="<?=$custom_field->properties['width']?>" /></td>
		</tr>	
		<?php endif; ?>
		
		<?php
		if ($custom_field->has_options == "true") :
			$options = implode("\n", (array)$custom_field->options)
		?>
		<tr valign="top">
			<th scope="row">Options:</th>
			<td>
				<textarea name="custom-field-options" id="custom-field-options" rows="2" cols="38"><?=$options?></textarea><br />
				<em>Separate each option with a newline.</em>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row">Default Value:</th>
			<td>
				<?php
				$default_value = implode("\n", (array)$custom_field->default_value);
				if ($custom_field->allow_multiple_values == "true") :
				?>
				<textarea name="custom-field-default-value" id="custom-field-default-value" rows="2" cols="38"><?=$default_value?></textarea><br />
				<em>Separate each value with a newline.</em>
				<?php
				else:
				?>
				<input type="text" name="custom-field-default-value" id="custom-field-default-value" size="25" value="<?=$default_value?>" />
				<?php
				endif;
				?>
			</td>
		</tr>
		<?php
		endif;
		?>
		
		<tr valign="top">
			<th scope="row">Type:</th>
			<td>
				<?php
				$field_types = RCCWP_CustomField::GetCustomFieldTypes();
				foreach ($field_types as $field) :
					$checked = 
						$field->name == $custom_field->type ?
						'checked="checked"' : '';
				?>
					<label><input name="custom-field-type" value="<?=$field->id?>" type="radio" <?=$checked?> />
					<?=$field->name?></label><br />
				<?php
				endforeach;
				?>
			</td>
		</tr>
		
		</tbody>
		</table>
		
		</fieldset>
	  	
  		<p class="submit" ><input name="cancel-edit-custom-field" type="submit" id="cancel-edit-custom-field" value="Cancel" /> <input name="submit-edit-custom-field" type="submit" id="submit-edit-custom-field" value="Update" /></p>
	  	
  		</form>
	  	
  		</div>
	  	
  		<?php
	}
}
?>