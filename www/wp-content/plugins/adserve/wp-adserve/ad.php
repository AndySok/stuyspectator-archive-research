<?php
/*
Plugin Name: AdServe
Plugin URI: http://www.irisco.it/?page_id=40
Description: Ads server for WordPress
Version: 0.3
Author: Daniele Lippi
Author URI: http://www.irisco.it
*/


function iri_AdServe_AddPages() {
	# Crea/aggiorna tabella se non esiste
	global $wpdb;
	$table_name = $wpdb->prefix . "adserve";
	if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
		iri_AdServe_CreateTable();
	}
	# add submenu
    add_management_page('index.php', 'Ads', 8, __FILE__, 'iri_AdServe_Manage');
    add_submenu_page('index.php', 'Ads', 'Ads', 0, 'adreport', 'iri_AdServe_Dashboard');
}


function iri_AdServe_Manage() {
	global $wpdb;
	$table_name = $wpdb->prefix . "adserve";
    
	# Tabella OVERVIEW
    $lastmonth = date('Ym', mktime(0, 0, 0, date("m")-1 , date("d") - 1, date("Y")));
    $yesterday = date('Ymd', time()-86400);
	print "<div class='wrap'><h2>Ads</h2><table class='widefat'><thead><tr><th scope='col'>Site</th><th scope='col'>Zones</th><th scope='col'>Active</th><th scope='col'>Impressions</th><th scope='col'>Clicks</th><th scope='col'>Ratio</th><th scope='col'>Credits</th><th scope='col'>Actions</th></tr></thead>";
	print "<tbody id='the-list'>";
	$qry = $wpdb->get_results("SELECT * FROM $table_name ORDER BY active DESC, credits DESC;");
	foreach ($qry as $rk) {
		print "<tr>";
		print "<td style='align:center;text-align:center;'><a href='".$rk->url."'><strong>".$rk->title."</strong></a><br /><img border=0 src='".$rk->src."'></td>";
		
		print "<td>".$rk->keywords."</td>\n";
#		print "<td>".$rk->weight."</td>\n";
		print "<td>".iri_iif($rk->active == 1,"Yes","No")."</td>\n";
		
		print "<td>".$rk->impressions."</td>\n";
		print "<td>".$rk->clicks."</td>\n";
		print "<td>".number_format($rk->clicks/($rk->impressions+1)*100,1)." %</td>\n";

		print "<td>".$rk->credits."</td>\n";

		$editform=" document.adform.vai.value=\"Save\";
					document.adform.id.value=\"".$rk->id."\";
					document.adform.title.value=\"".$rk->title."\";
					document.adform.url.value=\"".$rk->url."\";
					document.adform.src.value=\"".$rk->src."\";
					document.adform.email.value=\"".$rk->email."\";
					document.adform.user.value=\"".$rk->user."\";
					document.adform.keywords.value=\"".$rk->keywords."\";
					document.adform.credits.value=\"".$rk->credits."\";
					document.adform.active.value=\"".$rk->active."\";
					";
		print "<td><a href='' style='border:0px;' onclick='".$editform."; return false;'><img src='".get_settings('siteurl')."/wp-content/plugins/wp-adserve/files/edit.gif' style='border: 0px solid #AB6400; margin:0; padding:0;'></a> ";
		$url=get_settings('siteurl')."/wp-content/plugins/wp-adserve/adremove.php?id=$rk->id";
		print "<a href=$url onclick=\"return confirm('Are you sure you want to delete?')\" style='border:0px;'>";
		print "<img src='".get_settings('siteurl')."/wp-content/plugins/wp-adserve/files/delete.gif' style='border: 0px solid #AB6400; margin:0; padding:0;'></a></td>\n";

		print "</tr>";
	}
    print "</table>";
    print "<div style='border-top:1px dotted gray;margin-top:10px;padding-top:7px;font-size:9pt;'>";
    print "<form name=adform method=post action='".get_settings('siteurl')."/wp-content/plugins/wp-adserve/adsave.php'><input type=hidden name=id value=''>";
    print "title <input type=text name=title value=''> ";
    print "url <input type=text name=url value=''> ";
    print "src <input type=text name=src value=''> ";
    print "zones <input type=text name=keywords value=''> ";
    print "credits <input type=text name=credits value='' style='width:40px'> "; 
    print "active <input type=text name=active value='' style='width:15px'> "; 
    print "<br />";
    print "email <input type=text name=email value=''> ";
    print "user <input type=text name=user value=''> ";
    print "<input type=submit name=vai value=Save>";
    print "</form>";
    print "</div>";
	print "</div>";
	print "<div class='wrap'><h2>New Ad</h2>";
    print "<form name=adform2 method=post action='".get_settings('siteurl')."/wp-content/plugins/wp-adserve/adsave.php'><input type=hidden name=id value=''>";
    print "<table>";
    print "<tr><td>title</td><td><input type=text name=title value='' size=60></td></tr>";
    print "<tr><td>url</td><td><input type=text name=url value='' size=60></td></tr>";
    print "<tr><td>src</td><td><input type=text name=src value='' size=60></td></tr>";
    print "<tr><td>e-mail</td><td><input type=text name=email value='' size=40></td></tr>";
    print "<tr><td>blog user</td><td><input type=text name=user value='' size=20></td></tr>";
    print "<tr><td>zones</td><td><input type=text name=keywords value='' size=30></td></tr>";
    print "<tr><td>credits</td><td><input type=text name=credits value='' size=10></td></tr>"; 
    print "<tr><td>active</td><td><input type=text name=active value='' size=1></td></tr>"; 
    print "<tr><td></td><td><input type=submit name=vai value=Add></td></tr>";
    print "</table></form>";
	print "</div>";
	
}

