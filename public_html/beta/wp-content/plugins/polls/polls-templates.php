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
|	- Configure Poll Templates														|
|	- wp-content/plugins/polls/polls-templates.php							|
|																							|
+----------------------------------------------------------------+
*/


### Check Whether User Can Manage Polls
if(!current_user_can('manage_polls')) {
	die('Access Denied');
}


### Variables Variables Variables
$base_name = plugin_basename('polls/polls-templates.php');
$base_page = 'admin.php?page='.$base_name;
$id = intval($_GET['id']);


### If Form Is Submitted
if($_POST['Submit']) {	
	$poll_template_voteheader =trim($_POST['poll_template_voteheader']);
	$poll_template_votebody = trim($_POST['poll_template_votebody']);
	$poll_template_votefooter = trim($_POST['poll_template_votefooter']);
	$poll_template_resultheader = trim($_POST['poll_template_resultheader']);
	$poll_template_resultbody = trim($_POST['poll_template_resultbody']);
	$poll_template_resultbody2 = trim($_POST['poll_template_resultbody2']);
	$poll_template_resultfooter = trim($_POST['poll_template_resultfooter']);
	$poll_template_resultfooter2 = trim($_POST['poll_template_resultfooter2']);
	$poll_template_pollarchivelink = trim($_POST['poll_template_pollarchivelink']);
	$poll_template_pollarchiveheader = trim($_POST['poll_template_pollarchiveheader']);
	$poll_template_pollarchivefooter = trim($_POST['poll_template_pollarchivefooter']);
	$poll_template_disable = trim($_POST['poll_template_disable']);
	$poll_template_error = trim($_POST['poll_template_error']);
	$update_poll_queries = array();
	$update_poll_text = array();	
	$update_poll_queries[] = update_option('poll_template_voteheader', $poll_template_voteheader);
	$update_poll_queries[] = update_option('poll_template_votebody', $poll_template_votebody);
	$update_poll_queries[] = update_option('poll_template_votefooter', $poll_template_votefooter);
	$update_poll_queries[] = update_option('poll_template_resultheader', $poll_template_resultheader);
	$update_poll_queries[] = update_option('poll_template_resultbody', $poll_template_resultbody);
	$update_poll_queries[] = update_option('poll_template_resultbody2', $poll_template_resultbody2);
	$update_poll_queries[] = update_option('poll_template_resultfooter', $poll_template_resultfooter);
	$update_poll_queries[] = update_option('poll_template_resultfooter2', $poll_template_resultfooter2);
	$update_poll_queries[] = update_option('poll_template_pollarchivelink', $poll_template_pollarchivelink);
	$update_poll_queries[] = update_option('poll_template_pollarchiveheader', $poll_template_pollarchiveheader);
	$update_poll_queries[] = update_option('poll_template_pollarchivefooter', $poll_template_pollarchivefooter);
	$update_poll_queries[] = update_option('poll_template_disable', $poll_template_disable);
	$update_poll_queries[] = update_option('poll_template_error', $poll_template_error);
	$update_poll_text[] = __('Voting Form Header Template', 'wp-polls');
	$update_poll_text[] = __('Voting Form Body Template', 'wp-polls');
	$update_poll_text[] = __('Voting Form Footer Template', 'wp-polls');
	$update_poll_text[] = __('Result Header Template', 'wp-polls');
	$update_poll_text[] = __('Result Body Template', 'wp-polls');
	$update_poll_text[] = __('Result Body2 Template', 'wp-polls');
	$update_poll_text[] = __('Result Footer Template', 'wp-polls');
	$update_poll_text[] = __('Result Footer2 Template', 'wp-polls');
	$update_poll_text[] = __('Poll Archive Link Template', 'wp-polls');
	$update_poll_text[] = __('Poll Archive Poll Header Template', 'wp-polls');
	$update_poll_text[] = __('Poll Archive Poll Footer Template', 'wp-polls');
	$update_poll_text[] = __('Poll Disabled Template', 'wp-polls');
	$update_poll_text[] = __('Poll Error Template', 'wp-polls');
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
	wp_clear_scheduled_hook('polls_cron');
	if (!wp_next_scheduled('polls_cron')) {
		wp_schedule_event(time(), 'daily', 'polls_cron');
	}
}
?>
<script type="text/javascript">
/* <![CDATA[*/
	function poll_default_templates(template) {
		var default_template;
		switch(template) {
			case "voteheader":
				default_template = "<p style=\"text-align: center;\"><strong>%POLL_QUESTION%</strong></p>\n<div id=\"polls-%POLL_ID%-ans\" class=\"wp-polls-ans\">\n<ul class=\"wp-polls-ul\">";
				break;
			case "votebody":
				default_template = "<li><input type=\"%POLL_CHECKBOX_RADIO%\" id=\"poll-answer-%POLL_ANSWER_ID%\" name=\"poll_%POLL_ID%\" value=\"%POLL_ANSWER_ID%\" /> <label for=\"poll-answer-%POLL_ANSWER_ID%\">%POLL_ANSWER%</label></li>";
				break;
			case "votefooter":
				default_template = "</ul>\n<p style=\"text-align: center;\"><input type=\"button\" name=\"vote\" value=\"   <?php _e('Vote', 'wp-polls'); ?>   \" class=\"Buttons\" onclick=\"poll_vote(%POLL_ID%);\" /></p>\n<p style=\"text-align: center;\"><a href=\"#ViewPollResults\" onclick=\"poll_result(%POLL_ID%); return false;\" title=\"<?php _e('View Results Of This Poll', 'wp-polls'); ?>\"><?php _e('View Results', 'wp-polls'); ?></a></p>\n</div>";
				break;
			case "resultheader":
				default_template = "<p style=\"text-align: center;\"><strong>%POLL_QUESTION%</strong></p>\n<div id=\"polls-%POLL_ID%-ans\" class=\"wp-polls-ans\">\n<ul class=\"wp-polls-ul\">";
				break;
			case "resultbody":
				default_template = "<li>%POLL_ANSWER% <small>(%POLL_ANSWER_PERCENTAGE%%, %POLL_ANSWER_VOTES% <?php _e('Votes', 'wp-polls'); ?>)</small><div class=\"pollbar\" style=\"width: %POLL_ANSWER_IMAGEWIDTH%%;\" title=\"%POLL_ANSWER_TEXT% (%POLL_ANSWER_PERCENTAGE%% | %POLL_ANSWER_VOTES% <?php _e('Votes', 'wp-polls'); ?>)\"></div></li>";
				break;
			case "resultbody2":
				default_template = "<li><strong><i>%POLL_ANSWER% <small>(%POLL_ANSWER_PERCENTAGE%%, %POLL_ANSWER_VOTES% <?php _e('Votes', 'wp-polls'); ?>)</small></i></strong><div class=\"pollbar\" style=\"width: %POLL_ANSWER_IMAGEWIDTH%%;\" title=\"<?php _e('You Have Voted For This Choice', 'wp-polls'); ?> - %POLL_ANSWER_TEXT% (%POLL_ANSWER_PERCENTAGE%% | %POLL_ANSWER_VOTES% <?php _e('Votes', 'wp-polls'); ?>)\"></div></li>";
				break;
			case "resultfooter":
				default_template = "</ul>\n<p style=\"text-align: center;\"><?php _e('Total Voters', 'wp-polls'); ?>: <strong>%POLL_TOTALVOTERS%</strong></p>\n</div>";
				break;
			case "resultfooter2":
				default_template = "</ul>\n<p style=\"text-align: center;\"><?php _e('Total Voters', 'wp-polls'); ?>: <strong>%POLL_TOTALVOTERS%</strong></p>\n<p style=\"text-align: center;\"><a href=\"#VotePoll\" onclick=\"poll_booth(%POLL_ID%); return false;\" title=\"<?php _e('Vote For This Poll', 'wp-polls'); ?>\"><?php _e('Vote', 'wp-polls'); ?></a></p>\n</div>";
				break;
			case "pollarchivelink":
				default_template = "<ul>\n<li><a href=\"%POLL_ARCHIVE_URL%\"><?php _e('Polls Archive', 'wp-polls'); ?></a></li>\n</ul>";
				break;
			case "pollarchiveheader":
				default_template = "";
				break;
			case "pollarchivefooter":
				default_template = "<p><?php _e('Start Date:', 'wp-polls'); ?> %POLL_START_DATE%<br /><?php _e('End Date:', 'wp-polls'); ?> %POLL_END_DATE%</p>";
				break;
			case "disable":
				default_template = "<?php _e('Sorry, there are no polls available at the moment.', 'wp-polls'); ?>";
				break;
			case "error":
				default_template = "<?php _e('An error has occurred when processing your poll.', 'wp-polls'); ?>";
				break;
		}
		document.getElementById("poll_template_" + template).value = default_template;
	}
