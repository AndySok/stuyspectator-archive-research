<html>
<head>
	<title>Uploading...</title>
</head>
<body>
<h1>Uploading file...</h1>
<?php

$userfile = $HTTP_POST_FILES['userfile']['tmp_name'];

$userfile_name = $HTTP_POST_FILES['userfile']['name'];

$userfile_type = $HTTP_POST_FILES['userfile']['type'];

$userfile_error = $HTTP_POST_FILES['userfile']['error'];
$resolution = $_POST['resolution'];
	
	if ($userfile_error > 0)
	{
	echo 'Problem: ';
	switch ($userfile_error)
	  {
	  case 1: echo 'File exceeded upload_max_filesize'; 	break;
	  case 2: echo 'File exceeded max_file_size'; break;
	  case 3: echo 'File only partially uploaded'; break;
	  case 4: echo 'No file uploaded'; break;
	  }
	exit;
	}

$upfile = "/data/web/orgs/spectator/photos/$userfile_name";
if ( is_uploaded_file($userfile))
{
  if (!move_uploaded_file($userfile,$upfile))
    {
      echo '<p>userfile:'.$userfile.' upfile:'.$upfile.'</p>';
      echo 'Problem : Could not move file to destination directory';
      exit;
    }
}
else
{
  echo 'Problem : Possible file upload attack. Filename : '.$userfile_name;
  exit;
}

echo 'File uploaded successfully<br /><br />';
$userfile_name_array = explode('.zip', $userfile_name);                         
$dirname = $userfile_name_array[0];
$dirnametiff = $dirname . '_tiff';
//mkdir("/var/www/uploads/$dirname");
//chdir("/var/www/uploads/$dirname");                                      
chdir('/data/web/orgs/spectator/photos/');

if ( exec("unzip -d $dirnametiff $userfile_name"))
{
  echo 'File decompressed<br>';

}
else
{
  echo 'Unable to extract file<br>';
}

$jpeg = $dirname;
mkdir("/data/web/orgs/spectator/photos/$jpeg");

//determine number of files
chdir("/data/web/orgs/spectator/photos/$dirnametiff");

exec('ls | wc -l', $numfiles_array);
$numfiles =  $numfiles_array[0];

exec('ls', $filenames_array);
$filenames_length = count($filenames_array);
$TIFF = 'TIFF';
$tiff = 'tiff';
for($i = 0; $i<$filenames_length;$i++)
{
 	 
  chdir("/data/web/orgs/spectator/photos/$dirnametiff");
  $jpegname = $filenames_array[$i];
  if(strpos($jpegname, $TIFF))
    {
      $jpegname = explode('.TIFF', $jpegname);
    }
  
  if(strpos($jpegname, $tiff))
    {
      $jpegname = explode('.tiff', $jpegname);
    }
  $jpegname = $jpegname[0] . '.jpeg';
  exec("convert $filenames_array[$i] /data/web/orgs/spectator/photos/$jpeg/$jpegname");
  chdir("/data/web/orgs/spectator/photos/$jpeg");	
  exec("convert -scale $resolution $jpegname $jpegname");
  echo "$jpegname created<br>";
}
chdir("/data/web/orgs/spectator/photos");
exec(" rm -r $dirnametiff");
exec(" rm $userfile_name");
?>