function iri_AdServe_Dashboard() {
	global $wpdb;
	global $user_email;
	global $user_login;
	$table_name = $wpdb->prefix . "adserve";
	print "<div class='wrap'><h2>Your Ads</h2><table class='widefat'><thead><tr><th scope='col'>Site</th><th scope='col'>Zones</th><th scope='col'>Active</th><th scope='col'>Impressions</th><th scope='col'>Clicks</th><th scope='col'>Ratio</th><th scope='col'>Credits</th></tr></thead>";
	print "<tbody id='the-list'>";
	$qry = $wpdb->get_results("SELECT * FROM $table_name WHERE user='$user_login' ORDER BY active DESC, credits DESC;");
	foreach ($qry as $rk) {
		print "<tr>";
		print "<td style='align:center;text-align:center;'><a href='".$rk->url."'><strong>".$rk->title."</strong></a><br /><img border=0 src='".$rk->src."'></td>";
		print "<td>".$rk->keywords."</td>\n";
		print "<td>".iri_iif($rk->active == 1,"Yes","No")."</td>\n";
		print "<td>".$rk->impressions."</td>\n";
		print "<td>".$rk->clicks."</td>\n";
		print "<td>".number_format($rk->clicks/($rk->impressions+1)*100,1)." %</td>\n";
		print "<td>".$rk->credits."</td>\n";
		print "</tr>";
	}
    print "</tbody></table></div>";
}

function iri_AdServe_CreateTable() {
	global $wpdb;
	$table_name = $wpdb->prefix . "adserve";
	$sql_createtable = "CREATE TABLE " . $table_name . " (
	id mediumint(9) NOT NULL AUTO_INCREMENT,
	user text,
	active tinyint,
	date text,
	title text,
	url text,
	src text,
	email text,
	credits int,
	impressions int,
	keywords text,
	weight tinyint,
	clicks int,
	UNIQUE KEY id (id)
	);";
	if($wp_db_version >= 5540)	$page = 'wp-admin/includes/upgrade.php';  
								else $page = 'wp-admin/upgrade'.'-functions.php';
	require_once(ABSPATH . $page);
	dbDelta($sql_createtable);
}

function iri_iif($expression, $returntrue, $returnfalse = '') {
    return ($expression ? $returntrue : $returnfalse);
} 

function iri_AdServe_GetBanner($zone='') {
	global $wpdb;
	global $userdata;
	$table_name = $wpdb->prefix . "adserve";
	$ret="";
	# get banner
	$wherecond="((credits = -1) or (credits > 0)) AND (active = 1) AND (concat(keywords,' ') LIKE '%".$zone." %')";
	$numrows = $wpdb->get_var("SELECT count(id) FROM $table_name WHERE $wherecond;");
	if($numrows > 0) {
		usleep(2000);
		$bannum = mt_rand(1, $numrows)-1;
	    if ($bannum>=0) {
			$rk = $wpdb->get_row("SELECT * FROM $table_name WHERE $wherecond LIMIT 1 OFFSET $bannum;");
			$ret="\n\n<!-- Begin AdServe code : banner:$zone-$bannum/$numrows -->\n";
			$ret.="<a target='_blank' href='".get_settings('siteurl')."/wp-content/plugins/wp-adserve/adclick.php?id=$rk->id' style='margin:0px;border:0px;'><img src='$rk->src' alt='$rk->title' /></a>";
			$ret.="\n<!-- End AdServe code -->\n\n";
			get_currentuserinfo();
			if($userdata->user_login != $rk->user) {
				if($rk->credits > 0) {
					$results = $wpdb->query( "update $table_name set credits=credits-1 where id=$rk->id" );
				}
				$results = $wpdb->query( "update $table_name set impressions=impressions+1 where id=$rk->id" );
			}
		}
	}
	return $ret;
}

function AdServe($zone='') {
	print iri_AdServe_GetBanner($zone);
}


function iri_AdServe_Filter($the_content) {
	while($p=strpos($the_content, "[!AdServe")) {
		$pend=strpos($the_content, "!]",$p);
		$zone=substr($the_content,$p+10,$pend-$p-10);
		$the_content=str_replace("[!AdServe:$zone!]",iri_AdServe_GetBanner($zone),$the_content);
	}
	return $the_content;
}


add_action('admin_menu', 'iri_AdServe_AddPages');
add_filter('the_content', 'iri_AdServe_Filter', 99);

?>
