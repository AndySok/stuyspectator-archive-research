<?php
include_once('RCCWP_CustomWritePanelPage.php');
class RCCWP_CreateCustomWritePanelPage
{
	function Main()
	{
		?>

		<div class="wrap">

		<h2><?php _e('Create Custom Write Panel'); ?></h2>
		
		<form action="" method="post" id="create-new-write-panel-form">
		
		<?php RCCWP_CustomWritePanelPage::Content(); ?>
		
		<p class="submit" >
			<input name="cancel-create-custom-write-panel" type="submit" id="cancel-create-custom-write-panel" value="<?php _e('Cancel'); ?>" /> 
			<input name="finish-create-custom-write-panel" type="submit" id="finish-create-custom-write-panel" value="<?php _e('Finish'); ?>" />
		</p>
		
		</form>

		</div>

		<?php
	}
}
?>