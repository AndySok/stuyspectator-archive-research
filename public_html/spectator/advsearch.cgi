#! /usr/bin/perl

require "templates.pl";
require "tools.pl";
print "Content-type: text/html\n\n";
&connect_to_db;
&print_top("Search","Search","search.htm");
&wholepage_start;
&leftbar_start;
&leftnavtable;
&leftbar_end;
&maincontent_start;
&contenttable1_start;

print qq|<center>|;
&advsearchbox;
print qq|</center>|;
&contenttable1_end;
&maincontent_end;
&wholepage_end;

print<<"HTML";
<SCRIPT LANGUAGE="JavaScript1.2">
<!--

    function dothis(){
	
	if(asd.bytime.checked == true){
	    asd.from.value = asd.fmon.value + "z" + asd.fday.value + "z" + asd.fyear.value;
	    asd.to.value = asd.tmon.value + "z" + asd.tday.value + "z" + asd.tyear.value;
	}
	else{ 
	    asd.from.value = "";
	    asd.to.value = "";
	}
	if(asd.byauth.checked != true){
	    asd.author.value = "";
	}
	if(asd.bystr.checked != true){
	    asd.searchstr.value = "";
	}
	return;
    }

//-->
</SCRIPT>
HTML

&footer;




