<?php
#########################################
## Compressor option file ##############
#########################################
## Access control
$compress_options['username'] = "21232f297a57a5a743894a0e4a801fc3";
$compress_options['password'] = "028bec64fc5f3f1d2173cda4d5611400";
## Path info
$compress_options['document_root'] = "/home/stuyspec/public_html";
$compress_options['javascript_cachedir'] = "/home/stuyspec/public_html/php_speedy/";
$compress_options['css_cachedir'] = "/home/stuyspec/public_html/php_speedy/";
## Minify options
$compress_options['minify']['javascript'] = "1";
$compress_options['minify']['page'] = "1";
$compress_options['minify']['css'] = "1";
## Gzip options
$compress_options['gzip']['javascript'] = "0";
$compress_options['gzip']['page'] = "0";
$compress_options['gzip']['css'] = "0";
## Versioning
$compress_options['far_future_expires']['javascript'] = "1";
$compress_options['far_future_expires']['css'] = "1";
#########################################
?>