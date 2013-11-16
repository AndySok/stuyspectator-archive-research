<?php
if (!file_exists('../../../wp-config.php')) die ('wp-config.php not found');
require_once('../../../wp-config.php');

if (isset($_POST['id'])) {
    Header("Location: ".iri_AdServe_Bannersave($_POST['id']));
    return 1;
}


# Save banner!
function iri_AdServe_Bannersave($id) {
    global $wpdb,$table_prefix;
   	$table_name = $wpdb->prefix . "adserve";
   	if($id > 0) {  // update
    	$query = "UPDATE $table_name SET title='".$_POST['title']."',  url='".$_POST['url']."', src='".$_POST['src']."', user='".$_POST['user']."',  email='".$_POST['email']."', keywords='".$_POST['keywords']."', credits=".$_POST['credits'].", active=".$_POST['active']." WHERE id=$id";
    } else {       // insert
    		$query = "INSERT INTO " . $table_name .
            " (title, url, src, email, keywords, credits, active,impressions,user,clicks) " .
            "VALUES ('".$_POST['title']."', '".$_POST['url']."', '".$_POST['src']."', '".$_POST['email']."', '".$_POST['keywords']."', '".$_POST['credits']."', '".$_POST['active']."',0, '".$_POST['user']."',0 )";
    }
    $wpdb->query($query);
    return get_settings('siteurl')."/wp-admin/edit.php?page=wp-adserve/ad.php";
}

?>
