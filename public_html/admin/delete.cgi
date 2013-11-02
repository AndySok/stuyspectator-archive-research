#!/usr/bin/perl

use DBI;
use CGI qw/:param/;
require 'tools.pl';
&connect_to_db;
$rows = $dbh->do("delete from ".param("type")." where id=" . param("id"));
$dbh->disconnect;
print<<HTML;
Content-type: text/html

$rows affected.

HTML




