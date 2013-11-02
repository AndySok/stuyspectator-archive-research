<?php
	$this->load->view('desk/header');
	foreach ($volume_array as $volume => $issues) {
		print $volume.': <br />';
		foreach ($issues as $issue) {
			print $issue['issue_num'].' '.$issue['comment'].'(Active:'.$issue['active'].')<br />';
		}
	}
	$this->load->view('desk/footer');
?>