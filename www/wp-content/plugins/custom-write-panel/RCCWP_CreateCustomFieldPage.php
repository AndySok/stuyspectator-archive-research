<?php
include_once('RCCWP_CustomField.php');

class RCCWP_CreateCustomFieldPage
{
	function Main()
	{
		?>
  	
  		<div class="wrap">
	  	
  		<h2>Create Custom Field</h2>
	  	
  		<form action="" method="post" id="create-custom-field-form">
  		<input type="hidden" name="custom-write-panel-id" value="<?=$_GET['custom-write-panel-id']?>"
		<fieldset class="options">
		
		<table class="optiontable">
		<tbody>
		<tr valign="top">
			<th scope="row">Name:</th>
			<td><input name="custom-field-name" id="custom-field-name" size="40" type="text" /></td>
		</tr>
		<tr valign="top">
			<th scope="row">Description:</th>
			<td><textarea name="custom-field-description" id="custom-field-description" rows="2" cols="38"></textarea></td>
		</tr>
		<tr valign="top">
			<th scope="row">Order:</th>
			<td><input type="text" name="custom-field-order" id="custom-field-order" size="2" value="0" /></td>
		</tr>
		<tr valign="top">
			<th scope="row">Type:</th>
			<td>
				<?php
				$field_types = RCCWP_CustomField::GetCustomFieldTypes();
				foreach ($field_types as $field) :
					$checked = 
						$field->name == RCCWP_CustomField::GetDefaultCustomFieldType() ?
						'checked="checked"' : '';
				?>
					<label><input name="custom-field-type" value="<?=$field->id?>" type="radio" <?=$checked?>/>
					<?=$field->name?></label><br />
				<?php
				endforeach;
				?>
			</td>
		</tr>
		</tbody>
		</table>
		
		</fieldset>
	  	
  		<p class="submit" ><input name="cancel-create-custom-field" type="submit" id="cancel-create-custom-field" value="Cancel" /> <input name="continue-create-custom-field" type="submit" id="continue-create-custom-field" value="Continue" /></p>
	  	
  		</form>
	  	
  		</div>
	  	
  		<?php	
	}
	
	function SetOptions()
	{
		$current_field = RCCWP_CustomField::GetCustomFieldTypes($_POST['custom-field-type']);
		?>
		
		<div class="wrap">
		
		<h2>Create Custom Field</h2>
		
		<form action="" method="post" id="continue-create-new-field-form">
		
		<input type="hidden" name="custom-write-panel-id" value="<?=$_POST['custom-write-panel-id']?>" />
		<input type="hidden" name="custom-field-name" value="<?=$_POST['custom-field-name']?>" />
		<input type="hidden" name="custom-field-description" value="<?=$_POST['custom-field-description']?>" />
		<input type="hidden" name="custom-field-order" value="<?=$_POST['custom-field-order']?>" />
		<input type="hidden" name="custom-field-type" value="<?=$_POST['custom-field-type']?>" />
				
		<fieldset class="options">
		<legend><?=$current_field->name?></legend>
		
		<table class="optiontable">
		<tbody>
		
		<?php
		if ($current_field->has_properties == "true") :
		?>
		
		<?php 
		if (in_array($current_field->name, array('Textbox', 'Listbox'))) : 
			if ($current_field->name == 'Textbox')
				$size = 25;
			else if ($current_field->name == 'Listbox')
				$size = 3;
		?>
		<tr valign="top">
			<th scope="row">Size:</th>
			<td><input type="text" name="custom-field-size" id="custom-field-size" size="2" value="<?=$size?>" /></td>
		</tr>	
		<?php endif; ?>
		
		<?php 
		if (in_array($current_field->name, array('Multiline Textbox'))) : 
			$height = 3;
			$width = 23;
		?>
		<tr valign="top">
			<th scope="row">Height:</th>
			<td><input type="text" name="custom-field-height" id="custom-field-height" size="2" value="<?=$height?>" /></td>
		</tr>	
		<tr valign="top">
			<th scope="row">Width:</th>
			<td><input type="text" name="custom-field-width" id="custom-field-width" size="2" value="<?=$width?>" /></td>
		</tr>	
		<?php endif; ?>
		
		<?php
		endif; // has_properties
		?>
		
		<?php
		if ($current_field->has_options == "true") :
		?>		
		<tr valign="top">
			<th scope="row">Options:</th>
			<td>
				<textarea name="custom-field-options" id="custom-field-options" rows="2" cols="38"></textarea><br />
				<em>Separate each option with a newline.</em>
			</td>
		</tr>	
		<tr valign="top">
			<th scope="row">Default Value:</th>
			<td>
				<?php
				if ($current_field->allow_multiple_values == "true") :
				?>
				<textarea name="custom-field-default-value" id="custom-field-default-value" rows="2" cols="38"></textarea><br />
				<em>Separate each value with a newline.</em>
				<?php
				else :
				?>				
				<input type="text" name="custom-field-default-value" id="custom-field-default-value" size="25" />
				<?php
				endif;
				?>
			</td>
		</tr>
		<?php endif; ?>
		
		</tbody>
		</table>
		
		</fieldset>
		
			<p class="submit" ><input name="cancel-create-custom-field" type="submit" id="cancel-custom-new-field" value="Cancel" /> <input name="finish-create-custom-field" type="submit" id="finish-create-custom-field" value="Finish" /></p>
			
		</form>
		
		</div>
		
		<?php
	}
}
?>