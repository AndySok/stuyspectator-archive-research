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
|	- Configure Poll Options															|
|	- wp-content/plugins/polls/polls-options.php								|
|																							|
+----------------------------------------------------------------+
*/


### Check Whether User Can Manage Polls
if(!current_user_can('manage_polls')) {
	die('Access Denied');
}


### Variables Variables Variables
$base_name = plugin_basename('polls/polls-options.php');
$base_page = 'admin.php?page='.$base_name;
$id = intval($_GET['id']);


### If Form Is Submitted
if($_POST['Submit']) {
	$poll_bar_style = strip_tags(trim($_POST['poll_bar_style']));
	$poll_bar_background = strip_tags(trim($_POST['poll_bar_bg']));
	$poll_bar_border = strip_tags(trim($_POST['poll_bar_border']));
	$poll_bar_height = intval($_POST['poll_bar_height']);
	$poll_bar = array('style' => $poll_bar_style, 'background' => $poll_bar_background, 'border' => $poll_bar_border, 'height' => $poll_bar_height);
	$poll_ajax_style = array('loading' => intval($_POST['poll_ajax_style_loading']), 'fading' => intval($_POST['poll_ajax_style_fading']));
	$poll_ans_sortby = strip_tags(trim($_POST['poll_ans_sortby']));
	$poll_ans_sortorder = strip_tags(trim($_POST['poll_ans_sortorder']));
	$poll_ans_result_sortby = strip_tags(trim($_POST['poll_ans_result_sortby']));
	$poll_ans_result_sortorder = strip_tags(trim($_POST['poll_ans_result_sortorder']));
	$poll_archive_perpage = intval($_POST['poll_archive_perpage']);
	$poll_archive_displaypoll = intval($_POST['poll_archive_displaypoll']);
	$poll_archive_url = strip_tags(trim($_POST['poll_archive_url']));
	$poll_archive_show = intval($_POST['poll_archive_show']);
	$poll_currentpoll = intval($_POST['poll_currentpoll']);
	$poll_close = intval($_POST['poll_close']);
	$poll_logging_method = intval($_POST['poll_logging_method']);
	$poll_allowtovote = intval($_POST['poll_allowtovote']);
	$update_poll_queries = array();
	$update_poll_text = array();	
	$update_poll_queries[] = update_option('poll_bar', $poll_bar);
	$update_poll_queries[] = update_option('poll_ajax_style', $poll_ajax_style);
	$update_poll_queries[] = update_option('poll_ans_sortby', $poll_ans_sortby);
	$update_poll_queries[] = update_option('poll_ans_sortorder', $poll_ans_sortorder);
	$update_poll_queries[] = update_option('poll_ans_result_sortby', $poll_ans_result_sortby);
	$update_poll_queries[] = update_option('poll_ans_result_sortorder', $poll_ans_result_sortorder);
	$update_poll_queries[] = update_option('poll_archive_perpage', $poll_archive_perpage);
	$update_poll_queries[] = update_option('poll_archive_displaypoll', $poll_archive_displaypoll);
	$update_poll_queries[] = update_option('poll_archive_url', $poll_archive_url);
	$update_poll_queries[] = update_option('poll_archive_show', $poll_archive_show);
	$update_poll_queries[] = update_option('poll_currentpoll', $poll_currentpoll);
	$update_poll_queries[] = update_option('poll_close', $poll_close);
	$update_poll_queries[] = update_option('poll_logging_method', $poll_logging_method);
	$update_poll_queries[] = update_option('poll_allowtovote', $poll_allowtovote);
	$update_poll_text[] = __('Poll Bar Style', 'wp-polls');
	$update_poll_text[] = __('Poll AJAX Style', 'wp-polls');
	$update_poll_text[] = __('Sort Poll Answers By Option', 'wp-polls');
	$update_poll_text[] = __('Sort Order Of Poll Answers Option', 'wp-polls');
	$update_poll_text[] = __('Sort Poll Results By Option', 'wp-polls');
	$update_poll_text[] = __('Sort Order Of Poll Results Option', 'wp-polls');
	$update_poll_text[] = __('Number Of Polls Per Page To Display In Poll Archive Option', 'wp-polls');
	$update_poll_text[] = __('Type Of Polls To Display In Poll Archive Option', 'wp-polls');
	$update_poll_text[] = __('Poll Archive URL Option', 'wp-polls');
	$update_poll_text[] = __('Show Poll Achive Link Option', 'wp-polls');
	$update_poll_text[] = __('Current Active Poll Option', 'wp-polls');
	$update_poll_text[] = __('Poll Close Option', 'wp-polls');
	$update_poll_text[] = __('Logging Method', 'wp-polls');
	$update_poll_text[] = __('Allow To Vote Option', 'wp-polls');
	$i=0;
	$text = '';
	foreach($update_poll_queries as $update_poll_query) {
		if($update_poll_query) {
			$text .= '<font color="green">'.$update_poll_text[$i].' '.__('Updated', 'wp-polls').'</font><br />';
		}
		$i++;
	}
	if(empty($text)) {
		$text = '<font color="red">'.__('No Poll Option Updated', 'wp-polls').'</font>';
	}
	cron_polls_place();
}
?>
<script type="text/javascript">
/* <![CDATA[*/
	function set_pollbar_height(height) {
			document.getElementById('poll_bar_height').value = height;
	}
	function update_pollbar(where) {
		pollbar_background = '#' + document.getElementById('poll_bar_bg').value;
		pollbar_border = '#' + document.getElementById('poll_bar_border').value;
		pollbar_height = document.getElementById('poll_bar_height').value + 'px';
		if(where  == 'background') {
			document.getElementById('wp-polls-pollbar-bg').style.backgroundColor = pollbar_background;			
		} else if(where == 'border') {
			document.getElementById('wp-polls-pollbar-border').style.backgroundColor = pollbar_border;
		} else if(where == 'style') {
			pollbar_style_options = document.getElementById('poll_options_form').poll_bar_style;
			for(i = 0; i < pollbar_style_options.length; i++) {
				 if(pollbar_style_options[i].checked)  {
					pollbar_style = pollbar_style_options[i].value;
				 }
			}
			if(pollbar_style == 'use_css') {
				document.getElementById('wp-polls-pollbar').style.backgroundImage = "";
			} else {
				document.getElementById('wp-polls-pollbar').style.backgroundImage = "url('<?php echo get_option('siteurl'); ?>/wp-content/plugins/polls/images/" + pollbar_style + "/pollbg.gif')";
			}
		}
		document.getElementById('wp-polls-pollbar').style.backgroundColor = pollbar_background;
		document.getElementById('wp-polls-pollbar').style.border = '1px solid ' + pollbar_border;
		document.getElementById('wp-polls-pollbar').style.height = pollbar_height;
	}	
