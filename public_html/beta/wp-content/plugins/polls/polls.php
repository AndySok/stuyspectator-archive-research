<?php
/*
Plugin Name: WP-Polls
Plugin URI: http://lesterchan.net/portfolio/programming.php
Description: Adds an AJAX poll system to your WordPress blog. You can easily include a poll into your WordPress's blog post/page. WP-Polls is extremely customizable via templates and css styles and there are tons of options for you to choose to ensure that WP-Polls runs the way you wanted. It now supports multiple selection of answers.
Version: 2.21
Author: Lester 'GaMerZ' Chan
Author URI: http://lesterchan.net
*/


/*  
	Copyright 2007  Lester Chan  (email : gamerz84@hotmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/


### Load WP-Config File If This File Is Called Directly
if (!function_exists('add_action')) {
	require_once('../../../wp-config.php');
}


### Create Text Domain For Translations
add_action('init', 'polls_textdomain');
function polls_textdomain() {
	load_plugin_textdomain('wp-polls', 'wp-content/plugins/polls');
}


### Polls Table Name
$wpdb->pollsq					= $table_prefix.'pollsq';
$wpdb->pollsa					= $table_prefix.'pollsa';
$wpdb->pollsip					= $table_prefix.'pollsip';


### Function: Poll Administration Menu
add_action('admin_menu', 'poll_menu');
function poll_menu() {
	if (function_exists('add_menu_page')) {
		add_menu_page(__('Polls', 'wp-polls'), __('Polls', 'wp-polls'), 'manage_polls', 'polls/polls-manager.php');
	}
	if (function_exists('add_submenu_page')) {
		add_submenu_page('polls/polls-manager.php', __('Manage Polls', 'wp-polls'), __('Manage Polls', 'wp-polls'), 'manage_polls', 'polls/polls-manager.php');
		add_submenu_page('polls/polls-manager.php', __('Add Poll', 'wp-polls'), __('Add Poll', 'wp-polls'), 'manage_polls', 'polls/polls-add.php');		
		add_submenu_page('polls/polls-manager.php', __('Poll Options', 'wp-polls'), __('Poll Options', 'wp-polls'), 'manage_polls', 'polls/polls-options.php');
		add_submenu_page('polls/polls-manager.php', __('Poll Templates', 'wp-polls'), __('Poll Templates', 'wp-polls'), 'manage_polls', 'polls/polls-templates.php');
		add_submenu_page('polls/polls-manager.php', __('Poll Usage', 'wp-polls'), __('Poll Usage', 'wp-polls'), 'manage_polls', 'polls/polls-usage.php');
		add_submenu_page('polls/polls-manager.php', __('Uninstall WP-Polls', 'wp-polls'), __('Uninstall WP-Polls', 'wp-polls'), 'manage_polls', 'polls/polls-uninstall.php');
	}
}


### Function: Get Poll
function get_poll($temp_poll_id = 0, $display = true) {
	global $wpdb, $polls_loaded;
	// Poll Result Link
	$pollresult_id = intval($_GET['pollresult']);
	// Check Whether Poll Is Disabled
	if(intval(get_option('poll_currentpoll')) == -1) {
		if($display) {
			echo stripslashes(get_option('poll_template_disable'));
			return;
		} else {
			return stripslashes(get_option('poll_template_disable'));
		}		
	// Poll Is Enabled
	} else {
		// Hardcoded Poll ID Is Not Specified
		if(intval($temp_poll_id) == 0) {
			// Random Poll
			if(intval(get_option('poll_currentpoll')) == -2) {
				$random_poll_id = $wpdb->get_var("SELECT pollq_id FROM $wpdb->pollsq WHERE pollq_active = 1 ORDER BY RAND() LIMIT 1");
				$poll_id = intval($random_poll_id);
				if($pollresult_id > 0) {
					$poll_id = $pollresult_id;
				} elseif(intval($_POST['poll_id']) > 0) {
					$poll_id = intval($_POST['poll_id']);
				}
			// Current Poll ID Is Not Specified
			} elseif(intval(get_option('poll_currentpoll')) == 0) {
				// Get Lastest Poll ID
				$poll_id = intval(get_option('poll_latestpoll'));
			} else {
				// Get Current Poll ID
				$poll_id = intval(get_option('poll_currentpoll'));
			}
		// Get Hardcoded Poll ID
		} else {
			$poll_id = intval($temp_poll_id);
		}
	}
	
	// Assign All Loaded Poll To $polls_loaded
	if(empty($polls_loaded)) {
		$polls_loaded = array();
	}
	if(!in_array($poll_id, $polls_loaded)) {
		$polls_loaded[] = $poll_id;
	}

	// User Click on View Results Link
	if($pollresult_id == $poll_id) {
		if($display) {
			echo display_pollresult($poll_id);
			return;
		} else {
			return display_pollresult($poll_id);
		}
	// Check Whether User Has Voted
	} else {
		$poll_active = $wpdb->get_var("SELECT pollq_active FROM $wpdb->pollsq WHERE pollq_id = $poll_id");
		$poll_active = intval($poll_active);
		$check_voted = check_voted($poll_id);
		if($poll_active == 0) {
			$poll_close = intval(get_option('poll_close'));
		} else {
			$poll_close = 0;
		}
		if($check_voted > 0 || ($poll_active == 0 && $poll_close == 1) || !check_allowtovote()) {
			if($display) {
				echo display_pollresult($poll_id, $check_voted);
				return;
			} else {
				return display_pollresult($poll_id, $check_voted);
			}
		} elseif($poll_active == 1) {
			if($display) {
				echo display_pollvote($poll_id);
				return;
			} else {
				return display_pollvote($poll_id);
			}
		}
	}	
}


### Function: Displays Polls Header
add_action('wp_head', 'poll_header');
function poll_header() {	
	echo "\n".'<!-- Start Of Script Generated By WP-Polls 2.20 -->'."\n";
	wp_register_script('wp-polls', '/wp-content/plugins/polls/polls-js.php', false, '2.20');
	wp_print_scripts(array('sack', 'wp-polls'));
	echo '<link rel="stylesheet" href="'.get_option('siteurl').'/wp-content/plugins/polls/polls-css.css" type="text/css" media="screen" />'."\n";
	echo '<style type="text/css">'."\n";
	$pollbar = get_option('poll_bar');
	if($pollbar['style'] == 'use_css') {
		echo '.wp-polls .pollbar {'."\n";
		echo "\t".'margin: 1px;'."\n";
		echo "\t".'font-size: '.($pollbar['height']-2).'px;'."\n";
		echo "\t".'line-height: '.$pollbar['height'].'px;'."\n";
		echo "\t".'height: '.$pollbar['height'].'px;'."\n";
		echo "\t".'background: #'.$pollbar['background'].';'."\n";
		echo "\t".'border: 1px solid #'.$pollbar['border'].';'."\n";
		echo '}'."\n";
	} else {
		echo '.wp-polls .pollbar {'."\n";
		echo "\t".'margin: 1px;'."\n";
		echo "\t".'font-size: '.($pollbar['height']-2).'px;'."\n";
		echo "\t".'line-height: '.$pollbar['height'].'px;'."\n";
		echo "\t".'height: '.$pollbar['height'].'px;'."\n";
		echo "\t".'background-image: url(\''.get_option('siteurl').'/wp-content/plugins/polls/images/'.$pollbar['style'].'/pollbg.gif\');'."\n";
		echo "\t".'border: 1px solid #'.$pollbar['border'].';'."\n";
		echo '}'."\n";
	}
	echo '</style>'."\n";
	echo '<!-- End Of Script Generated By WP-Polls 2.20 -->'."\n";
}


### Function: Displays Polls Header In WP-Admin
add_action('admin_head', 'poll_header_admin');
function poll_header_admin() {
	wp_register_script('wp-polls-admin', '/wp-content/plugins/polls/polls-admin-js.php', false, '2.20');
	wp_print_scripts(array('sack', 'wp-polls-admin'));
	echo '<link rel="stylesheet" href="'.get_option('siteurl').'/wp-content/plugins/polls/polls-css.css" type="text/css" media="screen" />'."\n";
}


### Function: Displays Polls Footer In WP-Admin
add_action('admin_footer', 'poll_footer_admin');
function poll_footer_admin() {
	// Javascript Code Courtesy Of WP-AddQuicktag (http://bueltge.de/wp-addquicktags-de-plugin/120/)
	echo '<script type="text/javascript">'."\n";
	echo "\t".'if(document.getElementById("ed_toolbar")){'."\n";
	echo "\t\t".'qt_toolbar = document.getElementById("ed_toolbar");'."\n";
	echo "\t\t".'edButtons[edButtons.length] = new edButton("ed_poll","'.__('Poll', 'wp-polls').'", "", "","");'."\n";
	echo "\t\t".'var qt_button = qt_toolbar.lastChild;'."\n";
	echo "\t\t".'while (qt_button.nodeType != 1){'."\n";
	echo "\t\t\t".'qt_button = qt_button.previousSibling;'."\n";
	echo "\t\t".'}'."\n";
	echo "\t\t".'qt_button = qt_button.cloneNode(true);'."\n";
	echo "\t\t".'qt_button.value = "'.__('Poll', 'wp-polls').'";'."\n";
	echo "\t\t".'qt_button.title = "'.__('Insert Poll', 'wp-polls').'";'."\n";
	echo "\t\t".'qt_button.onclick = function () { insertPoll(\'code\', edCanvas);}'."\n";
	echo "\t\t".'qt_button.id = "ed_poll";'."\n";
	echo "\t\t".'qt_toolbar.appendChild(qt_button);'."\n";
	echo "\t".'}'."\n";
	echo '</script>'."\n";
}


### Function: Add Quick Tag For Poll In TinyMCE, Coutesy Of An-Archos (http://an-archos.com/anarchy-media-player)
add_filter('mce_plugins', 'poll_mce_plugins', 5);
function poll_mce_plugins($plugins) {    
	array_push($plugins, '-polls', 'bold');    
	return $plugins;
}
add_filter('mce_buttons', 'poll_mce_buttons', 5);
function poll_mce_buttons($buttons) {
	array_push($buttons, 'separator', 'polls');
	return $buttons;
}
add_action('tinymce_before_init','poll_external_plugins');
function poll_external_plugins() {	
	echo 'tinyMCE.loadPlugin("polls", "'.get_option('siteurl').'/wp-content/plugins/polls/tinymce/plugins/polls/");' . "\n"; 
	return;
}


### Function: Check Who Is Allow To Vote
function check_allowtovote() {
	global $user_ID;
	$user_ID = intval($user_ID);
	$allow_to_vote = intval(get_option('poll_allowtovote'));
	switch($allow_to_vote) {
		// Guests Only
		case 0:
			if($user_ID > 0) {
				return false;
			}
			return true;
			break;
		// Registered Users Only
		case 1:
			if($user_ID == 0) {
				return false;
			}
			return true;
			break;
		// Registered Users And Guests
		case 2:
		default:
			return true;
	}
}


### Funcrion: Check Voted By Cookie Or IP
function check_voted($poll_id) {
	$poll_logging_method = intval(get_option('poll_logging_method'));
	switch($poll_logging_method) {
		// Do Not Log
		case 0:
			return 0;
			break;
		// Logged By Cookie
		case 1:
			return check_voted_cookie($poll_id);
			break;
		// Logged By IP
		case 2:
			return check_voted_ip($poll_id);
			break;
		// Logged By Cookie And IP
		case 3:
			$check_voted_cookie = check_voted_cookie($poll_id);
			if(!empty($check_voted_cookie)) {
				return $check_voted_cookie;
			} else {
				return check_voted_ip($poll_id);
			}
			break;
		// Logged By Username
		case 4:
			return check_voted_username($poll_id);
			break;
	}
}


### Function: Check Voted By Cookie
function check_voted_cookie($poll_id) {
	if(!empty($_COOKIE["voted_$poll_id"])) {
		$get_voted_aids = explode(',', $_COOKIE["voted_$poll_id"]);
	} else {
		$get_voted_aids = 0;
	}
	return $get_voted_aids;
}


### Function: Check Voted By IP
function check_voted_ip($poll_id) {
	global $wpdb;
	// Check IP From IP Logging Database
	$get_voted_aids = $wpdb->get_col("SELECT pollip_aid FROM $wpdb->pollsip WHERE pollip_qid = $poll_id AND pollip_ip = '".get_ipaddress()."'");
	if($get_voted_aids) {
		return $get_voted_aids;
	} else {
		return 0;
	}
}


### Function: Check Voted By Username
function check_voted_username($poll_id) {
	global $wpdb, $user_ID;
	// Check IP If User Is Guest
	if ($user_ID == 0) {
		return check_voted_ip($poll_id);
	}
	$pollsip_userid = intval($user_ID);
	// Check User ID From IP Logging Database
	$get_voted_aids = $wpdb->get_col("SELECT pollip_aid FROM $wpdb->pollsip WHERE pollip_qid = $poll_id AND pollip_userid = $pollsip_userid");
	if($get_voted_aids) {
		return $get_voted_aids;
	} else {
		return 0;
	}
}


### Function: Display Voting Form
function display_pollvote($poll_id, $without_poll_title = false) {
	global $wpdb;
	// Temp Poll Result
	$temp_pollvote = '';
	// Get Poll Question Data
	$poll_question = $wpdb->get_row("SELECT pollq_id, pollq_question, pollq_totalvotes, pollq_timestamp, pollq_expiry, pollq_multiple, pollq_totalvoters FROM $wpdb->pollsq WHERE pollq_id = $poll_id LIMIT 1");
	// Poll Question Variables
	$poll_question_text = stripslashes($poll_question->pollq_question);
	$poll_question_id = intval($poll_question->pollq_id);
	$poll_question_totalvotes = intval($poll_question->pollq_totalvotes);
	$poll_question_totalvoters = intval($poll_question->pollq_totalvoters);
	$poll_start_date = mysql2date(sprintf(__('%s @ %s', 'wp-polls'), get_option('date_format'), get_option('time_format')), gmdate('Y-m-d H:i:s', $poll_question->pollq_timestamp));
	$poll_expiry = trim($poll_question->pollq_expiry);
	if(empty($poll_expiry)) {
		$poll_end_date  = __('No Expiry', 'wp-polls');
	} else {
		$poll_end_date  = mysql2date(sprintf(__('%s @ %s', 'wp-polls'), get_option('date_format'), get_option('time_format')), gmdate('Y-m-d H:i:s', $poll_expiry));
	}
	$poll_multiple_ans = intval($poll_question->pollq_multiple);
	$template_question = stripslashes(get_option('poll_template_voteheader'));
	$template_question = str_replace("%POLL_QUESTION%", $poll_question_text, $template_question);
	$template_question = str_replace("%POLL_ID%", $poll_question_id, $template_question);
	$template_question = str_replace("%POLL_TOTALVOTES%", $poll_question_totalvotes, $template_question);
	$template_question = str_replace("%POLL_TOTALVOTERS%", $poll_question_totalvoters, $template_question);
	$template_question = str_replace("%POLL_START_DATE%", $poll_start_date, $template_question);
	$template_question = str_replace("%POLL_END_DATE%", $poll_end_date, $template_question);
	if($poll_multiple_ans > 0) {
		$template_question = str_replace("%POLL_MULTIPLE_ANS_MAX%", $poll_multiple_ans, $template_question);
	} else {
		$template_question = str_replace("%POLL_MULTIPLE_ANS_MAX%", '1', $template_question);
	}
	// Get Poll Answers Data
	$poll_answers = $wpdb->get_results("SELECT polla_aid, polla_answers, polla_votes FROM $wpdb->pollsa WHERE polla_qid = $poll_question_id ORDER BY ".get_option('poll_ans_sortby').' '.get_option('poll_ans_sortorder'));
	// If There Is Poll Question With Answers
	if($poll_question && $poll_answers) {
		// Display Poll Voting Form
		if(!$without_poll_title) {
			$temp_pollvote .= "<div id=\"polls-$poll_question_id\" class=\"wp-polls\">\n";
			$temp_pollvote .= "\t<form id=\"polls_form_$poll_question_id\" class=\"wp-polls-form\" action=\"".htmlspecialchars($_SERVER['REQUEST_URI'])."\" method=\"post\">\n";
			$temp_pollvote .= "\t\t<p style=\"display: none;\"><input type=\"hidden\" name=\"poll_id\" value=\"$poll_question_id\" /></p>\n";
			if($poll_multiple_ans > 0) {
				$temp_pollvote .= "\t\t<p style=\"display: none;\"><input type=\"hidden\" id=\"poll_multiple_ans_$poll_question_id\" name=\"poll_multiple_ans_$poll_question_id\" value=\"$poll_multiple_ans\" /></p>\n";
			}
			// Print Out Voting Form Header Template
			$temp_pollvote .= "\t\t$template_question\n";
		}
		foreach($poll_answers as $poll_answer) {
			// Poll Answer Variables
			$poll_answer_id = intval($poll_answer->polla_aid); 
			$poll_answer_text = stripslashes($poll_answer->polla_answers);
			$poll_answer_votes = intval($poll_answer->polla_votes);
			$template_answer = stripslashes(get_option('poll_template_votebody'));
			$template_answer = str_replace("%POLL_ID%", $poll_question_id, $template_answer);
			$template_answer = str_replace("%POLL_ANSWER_ID%", $poll_answer_id, $template_answer);
			$template_answer = str_replace("%POLL_ANSWER%", $poll_answer_text, $template_answer);
			$template_answer = str_replace("%POLL_ANSWER_VOTES%", number_format($poll_answer_votes), $template_answer);
			if($poll_multiple_ans > 0) {
				$template_answer = str_replace("%POLL_CHECKBOX_RADIO%", 'checkbox', $template_answer);
			} else {
				$template_answer = str_replace("%POLL_CHECKBOX_RADIO%", 'radio', $template_answer);
			}
			// Print Out Voting Form Body Template
			$temp_pollvote .= "\t\t$template_answer\n";
		}
		// Determine Poll Result URL
		$poll_result_url = $_SERVER['REQUEST_URI'];
		$poll_result_url = preg_replace('/pollresult=(\d+)/i', 'pollresult='.$poll_question_id, $poll_result_url);
		if(intval($_GET['pollresult']) == 0) {
			if(strpos($poll_result_url, '?') !== false) {
				$poll_result_url = "$poll_result_url&amp;pollresult=$poll_question_id";
			} else {
				$poll_result_url = "$poll_result_url?pollresult=$poll_question_id";
			}
		}
		// Voting Form Footer Variables
		$template_footer = stripslashes(get_option('poll_template_votefooter'));
		$template_footer = str_replace("%POLL_ID%", $poll_question_id, $template_footer);
		$template_footer = str_replace("%POLL_RESULT_URL%", $poll_result_url, $template_footer);
		$template_footer = str_replace("%POLL_START_DATE%", $poll_start_date, $template_footer);
		$template_footer = str_replace("%POLL_END_DATE%", $poll_end_date, $template_footer);
		if($poll_multiple_ans > 0) {
			$template_footer = str_replace("%POLL_MULTIPLE_ANS_MAX%", $poll_multiple_ans, $template_footer);
		} else {
			$template_footer = str_replace("%POLL_MULTIPLE_ANS_MAX%", '1', $template_footer);
		}
		// Print Out Voting Form Footer Template
		$temp_pollvote .= "\t\t$template_footer\n";
		if(!$without_poll_title) {
			$temp_pollvote .= "\t</form>\n";
			$temp_pollvote .= "</div>\n";
			$poll_ajax_style = get_option('poll_ajax_style');
			if(intval($poll_ajax_style['loading']) == 1) {
				$temp_pollvote .= "<div id=\"polls-$poll_question_id-loading\" class=\"wp-polls-loading\"><img src=\"".get_option('siteurl')."/wp-content/plugins/polls/images/loading.gif\" width=\"16\" height=\"16\" alt=\"".__('Loading', 'wp-polls')." ...\" title=\"".__('Loading', 'wp-polls')." ...\" class=\"wp-polls-image\" />&nbsp;".__('Loading', 'wp-polls')." ...</div>\n";
			}
		}		
	} else {
		$temp_pollvote .= stripslashes(get_option('poll_template_disable'));
	}
	// Return Poll Vote Template
	return $temp_pollvote;
}


### Function: Display Results Form
function display_pollresult($poll_id, $user_voted = '', $without_poll_title = false) {
	global $wpdb;
	// User Voted
	if(!is_array($user_voted)) {
		$user_voted = array();
	}
	// Temp Poll Result
	$temp_pollresult = '';	
	// Most/Least Variables
	$poll_most_answer = '';
	$poll_most_votes = 0;
	$poll_most_percentage = 0;
	$poll_least_answer = '';
	$poll_least_votes = 0;
	$poll_least_percentage = 0;
	// Get Poll Question Data
	$poll_question = $wpdb->get_row("SELECT pollq_id, pollq_question, pollq_totalvotes, pollq_active, pollq_timestamp, pollq_expiry, pollq_multiple, pollq_totalvoters FROM $wpdb->pollsq WHERE pollq_id = $poll_id LIMIT 1");
	// Poll Question Variables
	$poll_question_text = stripslashes($poll_question->pollq_question);
	$poll_question_id = intval($poll_question->pollq_id);
	$poll_question_totalvotes = intval($poll_question->pollq_totalvotes);
	$poll_question_totalvoters = intval($poll_question->pollq_totalvoters);
	$poll_question_active = intval($poll_question->pollq_active);
	$poll_start_date = mysql2date(sprintf(__('%s @ %s', 'wp-polls'), get_option('date_format'), get_option('time_format')), gmdate('Y-m-d H:i:s', $poll_question->pollq_timestamp));
	$poll_expiry = trim($poll_question->pollq_expiry);
	if(empty($poll_expiry)) {
		$poll_end_date  = __('No Expiry', 'wp-polls');
	} else {
		$poll_end_date  = mysql2date(sprintf(__('%s @ %s', 'wp-polls'), get_option('date_format'), get_option('time_format')), gmdate('Y-m-d H:i:s', $poll_expiry));
	}
	$poll_multiple_ans = intval($poll_question->pollq_multiple);
	$template_question = stripslashes(get_option('poll_template_resultheader'));
	$template_question = str_replace("%POLL_QUESTION%", $poll_question_text, $template_question);
	$template_question = str_replace("%POLL_ID%", $poll_question_id, $template_question);
	$template_question = str_replace("%POLL_TOTALVOTES%", $poll_question_totalvotes, $template_question);
	$template_question = str_replace("%POLL_TOTALVOTERS%", $poll_question_totalvoters, $template_question);
	$template_question = str_replace("%POLL_START_DATE%", $poll_start_date, $template_question);
	$template_question = str_replace("%POLL_END_DATE%", $poll_end_date, $template_question);
	if($poll_multiple_ans > 0) {
		$template_question = str_replace("%POLL_MULTIPLE_ANS_MAX%", $poll_multiple_ans, $template_question);
	} else {
		$template_question = str_replace("%POLL_MULTIPLE_ANS_MAX%", '1', $template_question);
	}
	// Get Poll Answers Data
	$poll_answers = $wpdb->get_results("SELECT polla_aid, polla_answers, polla_votes FROM $wpdb->pollsa WHERE polla_qid = $poll_question_id ORDER BY ".get_option('poll_ans_result_sortby').' '.get_option('poll_ans_result_sortorder'));
	// If There Is Poll Question With Answers
	if($poll_question && $poll_answers) {
		// Is The Poll Total Votes 0?
		$poll_totalvotes_zero = true;
		if($poll_question_totalvotes > 0) {
			$poll_totalvotes_zero = false;
		}
		// Print Out Result Header Template
		if(!$without_poll_title) {
			$temp_pollresult .= "<div id=\"polls-$poll_question_id\" class=\"wp-polls\">\n";
			$temp_pollresult .= "\t\t$template_question\n";
		}
		foreach($poll_answers as $poll_answer) {
			// Poll Answer Variables
			$poll_answer_id = intval($poll_answer->polla_aid); 
			$poll_answer_text = stripslashes($poll_answer->polla_answers);
			$poll_answer_votes = intval($poll_answer->polla_votes);
			$poll_answer_percentage = 0;
			$poll_answer_imagewidth = 0;
			// Calculate Percentage And Image Bar Width
			if(!$poll_totalvotes_zero) {
				if($poll_answer_votes > 0) {
					$poll_answer_percentage = round((($poll_answer_votes/$poll_question_totalvoters)*100));
					$poll_answer_imagewidth = round($poll_answer_percentage);
					if($poll_answer_imagewidth == 100) {
						$poll_answer_imagewidth = 99;
					}
				} else {
					$poll_answer_percentage = 0;
					$poll_answer_imagewidth = 1;
				}
			} else {
				$poll_answer_percentage = 0;
				$poll_answer_imagewidth = 1;
			}
			// Let User See What Options They Voted
			if(in_array($poll_answer_id, $user_voted)) {
				// Results Body Variables
				$template_answer = stripslashes(get_option('poll_template_resultbody2'));
				$template_answer = str_replace("%POLL_ANSWER_ID%", $poll_answer_id, $template_answer);
				$template_answer = str_replace("%POLL_ANSWER%", $poll_answer_text, $template_answer);
				$template_answer = str_replace("%POLL_ANSWER_TEXT%", htmlspecialchars(strip_tags($poll_answer_text)), $template_answer);
				$template_answer = str_replace("%POLL_ANSWER_VOTES%", number_format($poll_answer_votes), $template_answer);
				$template_answer = str_replace("%POLL_ANSWER_PERCENTAGE%", $poll_answer_percentage, $template_answer);
				$template_answer = str_replace("%POLL_ANSWER_IMAGEWIDTH%", $poll_answer_imagewidth, $template_answer);
				// Print Out Results Body Template
				$temp_pollresult .= "\t\t$template_answer\n";
			} else {
				// Results Body Variables
				$template_answer = stripslashes(get_option('poll_template_resultbody'));
				$template_answer = str_replace("%POLL_ANSWER_ID%", $poll_answer_id, $template_answer);
				$template_answer = str_replace("%POLL_ANSWER%", $poll_answer_text, $template_answer);
				$template_answer = str_replace("%POLL_ANSWER_TEXT%", htmlspecialchars(strip_tags($poll_answer_text)), $template_answer);
				$template_answer = str_replace("%POLL_ANSWER_VOTES%", number_format($poll_answer_votes), $template_answer);
				$template_answer = str_replace("%POLL_ANSWER_PERCENTAGE%", $poll_answer_percentage, $template_answer);
				$template_answer = str_replace("%POLL_ANSWER_IMAGEWIDTH%", $poll_answer_imagewidth, $template_answer);
				// Print Out Results Body Template
				$temp_pollresult .= "\t\t$template_answer\n";
			}
			// Get Most Voted Data
			if($poll_answer_votes > $poll_most_votes) {
				$poll_most_answer = $poll_answer_text;
				$poll_most_votes = $poll_answer_votes;
				$poll_most_percentage = $poll_answer_percentage;
			}
			// Get Least Voted Data
			if($poll_least_votes == 0) {
				$poll_least_votes = $poll_answer_votes;
			}
			if($poll_answer_votes <= $poll_least_votes) {
				$poll_least_answer = $poll_answer_text;
				$poll_least_votes = $poll_answer_votes;
				$poll_least_percentage = $poll_answer_percentage;
			}
		}
		// Results Footer Variables
		if(!empty($user_voted) || $poll_question_active == 0 || !check_allowtovote()) {
			$template_footer = stripslashes(get_option('poll_template_resultfooter'));
		} else {
			$template_footer = stripslashes(get_option('poll_template_resultfooter2'));
		}
		$template_footer = str_replace("%POLL_START_DATE%", $poll_start_date, $template_footer);
		$template_footer = str_replace("%POLL_END_DATE%", $poll_end_date, $template_footer);
		$template_footer = str_replace("%POLL_ID%", $poll_question_id, $template_footer);
		$template_footer = str_replace("%POLL_TOTALVOTES%", number_format($poll_question_totalvotes), $template_footer);
		$template_footer = str_replace("%POLL_TOTALVOTERS%", number_format($poll_question_totalvoters), $template_footer);
		$template_footer = str_replace("%POLL_MOST_ANSWER%", $poll_most_answer, $template_footer);
		$template_footer = str_replace("%POLL_MOST_VOTES%", number_format($poll_most_votes), $template_footer);
		$template_footer = str_replace("%POLL_MOST_PERCENTAGE%", $poll_most_percentage, $template_footer);
		$template_footer = str_replace("%POLL_LEAST_ANSWER%", $poll_least_answer, $template_footer);
		$template_footer = str_replace("%POLL_LEAST_VOTES%", number_format($poll_least_votes), $template_footer);
		$template_footer = str_replace("%POLL_LEAST_PERCENTAGE%", $poll_least_percentage, $template_footer);
		if($poll_multiple_ans > 0) {
			$template_footer = str_replace("%POLL_MULTIPLE_ANS_MAX%", $poll_multiple_ans, $template_footer);
		} else {
			$template_footer = str_replace("%POLL_MULTIPLE_ANS_MAX%", '1', $template_footer);
		}
		// Print Out Results Footer Template
		$temp_pollresult .= "\t\t$template_footer\n";
		if(!$without_poll_title) {
			$temp_pollresult .= "</div>\n";
			$poll_ajax_style = get_option('poll_ajax_style');
			if(intval($poll_ajax_style['loading']) == 1) {
				$temp_pollresult .= "<div id=\"polls-$poll_question_id-loading\" class=\"wp-polls-loading\"><img src=\"".get_option('siteurl')."/wp-content/plugins/polls/images/loading.gif\" width=\"16\" height=\"16\" alt=\"".__('Loading', 'wp-polls')." ...\" title=\"".__('Loading', 'wp-polls')." ...\" class=\"wp-polls-image\" />&nbsp;".__('Loading', 'wp-polls')." ...</div>\n";
			}
		}		
	} else {
		$temp_pollresult .= stripslashes(get_option('poll_template_disable'));
	}	
	// Return Poll Result
	return $temp_pollresult;
}


### Function: Get IP Address
if(!function_exists('get_ipaddress')) {
	function get_ipaddress() {
		if (empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
			$ip_address = $_SERVER["REMOTE_ADDR"];
		} else {
			$ip_address = $_SERVER["HTTP_X_FORWARDED_FOR"];
		}
		if(strpos($ip_address, ',') !== false) {
			$ip_address = explode(',', $ip_address);
			$ip_address = $ip_address[0];
		}
		return $ip_address;
	}
}


### Function: Place Polls Archive In Content
add_filter('the_content', 'place_pollsarchive', '7');
function place_pollsarchive($content){
	$content = preg_replace("/\[page_polls\]/ise", "polls_archive()", $content); 
	return $content;
}


### Function: Place Poll In Content (By: Robert Accettura Of http://robert.accettura.com/)
add_filter('the_content', 'place_poll', '7');
add_filter('the_excerpt', 'place_poll', '7');
function place_poll($content){
	if(!is_feed()) {
		$content = preg_replace("/\[poll=(\d+)\]/ise", "display_poll('\\1')", $content);
	} else {
		$content = preg_replace("/\[poll=(\d+)\]/i", __('Note: There is a poll embedded within this post, please visit the site to participate in this post\'s poll.', 'wp-polls'), $content);
	}
    return $content;
}


### Function: Display The Poll In Content (By: Robert Accettura Of http://robert.accettura.com/)
function display_poll($poll_id){
	return get_poll($poll_id, false);
}


### Function: Get Poll Total Questions
if(!function_exists('get_pollquestions')) {
	function get_pollquestions($display = true) {
		global $wpdb;
		$totalpollq = $wpdb->get_var("SELECT COUNT(pollq_id) FROM $wpdb->pollsq");
		if($display) {
			echo number_format($totalpollq);
		} else {
			return number_format($totalpollq);
		}
	}
}


### Function: Get Poll Total Answers
if(!function_exists('get_pollanswers')) {
	function get_pollanswers($display = true) {
		global $wpdb;
		$totalpolla = $wpdb->get_var("SELECT COUNT(polla_aid) FROM $wpdb->pollsa");
		if($display) {
			echo number_format($totalpolla);
		} else {
			return number_format($totalpolla);
		}
	}
}


### Function: Get Poll Total Votes
if(!function_exists('get_pollvotes')) {
	function get_pollvotes($display = true) {
		global $wpdb;
		$totalvotes = $wpdb->get_var("SELECT SUM(pollq_totalvotes) FROM $wpdb->pollsq");
		if($display) {
			echo number_format($totalvotes);
		} else {
			return number_format($totalvotes);
		}
	}
}


### Function: Get Poll Total Voters
if(!function_exists('get_pollvoters')) {
	function get_pollvoters($display = true) {
		global $wpdb;
		$totalvoters = $wpdb->get_var("SELECT SUM(pollq_totalvoters) FROM $wpdb->pollsq");
		if($display) {
			echo number_format($totalvoters);
		} else {
			return number_format($totalvoters);
		}
	}
}


### Function: Check Voted To Get Voted Answer
function check_voted_multiple($poll_id) {
	global $polls_ips;
	$temp_voted_aid = array();
	if(!empty($_COOKIE["voted_$poll_id"])) {
		$temp_voted_aid = explode(',', $_COOKIE["voted_$poll_id"]);
	} else {
		if($polls_ips) {
			foreach($polls_ips as $polls_ip) {
				if($polls_ip['qid'] == $poll_id) {
					$temp_voted_aid[] = $polls_ip['aid'];
				}
			}
		}
	}
	return $temp_voted_aid;
}


### Function: Polls Archive Link
function polls_archive_link($page) {
	$current_url = $_SERVER['REQUEST_URI'];
	$curren_pollpage = intval($_GET['poll_page']);
	$polls_archive_url = preg_replace('/poll_page=(\d+)/i', 'poll_page='.$page, $current_url);
	if($curren_pollpage == 0) {
		if(strpos($current_url, '?') !== false) {
			$polls_archive_url = "$polls_archive_url&amp;poll_page=$page";
		} else {
			$polls_archive_url = "$polls_archive_url?poll_page=$page";
		}
	}
	return $polls_archive_url;
}


### Function: Displays Polls Archive Link
function display_polls_archive_link($display = true) {
	if(intval(get_option('poll_archive_show')) == 1) {
		$template_pollarchivelink = stripslashes(get_option('poll_template_pollarchivelink'));
		$template_pollarchivelink = str_replace("%POLL_ARCHIVE_URL%", get_option('poll_archive_url'), $template_pollarchivelink);
		if($display) {
			echo $template_pollarchivelink;
		} else{
			return $template_pollarchivelink;
		}
	}
}


### Function: Display Polls Archive
function polls_archive() {
	global $wpdb, $polls_ips, $in_pollsarchive;
	// Polls Variables
	$in_pollsarchive = true;
	$page = intval($_GET['poll_page']);
	$polls_questions = array();
	$polls_answers = array();
	$polls_ip = array();
	$polls_perpage = intval(get_option('poll_archive_perpage'));
	$poll_questions_ids = '0';
	$poll_voted = false;
	$poll_voted_aid = 0;
	$poll_id = 0;
	$pollsarchive_output_archive = '';
	$polls_type = intval(get_option('poll_archive_displaypoll'));
	$polls_type_sql = '';
	// Determine What Type Of Polls To Show
	switch($polls_type) {
		case 1:
			$polls_type_sql = 'pollq_active = 0';
			break;
		case 2:
			$polls_type_sql = 'pollq_active = 1';
			break;
		case 3:
			$polls_type_sql = 'pollq_active IN (0,1)';
			break;
	}
	// Get Total Polls
	$total_polls = $wpdb->get_var("SELECT COUNT(pollq_id) FROM $wpdb->pollsq WHERE $polls_type_sql AND pollq_active != -1");

	// Checking $page and $offset
	if (empty($page) || $page == 0) { $page = 1; }
	if (empty($offset)) { $offset = 0; }

	// Determin $offset
	$offset = ($page-1) * $polls_perpage;

	// Determine Max Number Of Polls To Display On Page
	if(($offset + $polls_perpage) > $total_polls) { 
		$max_on_page = $total_polls; 
	} else { 
		$max_on_page = ($offset + $polls_perpage); 
	}

	// Determine Number Of Polls To Display On Page
	if (($offset + 1) > ($total_polls)) { 
		$display_on_page = $total_polls; 
	} else { 
		$display_on_page = ($offset + 1); 
	}

	// Determing Total Amount Of Pages
	$total_pages = ceil($total_polls / $polls_perpage);

	// Get Poll Questions
	$questions = $wpdb->get_results("SELECT * FROM $wpdb->pollsq WHERE $polls_type_sql ORDER BY pollq_id DESC LIMIT $offset, $polls_perpage");
	if($questions) {
		foreach($questions as $question) {
			$polls_questions[] = array('id' => intval($question->pollq_id), 'question' => stripslashes($question->pollq_question), 'timestamp' => $question->pollq_timestamp, 'totalvotes' => intval($question->pollq_totalvotes), 'start' => $question->pollq_timestamp, 'end' => trim($question->pollq_expiry), 'multiple' => intval($question->pollq_multiple), 'totalvoters' => intval($question->pollq_totalvoters));
			$poll_questions_ids .= intval($question->pollq_id).', ';
		}
		$poll_questions_ids = substr($poll_questions_ids, 0, -2);
	}

	// Get Poll Answers
	$answers = $wpdb->get_results("SELECT polla_aid, polla_qid, polla_answers, polla_votes FROM $wpdb->pollsa WHERE polla_qid IN ($poll_questions_ids) ORDER BY ".get_option('poll_ans_result_sortby').' '.get_option('poll_ans_result_sortorder'));
	if($answers) {
		foreach($answers as $answer) {
			$polls_answers[] = array('aid' => intval($answer->polla_aid), 'qid' => intval($answer->polla_qid), 'answers' => stripslashes($answer->polla_answers), 'votes' => intval($answer->polla_votes));
		}
	}

	// Get Poll IPs
	$ips = $wpdb->get_results("SELECT pollip_qid, pollip_aid FROM $wpdb->pollsip WHERE pollip_qid IN ($poll_questions_ids) AND pollip_ip = '".get_ipaddress()."'");
	if($ips) {
		foreach($ips as $ip) {
			$polls_ips[] = array('qid' => intval($ip->pollip_qid), 'aid' => intval($ip->pollip_aid));
		}
	}

	// Poll Archives
	$pollsarchive_output_archive .= "<div class=\"wp-polls wp-polls-archive\">\n";
	foreach($polls_questions as $polls_question) {
		// Most/Least Variables
		$poll_most_answer = '';
		$poll_most_votes = 0;
		$poll_most_percentage = 0;
		$poll_least_answer = '';
		$poll_least_votes = 0;
		$poll_least_percentage = 0;
		// Is The Poll Total Votes 0?
		$poll_totalvotes_zero = true;
		if($polls_question['totalvotes'] > 0) {
			$poll_totalvotes_zero = false;
		}
			$poll_start_date = mysql2date(sprintf(__('%s @ %s', 'wp-polls'), get_option('date_format'), get_option('time_format')), gmdate('Y-m-d H:i:s', $polls_question['start']));
			if(empty($polls_question['end'])) {
				$poll_end_date  = __('No Expiry', 'wp-polls');
			} else {
				$poll_end_date  = mysql2date(sprintf(__('%s @ %s', 'wp-polls'), get_option('date_format'), get_option('time_format')), gmdate('Y-m-d H:i:s', $polls_question['end']));
			}
		// Archive Poll Header
		$template_archive_header = stripslashes(get_option('poll_template_pollarchiveheader'));
		// Poll Question Variables
		$template_question = stripslashes(get_option('poll_template_resultheader'));
		$template_question = str_replace("%POLL_QUESTION%", $polls_question['question'], $template_question);
		$template_question = str_replace("%POLL_ID%", $polls_question['id'], $template_question);
		$template_question = str_replace("%POLL_TOTALVOTES%", $polls_question['totalvotes'], $template_question);
		$template_question = str_replace("%POLL_TOTALVOTERS%", $polls_question['totalvoters'], $template_question);
		$template_question = str_replace("%POLL_START_DATE%", $poll_start_date, $template_question);
		$template_question = str_replace("%POLL_END_DATE%", $poll_end_date, $template_question);
		if($polls_question['multiple'] > 0) {
			$template_question = str_replace("%POLL_MULTIPLE_ANS_MAX%", $polls_question['multiple'], $template_question);
		} else {
			$template_question = str_replace("%POLL_MULTIPLE_ANS_MAX%", '1', $template_question);
		}
		// Print Out Result Header Template
		$pollsarchive_output_archive .= $template_archive_header;
		$pollsarchive_output_archive .= $template_question;
		foreach($polls_answers as $polls_answer) {
			if($polls_question['id'] == $polls_answer['qid']) {
				// Calculate Percentage And Image Bar Width
				if(!$poll_totalvotes_zero) {
					if($polls_answer['votes'] > 0) {
						$poll_answer_percentage = round((($polls_answer['votes']/$polls_question['totalvoters'])*100));
						$poll_answer_imagewidth = round($poll_answer_percentage*0.9);
					} else {
						$poll_answer_percentage = 0;
						$poll_answer_imagewidth = 1;
					}
				} else {
					$poll_answer_percentage = 0;
					$poll_answer_imagewidth = 1;
				}
				// Let User See What Options They Voted
				if(in_array($polls_answer['aid'], check_voted_multiple($polls_question['id']))) {				
					// Results Body Variables
					$template_answer = stripslashes(get_option('poll_template_resultbody2'));
					$template_answer = str_replace("%POLL_ANSWER_ID%", $polls_answer['aid'], $template_answer);
					$template_answer = str_replace("%POLL_ANSWER%", $polls_answer['answers'], $template_answer);
					$template_answer = str_replace("%POLL_ANSWER_TEXT%", htmlspecialchars(strip_tags($polls_answer['answers'])), $template_answer);
					$template_answer = str_replace("%POLL_ANSWER_VOTES%", $polls_answer['votes'], $template_answer);
					$template_answer = str_replace("%POLL_ANSWER_PERCENTAGE%", $poll_answer_percentage, $template_answer);
					$template_answer = str_replace("%POLL_ANSWER_IMAGEWIDTH%", $poll_answer_imagewidth, $template_answer);
					// Print Out Results Body Template
					$pollsarchive_output_archive .= $template_answer;
				} else {
					// Results Body Variables
					$template_answer = stripslashes(get_option('poll_template_resultbody'));
					$template_answer = str_replace("%POLL_ANSWER_ID%", $polls_answer['aid'], $template_answer);
					$template_answer = str_replace("%POLL_ANSWER%", $polls_answer['answers'], $template_answer);
					$template_answer = str_replace("%POLL_ANSWER_TEXT%", htmlspecialchars(strip_tags($polls_answer['answers'])), $template_answer);
					$template_answer = str_replace("%POLL_ANSWER_VOTES%", $polls_answer['votes'], $template_answer);
					$template_answer = str_replace("%POLL_ANSWER_PERCENTAGE%", $poll_answer_percentage, $template_answer);
					$template_answer = str_replace("%POLL_ANSWER_IMAGEWIDTH%", $poll_answer_imagewidth, $template_answer);
					// Print Out Results Body Template
					$pollsarchive_output_archive .= $template_answer;
				}
				// Get Most Voted Data
				if($polls_answer['votes'] > $poll_most_votes) {
					$poll_most_answer = $polls_answer['answers'];
					$poll_most_votes = $polls_answer['votes'];
					$poll_most_percentage = $poll_answer_percentage;
				}
				// Get Least Voted Data
				if($poll_least_votes == 0) {
					$poll_least_votes = $polls_answer['votes'];
				}
				if($polls_answer['votes'] <= $poll_least_votes) {
					$poll_least_answer = $polls_answer['answers'];
					$poll_least_votes = $polls_answer['votes'];
					$poll_least_percentage = $poll_answer_percentage;
				}
				// Delete Away From Array
				unset($polls_answer['answers']);
			}
		}
		// Results Footer Variables
		$template_footer = stripslashes(get_option('poll_template_resultfooter'));
		$template_footer = str_replace("%POLL_START_DATE%", $poll_start_date, $template_footer);
		$template_footer = str_replace("%POLL_END_DATE%", $poll_end_date, $template_footer);
		$template_footer = str_replace("%POLL_TOTALVOTES%", $polls_question['totalvotes'], $template_footer);
		$template_footer = str_replace("%POLL_TOTALVOTERS%", $polls_question['totalvoters'], $template_footer);
		$template_footer = str_replace("%POLL_MOST_ANSWER%", $poll_most_answer, $template_footer);
		$template_footer = str_replace("%POLL_MOST_VOTES%", number_format($poll_most_votes), $template_footer);
		$template_footer = str_replace("%POLL_MOST_PERCENTAGE%", $poll_most_percentage, $template_footer);
		$template_footer = str_replace("%POLL_LEAST_ANSWER%", $poll_least_answer, $template_footer);
		$template_footer = str_replace("%POLL_LEAST_VOTES%", number_format($poll_least_votes), $template_footer);
		$template_footer = str_replace("%POLL_LEAST_PERCENTAGE%", $poll_least_percentage, $template_footer);
		if($polls_question['multiple'] > 0) {
			$template_footer  = str_replace("%POLL_MULTIPLE_ANS_MAX%", $polls_question['multiple'], $template_footer);
		} else {
			$template_footer  = str_replace("%POLL_MULTIPLE_ANS_MAX%", '1', $template_footer);
		}
		// Archive Poll Footer
		$template_archive_footer = stripslashes(get_option('poll_template_pollarchivefooter'));
		$template_archive_footer = str_replace("%POLL_START_DATE%", $poll_start_date, $template_archive_footer);
		$template_archive_footer = str_replace("%POLL_END_DATE%", $poll_end_date, $template_archive_footer);
		$template_archive_footer = str_replace("%POLL_TOTALVOTES%", $polls_question['totalvotes'], $template_archive_footer);
		$template_archive_footer = str_replace("%POLL_TOTALVOTERS%", $polls_question['totalvoters'], $template_archive_footer);
		$template_archive_footer = str_replace("%POLL_MOST_ANSWER%", $poll_most_answer, $template_archive_footer);
		$template_archive_footer = str_replace("%POLL_MOST_VOTES%", number_format($poll_most_votes), $template_archive_footer);
		$template_archive_footer = str_replace("%POLL_MOST_PERCENTAGE%", $poll_most_percentage, $template_archive_footer);
		$template_archive_footer = str_replace("%POLL_LEAST_ANSWER%", $poll_least_answer, $template_archive_footer);
		$template_archive_footer = str_replace("%POLL_LEAST_VOTES%", number_format($poll_least_votes), $template_archive_footer);
		$template_archive_footer = str_replace("%POLL_LEAST_PERCENTAGE%", $poll_least_percentage, $template_archive_footer);
		if($polls_question['multiple'] > 0) {
			$template_archive_footer  = str_replace("%POLL_MULTIPLE_ANS_MAX%", $polls_question['multiple'], $template_archive_footer);
		} else {
			$template_archive_footer  = str_replace("%POLL_MULTIPLE_ANS_MAX%", '1', $template_archive_footer);
		}
		// Print Out Results Footer Template
		$pollsarchive_output_archive .= $template_footer;
		// Print Out Archive Poll Footer Template
		$pollsarchive_output_archive .= $template_archive_footer;
	}
	$pollsarchive_output_archive .= "</div>\n";

	// Polls Archive Paging
	if($total_pages > 1) {
		// Output Previous Page
		$pollsarchive_output_archive .= "<p>\n";
		$pollsarchive_output_archive .= "<span style=\"float: left;\">\n";
		if($page > 1 && ((($page*$polls_perpage)-($polls_perpage-1)) <= $total_polls)) {
			$pollsarchive_output_archive .= '<strong>&laquo;</strong> <a href="'.polls_archive_link($page-1).'" title="&laquo; '.__('Previous Page', 'wp-polls').'">'.__('Previous Page', 'wp-polls').'</a>';
		} else {
			$pollsarchive_output_archive .= '&nbsp;';
		}		
		$pollsarchive_output_archive .= "</span>\n";
		// Output Next Page
		$pollsarchive_output_archive .= "<span style=\"float: right;\">\n";
		if($page >= 1 && ((($page*$polls_perpage)+1) <=  $total_polls)) {
			$pollsarchive_output_archive .= '<a href="'.polls_archive_link($page+1).'" title="'.__('Next Page', 'wp-polls').' &raquo;">'.__('Next Page', 'wp-polls').'</a> <strong>&raquo;</strong>';
		} else {
			$pollsarchive_output_archive .= '&nbsp;';
		}
		$pollsarchive_output_archive .= "</span>\n";
		// Output Pages
		$pollsarchive_output_archive .= "</p>\n";
		$pollsarchive_output_archive .= "<br style=\"clear: both;\" />\n";
		$pollsarchive_output_archive .= "<p style=\"text-align: center;\">\n";
		$pollsarchive_output_archive .= __('Pages', 'wp-polls')." ($total_pages): ";
		if ($page >= 4) {
			$pollsarchive_output_archive .= '<strong><a href="'.polls_archive_link(1).'" title="'.__('Go to First Page', 'wp-polls').'">&laquo; '.__('First', 'wp-polls').'</a></strong> ... ';
		}
		if($page > 1) {
			$pollsarchive_output_archive .= ' <strong><a href="'.polls_archive_link($page-1).'" title="&laquo; '.__('Go to Page', 'wp-polls').' '.($page-1).'">&laquo;</a></strong> ';
		}
		for($i = $page - 2 ; $i  <= $page +2; $i++) {
			if ($i >= 1 && $i <= $total_pages) {
				if($i == $page) {
					$pollsarchive_output_archive .= "<strong>[$i]</strong> ";
				} else {
					$pollsarchive_output_archive .= '<a href="'.polls_archive_link($i).'" title="'.__('Page', 'wp-polls').' '.$i.'">'.$i.'</a> ';
				}
			}
		}
		if($page < $total_pages) {
			$pollsarchive_output_archive .= ' <strong><a href="'.polls_archive_link($page+1).'" title="'.__('Go to Page', 'wp-polls').' '.($page+1).' &raquo;">&raquo;</a></strong> ';
		}
		if (($page+2) < $total_pages) {
			$pollsarchive_output_archive .= ' ... <strong><a href="'.polls_archive_link($total_pages).'" title="'.__('Go to Last Page', 'wp-polls').'">'.__('Last', 'wp-polls').' &raquo;</a></strong>';
		}
		$pollsarchive_output_archive .= "</p>\n";
	}

	// Output Polls Archive Page
	return $pollsarchive_output_archive;
}


// Edit Timestamp Options
function poll_timestamp($poll_timestamp, $fieldname = 'pollq_timestamp', $display = 'block') {
	global $month;
	echo '<div id="'.$fieldname.'" style="display: '.$display.'">'."\n";
	$day = gmdate('j', $poll_timestamp);
	echo '<select name="'.$fieldname.'_day" size="1">'."\n";
	for($i = 1; $i <=31; $i++) {
		if($day == $i) {
			echo "<option value=\"$i\" selected=\"selected\">$i</option>\n";	
		} else {
			echo "<option value=\"$i\">$i</option>\n";	
		}
	}
	echo '</select>&nbsp;&nbsp;'."\n";
	$month2 = gmdate('n', $poll_timestamp);
	echo '<select name="'.$fieldname.'_month" size="1">'."\n";
	for($i = 1; $i <= 12; $i++) {
		if ($i < 10) {
			$ii = '0'.$i;
		} else {
			$ii = $i;
		}
		if($month2 == $i) {
			echo "<option value=\"$i\" selected=\"selected\">$month[$ii]</option>\n";	
		} else {
			echo "<option value=\"$i\">$month[$ii]</option>\n";	
		}
	}
	echo '</select>&nbsp;&nbsp;'."\n";
	$year = gmdate('Y', $poll_timestamp);
	echo '<select name="'.$fieldname.'_year" size="1">'."\n";
	for($i = 2000; $i <= $year; $i++) {
		if($year == $i) {
			echo "<option value=\"$i\" selected=\"selected\">$i</option>\n";	
		} else {
			echo "<option value=\"$i\">$i</option>\n";	
		}
	}
	echo '</select>&nbsp;@'."\n";
	$hour = gmdate('H', $poll_timestamp);
	echo '<select name="'.$fieldname.'_hour" size="1">'."\n";
	for($i = 0; $i < 24; $i++) {
		if($hour == $i) {
			echo "<option value=\"$i\" selected=\"selected\">$i</option>\n";	
		} else {
			echo "<option value=\"$i\">$i</option>\n";	
		}
	}
	echo '</select>&nbsp;:'."\n";
	$minute = gmdate('i', $poll_timestamp);
	echo '<select name="'.$fieldname.'_minute" size="1">'."\n";
	for($i = 0; $i < 60; $i++) {
		if($minute == $i) {
			echo "<option value=\"$i\" selected=\"selected\">$i</option>\n";	
		} else {
			echo "<option value=\"$i\">$i</option>\n";	
		}
	}
	
	echo '</select>&nbsp;:'."\n";
	$second = gmdate('s', $poll_timestamp);
	echo '<select name="'.$fieldname.'_second" size="1">'."\n";
	for($i = 0; $i <= 60; $i++) {
		if($second == $i) {
			echo "<option value=\"$i\" selected=\"selected\">$i</option>\n";	
		} else {
			echo "<option value=\"$i\">$i</option>\n";	
		}
	}
	echo '</select>'."\n";
	echo '</div>'."\n";
}


### Function: Place Cron
function cron_polls_place() {
	wp_clear_scheduled_hook('polls_cron');
	if (!wp_next_scheduled('polls_cron')) {
		wp_schedule_event(time(), 'daily', 'polls_cron');
	}
}


### Funcion: Check All Polls Status To Check If It Expires
add_action('polls_cron', 'cron_polls_status');
function cron_polls_status() {
	global $wpdb;
	// Close Poll
	$close_polls = $wpdb->query("UPDATE $wpdb->pollsq SET pollq_active = 0 WHERE pollq_expiry < '".current_time('timestamp')."' AND pollq_expiry != '' AND pollq_active != 0");
	// Open Future Polls
	$active_polls = $wpdb->query("UPDATE $wpdb->pollsq SET pollq_active = 1 WHERE pollq_timestamp <= '".current_time('timestamp')."' AND pollq_active = -1");
	// Update Latest Poll If Future Poll Is Opened
	if($active_polls) {
		$update_latestpoll = update_option('poll_latestpoll', polls_latest_id());
	}
	return;
}


### Funcion: Get Latest Poll ID
function polls_latest_id() {
	global $wpdb;
	$poll_id = $wpdb->get_var("SELECT pollq_id FROM $wpdb->pollsq WHERE pollq_active = 1 ORDER BY pollq_timestamp DESC LIMIT 1");
	return intval($poll_id);
}


### Check If In Poll Archive Page
function in_pollarchive() {
	$poll_archive_url = get_option('poll_archive_url');
	$poll_archive_url_array = explode('/', $poll_archive_url);
	$poll_archive_url = $poll_archive_url_array[sizeof($poll_archive_url_array)-1];	
	if(empty($poll_archive_url)) {
		$poll_archive_url = $poll_archive_url_array[sizeof($poll_archive_url_array)-2];
	}
	$current_url = $_SERVER['REQUEST_URI'];
	if(strpos($current_url, $poll_archive_url) === false) {
		return false;
	} else {
		return true;
	}
}


### Function: Vote Poll
vote_poll();
function vote_poll() {
	global $wpdb, $user_identity, $user_ID;
	if(!empty($_POST['vote'])) {
		header('Content-Type: text/html; charset='.get_option('blog_charset').'');
		$poll_id = intval($_POST['poll_id']);
		$poll_aid = $_POST["poll_$poll_id"];
		$poll_aid_array = explode(',', $poll_aid);
		if($poll_id > 0 && !empty($poll_aid_array) && check_allowtovote()) {
			$check_voted = check_voted($poll_id);
			if($check_voted == 0) {
				if(!empty($user_identity)) {
					$pollip_user = addslashes($user_identity);
				} elseif(!empty($_COOKIE['comment_author_'.COOKIEHASH])) {
					$pollip_user = addslashes($_COOKIE['comment_author_'.COOKIEHASH]);
				} else {
					$pollip_user = 'Guest';
				}
				$pollip_userid = intval($user_ID);
				$pollip_ip = get_ipaddress();
				$pollip_host = @gethostbyaddr($pollip_ip);
				$pollip_timestamp = current_time('timestamp');
				// Only Create Cookie If User Choose Logging Method 1 Or 2
				$poll_logging_method = intval(get_option('poll_logging_method'));
				if($poll_logging_method == 1 || $poll_logging_method == 3) {
					$vote_cookie = setcookie("voted_".$poll_id, $poll_aid, time() + 30000000, COOKIEPATH);						
				}
				foreach($poll_aid_array as $polla_aid) {
					$wpdb->query("UPDATE $wpdb->pollsa SET polla_votes = (polla_votes+1) WHERE polla_qid = $poll_id AND polla_aid = $polla_aid");
				}
				$vote_q = $wpdb->query("UPDATE $wpdb->pollsq SET pollq_totalvotes = (pollq_totalvotes+".sizeof($poll_aid_array)."), pollq_totalvoters = (pollq_totalvoters+1) WHERE pollq_id = $poll_id");
				if($vote_q) {
					foreach($poll_aid_array as $polla_aid) {
						$wpdb->query("INSERT INTO $wpdb->pollsip VALUES (0, $poll_id, $polla_aid, '$pollip_ip', '$pollip_host', '$pollip_timestamp', '$pollip_user', $pollip_userid)");
					}
					echo "<ul class=\"wp-polls-ul\">\n".display_pollresult($poll_id,$poll_aid_array, 1);
					exit();
				} else {
					printf(__('Unable To Update Poll Total Votes And Poll Total Voters. Poll ID #%s', 'wp-polls'), $poll_id);
					exit();	
				} // End if($vote_a)
			} else {
				printf(__('You Had Already Voted For This Poll. Poll ID #%s', 'wp-polls'), $poll_id);
				exit();
			}// End if($check_voted)
		} else {
			printf(__('Invalid Poll ID. Poll ID #%s', 'wp-polls'), $poll_id);
			exit();
		} // End if($poll_id > 0 && $poll_aid > 0)
	} elseif (intval($_GET['pollresult']) > 0) {
		$poll_id = intval($_GET['pollresult']);
		echo "<ul class=\"wp-polls-ul\">\n".display_pollresult($poll_id, 0, true);
		exit();
	} elseif (intval($_GET['pollbooth']) > 0) {
		$poll_id = intval($_GET['pollbooth']);
		echo "<ul class=\"wp-polls-ul\">\n".display_pollvote($poll_id, true);
		exit();
	} // End if(!empty($_POST['vote']))
}


### Function: Plug Into WP-Stats
if(strpos(get_option('stats_url'), $_SERVER['REQUEST_URI']) || strpos($_SERVER['REQUEST_URI'], 'stats-options.php') || strpos($_SERVER['REQUEST_URI'], 'stats/stats.php')) {
	add_filter('wp_stats_page_admin_plugins', 'polls_page_admin_general_stats');
	add_filter('wp_stats_page_plugins', 'polls_page_general_stats');
}


### Function: Add WP-Polls General Stats To WP-Stats Page Options
function polls_page_admin_general_stats($content) {
	$stats_display = get_option('stats_display');
	if($stats_display['polls'] == 1) {
		$content .= '<input type="checkbox" name="stats_display[]" id="wpstats_polls" value="polls" checked="checked" />&nbsp;&nbsp;<label for="wpstats_polls">'.__('WP-Polls', 'wp-polls').'</label><br />'."\n";
	} else {
		$content .= '<input type="checkbox" name="stats_display[]" id="wpstats_polls" value="polls" />&nbsp;&nbsp;<label for="wpstats_polls">'.__('WP-Polls', 'wp-polls').'</label><br />'."\n";
	}
	return $content;
}


### Function: Add WP-Polls General Stats To WP-Stats Page
function polls_page_general_stats($content) {
	$stats_display = get_option('stats_display');
	if($stats_display['polls'] == 1) {
		$content .= '<p><strong>'.__('WP-Polls', 'wp-polls').'</strong></p>'."\n";
		$content .= '<ul>'."\n";
		$content .= '<li><strong>'.get_pollquestions(false).'</strong> '.__('polls were created.', 'wp-polls').'</li>'."\n";
		$content .= '<li><strong>'.get_pollanswers(false).'</strong> '.__('polls\' answers were given.', 'wp-polls').'</li>'."\n";
		$content .= '<li><strong>'.get_pollvotes(false).'</strong> '.__('votes were casted.', 'wp-polls').'</li>'."\n";
		$content .= '</ul>'."\n";
	}
	return $content;
}


### Function: Create Poll Tables
add_action('activate_polls/polls.php', 'create_poll_table');
function create_poll_table() {
	global $wpdb;
	if(@is_file(ABSPATH.'/wp-admin/upgrade-functions.php')) {
		include_once(ABSPATH.'/wp-admin/upgrade-functions.php');
	} elseif(@is_file(ABSPATH.'/wp-admin/includes/upgrade.php')) {
		include_once(ABSPATH.'/wp-admin/includes/upgrade.php');
	} else {
		die('We have problem finding your \'/wp-admin/upgrade-functions.php\' and \'/wp-admin/includes/upgrade.php\'');
	}
	// Create Poll Tables (3 Tables)
	$create_table = array();
	$create_table['pollsq'] = "CREATE TABLE $wpdb->pollsq (".
									"pollq_id int(10) NOT NULL auto_increment,".
									"pollq_question varchar(200) character set utf8 NOT NULL default '',".
									"pollq_timestamp varchar(20) NOT NULL default '',".
									"pollq_totalvotes int(10) NOT NULL default '0',".
									"pollq_active tinyint(1) NOT NULL default '1',".
									"pollq_expiry varchar(20) NOT NULL default '',".
									"pollq_multiple tinyint(3) NOT NULL default '0',".
									"pollq_totalvoters int(10) NOT NULL default '0',".
									"PRIMARY KEY (pollq_id))";
	$create_table['pollsa'] = "CREATE TABLE $wpdb->pollsa (".
									"polla_aid int(10) NOT NULL auto_increment,".
									"polla_qid int(10) NOT NULL default '0',".
									"polla_answers varchar(200) character set utf8 NOT NULL default '',".
									"polla_votes int(10) NOT NULL default '0',".
									"PRIMARY KEY (polla_aid))";
	$create_table['pollsip'] = "CREATE TABLE $wpdb->pollsip (".
									"pollip_id int(10) NOT NULL auto_increment,".
									"pollip_qid varchar(10) NOT NULL default '',".
									"pollip_aid varchar(10) NOT NULL default '',".
									"pollip_ip varchar(100) NOT NULL default '',".
									"pollip_host VARCHAR(200) NOT NULL default '',".
									"pollip_timestamp varchar(20) NOT NULL default '0000-00-00 00:00:00',".
									"pollip_user tinytext NOT NULL,".
									"pollip_userid int(10) NOT NULL default '0',".
									"PRIMARY KEY (pollip_id))";
	maybe_create_table($wpdb->pollsq, $create_table['pollsq']);
	maybe_create_table($wpdb->pollsa, $create_table['pollsa']);
	maybe_create_table($wpdb->pollsip, $create_table['pollsip']);
	// Check Whether It is Install Or Upgrade
	$first_poll = $wpdb->get_var("SELECT pollq_id FROM $wpdb->pollsq LIMIT 1");
	// If Install, Insert 1st Poll Question With 5 Poll Answers
	if(empty($first_poll)) {
		// Insert Poll Question (1 Record)
		$insert_pollq = $wpdb->query("INSERT INTO $wpdb->pollsq VALUES (1, '".__('How Is My Site?', 'wp-polls')."', '".current_time('timestamp')."', 0, 1, '', 0, 0);");
		if($insert_pollq) {
			// Insert Poll Answers  (5 Records)
			$wpdb->query("INSERT INTO $wpdb->pollsa VALUES (1, 1, '".__('Good', 'wp-polls')."', 0);");
			$wpdb->query("INSERT INTO $wpdb->pollsa VALUES (2, 1, '".__('Excellent', 'wp-polls')."', 0);");
			$wpdb->query("INSERT INTO $wpdb->pollsa VALUES (3, 1, '".__('Bad', 'wp-polls')."', 0);");
			$wpdb->query("INSERT INTO $wpdb->pollsa VALUES (4, 1, '".__('Can Be Improved', 'wp-polls')."', 0);");
			$wpdb->query("INSERT INTO $wpdb->pollsa VALUES (5, 1, '".__('No Comments', 'wp-polls')."', 0);");
		}
	}
	// Add In Options (16 Records)
	add_option('poll_template_voteheader', '<p style="text-align: center;"><strong>%POLL_QUESTION%</strong></p>'.
	'<div id="polls-%POLL_ID%-ans" class="wp-polls-ans">'.
	'<ul class="wp-polls-ul">', 'Template For Poll\'s Question');
	add_option('poll_template_votebody',  '<li><input type="%POLL_CHECKBOX_RADIO%" id="poll-answer-%POLL_ANSWER_ID%" name="poll_%POLL_ID%" value="%POLL_ANSWER_ID%" /> <label for="poll-answer-%POLL_ANSWER_ID%">%POLL_ANSWER%</label></li>', 'Template For Poll\'s Answers');
	add_option('poll_template_votefooter', '</ul>'.
	'<p style="text-align: center;"><input type="button" name="vote" value="   '.__('Vote', 'wp-polls').'   " class="Buttons" onclick="poll_vote(%POLL_ID%);" onkeypress="poll_result(%POLL_ID%);" /></p>'.
	'<p style="text-align: center;"><a href="#ViewPollResults" onclick="poll_result(%POLL_ID%); return false;" onkeypress="poll_result(%POLL_ID%); return false;" title="'.__('View Results Of This Poll', 'wp-polls').'">'.__('View Results', 'wp-polls').'</a></p>'.
	'</div>', 'Template For Poll\'s Voting Footer');
	add_option('poll_template_resultheader', '<p style="text-align: center;"><strong>%POLL_QUESTION%</strong></p>'.
	'<div id="polls-%POLL_ID%-ans" class="wp-polls-ans">'.
	'<ul class="wp-polls-ul">', 'Template For Poll Header');
	add_option('poll_template_resultbody', '<li>%POLL_ANSWER% <small>(%POLL_ANSWER_PERCENTAGE%%, %POLL_ANSWER_VOTES% '.__('Votes', 'wp-polls').')</small><div class="pollbar" style="width: %POLL_ANSWER_IMAGEWIDTH%%;" title="%POLL_ANSWER_TEXT% (%POLL_ANSWER_PERCENTAGE%% | %POLL_ANSWER_VOTES% '.__('Votes', 'wp-polls').')"></div></li>', 'Template For Poll Results');
	add_option('poll_template_resultbody2', '<li><strong><i>%POLL_ANSWER% <small>(%POLL_ANSWER_PERCENTAGE%%, %POLL_ANSWER_VOTES% '.__('Votes', 'wp-polls').')</small></i></strong><div class="pollbar" style="width: %POLL_ANSWER_IMAGEWIDTH%%;" title="'.__('You Have Voted For This Choice', 'wp-polls').' - %POLL_ANSWER_TEXT% (%POLL_ANSWER_PERCENTAGE%% | %POLL_ANSWER_VOTES% '.__('Votes', 'wp-polls').')"></div></li>', 'Template For Poll Results (User Voted)');
	add_option('poll_template_resultfooter', '</ul>'.
	'<p style="text-align: center;">'.__('Total Voters', 'wp-polls').': <strong>%POLL_TOTALVOTERS%</strong></p>'.
	'</div>', 'Template For Poll Result Footer');
	add_option('poll_template_resultfooter2', '</ul>'.
	'<p style="text-align: center;">'.__('Total Voters', 'wp-polls').': <strong>%POLL_TOTALVOTERS%</strong></p>'.
	'<p style="text-align: center;"><a href="#VotePoll" onclick="poll_booth(%POLL_ID%); return false;" onkeypress="poll_booth(%POLL_ID%); return false;" title="'.__('Vote For This Poll', 'wp-polls').'">'.__('Vote', 'wp-polls').'</a></p>'.
	'</div>', 'Template For Poll Result Footer');
	add_option('poll_template_disable', __('Sorry, there are no polls available at the moment.', 'wp-polls'), 'Template For Poll When It Is Disabled');
	add_option('poll_template_error', __('An error has occurred when processing your poll.', 'wp-polls'), 'Template For Poll When An Error Has Occured');
	add_option('poll_currentpoll', 0, 'Current Displayed Poll');
	add_option('poll_latestpoll', 1, 'The Latest Poll');
	add_option('poll_archive_perpage', 5, 'Number Of Polls To Display Per Page On The Poll\'s Archive', 'no');
	add_option('poll_ans_sortby', 'polla_aid', 'Sorting Of Poll\'s Answers');
	add_option('poll_ans_sortorder', 'asc', 'Sort Order Of Poll\'s Answers');
	add_option('poll_ans_result_sortby', 'polla_votes', 'Sorting Of Poll\'s Answers Result');
	add_option('poll_ans_result_sortorder', 'desc', 'Sorting Order Of Poll\'s Answers Result');
	// Database Upgrade For WP-Polls 2.1
	add_option('poll_logging_method', '3', 'Logging Method Of User Poll\'s Answer');
	add_option('poll_allowtovote', '2', 'Who Is Allowed To Vote');
	maybe_add_column($wpdb->pollsq, 'pollq_active', "ALTER TABLE $wpdb->pollsq ADD pollq_active TINYINT( 1 ) NOT NULL DEFAULT '1';");
	// Database Upgrade For WP-Polls 2.12
	maybe_add_column($wpdb->pollsip, 'pollip_userid', "ALTER TABLE $wpdb->pollsip ADD pollip_userid INT( 10 ) NOT NULL DEFAULT '0';");
	add_option('poll_archive_url', get_option('siteurl').'/pollsarchive/', 'Polls Archive URL');
	add_option('poll_archive_show', 1, 'Show Polls Archive?');
	// Database Upgrade For WP-Polls 2.13
	add_option('poll_bar', array('style' => 'default', 'background' => 'd8e1eb', 'border' => 'c8c8c8', 'height' => 8), 'Poll Bar Style');
	// Database Upgrade For WP-Polls 2.14
	maybe_add_column($wpdb->pollsq, 'pollq_expiry', "ALTER TABLE $wpdb->pollsq ADD pollq_expiry varchar(20) NOT NULL default '';");
	add_option('poll_close', 1, 'Poll Close');
	// Database Upgrade For WP-Polls 2.20
	add_option('poll_ajax_style', array('loading' => 1, 'fading' => 1), 'Poll AJAX Style');
	add_option('poll_template_pollarchivelink', '<ul>'.
	'<li><a href="%POLL_ARCHIVE_URL%">'.__('Polls Archive', 'wp-polls').'</a></li>'.
	'</ul>', 'Template For Poll Archive Link');
	add_option('poll_archive_displaypoll', 2, 'Type Of Polls To Display In Polls Archive');
	add_option('poll_template_pollarchiveheader', '', 'Displayed Before Each Poll In The Poll Archive');
	add_option('poll_template_pollarchivefooter', '<p>Start Date: %POLL_START_DATE%<br />End Date: %POLL_END_DATE%</p>', 'Displayed After Each Poll In The Poll Archive');
	maybe_add_column($wpdb->pollsq, 'pollq_multiple', "ALTER TABLE $wpdb->pollsq ADD pollq_multiple TINYINT( 3 ) NOT NULL DEFAULT '0';");
	$pollq_totalvoters = maybe_add_column($wpdb->pollsq, 'pollq_totalvoters', "ALTER TABLE $wpdb->pollsq ADD pollq_totalvoters INT( 10 ) NOT NULL DEFAULT '0';");
	if($pollq_totalvoters) {
		$wpdb->query("UPDATE $wpdb->pollsq SET pollq_totalvoters = pollq_totalvotes");
	}
	// Set 'manage_polls' Capabilities To Administrator	
	$role = get_role('administrator');
	if(!$role->has_cap('manage_polls')) {
		$role->add_cap('manage_polls');
	}
	cron_polls_place();
}
?>