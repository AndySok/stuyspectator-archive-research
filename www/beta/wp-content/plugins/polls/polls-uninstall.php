<?php
/*
+----------------------------------------------------------------+
|																							|
|	WordPress 2.1 Plugin: WP-Polls 2.21										|
|	Copyright (c) 2007 Lester "GaMerZ" Chan									|
|																							|
|	File Written By:																	|
|	- Lester "GaMerZ" Chan															|
|	- http://lesterchan.net															|
|																							|
|	File Information:																	|
|	- Uninstall WP-Polls																|
|	- wp-content/plugins/polls/polls-uninstall.php							|
|																							|
+----------------------------------------------------------------+
*/


### Check Whether User Can Manage Polls
if(!current_user_can('manage_polls')) {
	die('Access Denied');
}


### Variables Variables Variables
$base_name = plugin_basename('polls/polls-manager.php');
$base_page = 'admin.php?page='.$base_name;
$mode = trim($_GET['mode']);
$polls_tables = array($wpdb->pollsq, $wpdb->pollsa, $wpdb->pollsip);
$polls_settings = array('poll_template_voteheader', 'poll_template_votebody', 'poll_template_votefooter', 'poll_template_resultheader', 'poll_template_resultbody', 'poll_template_resultbody2', 'poll_template_resultfooter', 'poll_template_resultfooter2',  'poll_template_disable', 'poll_template_error', 'poll_currentpoll', 'poll_latestpoll', 'poll_archive_perpage', 'poll_ans_sortby', 'poll_ans_sortorder', 'poll_ans_result_sortby', 'poll_ans_result_sortorder', 'poll_logging_method', 'poll_allowtovote', 'poll_archive_show', 'poll_archive_url', 'poll_bar', 'poll_close', 'poll_ajax_style', 'poll_template_pollarchivelink', 'widget_polls', 'poll_archive_displaypoll', 'poll_template_pollarchiveheader', 'poll_template_pollarchivefooter');


### Form Processing 
if(!empty($_POST['do'])) {
	// Decide What To Do
	switch($_POST['do']) {
		//  Uninstall WP-Polls (By: Philippe Corbes)
		case __('UNINSTALL WP-Polls', 'wp-polls') :
			if(trim($_POST['uninstall_poll_yes']) == 'yes') {
				echo '<div id="message" class="updated fade">';
				echo '<p>';
				foreach($polls_tables as $table) {
					$wpdb->query("DROP TABLE {$table}");
					echo '<font style="color: green;">';
					printf(__('Table \'%s\' has been deleted.', 'wp-polls'), "<strong><em>{$table}</em></strong>");
					echo '</font><br />';
				}
				echo '</p>';
				echo '<p>';
				foreach($polls_settings as $setting) {
					$delete_setting = delete_option($setting);
					if($delete_setting) {
						echo '<font color="green">';
						printf(__('Setting Key \'%s\' has been deleted.', 'wp-polls'), "<strong><em>{$setting}</em></strong>");
						echo '</font><br />';
					} else {
						echo '<font color="red">';
						printf(__('Error deleting Setting Key \'%s\'.', 'wp-polls'), "<strong><em>{$setting}</em></strong>");
						echo '</font><br />';
					}
				}
				echo '</p>';
				echo '</div>'; 
				$mode = 'end-UNINSTALL';
			}
			break;
	}
}


### Determines Which Mode It Is
switch($mode) {
		//  Deactivating WP-Polls (By: Philippe Corbes)
		case 'end-UNINSTALL':
			$deactivate_url = 'plugins.php?action=deactivate&amp;plugin=polls/polls.php';
			if(function_exists('wp_nonce_url')) { 
				$deactivate_url = wp_nonce_url($deactivate_url, 'deactivate-plugin_polls/polls.php');
			}
			echo '<div class="wrap">';
			echo '<h2>'.__('Uninstall WP-Polls', 'wp-polls').'</h2>';
			echo '<p><strong>'.sprintf(__('<a href="%s">Click Here</a> To Finish The Uninstallation And WP-Polls Will Be Deactivated Automatically.', 'wp-polls'), $deactivate_url).'</strong></p>';
			echo '</div>';
			break;
	// Main Page
	default:
?>
<!-- Uninstall WP-Polls (By: Philippe Corbes) -->
<form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>" method="post">
<div class="wrap">
	<h2><?php _e('Uninstall WP-Polls', 'wp-polls'); ?></h2>
	<p style="text-align: left;">
		<?php _e('Deactivating WP-Polls plugin does not remove any data that may have been created, such as the poll data and the poll\'s voting logs. To completely remove this plugin, you can uninstall it here.', 'wp-polls'); ?>
	</p>
	<p style="text-align: left; color: red">
		<strong><?php _e('WARNING:', 'wp-polls'); ?></strong><br />
		<?php _e('Once uninstalled, this cannot be undone. You should use a Database Backup plugin of WordPress to back up all the data first.', 'wp-polls'); ?>
	</p>
	<p style="text-align: left; color: red">
		<strong><?php _e('The following WordPress Options/Tables will be DELETED:', 'wp-polls'); ?></strong><br />
	</p>
	<table width="50%"  border="0" cellspacing="3" cellpadding="3">
		<tr class="thead">
			<td align="center"><strong><?php _e('WordPress Options', 'wp-polls'); ?></strong></td>
			<td align="center"><strong><?php _e('WordPress Tables', 'wp-polls'); ?></strong></td>
		</tr>
		<tr>
			<td valign="top" style="background-color: #eee;">
				<ol>
				<?php
					foreach($polls_settings as $settings) {
						echo '<li>'.$settings.'</li>'."\n";
					}
				?>
				</ol>
			</td>
			<td valign="top" style="background-color: #eee;">
				<ol>
				<?php
					foreach($polls_tables as $tables) {
						echo '<li>'.$tables.'</li>'."\n";
					}
				?>
				</ol>
			</td>
		</tr>
	</table>
	<p>&nbsp;</p>
	<p style="text-align: center;">
		<input type="checkbox" name="uninstall_poll_yes" value="yes" />&nbsp;<?php _e('Yes', 'wp-polls'); ?><br /><br />
		<input type="submit" name="do" value="<?php _e('UNINSTALL WP-Polls', 'wp-polls'); ?>" class="button" onclick="return confirm('<?php _e('You Are About To Uninstall WP-Polls From WordPress.\nThis Action Is Not Reversible.\n\n Choose [Cancel] To Stop, [OK] To Uninstall.', 'wp-polls'); ?>')" />
	</p>
</div>
</form>
<?php
} // End switch($mode)
?>