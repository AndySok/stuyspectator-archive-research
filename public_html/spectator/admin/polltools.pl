sub print{
  my @colors=("\#FF4500","\#20B2AA","\#2F4F4F",
	      "\#800080");
  my $id =&filter($_[0],"int");
  my $ques=&do_sql("select question from poll where id=$id");
  my $question=$ques->[0][0];
  my @results=&results($id,"break");
  my $answers=&answers($id);
  my $sum_answers=0;
  foreach $result (@results){
      $sum_answers+=$result;
  }
  print<<HTML;
Results for: $question</font></td>
</tr>

HTML

  $pixelsper=210/($#results);
  for ($i=0; $i<$#results;$i++){
    print "<tr height=$pixelsper><td height=$pixelsper width=25>";
    print "\n<font size=2>$answers[$i]</font></td>\n";
    print "<td height=$pixelsper width=" . ($results[$i]/$sum_answers)*285 . " bgcolor=" . $colors[$i] . ">" . $results[$i] . " votes, " . ($results[$i]/$sum_answers)*100 . "%.</td>";
    print "<td width="*" height=$pixelsper>&nbsp;</td></tr>";
  }
  print<<HTML;
</table>
</body>
</html>
HTML
}


1;








