<?php
// $Id: inline_imagewrap.inc,v 1.28 2004/06/10 15:08:18 jenst Exp $

//-- shorten the variables for convinience ---
$borderWidth = $gallery->html_wrap['borderWidth'];
$borderColor = $gallery->html_wrap['borderColor'];
$pixelImage = isset($gallery->html_wrap['pixelImage']) ?
     $gallery->html_wrap['pixelImage'] :
    dirname(dirname(__FILE__)) . '/images/pixel_trans.gif';
$imageWidth = $gallery->html_wrap['imageWidth'];
$imageHeight = $gallery->html_wrap['imageHeight'];
$href = $gallery->html_wrap['imageHref'];
$tag = $gallery->html_wrap['imageTag'];
$frame = $gallery->html_wrap['frame'];
$attr=isset($gallery->html_wrap['attr']) ? $gallery->html_wrap['attr'] : "";

if (isset($gallery->html_wrap['base'])) {
	$base = $gallery->html_wrap['base'];
	if (!realpath($base)) {
		print _("Security violation") ."\n";
		exit;
	}
}

if (!empty($href) ) {
  $href_tag= "<a href=\"$href\" ". $attr .">$tag</a>";
} else {
  $href_tag= '<a '. $attr .">$tag</a>";
}

switch ($frame) {

// special cases
case "none":
  echo $href_tag;
  break;
case "dots":
?>
  <table style="border-width:1px; border-style:dashed; border-color:<?php echo $borderColor ?>">
    <tr>
      <td>
        <?php echo $href_tag ?>
      </td>
    </tr>
  </table>
<?php
  break;
case "solid":
?>
  <table width="1%" border="0" cellspacing="0" cellpadding="0">
    <tr bgcolor="<?php echo $borderColor ?>">
      <td colspan="3" height="<?php echo $borderWidth ?>"><img src="<?php echo $pixelImage ?>" height="1" alt="transpixel"></td>
    </tr>
    <tr>
      <td bgcolor="<?php echo $borderColor ?>" width="<?php echo $borderWidth ?>"><img src="<?php echo $pixelImage ?>" width="<?php echo $borderWidth ?>" alt="transpixel"></td>
      <td align="center"><?php echo $href_tag ?></td>
      <td bgcolor="<?php echo $borderColor ?>" width="<?php echo $borderWidth ?>"><img src="<?php echo $pixelImage ?>" width="<?php echo $borderWidth ?>" height="1" alt="transpixel"></td>
    </tr>
    <tr bgcolor="<?php echo $borderColor ?>">
      <td colspan="3" height="<?php echo $borderWidth ?>"><img src="<?php echo $pixelImage ?>" width="<?php echo $borderWidth ?>" height="1" alt="transpixel"></td>
    </tr>
  </table>
  <?php
  break;
default: // use frames directory
  if (isset($base)) {
    $base = $base . "/html_wrap/frames/$frame";
  } else {
    $base = $gallery->app->photoAlbumURL . "/html_wrap/frames/$frame";
  }

  include (dirname(__FILE__) . "/frames/$frame/frame.def");
  // Safari/Opera ignore height="100%" for table, but this ensures HTML
  // standards, so do it for all browsers
  $hLL = $imageHeight - $heightLLT - $heightLLB;
  $hRR = $imageHeight - $heightRRT - $heightRRB;
  ?>

  <table width="1" border="0" cellspacing="0" cellpadding="0">
  <tr>
	<!-- TL -->
	<td width="<?php echo $widthTL ?>" height="<?php echo $heightTL ?>"><img src="<?php echo "$base/$imageTL" ?>" border="0" width="<?php echo $widthTL ?>" height="<?php echo $heightTL ?>" alt="FRAME"></td>
	<td><table width="100%" border="0" cellspacing="0" cellpadding="0">
	    <tr>
		<?php if ($widthTTL > 0) { ?>
		<!-- TTL -->
		<td width="<?php echo $widthTTL ?>"><img src="<?php echo "$base/$imageTTL" ?>" border="0" width="<?php echo $widthTTL ?>" height="<?php echo $heightTTL ?>" alt="FRAME"></td>
		<?php } ?>
		<!-- TT -->
		<td height="<?php echo $heightTT ?>" style="background-image:url(<?php echo "$base/$imageTT" ?>)"><img src="<?php echo $pixelImage ?>" border="0" width="1" height="1" alt="FRAME"></td>
		<?php if ($widthTTR > 0) { ?>
		<!-- TTR -->
		<td width="<?php echo $widthTTR ?>"><img src="<?php echo "$base/$imageTTR" ?>" border="0" width="<?php echo $widthTTR ?>" height="<?php echo $heightTTR ?>" alt="FRAME"></td>
		<?php } ?>
	    </tr>
	    </table></td>
	<!-- TR -->
	<td><img src="<?php echo "$base/$imageTR" ?>" border="0" width="<?php echo $widthTR ?>" height="<?php echo $heightTR ?>" alt="FRAME"></td>
  </tr>
  <tr>
	<td height="100%"><table border="0" cellspacing="0" cellpadding="0" style="height:<?php echo $hLL ?>px">
	    <?php if ($heightLLT > 0) { ?>
	    <!-- LLT -->
	    <tr>
		<td height="<?php echo $heightLLT ?>"><img src="<?php echo "$base/$imageLLT" ?>" border="0" width="<?php echo $widthLLT ?>" height="<?php echo $heightLLT ?>" alt="FRAME"></td>
	    </tr>
	    <?php } ?>
	    <tr>
		<!-- LL -->
		<td width="<?php echo $widthLL ?>" style="background-image:url(<?php echo "$base/$imageLL" ?>)"><img src="<?php echo $pixelImage ?>" border="0" width="1" height="<?php echo $hLL ?>" alt="FRAME"></td>
	    </tr>
	    <?php if ($heightLLB > 0) { ?>
	    <!-- LLB -->
	    <tr>
		<td height="<?php echo $heightLLB ?>"><img src="<?php echo "$base/$imageLLB" ?>" border="0" width="<?php echo $widthLLB ?>" height="<?php echo $heightLLB ?>" alt="FRAME"></td>
	    </tr>
	    <?php } ?>
	    </table></td>
	<td><table cellspacing="0" cellpadding="0">
	     <tr>
		<td align="center"><?php echo $href_tag ?></td>
	     </tr>
	    </table></td>
	<td height="100%"><table border="0" cellspacing="0" cellpadding="0" style="height:<?php echo $hRR ?>px">
	    <?php if ($heightRRT > 0) { ?>
	    <!-- RRT -->
	    <tr>
		<td height="<?php echo $heightRRT ?>"><img src="<?php echo "$base/$imageRRT" ?>" border="0" width="<?php echo $widthRRT ?>" height="<?php echo $heightRRT ?>" alt="FRAME"></td>
	    </tr>
	    <?php } ?>
	    <tr>
		<!-- RR -->
		<td width="<?php echo $widthRR ?>" style="background-image:url(<?php echo "$base/$imageRR" ?>)"><img src="<?php echo $pixelImage ?>" border="0" width="1" height="<?php echo $hRR ?>" alt="FRAME"></td>
	    </tr>
	    <?php if ($heightRRB > 0) { ?>
	    <tr>
		<!-- RRB -->
		<td height="<?php echo $heightRRB ?>"><img src="<?php echo "$base/$imageRRB" ?>" border="0" width="<?php echo $widthRRB ?>" height="<?php echo $heightRRB ?>" alt="FRAME"></td>
	    </tr>
	    <?php } ?>
	    </table></td>
  </tr>
  <tr>
	<!-- BL -->
	<td width="<?php echo $widthBL ?>" height="<?php echo $heightBL ?>"><img src="<?php echo "$base/$imageBL" ?>" border="0" width="<?php echo $widthBL ?>" height="<?php echo $heightBL ?>" alt="FRAME"></td>
	<td><table width="100%" border="0" cellspacing="0" cellpadding="0">
	    <tr>
		<?php if ($widthBBL > 0) { ?>
		<!-- BBL -->
		<td width="<?php echo $widthBBL ?>"><img src="<?php echo "$base/$imageBBL" ?>" border="0" width="<?php echo $widthBBL ?>" height="<?php echo $heightBBL ?>" alt="FRAME"></td>
		<?php } ?>
		<!-- BB -->
		<td height="<?php echo $heightBB ?>" style="background-image:url(<?php echo "$base/$imageBB" ?>)"><img src="<?php echo $pixelImage ?>" border="0" width="1" height="1" alt="FRAME"></td>
		<?php if ($widthBBR > 0) { ?>
		<!-- BBR -->
		<td width="<?php echo $widthBBR ?>"><img src="<?php echo "$base/$imageBBR" ?>" border="0" width="<?php echo $widthBBR ?>" height="<?php echo $heightBBR ?>" alt="FRAME"></td>
		<?php } ?>
	    </tr>
	    </table></td>
	<!-- BR -->
	<td><img src="<?php echo "$base/$imageBR" ?>" border="0" width="<?php echo $widthBR ?>" height="<?php echo $heightBR ?>" alt="FRAME"></td>
  </tr>
  </table>
<?php } // end of switch ?>