/* ]]> */
</script>
<?php if(!empty($text)) { echo '<!-- Last Action --><div id="message" class="updated fade"><p>'.$text.'</p></div>'; } ?>
<form id="poll_options_form" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>"> 
<div class="wrap"> 
	<h2><?php _e('Poll Options', 'wp-polls'); ?></h2> 
		<fieldset class="options">
			<legend><?php _e('Poll Bar Style', 'wp-polls'); ?></legend>
			<table width="100%"  border="0" cellspacing="3" cellpadding="3">
				 <tr valign="top">
					<th align="left" width="20%"><?php _e('Poll Bar Style', 'wp-polls'); ?></th>
					<td align="left" colspan="2">
						<?php
							$pollbar = get_option('poll_bar');
							$pollbar_url = get_option('siteurl').'/wp-content/plugins/polls/images';
							$pollbar_path = ABSPATH.'/wp-content/plugins/polls/images';
							if($handle = @opendir($pollbar_path)) {     
								while (false !== ($filename = readdir($handle))) {  
									if ($filename != '.' && $filename != '..') {
										if(is_dir($pollbar_path.'/'.$filename)) {
											$pollbar_info = getimagesize($pollbar_path.'/'.$filename.'/pollbg.gif');
											if($pollbar['style'] == $filename) {
												echo '<input type="radio" name="poll_bar_style" value="'.$filename.'" checked="checked" onblur="set_pollbar_height('.$pollbar_info[1].'); update_pollbar(\'style\');" />';										
											} else {
												echo '<input type="radio" name="poll_bar_style" value="'.$filename.'" onblur="set_pollbar_height('.$pollbar_info[1].'); update_pollbar(\'style\');" />';
											}
											echo '&nbsp;&nbsp;&nbsp;';
											echo '<img src="'.$pollbar_url.'/'.$filename.'/pollbg.gif" height="'.$pollbar_info[1].'" width="100" alt="pollbg.gif" />';
											echo '&nbsp;&nbsp;&nbsp;('.$filename.')';
											echo '<br /><br />'."\n";
										}
									} 
								} 
								closedir($handle);
							}
						?>
						<input type="radio" name="poll_bar_style" value="use_css"<?php checked('use_css', $pollbar['style']); ?> onblur="update_pollbar('style');" /> <?php _e('Use CSS Style', 'wp-polls'); ?>
					</td>
				</tr>
				<tr valign="top">
					<th align="left" width="20%"><?php _e('Poll Bar Background', 'wp-polls'); ?></th>
					<td align="left" width="10%">#<input type="text" id="poll_bar_bg" name="poll_bar_bg" value="<?php echo $pollbar['background']; ?>" size="6" maxlength="6" onblur="update_pollbar('background');" /></td>
					<td align="left"><div id="wp-polls-pollbar-bg" style="background-color: #<?php echo $pollbar['background']; ?>;"></div></td>
				</tr>
				<tr valign="top">
					<th align="left" width="20%"><?php _e('Poll Bar Border', 'wp-polls'); ?></th>
					<td align="left" width="10%">#<input type="text" id="poll_bar_border" name="poll_bar_border" value="<?php echo $pollbar['border']; ?>" size="6" maxlength="6" onblur="update_pollbar('border');" /></td>
					<td align="left"><div id="wp-polls-pollbar-border" style="background-color: #<?php echo $pollbar['border']; ?>;"></div></td>
				</tr>
				<tr valign="top">
					<th align="left" width="20%"><?php _e('Poll Bar Height', 'wp-polls'); ?></th>
					<td align="left" colspan="2"><input type="text" id="poll_bar_height" name="poll_bar_height" value="<?php echo $pollbar['height']; ?>" size="2" maxlength="2" onblur="update_pollbar('height');" />px</td>
				</tr>
				<tr valign="top">
					<th align="left" width="20%"><?php _e('Your poll bar will look like this', 'wp-polls'); ?></th>
					<td align="left" >
						<?php
							if($pollbar['style'] == 'use_css') {
								echo '<div id="wp-polls-pollbar" style="width: 100px; height: '.$pollbar['height'].'px; background-color: #'.$pollbar['background'].'; border: 1px solid #'.$pollbar['border'].'"></div>'."\n";
							} else {
								echo '<div id="wp-polls-pollbar" style="width: 100px; height: '.$pollbar['height'].'px; background-color: #'.$pollbar['background'].'; border: 1px solid #'.$pollbar['border'].'; background-image: url(\''.get_option('siteurl').'/wp-content/plugins/polls/images/'.$pollbar['style'].'/pollbg.gif\');"></div>'."\n";
							}
						?>
					</td>
				</tr>
			</table>
		</fieldset>
		<?php $poll_ajax_style = get_option('poll_ajax_style'); ?>
		<fieldset class="options">
			<legend><?php _e('Polls AJAX Style', 'wp-polls'); ?></legend>
			<table width="100%"  border="0" cellspacing="3" cellpadding="3">
				 <tr valign="top">
					<th align="left" width="30%"><?php _e('Show Loading Image With Text', 'wp-polls'); ?></th>
					<td align="left">
						<select name="poll_ajax_style_loading" size="1">
							<option value="0"<?php selected('0', $poll_ajax_style['loading']); ?>><?php _e('No', 'wp-polls'); ?></option>
							<option value="1"<?php selected('1', $poll_ajax_style['loading']); ?>><?php _e('Yes', 'wp-polls'); ?></option>
						</select>
					</td>
				</tr>
				<tr valign="top"> 
					<th align="left" width="30%"><?php _e('Show Fading In And Fading Out Of Poll', 'wp-polls'); ?></th>
					<td align="left">
						<select name="poll_ajax_style_fading" size="1">
							<option value="0"<?php selected('0', $poll_ajax_style['fading']); ?>><?php _e('No', 'wp-polls'); ?></option>
							<option value="1"<?php selected('1', $poll_ajax_style['fading']); ?>><?php _e('Yes', 'wp-polls'); ?></option>
						</select>
					</td> 
				</tr>
			</table>
		</fieldset>
		<fieldset class="options">
			<legend><?php _e('Sorting Of Poll Answers', 'wp-polls'); ?></legend>
			<table width="100%"  border="0" cellspacing="3" cellpadding="3">
				 <tr valign="top">
					<th align="left" width="30%"><?php _e('Sort Poll Answers By:', 'wp-polls'); ?></th>
					<td align="left">
						<select name="poll_ans_sortby" size="1">
							<option value="polla_aid"<?php selected('polla_aid', get_option('poll_ans_sortby')); ?>><?php _e('Exact Order', 'wp-polls'); ?></option>
							<option value="polla_answers"<?php selected('polla_answers', get_option('poll_ans_sortby')); ?>><?php _e('Alphabetical Order', 'wp-polls'); ?></option>
							<option value="RAND()"<?php selected('RAND()', get_option('poll_ans_sortby')); ?>><?php _e('Random Order', 'wp-polls'); ?></option>
						</select>
					</td>
				</tr>
				<tr valign="top"> 
					<th align="left" width="30%"><?php _e('Sort Order Of Poll Answers:', 'wp-polls'); ?></th>
					<td align="left">
						<select name="poll_ans_sortorder" size="1">
							<option value="asc"<?php selected('asc', get_option('poll_ans_sortorder')); ?>><?php _e('Ascending', 'wp-polls'); ?></option>
							<option value="desc"<?php selected('desc', get_option('poll_ans_sortorder')); ?>><?php _e('Descending', 'wp-polls'); ?></option>
						</select>
					</td> 
				</tr>
			</table>
		</fieldset>
		<fieldset class="options">
			<legend><?php _e('Sorting Of Poll Results', 'wp-polls'); ?></legend>
			<table width="100%"  border="0" cellspacing="3" cellpadding="3">
				 <tr valign="top">
					<th align="left" width="30%"><?php _e('Sort Poll Results By:', 'wp-polls'); ?></th>
					<td align="left">
						<select name="poll_ans_result_sortby" size="1">
							<option value="polla_votes"<?php selected('polla_votes', get_option('poll_ans_result_sortby')); ?>><?php _e('Votes', 'wp-polls'); ?></option>
							<option value="polla_aid"<?php selected('polla_aid', get_option('poll_ans_result_sortby')); ?>><?php _e('Exact Order', 'wp-polls'); ?></option>
							<option value="polla_answers"<?php selected('polla_answers', get_option('poll_ans_result_sortby')); ?>><?php _e('Alphabetical Order', 'wp-polls'); ?></option>
							<option value="RAND()"<?php selected('RAND()', get_option('poll_ans_result_sortby')); ?>><?php _e('Random Order', 'wp-polls'); ?></option>
						</select>
					</td>
				</tr>
				<tr valign="top"> 
					<th align="left" width="30%"><?php _e('Sort Order Of Poll Results:', 'wp-polls'); ?></th>
					<td align="left">
						<select name="poll_ans_result_sortorder" size="1">
							<option value="asc"<?php selected('asc', get_option('poll_ans_result_sortorder')); ?>><?php _e('Ascending', 'wp-polls'); ?></option>
							<option value="desc"<?php selected('desc', get_option('poll_ans_result_sortorder')); ?>><?php _e('Descending', 'wp-polls'); ?></option>
						</select>
					</td> 
				</tr>
			</table>
		</fieldset>
		<fieldset class="options">
			<legend><?php _e('Allow To Vote', 'wp-polls'); ?></legend>
			<table width="100%"  border="0" cellspacing="3" cellpadding="3">
				 <tr valign="top">
					<th align="left" width="30%"><?php _e('Who Is Allowed To Vote?', 'wp-polls'); ?></th>
					<td align="left">
						<select name="poll_allowtovote" size="1">
							<option value="0"<?php selected('0', get_option('poll_allowtovote')); ?>><?php _e('Guests Only', 'wp-polls'); ?></option>
							<option value="1"<?php selected('1', get_option('poll_allowtovote')); ?>><?php _e('Registered Users Only', 'wp-polls'); ?></option>
							<option value="2"<?php selected('2', get_option('poll_allowtovote')); ?>><?php _e('Registered Users And Guests', 'wp-polls'); ?></option>
						</select>
					</td>
				</tr>
			</table>
		</fieldset>
		<fieldset class="options">
			<legend><?php _e('Logging Method', 'wp-polls'); ?></legend>
			<table width="100%"  border="0" cellspacing="3" cellpadding="3">
				 <tr valign="top">
					<th align="left" width="30%"><?php _e('Poll Logging Method:', 'wp-polls'); ?></th>
					<td align="left">
						<select name="poll_logging_method" size="1">
							<option value="0"<?php selected('0', get_option('poll_logging_method')); ?>><?php _e('Do Not Log', 'wp-polls'); ?></option>
							<option value="1"<?php selected('1', get_option('poll_logging_method')); ?>><?php _e('Logged By Cookie', 'wp-polls'); ?></option>
							<option value="2"<?php selected('2', get_option('poll_logging_method')); ?>><?php _e('Logged By IP', 'wp-polls'); ?></option>
							<option value="3"<?php selected('3', get_option('poll_logging_method')); ?>><?php _e('Logged By Cookie And IP', 'wp-polls'); ?></option>
							<option value="4"<?php selected('4', get_option('poll_logging_method')); ?>><?php _e('Logged By Username', 'wp-polls'); ?></option>
						</select>
					</td>
				</tr>
			</table>
		</fieldset>
		<fieldset class="options">
			<legend><?php _e('Poll Archive', 'wp-polls'); ?></legend>
			<table width="100%"  border="0" cellspacing="3" cellpadding="3">
				 <tr valign="top">
					<th align="left" width="30%"><?php _e('Number Of Polls Per Page:', 'wp-polls'); ?></th>
					<td align="left"><input type="text" name="poll_archive_perpage" value="<?php echo intval(get_option('poll_archive_perpage')); ?>" size="2" /></td>
				</tr>
				<tr valign="top">
					<th align="left" width="30%"><?php _e('Type Of Polls To Display In Poll Archive:', 'wp-polls'); ?></th>
					<td align="left">
						<select name="poll_archive_displaypoll" size="1">
							<option value="1"<?php selected('1', get_option('poll_archive_displaypoll')); ?>><?php _e('Closed Polls Only', 'wp-polls'); ?></option>
							<option value="2"<?php selected('2', get_option('poll_archive_displaypoll')); ?>><?php _e('Opened Polls Only', 'wp-polls'); ?></option>
							<option value="3"<?php selected('3', get_option('poll_archive_displaypoll')); ?>><?php _e('Closed And Opened Polls', 'wp-polls'); ?></option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<th align="left" width="30%"><?php _e('Poll Archive URL:', 'wp-polls'); ?></th>
					<td align="left"><input type="text" name="poll_archive_url" value="<?php echo get_option('poll_archive_url'); ?>" size="50" /></td>
				</tr>
				<tr valign="top">
					<th align="left" width="30%"><?php _e('Display Poll Archive Link Below Poll?', 'wp-polls'); ?></th>
					<td align="left">
						<select name="poll_archive_show" size="1">
							<option value="0"<?php selected('0', get_option('poll_archive_show')); ?>><?php _e('No', 'wp-polls'); ?></option>
							<option value="1"<?php selected('1', get_option('poll_archive_show')); ?>><?php _e('Yes', 'wp-polls'); ?></option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<th align="left" colspan="2"><em><?php _e('Note: Only polls\' results will be shown in the Poll Archive regardless of whether the poll is closed or opened.', 'wp-polls'); ?></em></th>
				</tr>
			</table>
		</fieldset>
		<fieldset class="options">
			<legend><?php _e('Current Active Poll', 'wp-polls'); ?></legend>
			<table width="100%"  border="0" cellspacing="3" cellpadding="3">
				 <tr valign="top">
					<th align="left" width="30%"><?php _e('Current Active Poll', 'wp-polls'); ?>:</th>
					<td align="left">
						<select name="poll_currentpoll" size="1">
							<option value="-1"<?php selected(-1, get_option('poll_currentpoll')); ?>><?php _e('Do NOT Display Poll (Disable)', 'wp-polls'); ?></option>
							<option value="-2"<?php selected(-2, get_option('poll_currentpoll')); ?>><?php _e('Display Random Poll', 'wp-polls'); ?></option>
							<option value="0"<?php selected(0, get_option('poll_currentpoll')); ?>><?php _e('Display Latest Poll', 'wp-polls'); ?></option>
							<?php if(function_exists('dynamic_sidebar')) { ?>
							<option value="-3"<?php selected(-3, get_option('poll_currentpoll')); ?>><?php _e('Display Multiple Polls', 'wp-polls'); ?></option>
							<?php } ?>
							<option value="0">&nbsp;</option>
							<?php
								$polls = $wpdb->get_results("SELECT pollq_id, pollq_question FROM $wpdb->pollsq ORDER BY pollq_id DESC");
								if($polls) {
									foreach($polls as $poll) {
										$poll_question = stripslashes($poll->pollq_question);
										$poll_id = intval($poll->pollq_id);
										if($poll_id == intval(get_option('poll_currentpoll'))) {
											echo "<option value=\"$poll_id\" selected=\"selected\">$poll_question</option>\n";
										} else {
											echo "<option value=\"$poll_id\">$poll_question</option>\n";
										}
									}
								}
							?>
						</select>
					</td>
				</tr>
				<?php if(function_exists('dynamic_sidebar')) { ?>
				<tr valign="top">
					<th align="left" colspan="2"><em><?php _e('Note: If you chose \'Display Multiple Polls\' for the above option, you need to configure it in Presentation -> Widgets -> Poll.', 'wp-polls'); ?></em></th>
				</tr>
				<?php } ?>
				 <tr valign="top">
					<th align="left" width="30%"><?php _e('When Poll Is Closed', 'wp-polls'); ?>:</th>
					<td align="left">
						<select name="poll_close" size="1">
							<option value="1"<?php selected(1, get_option('poll_close')); ?>><?php _e('Display Poll\'s Results', 'wp-polls'); ?></option>
							<option value="2"<?php selected(2, get_option('poll_close')); ?>><?php _e('Do Not Display Poll In Post/Sidebar', 'wp-polls'); ?></option>
						</select>
					</td>
				</tr>
			</table>
		</fieldset>
		<div align="center">
			<input type="submit" name="Submit" class="button" value="<?php _e('Update Options', 'wp-polls'); ?>" />&nbsp;&nbsp;<input type="button" name="cancel" value="<?php _e('Cancel', 'wp-polls'); ?>" class="button" onclick="javascript:history.go(-1)" /> 
		</div>
</div> 
</form> 