/* ]]> */
</script>
<?php if(!empty($text)) { echo '<!-- Last Action --><div id="message" class="updated fade"><p>'.$text.'</p></div>'; } ?>
<form id="poll_options_form" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>"> 
<div class="wrap"> 
	<h2><?php _e('Poll Templates', 'wp-polls'); ?></h2> 
		<fieldset class="options">
			<legend><?php _e('Template Variables', 'wp-polls'); ?></legend>
			<table width="100%"  border="0" cellspacing="0" cellpadding="5">
				<tr>
					<td>
						<strong>%POLL_ID%</strong><br />
						<?php _e('Display the poll\'s ID', 'wp-polls'); ?>
					</td>
					<td>
						<strong>%POLL_ANSWER_ID%</strong><br />
						<?php _e('Display the poll\'s answer ID', 'wp-polls'); ?>
					</td>
				</tr>
				<tr>
					<td>
						<strong>%POLL_QUESTION%</strong><br />
						<?php _e('Display the poll\'s question', 'wp-polls'); ?>
					</td>
					<td>
						<strong>%POLL_ANSWER%</strong><br />
						<?php _e('Display the poll\'s answer', 'wp-polls'); ?>
					</td>
				</tr>
				<tr>
					<td>
						<strong>%POLL_TOTALVOTES%</strong><br />
						<?php _e('Display the poll\'s total votes NOT the number of people who voted for the poll', 'wp-polls'); ?>
					</td>
					<td>
						<strong>%POLL_ANSWER_TEXT%</strong><br />
						<?php _e('Display the poll\'s answer without HTML formatting.', 'wp-polls'); ?>
					</td>
				</tr>
				<tr>
					<td>
						<strong>%POLL_RESULT_URL%</strong><br />
						<?php _e('Displays URL to poll\'s result', 'wp-polls'); ?>
					</td>
					<td>
						<strong>%POLL_ANSWER_VOTES%</strong><br />
						<?php _e('Display the poll\'s answer votes', 'wp-polls'); ?>
					</td>
				</tr>
				<tr>
					<td>
						<strong>%POLL_MOST_ANSWER%</strong><br />
						<?php _e('Display the poll\'s most voted answer', 'wp-polls'); ?>
					</td>
					<td>
						<strong>%POLL_ANSWER_PERCENTAGE%</strong><br />
						<?php _e('Display the poll\'s answer percentage', 'wp-polls'); ?>
					</td>
				</tr>
				<tr>
					<td>
						<strong>%POLL_MOST_VOTES%</strong><br />
						<?php _e('Display the poll\'s answer votes for the most voted answer', 'wp-polls'); ?>
					</td>
					<td>
						<strong>%POLL_ANSWER_IMAGEWIDTH%</strong><br />
						<?php _e('Display the poll\'s answer image width', 'wp-polls'); ?>
					</td>
				</tr>
				<tr>
					<td>
						<strong>%POLL_MOST_PERCENTAGE%</strong><br />
						<?php _e('Display the poll\'s answer percentage for the most voted answer', 'wp-polls'); ?>
					</td>
					<td>
						<strong>%POLL_LEAST_ANSWER%</strong><br />
						<?php _e('Display the poll\'s least voted answer', 'wp-polls'); ?>
					</td>
				</tr>
				<tr>
					<td>
						<strong>%POLL_START_DATE%</strong><br />
						<?php _e('Display the poll\'s start date/time', 'wp-polls'); ?>
					</td>
					<td>
						<strong>%POLL_LEAST_VOTES%</strong><br />
						<?php _e('Display the poll\'s answer votes for the least voted answer', 'wp-polls'); ?>
				</td>
				</tr>
				<tr>
					<td>
						<strong>%POLL_END_DATE%</strong><br />
						<?php _e('Display the poll\'s end date/time', 'wp-polls'); ?>
					</td>
					<td>
						<strong>%POLL_LEAST_PERCENTAGE%</strong><br />
						<?php _e('Display the poll\'s answer percentage for the least voted answer', 'wp-polls'); ?>
					</td>
				</tr>
				<tr>
					<td>
						<strong>%POLL_MULTIPLE_ANS_MAX%</strong><br />
						<?php _e('Display the the maximum number of answers the user can choose if the poll supports multiple answers', 'wp-polls'); ?>
					</td>
					<td>
						<strong>%POLL_CHECKBOX_RADIO%</strong><br />
						<?php _e('Display "checkbox" or "radio" input types depending on the poll type', 'wp-polls'); ?>
					</td>
				</tr>
				<tr>
					<td>
						<strong>%POLL_TOTALVOTERS%</strong><br />
						<?php _e('Display the number of people who voted for the poll NOT the total votes of the poll', 'wp-polls'); ?>
					</td>
					<td>
						<strong>%POLL_ARCHIVE_URL%</strong><br />
						<?php _e('Display the poll archive URL', 'wp-polls'); ?>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<strong><?php _e('Note:', 'wp-polls'); ?></strong><br />
						<?php _e('<strong>%POLL_TOTALVOTES%</strong> and <strong>%POLL_TOTALVOTERS%</strong> will be different if your poll supports multiple answers. If your poll allows only single answer, both value will be the same.', 'wp-polls'); ?>
					</td>
				</tr>
			</table>
		</fieldset>
		<fieldset class="options">
			<legend><?php _e('Poll Voting Form Templates', 'wp-polls'); ?></legend>
			<table width="100%"  border="0" cellspacing="3" cellpadding="3">
				 <tr valign="top">
					<td width="30%" align="left">
						<strong><?php _e('Voting Form Header:', 'wp-polls'); ?></strong><br /><br /><br />
						<?php _e('Allowed Variables:', 'wp-polls'); ?><br />
						- %POLL_ID%<br />
						- %POLL_QUESTION%<br />
						- %POLL_START_DATE%<br />
						- %POLL_END_DATE%<br />
						- %POLL_TOTALVOTES%<br />
						- %POLL_TOTALVOTERS%<br />
						- %POLL_MULTIPLE_ANS_MAX%<br /><br />
						<input type="button" name="RestoreDefault" value="<?php _e('Restore Default Template', 'wp-polls'); ?>" onclick="poll_default_templates('voteheader');" class="button" />
					</td>
					<td align="left"><textarea cols="80" rows="12" id="poll_template_voteheader" name="poll_template_voteheader"><?php echo htmlspecialchars(stripslashes(get_option('poll_template_voteheader'))); ?></textarea></td>
				</tr>
				<tr valign="top"> 
					<td width="30%" align="left">
						<strong><?php _e('Voting Form Body:', 'wp-polls'); ?></strong><br /><br /><br />
						<?php _e('Allowed Variables:', 'wp-polls'); ?><br />
						- %POLL_ID%<br />
						- %POLL_ANSWER_ID%<br />
						- %POLL_ANSWER%<br />
						- %POLL_ANSWER_VOTES%<br />
						- %POLL_CHECKBOX_RADIO%<br /><br />
						<input type="button" name="RestoreDefault" value="<?php _e('Restore Default Template', 'wp-polls'); ?>" onclick="poll_default_templates('votebody');" class="button" />
					</td>
					<td align="left"><textarea cols="80" rows="12" id="poll_template_votebody" name="poll_template_votebody"><?php echo htmlspecialchars(stripslashes(get_option('poll_template_votebody'))); ?></textarea></td> 
				</tr>
				<tr valign="top"> 
					<td width="30%" align="left">
						<strong><?php _e('Voting Form Footer:', 'wp-polls'); ?></strong><br /><br /><br />
							<?php _e('Allowed Variables:', 'wp-polls'); ?><br />
							- %POLL_ID%<br />
							- %POLL_RESULT_URL%<br />
							- %POLL_MULTIPLE_ANS_MAX%<br /><br />
						<input type="button" name="RestoreDefault" value="<?php _e('Restore Default Template', 'wp-polls'); ?>" onclick="poll_default_templates('votefooter');" class="button" />
					</td>
					<td align="left"><textarea cols="80" rows="12" id="poll_template_votefooter" name="poll_template_votefooter"><?php echo htmlspecialchars(stripslashes(get_option('poll_template_votefooter'))); ?></textarea></td> 
				</tr>
			</table>
		</fieldset>
		<fieldset class="options">
			<legend><?php _e('Poll Result Templates', 'wp-polls'); ?></legend>
			<table width="100%"  border="0" cellspacing="3" cellpadding="3"> 
				 <tr valign="top">
					<td width="30%" align="left">
						<strong><?php _e('Result Header:', 'wp-polls'); ?></strong><br /><br /><br />
						<?php _e('Allowed Variables:', 'wp-polls'); ?><br />
						- %POLL_ID%<br />
						- %POLL_QUESTION%<br />
						- %POLL_START_DATE%<br />
						- %POLL_END_DATE%<br />
						- %POLL_TOTALVOTES%<br />
						- %POLL_TOTALVOTERS%<br />
						- %POLL_MULTIPLE_ANS_MAX%<br /><br />
						<input type="button" name="RestoreDefault" value="<?php _e('Restore Default Template', 'wp-polls'); ?>" onclick="poll_default_templates('resultheader');" class="button" />
					</td>
					<td align="left"><textarea cols="80" rows="12" id="poll_template_resultheader" name="poll_template_resultheader"><?php echo htmlspecialchars(stripslashes(get_option('poll_template_resultheader'))); ?></textarea></td>
				</tr>
				<tr valign="top"> 
					<td width="30%" align="left">
						<strong><?php _e('Result Body:', 'wp-polls'); ?></strong><br /><?php _e('Displayed When The User HAS NOT Voted', 'wp-polls'); ?><br /><br />
						<?php _e('Allowed Variables:', 'wp-polls'); ?><br />
						- %POLL_ANSWER_ID%<br />
						- %POLL_ANSWER%<br />
						- %POLL_ANSWER_TEXT%<br />
						- %POLL_ANSWER_VOTES%<br />
						- %POLL_ANSWER_PERCENTAGE%<br />
						- %POLL_ANSWER_IMAGEWIDTH%<br /><br />
						<input type="button" name="RestoreDefault" value="<?php _e('Restore Default Template', 'wp-polls'); ?>" onclick="poll_default_templates('resultbody');" class="button" />
					</td>
					<td align="left"><textarea cols="80" rows="12" id="poll_template_resultbody" name="poll_template_resultbody"><?php echo htmlspecialchars(stripslashes(get_option('poll_template_resultbody'))); ?></textarea></td> 
				</tr>
				<tr valign="top"> 
					<td width="30%" align="left">
						<strong><?php _e('Result Body:', 'wp-polls'); ?></strong><br /><?php _e('Displayed When The User HAS Voted', 'wp-polls'); ?><br /><br />
						<?php _e('Allowed Variables:', 'wp-polls'); ?><br />
						- %POLL_ANSWER_ID%<br />
						- %POLL_ANSWER%<br />
						- %POLL_ANSWER_TEXT%<br />
						- %POLL_ANSWER_VOTES%<br />
						-  %POLL_ANSWER_PERCENTAGE%<br />
						- %POLL_ANSWER_IMAGEWIDTH%<br /><br />
						<input type="button" name="RestoreDefault" value="<?php _e('Restore Default Template', 'wp-polls'); ?>" onclick="poll_default_templates('resultbody2');" class="button" />
					</td>
					<td align="left"><textarea cols="80" rows="12" id="poll_template_resultbody2" name="poll_template_resultbody2"><?php echo htmlspecialchars(stripslashes(get_option('poll_template_resultbody2'))); ?></textarea></td> 
				</tr>
				<tr valign="top"> 
					<td width="30%" align="left">
						<strong><?php _e('Result Footer:', 'wp-polls'); ?></strong><br /><?php _e('Displayed When The User HAS Voted', 'wp-polls'); ?><br /><br />
						<?php _e('Allowed Variables:', 'wp-polls'); ?><br />
						- %POLL_ID%<br />
						- %POLL_START_DATE%<br />
						- %POLL_END_DATE%<br />
						- %POLL_TOTALVOTES%<br />
						- %POLL_TOTALVOTERS%<br />
						- %POLL_MOST_ANSWER%<br />
						- %POLL_MOST_VOTES%<br />
						- %POLL_MOST_PERCENTAGE%<br />
						- %POLL_LEAST_ANSWER%<br />
						- %POLL_LEAST_VOTES%<br />
						- %POLL_LEAST_PERCENTAGE%<br />
						- %POLL_MULTIPLE_ANS_MAX%<br /><br />
						<input type="button" name="RestoreDefault" value="<?php _e('Restore Default Template', 'wp-polls'); ?>" onclick="poll_default_templates('resultfooter');" class="button" />
					</td>
					<td align="left"><textarea cols="80" rows="12" id="poll_template_resultfooter" name="poll_template_resultfooter"><?php echo htmlspecialchars(stripslashes(get_option('poll_template_resultfooter'))); ?></textarea></td> 
				</tr>
				<tr valign="top"> 
					<td width="30%" align="left">
						<strong><?php _e('Result Footer:', 'wp-polls'); ?></strong><br /><?php _e('Displayed When The User HAS NOT Voted', 'wp-polls'); ?><br /><br />
						<?php _e('Allowed Variables:', 'wp-polls'); ?><br />
						- %POLL_ID%<br />
						- %POLL_START_DATE%<br />
						- %POLL_END_DATE%<br />
						- %POLL_TOTALVOTES%<br />
						- %POLL_TOTALVOTERS%<br />
						- %POLL_MOST_ANSWER%<br />
						- %POLL_MOST_VOTES%<br />
						- %POLL_MOST_PERCENTAGE%<br />
						- %POLL_LEAST_ANSWER%<br />
						- %POLL_LEAST_VOTES%<br />
						- %POLL_LEAST_PERCENTAGE%<br />
						- %POLL_MULTIPLE_ANS_MAX%<br /><br />
						<input type="button" name="RestoreDefault" value="<?php _e('Restore Default Template', 'wp-polls'); ?>" onclick="poll_default_templates('resultfooter2');" class="button" />
					</td>
					<td align="left"><textarea cols="80" rows="12" id="poll_template_resultfooter2" name="poll_template_resultfooter2"><?php echo htmlspecialchars(stripslashes(get_option('poll_template_resultfooter2'))); ?></textarea></td> 
				</tr>
			</table>
		</fieldset>
		<fieldset class="options">
			<legend><?php _e('Poll Archive Templates', 'wp-polls'); ?></legend>
			<table width="100%"  border="0" cellspacing="3" cellpadding="3"> 
				<tr valign="top">
					<td width="30%" align="left">
						<strong><?php _e('Poll Archive Link', 'wp-polls'); ?></strong><br /><?php _e('Template For Displaying Poll Archive Link', 'wp-polls'); ?><br /><br />
						<?php _e('Allowed Variables:', 'wp-polls'); ?><br />
						- %POLL_ARCHIVE_URL%<br /><br />
						<input type="button" name="RestoreDefault" value="<?php _e('Restore Default Template', 'wp-polls'); ?>" onclick="poll_default_templates('pollarchivelink');" class="button" />
					</td>
					<td align="left"><textarea cols="80" rows="12" id="poll_template_pollarchivelink" name="poll_template_pollarchivelink"><?php echo htmlspecialchars(stripslashes(get_option('poll_template_pollarchivelink'))); ?></textarea></td>
				</tr>
				 <tr valign="top">
					<td width="30%" align="left">
						<strong><?php _e('Individual Poll Header', 'wp-polls'); ?></strong><br /><?php _e('Displayed Before Each Poll In The Poll Archive', 'wp-polls'); ?><br /><br />
						<?php _e('Allowed Variables:', 'wp-polls'); ?><br />
						- <?php _e('N/A', 'wp-polls'); ?><br /><br />
						<input type="button" name="RestoreDefault" value="<?php _e('Restore Default Template', 'wp-polls'); ?>" onclick="poll_default_templates('pollarchiveheader');" class="button" />
					</td>
					<td align="left"><textarea cols="80" rows="12" id="poll_template_pollarchiveheader" name="poll_template_pollarchiveheader"><?php echo htmlspecialchars(stripslashes(get_option('poll_template_pollarchiveheader'))); ?></textarea></td>
				</tr>
				<tr valign="top">
					<td width="30%" align="left">
						<strong><?php _e('Individual Poll Footer', 'wp-polls'); ?></strong><br /><?php _e('Displayed After Each Poll In The Poll Archive', 'wp-polls'); ?><br /><br />
						<?php _e('Allowed Variables:', 'wp-polls'); ?><br />
						- %POLL_START_DATE%<br />
						- %POLL_END_DATE%<br />
						- %POLL_TOTALVOTES%<br />
						- %POLL_TOTALVOTERS%<br />
						- %POLL_MOST_ANSWER%<br />
						- %POLL_MOST_VOTES%<br />
						- %POLL_MOST_PERCENTAGE%<br />
						- %POLL_LEAST_ANSWER%<br />
						- %POLL_LEAST_VOTES%<br />
						- %POLL_LEAST_PERCENTAGE%<br />
						- %POLL_MULTIPLE_ANS_MAX%<br /><br />
						<input type="button" name="RestoreDefault" value="<?php _e('Restore Default Template', 'wp-polls'); ?>" onclick="poll_default_templates('pollarchivefooter');" class="button" />
					</td>
					<td align="left"><textarea cols="80" rows="12" id="poll_template_pollarchivefooter" name="poll_template_pollarchivefooter"><?php echo htmlspecialchars(stripslashes(get_option('poll_template_pollarchivefooter'))); ?></textarea></td>
				</tr>
			</table>
		</fieldset>
		<fieldset class="options">
			<legend><?php _e('Poll Misc Templates', 'wp-polls'); ?></legend>
			<table width="100%"  border="0" cellspacing="3" cellpadding="3"> 
				 <tr valign="top">
					<td width="30%" align="left">
						<strong><?php _e('Poll Disabled', 'wp-polls'); ?></strong><br /><?php _e('Displayed When The Poll Is Disabled', 'wp-polls'); ?><br /><br />
						<?php _e('Allowed Variables:', 'wp-polls'); ?><br />
						- <?php _e('N/A', 'wp-polls'); ?><br /><br />
						<input type="button" name="RestoreDefault" value="<?php _e('Restore Default Template', 'wp-polls'); ?>" onclick="poll_default_templates('disable');" class="button" />
					</td>
					<td align="left"><textarea cols="80" rows="12" id="poll_template_disable" name="poll_template_disable"><?php echo htmlspecialchars(stripslashes(get_option('poll_template_disable'))); ?></textarea></td>
				</tr>
				<tr valign="top">
					<td width="30%" align="left">
						<strong><?php _e('Poll Error', 'wp-polls'); ?></strong><br /><?php _e('Displayed When An Error Has Occured While Processing The Poll', 'wp-polls'); ?><br /><br />
						<?php _e('Allowed Variables:', 'wp-polls'); ?><br />
						- <?php _e('N/A', 'wp-polls'); ?><br /><br />
						<input type="button" name="RestoreDefault" value="<?php _e('Restore Default Template', 'wp-polls'); ?>" onclick="poll_default_templates('error');" class="button" />
					</td>
					<td align="left"><textarea cols="80" rows="12" id="poll_template_error" name="poll_template_error"><?php echo htmlspecialchars(stripslashes(get_option('poll_template_error'))); ?></textarea></td>
				</tr>
			</table>
		</fieldset>
		<div align="center">
			<input type="submit" name="Submit" class="button" value="<?php _e('Update Templates', 'wp-polls'); ?>" />&nbsp;&nbsp;<input type="button" name="cancel" value="<?php _e('Cancel', 'wp-polls'); ?>" class="button" onclick="javascript:history.go(-1)" /> 
		</div>
</div> 
</form> 