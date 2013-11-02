<?php
/****************************************************************/
/* Usage :
$h = new pt_highslide ($main_url, $thumb_url, $main_text = '', $src_url = '' );

$h->set_borders ($outlineType='');
$h->set_title ($title);
$h->set_href_text($alt_text='');
$h->set_size ($objectWidth=0, $objectHeight=0);
$h->set_colors ($bgcolor, $hdcolor='', $ftcolor='');
$h->set_myclasshref ($myclasshref = '') {
$h->set_body ($body_text = '');
$h->set_bottom ($bottom_text = '', $bottom_url='');
$h->set_caption();

$return_str = $h->highslide_link($objectType, $so='');

/****************************************************************/
class pt_highslide {

	// The six parts of the code
	var $href_text = '';
	var $header;
	var $has_bottom=false;
	var $bottom='';
	var $has_caption=false;
	var $caption='';

	// The parameters
	var $objectType;
	var $ID;
	var $htmlID = 'html-';
	var $hrefID = 'href-';
	var $outlineType = "outlineType: 'drop-shadow'";
	var $align= "align: 'center'";
	var $align1= "position: 'center center'";
	var $align2= "targetX: 'hsanchor', targetY: 'hsanchor'";
	var $align3= "align: 'center'";
	var $align4= "";
	var $objectWidth = 0;
	var $objectHeight = 0;
	var $objectLoadTime = ", objectLoadTime: 'after'";
	var $contentId;
	var $bgcolor = '#FFF';
	var $hdcolor = '#FFF';
	var $ftcolor = '#FFF';
	var $move_text = '<a href="#" onclick="return false" class="highslide-move control control2">Move</a>';
	var $close_text = '<a href="#" onclick="return hs.close(this)" class="control">Close</a>';
	var $width = 0;
	var $height = 0;

	var $img_url;		// original image url
	var $thumb_url = '';	// thumbnail url
	var $link_url;		// if src_url empty, url to link thumbnail to. Otherwise, url to display.
	var $src_url = '';	// src url. url to link thumbnail to.
	
	var $title = '';
	var $alt_text = '';

	var $main_div;
	var $body='';
	var $padding = 'padding: 0;';
	var $myclass = 'highslide';
	var $contentclass = 'highslide-html-content';
	var $bottomclass = 'highslide-bottom';

	/****************************************************************/
	/* Constructor
	/****************************************************************/
	function pt_highslide (	$main_url,
                                $thumb_url,
                                $main_text = '',
                                $src_url = ''
                                ) {

		$this->ID 		= 'a'.mt_rand(0,10000);
		$this->htmlID		.= $this->ID;
		$this->hrefID		.= $this->ID;
		$this->href_ID		= $this->hrefID;
		$this->img_url 		= $main_url;
		$this->link_url 	= $main_url;
		$this->thumb_url 	= $thumb_url;
		$this->src_url 		= $src_url;
		$this->title 		= $main_text;
		$this->alt_text		= $main_text;
	}

