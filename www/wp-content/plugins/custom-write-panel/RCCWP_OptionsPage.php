<?php
include_once('RCCWP_Options.php');

class RCCWP_OptionsPage
{

function Main()
{
	$customWritePanels = RCCWP_Application::GetCustomWritePanels();
	$customWritePanelOptions = RCCWP_Options::Get();
	?>
	
	<div class="wrap">

	<h2>Custom Write Panel Options</h2>
	
	<form action="" method="post" id="custom-write-panel-options-form">
	
	<p class="submit" ><input name="update-custom-write-panel-options" type="submit" value="Update Options" /></p>
	
	<ul> 
	<li> 
		<label for="hide-write-post"> 
		<input name="hide-write-post" id="hide-write-post" value="1" <?=RCCWP_OptionsPage::GetCheckboxState($customWritePanelOptions['hide-write-post'])?> type="checkbox"> 
		Hide WordPress' Write Post panel.</label> 
	</li> 
	<li> 
		<label for="hide-write-page"> 
		<input name="hide-write-page" id="hide-write-page" value="1" <?=RCCWP_OptionsPage::GetCheckboxState($customWritePanelOptions['hide-write-page'])?> type="checkbox"> 
		Hide WordPress' Write Page panel.</label> 
	</li> 
	<li> 
		<label for="prompt-editing-post"> 
		<input name="prompt-editing-post" id="prompt-editing-post" value="1" <?=RCCWP_OptionsPage::GetCheckboxState($customWritePanelOptions['prompt-editing-post'])?> type="checkbox"> 
		Prompt when editing a Post not created with Custom Write Panel.</label> 
	</li>
	<li> 
		<label for="assign-to-role"> 
		<input name="assign-to-role" id="assign-to-role" value="1" <?=RCCWP_OptionsPage::GetCheckboxState($customWritePanelOptions['assign-to-role'])?> type="checkbox"> 
		Assign custom write panels to a role. (Requires installing plugin "Role Manager" at http://www.im-web-gefunden.de/wordpress-plugins/role-manager/)</label> 
	</li>
	<li>
		<label for="default-custom-write-panel">Default Custom Write Panel
		<select name="default-custom-write-panel" id="default-custom-write-panel">
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
		</label>
	</li>
	<li>
		<label for="uninstall-custom-write-panel">
		Type <strong>uninstall</strong> into the textbox, click <strong>Update Options</strong>, and all the tables created by this plugin will be deleted
		<input type="text" id="uninstall-custom-write-panel" name="uninstall-custom-write-panel" size="25" />
		</label>
	</li>
	</ul>
	
	<p class="submit" ><input name="update-custom-write-panel-options" type="submit" value="Update Options" /></p>
	
	</form>

	</div>
	
	<?php
}

function GetCheckboxState($optionValue)
{
	if ($optionValue == '')
		return '';
	else 
		return 'checked="checked"';
}

}

?>