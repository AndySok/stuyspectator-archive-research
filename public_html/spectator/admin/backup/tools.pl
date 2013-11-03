#!/usr/bin/perl
use DBI;

sub connect_to_db{
    $dbh = DBI->connect ("DBI:mysql:spectator:localhost", "goetsch", "encryption", {RaiseError => 1 });
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


1;










