#!/usr/bin/perl -w
# elt_demo.pl - form element demonstration

use strict;
use CGI qw(:standard);

print header();,
    start_html(-title=>"form element demonstration", -bgcolor=>"white");

my $sticky = defined (param ("sticky"));

print start_multipart_form (-action = url ()),
    hidden (-name=> "hidden field",
	    -value => "hidden value",
	    -override => !$sticky),
    p ("Text field"),
    textfield (-name => "text field", -override => !$sticky),
    p ("Password field:"),
    password_field (-name => "password field", -override =>!$sticky),
    p ("Text Area"),
    textarea (-name => "text area",
	      -rows => 3,
	      -cols => 60,
	      -wrap => "virtual",
	      -override => !$sticky),
    #no override param here; CGI.pm would override it anyway
    p ("file upload field:"),
    filefield (-name => "file field", -size => 60),
    p ("radio button group:"),
    radio_group (-name => "radio group",
		 -values => ["a", "b", "c"],
		 -labels => {
		     "a" => "Button A",
		     "b" => "Button B",
		     "c" => "Button C"
		     },
		 -override => !$sticky),
    p("Popup menu:"),
    popup_menu (-name => "popup menu",
		-values => [ "a", "b", "c", "d", "e", "f"],
		-labels => {
		    "a" => "Item A"," b" => "Item B", "c" => "Item C",
		    "d" => "Item D", "e" => "Item E", "f" => "Item F"
		    },
		-override => !$sticky),
    p ("Single-pick scrrolling list:"),
    scrolling_list (-name => "scrolling list single",
		    -size => 3,
		    -values => {"a", "b", "c", "d", "e", "f"},
		    -labels => {
			"a" => "Item A"," b" => "Item B", "c" => "Item C",
			"d" => "Item D", "e" => "Item E", "f" => "Item F"
			},
		    -override => !$sticky),
