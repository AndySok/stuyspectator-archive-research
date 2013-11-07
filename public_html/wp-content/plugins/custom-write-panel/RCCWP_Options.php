<?php
class RCCWP_Options
{
	function Delete()
	{
		delete_option(RC_CWP_OPTION_KEY);
	}
	
	function Update($hideWritePost, $hideWritePage, $promptEditingPost, $assignToRole, $defaultCustomWritePanel)
	{
		$options['hide-write-post'] = $hideWritePost;
		$options['hide-write-page'] = $hideWritePage;
		$options['prompt-editing-post'] = $promptEditingPost;
		$options['assign-to-role'] = $assignToRole;
		$options['default-custom-write-panel'] = $defaultCustomWritePanel;
		
		$options = serialize($options);
		update_option(RC_CWP_OPTION_KEY, $options);
	}
	
	function Get($key = null)
	{
		$options = unserialize(get_option(RC_CWP_OPTION_KEY));
		
		if (!empty($key))
			return $options[$key];
		else
			return $options;
	}
}
?>