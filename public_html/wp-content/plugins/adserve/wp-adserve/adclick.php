<?php
if (!file_exists('../../../wp-config.php')) die ('wp-config.php not found');
require_once('../../../wp-config.php');

if (isset($_GET['id'])) {
	$id=$_GET['id'];
    Header("Location: ".iri_AdServe_BannerClick((int)$id));
    return 1;
}


# Add one click!
function iri_AdServe_BannerClick($id) {
    global $wpdb,$table_prefix;
   	$table_name = $wpdb->prefix . "adserve";
    $query = "UPDATE $table_name SET  clicks=clicks+1 WHERE id=$id";
    $wpdb->query($query);
    return $wpdb->get_var("SELECT url FROM $table_name WHERE id=$id;");
}

?>