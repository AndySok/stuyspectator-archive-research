#!/usr/bin/perl
use DBI;

sub connect_to_db{
     $dbh = DBI->connect("DBI:mysql:stuyspec_specold:localhost","stuyspec_sepcold","test");
}

sub disconnect{
    $dbh->disconnect();
}
sub do_sql{
    $the_query = $_[0];
    $sth = $dbh->prepare ($the_query);
    $sth->execute();
    $SQL_DATA=$sth->fetchall_arrayref();
    return $SQL_DATA;
}

sub unwebify{
    $thestring=$_[0];
    $thestring =~ s/\+/ /g;
    $thestring =~ s/%(..)/pack("c",hex($1))/ge;
    return $thestring; 
}

sub read_post_data{
    my (%form);
    my ($name,$value,$pair);
    my (@pairs);
    my ($buffer);
    if ($ENV{'REQUEST_METHOD'} eq 'POST') {
	read(STDIN, $buffer, $ENV{'CONTENT_LENGTH'});
	@pairs = split(/&/, $buffer);
	foreach $pair (@pairs) {
	    ($name, $value) = split(/=/, $pair);
	    $value =~ tr/+/ /;
	    $value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg; 
	    $FORM{$name} = $value;
	}
    }
    return %FORM;
}


sub decodeData
{
    local(*queryString) = @_ if @_;
    $queryString =~ s/\+/ /g;
    $queryString =~ s/%(..)/pack("c",hex($1))/ge; 
    return 1;
}


sub parseData
{
    local(*queryString,*formData) = @_ if @_;
    local($key,$value,$curString,@tmpArray);
    @tmpArray = split(/&/,$queryString);
    foreach $curString (@tmpArray)
    {		
	($key,$value) = split(/=/,$curString);
	&decodeData(*key);
	&decodeData(*value);
	$formData{$key} = $value;
    }
    
    return 1;
}


sub readPostData
{
    local(*queryString) = @_ if @_;
    local($contentLength);
    $contentLength = $ENV{"CONTENT_LENGTH"};
    if($contentLength)
    {
	
	read(STDIN,$queryString,$contentLength);
    }
    return 1;
}

sub readGetData
{
    local(*queryString) = @_ if @_;
    $queryString = $ENV{"QUERY_STRING"};
    return 1;
}

sub readData
{
    local(*queryString) = @_ if @_;
    $requestType = $ENV{"REQUEST_METHOD"};
    if($requestType eq "GET")
    {
	&readGetData(*queryString);
    }
    elsif($requestType eq "POST")
    {
	&readPostData(*queryString);
    }
    
}


sub newlines_to_paragraphs{
    my ($stuff)=$_[0];
    $stuff="<p>".$stuff;
    $stuff =~ tr/\n/\n/s;
    $stuff =~ s/\n/\<\/p><p>/g;
    $stuff .= "</p>";
    $stuff =~ s/<p>\/p>//ig;
    return $stuff;
}

sub paragraphs_to_summary{
    my ($stuff)=$_[0];
    $stuff =~ /([^\a]+?<\/p><p>)/;
    $stuff = $1;
    $stuff =~ /([^\a]+)<\/p><p>/;
    $stuff=$1;
    return $stuff;
}

sub inlist{
    my($crap)=shift;
    my($i);
    for($i=0; $i<scalar(@_); $i++){
	if($crap eq $_[$i]){ return 1; }
    }
    return 0;
}


sub lastid{
    my $ID = &do_sql("select id from poll order by id desc limit 1");
    return $ID->[0][0];
}

sub update_poll{
    my $rows, $err=0;
    my $id=shift;
    my $vote=shift;
    my $pointer, @ary, $string;
    $pointer=&do_sql("select results,ips from poll where id=$id limit 1");
    @ary=split(/\|/,$pointer->[0][0]);

    if($vote <= scalar(@ary) && $vote>0){
	$ary[$vote-1]++;
    }
    else{  $err=1; }
    $string=join("|",@ary);
    $ips=$pointer->[0][1];
    if($ips !~ /$ENV{'REMOTE_ADDR'}/ && !$err){
	$ips.="|$ENV{'REMOTE_ADDR'}";
	$rows=$dbh->do(qq|update poll set results="$string" where id=$id|);
	$rows=$dbh->do(qq|update poll set ips="$ips" where id=$id|);
	
    }
}

sub print_results{
    my $pointer, $question, @answers, @results, $i, $sum, $width, $percent;
    my $id=shift;
    my @colors=("\#FF4500","\#20B2AA","\#2F4F4F","\#800080");
    $pointer=&do_sql("select question,answers,results from poll where id=$id limit 1");
    $question=$pointer->[0][0];
    @answers=split(/\|/,$pointer->[0][1]);
    @results=split(/\|/,$pointer->[0][2]);
    for($i=0; $i<scalar(@results); $i++){
	$sum+=$results[$i];
    }    
    print qq|<p class="content"><font size="2"><b>$question</b></font></p>|;
    print qq|<table width="400">|;
    
    for($i=0; $i<scalar(@answers); $i++){
	$width=(100/$sum)*$results[$i];
	$percent=int($width)."%";
	print qq|<tr><td>$answers[$i]</td>|;
	print qq|<td>|;
	print qq|<table width="$percent" bgcolor="$colors[$i]"><tr><td><font face="verdana" size="2" color="white">$results[$i] votes, $percent</font></td></tr></table>|;
	print qq|</td></tr>|;
    }
    print qq|</table>|;
}

sub get_pollinfo{
    my @ary, $pointer, $question, @answers, $id;
    $pointer=&do_sql("select question,answers,id from poll order by id desc limit 1");
    $question=$pointer->[0][0];
    @ary=split(/\|/,$pointer->[0][1]);
    $id=$pointer->[0][2];
    unshift(@ary,$question);
    unshift(@ary,$id);
    return @ary;
}



1;

