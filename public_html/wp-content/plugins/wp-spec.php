<?php
/*
Plugin Name: Spectator Functions
Plugin URI: http://stuyspectator.com
Description: A collection of functions used on the Spectator website.
Version: .1
Author: Sam Gerstenzang
Author URI: http://samgerstenzang.com
Edited for integration into 3.1 - Vijendra Ramlall (Editor) and Eugene Lee (EIT) 2011
*/
?>
<?php
/*  Copyright 2007  SAM GERSTENZANG  (email : SGERSTENZANG@GMAIL.COM)

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
?>
<?php

function clean_authors($authors) {
	$authors_array = explode(',',$authors[0]);
	
	$count = 0;
	if (strlen($authors_array[0]) >= 1) {
		print 'By ';
	}
	
	foreach ($authors_array as $author) {
		$count++;
		$author = "<a href='http://stuyspectator.com/?s=&quot;$author&quot;&key=".urlencode('Written by:')."'>".strtoupper($author)."</a>";
		if (count($authors_array) == 1 ) {
			print $author;
		}
		elseif (count($authors_array) > 1) {
			if ($count == count($authors_array)) {
				print " and $author";
			}
			elseif ($count == (count($authors_array) - 1)) {
				print $author;
			}
			else {
				print "$author, ";
			}
		}
	}
}


function clean_additional($authors) {
	$authors_array = explode(',',$authors[0]);
	
	$count = 0;
	if (strlen($authors_array[0]) >= 1) {
		print ' with additional reporting by ';
	}
	
	foreach ($authors_array as $author) {
		$count++;
		$author = "<a href='http://stuyspectator.com/?s=&quot;$author&quot;&key=".urlencode('Additional reporting by:')."'>".strtoupper($author)."</a>";
		if (count($authors_array) == 1 ) {
			print $author;
		}
		elseif (count($authors_array) > 1) {
			if ($count == count($authors_array)) {
				print " and $author";
			}
			elseif ($count == (count($authors_array) - 1)) {
				print $author;
			}
			else {
				print "$author, ";
			}
		}
	}
}

?>