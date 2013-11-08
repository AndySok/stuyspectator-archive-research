#!/usr/bin/perl

opendir(PHOTOS,"../photos");
@array=sort(readdir(PHOTOS));
closedir(PHOTOS);

print<<HTML;
Content-type: text/html

HTML

for (@array){
  print $_ . ": <a href=\"../photos/$_\">view</a><br><br>\n"
}