	/****************************************************************/
	/* This chooses the border type and set the close/move text
	/****************************************************************/
	function set_borders ($outlineType='', $TopBorderStyle='') {
	
		if ($outlineType != '') $this->outlineType = "outlineType: '".$outlineType."'";
		if ($TopBorderStyle == '') {
			if ($outlineType == 'windows' || $outlineType == 'none') {
				$this->move_text = '';
				$this->close_text = '<a href="#" onclick="return hs.close(this)" class="controlw">';
				$this->close_text .= '<img src="'.POSTHUMB_ABSPATH.'images/icon_close.png" alt="Close" /></a>';
			}
	                else {
				$this->close_text = '<a href="#" onclick="return false" class="highslide-move control">Move</a>';
				$this->move_text = '<a href="#" onclick="return hs.close(this)" class="control">Close</a>';
	                }
                } elseif ($TopBorderStyle == 'windows') {
			$this->move_text = '';
			$this->close_text = '<a href="#" onclick="return hs.close(this)" class="controlw">';
			$this->close_text .= '<img src="'.POSTHUMB_ABSPATH.'images/icon_close.png" alt="Close" /></a>';
                
		} else {
			$this->close_text = '<a href="#" onclick="return false" class="highslide-move control">Move</a>';
			$this->move_text = '<a href="#" onclick="return hs.close(this)" class="control">Close</a>';
		}
                
	}
	/****************************************************************/
	/* This sets the title
	/****************************************************************/
	function set_title ($title) {
	
		$this->title = $title;
	}
	/****************************************************************/
	/* This sets the size of the frame
	/****************************************************************/
	function set_html_size ($width=0, $height=0) {
	
		$this->width 	= $width;
		$this->height 	= $height;
	}
	/****************************************************************/
	/* This sets the class of the content
	/****************************************************************/
	function set_content_class ($class='') {

		if ($class != '') $this->contentclass .= ' '.$class;
	}
	/****************************************************************/
	/* This sets the class of the content
	/****************************************************************/
	function set_href_ID ($ID='') {

		if ($ID != '') $this->href_ID .= ' '.$ID;
	}
	/****************************************************************/
	/* This sets the class of the content
	/****************************************************************/
	function set_bottom_class ($class='') {
		if ($class != '') $this->bottomclass .= ' '.$class;
	}
	/****************************************************************/
	/* this sets the display part, wether a thumbnail or a text
	/****************************************************************/
	function set_href_text ($alt_text='', $add_tags='') {
	
		if ($alt_text == '') $alt_text = __('Click to enlarge: ', 'post-thumb').$this->title;
		if ($this->thumb_url=='')
			$this->href_text = $alt_text;
		else
		{
			if ($this->width == 0) $tag_width = ''; else $tag_width = ' width="'.$this->width.'"';
			if ($this->height == 0) $tag_height = ''; else $tag_height = ' height="'.$this->height.'"';
			$this->href_text = "\n\t".'<img src="'.$this->thumb_url.'" alt="'.$this->title.'" title="'.$alt_text.'"'.$tag_width.$tag_height.' '.$add_tags.' />';
		}
		$this->href_text .= "\n".'</a>';
	}
	/****************************************************************/
	/* This sets the size of the frame
	/****************************************************************/
	function set_size ($objectWidth=0, $objectHeight=0) {
		$this->objectWidth 	= $objectWidth;
		$this->objectHeight 	= $objectHeight;
	}
	/****************************************************************/
	/* This sets the colors of the frame
	/****************************************************************/
	function set_colors ($bgcolor, $hdcolor='', $ftcolor='') {
		$this->bgcolor = $bgcolor;
		if ($hdcolor=='') $this->hdcolor= $bgcolor; else $this->hdcolor=$hdcolor;
		if ($ftcolor=='') $this->ftcolor= $bgcolor; else $this->ftcolor=$ftcolor;
	}
	/****************************************************************/
	/* This sets the content of the frame.
	/****************************************************************/
	function set_body ($body_text = '') {

		$this->has_body = true;
		$this->body = $body_text;
	}
	/****************************************************************/
	/* This sets the bottom part of the frame
	/****************************************************************/
	function set_bottom ($bottom_text = '', $bottom_url = '') {

		$this->has_bottom = true;
		$this->bottom = "\n\t".'<div class="'.$this->bottomclass.'" style="background-color: '.$this->ftcolor.'; ">';
		if ($bottom_url == '')
			$this->bottom .= "\n\t\t".'<small><i>'.$bottom_text.'</i></small>';
		else
        	        $this->bottom .= "\n\t\t".'<small><i><a href="'.$bottom_url.'" title="'.$bottom_text.'">'.$bottom_text.'</a></i></small>';
		$this->bottom .= "\n\t".'</div>';
	}
	/****************************************************************/
	/* this sets the caption (for overlay only)
	/****************************************************************/
	function set_caption ($caption_text = '') {

		$this->has_caption = true;
		if ($caption_text == '') $caption_text = $this->title;
		$this->caption ="\n".'<div class="highslide-caption" id="caption'.$this->ID.'">'.
                                "\n\t".$caption_text.
				"\n".'</div>';
	}
	/****************************************************************/
	/* this sets the caption (for overlay only)
	/****************************************************************/
	function set_myclasshref ($myclasshref = '') {

		if ($myclasshref != '') $this->myclass .= ' '.$myclasshref;
	}
	/****************************************************************/
	/* Returns html code
	/****************************************************************/
	function highslide_div($objectType='overlay', $so='', $event='onclick') {

		if ($objectType == 'swfObject')
			$this->padding = 'padding: 0 10px 10px 10px;';

		switch ($objectType) :
			case 'iframe' :
			case 'ajax' :
			case 'swfObject' :
			case 'html' :
				$this->highslide_main_div();
				$html_string = $this->main_div;
				break;
			default :
				$html_string = $this->caption;
                endswitch;

		return $html_string;
	}
	/****************************************************************/
	/* Returns html code
	/****************************************************************/
	function highslide_href($objectType='overlay', $so='', $event='onclick') {

		$href = $this->pt_highslide_href ($objectType, $so, $event);

		switch ($objectType) :
			case 'iframe' :
			case 'ajax' :
			case 'swfObject' :
			case 'html' :
				$html_string = $href.$this->href_text;
				break;
			default :
				$html_string = $href.$this->href_text;
                endswitch;

		return $html_string;
	}
	/****************************************************************/
	/* Returns html code
	/****************************************************************/
	function highslide_link($objectType='overlay', $so='', $event='onclick') {

		$href = $this->pt_highslide_href ($objectType, $so, $event);
		if ($objectType == 'swfObject')
			$this->padding = 'padding: 0 10px 10px 10px;';

		switch ($objectType) :
			case 'iframe' :
			case 'ajax' :
			case 'swfObject' :
			case 'html' :
				$this->highslide_main_div();
				$html_string = $href.$this->href_text.$this->main_div;
				break;
			default :
				$html_string = $href.$this->href_text.$this->caption;
                endswitch;

		return $html_string;
	}
	/****************************************************************/
	/* Sets the a tag part of the HS code
	/****************************************************************/
	function pt_highslide_href ($objectType, $so='', $event='onclick') {

		$var_caption = '';
		$href_ID='';
                switch ($objectType) :
			case 'iframe' :
			case 'ajax' :
				$link_url = $this->link_url;
				$expand = 'htmlExpand';
				$var_objectType = "objectType: '".$objectType."'";
				$var_contentId = ", contentId: 'html-".$this->ID."'";
				$outlineType = ', '.$this->outlineType;
				if ($this->align != '') $var_align = ', '.$this->align; else $var_align='';
				if ($this->src_url == '') $var_srcurl = pt_return_get($this->link_url); else $var_srcurl = $this->src_url;
				$var_srcurl = ", src: '".$var_srcurl."'";
				$var_objectWidth = ', objectWidth: '.$this->objectWidth;
				$var_objectHeight = ', objectHeight: '.$this->objectHeight;     // Check
				$var_allowSizeReduction = '';
				$var_objectLoadTime = $this->objectLoadTime;
				break;
			case 'swfObject' :
				$link_url = $this->link_url;
				$expand = 'htmlExpand';
				$var_objectType = 'swfObject: '.$so;
				$var_contentId = ", contentId: 'html-".$this->ID."'";
				$outlineType = ', '.$this->outlineType;
				if ($this->align != '') $var_align = ', '.$this->align; else $var_align='';
				$var_objectWidth = ', objectWidth: '.$this->objectWidth;
				$var_objectHeight = ', objectHeight: '.$this->objectHeight;    // Check
				$var_srcurl = '';
				$var_allowSizeReduction = ', allowSizeReduction: false';
				$var_objectLoadTime = $this->objectLoadTime;
				break;
			case 'html' :
				$link_url = '#';
				$href_ID = ' id="'.$this->href_ID.'" ';
				$expand = 'htmlExpand';
				$var_contentId = "contentId: 'html-".$this->ID."'";
				$outlineType = ', '.$this->outlineType;
				if ($this->align != '') $var_align = ', '.$this->align; else $var_align='';
				$var_objectType = '';
				$var_objectWidth = ', objectWidth: '.$this->objectWidth;
				$var_objectHeight = '';
				$var_srcurl = '';
				$var_allowSizeReduction = '';
				$var_objectLoadTime = '';
				break;
			default :
				$link_url = $this->img_url;
				$expand = 'expand';
				$var_contentId = '';
				$outlineType = $this->outlineType;
				if ($this->has_caption) {
					$var_caption = ", captionId: 'caption".$this->ID."'";
				}
				if ($this->align != '') $var_align = ', '.$this->align; else $var_align='';
				$var_objectType = '';
				$var_objectWidth = '';
				$var_objectHeight = '';
				$var_srcurl = '';
				$var_allowSizeReduction = '';
				$var_objectLoadTime = '';
                endswitch;

       		$this->htmlexpand='return hs.'.$expand.'(this, { '.
						$var_objectType.
						$var_contentId.
                				$outlineType.
						$var_caption.
                                        	$var_align.
                	                        $var_objectWidth.
                	                        $var_objectHeight.
                	                        $var_srcurl.
                	                        $var_allowSizeReduction.
						$var_objectLoadTime.
				'})';

		return	"\n".'<a href="'.$link_url.'" '.
				'title="'.$this->title.'" '.
				'class="'.$this->myclass.'" '.
				$href_ID.
                		$event.'="return hs.'.$expand.'(this, { '.
									$var_objectType.
									$var_contentId.
                	                				$outlineType.
									$var_caption.
                	                                        	$var_align.
                	                                        	$var_objectWidth.
                	                                        	$var_objectHeight.
                	                                        	$var_srcurl.
                	                                        	$var_allowSizeReduction.
									$var_objectLoadTime.
					'} )" '.
				'>';
	}
	/****************************************************************/
	/****************************************************************/
	function highslide_main_div ($so='') {
		$this->main_div = "\n".'<div class="'.$this->contentclass.'" id="html-'.$this->ID.'" style="width: '.$this->objectWidth.'px">';
		$this->main_div .= "\n\t".'<div class="highslide-move" style="background-color: '.$this->hdcolor.'; ">';
		$this->main_div .= "\n\t\t".$this->move_text;
		$this->main_div .= "\n\t\t".$this->close_text;
		$this->main_div .= "\n\t".'</div>';
		$this->main_div .= "\n\t".'<div class="highslide-body" style="'.$this->padding.'">'.$this->body.'</div>';
		$this->main_div .= $this->bottom;
		$this->main_div .= "\n".'</div>';
	}
}  // End of pt_highslide class

?>