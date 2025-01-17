<?php
##################################################################
class am_option_pages{
##################################################################

	var $options; 			// options passed by the option file
	var $pageinfo;			// pageifo passed by the option file
	var $table_bg_class;	// background color for tables, used to stripe
	var $database_options;	// already saved options
	var $grouped;			// variable to check if option items should be grouped
	var $saved_optionname; 	// option_name 
	
	
	//constructor
	function am_option_pages($options, $pageinfo)
	{	
	
		// set options and page variables
		$this->options = $options;
		$this->pageinfo = $pageinfo;
		$this->grouped = false;
		$this->make_data_available();
		
		
		// call method to create the sidebar menu items, if its not a child call it with higher priority
		$priority = 10;
		if(!$this->pageinfo['child']) $priority = 1;
		
		add_action('admin_menu', array(&$this, 'add_admin_menu'), $priority);
		
		if(isset($_GET['page']) && $_GET['page'] == $this->pageinfo['filename'])
		{	
			add_action('admin_head', array(&$this, 'admin_head_addition'));	
		}
	}
	
	
	// add stylesheet and javascript to the options page
	function admin_head_addition() 
	{	
		global $am_option;
		echo '<link rel="stylesheet" href="'. $am_option['url']['themeoptions_url'] . '/admin.css" type="text/css" />';
		echo '<script type="text/javascript" src="'.$am_option['url']['themeoptions_url'].'/supporting_scripts.js"></script>';
		
		wp_enqueue_script( 'common'); 
		wp_enqueue_script( 'jquery-color' ); 
		wp_print_scripts('editor'); 
		if (function_exists('add_thickbox')) add_thickbox(); 
			wp_print_scripts('media-upload'); 
		if (function_exists('wp_tiny_mce')) 
			wp_tiny_mce(); 
		
		wp_admin_css(); 
		wp_enqueue_script('utils'); 
		do_action('admin_print_styles-post-php'); 
		do_action('admin_print_styles');		
	}
	
	// function that creates the sidebar menus
	function add_admin_menu()
	{	
		global $am_themename;
		$top_level = $am_themename." ".__("Options",'neo_wdl');
		
		add_theme_page($top_level, $this->pageinfo['full_name'], 'edit_theme_options', $this->pageinfo['filename'], array(&$this, 'initialize'));
	}
	
	function make_data_available()
	{
		global $am_option;
		global $shortname;
		// save basic values into $am_options array, then overwrite it with retrieved options from database table if avaliable
		// add widgets if necessary
		foreach ($this->options as $option)
		{	
			if(isset($option['type']) && $option['type'] == 'boxes')
			{
				$this->add_widget($option);
			}
			
			if(isset($option['std']) && $option['std'])
			{
				$am_option_std[$this->pageinfo['optionname']][$option['id']] = $option['std'];
			}
		}
		
		$this->saved_optionname = $shortname."_".$this->pageinfo['optionname'];
		$am_option[$this->pageinfo['optionname']] = get_option($this->saved_optionname);
		
		$am_option[$this->pageinfo['optionname']] = array_merge((array)$am_option_std[$this->pageinfo['optionname']], (array)$am_option[$this->pageinfo['optionname']]);
		
		
		//htmlspecialchars decode the array for frontend use
		$am_option[$this->pageinfo['optionname']] = $this->htmlspecialchars_deep($am_option[$this->pageinfo['optionname']]);
	
	}
	
	//decode the whole options array with a recursive function
	function htmlspecialchars_deep($mixed, $quote_style = ENT_QUOTES, $charset = 'UTF-8')
	{
	    if (is_array($mixed) || is_object($mixed)) 
	    {
	        foreach($mixed as $key => $value) 
	        {
	            $mixed[$key] = $this->htmlspecialchars_deep($value, $quote_style, $charset);
	        }
	    } 
	    elseif (is_string($mixed)) 
	    {
	        $mixed = htmlspecialchars_decode($mixed, $quote_style);
	    }
	    
	    return $mixed;
	} 
	
	
	function initialize()
	{
		$this->get_save_options();
		$this->display();
	}
	
	// display options page	
	function display()
	{	

		echo '<div class="wrap">';
		echo '<div class="icon32" id="icon-options-general"><br/></div>';
		echo '<h2>'.$this->pageinfo['full_name'].' </h2>';
		echo '<form method="post" action="">';
		
		//calls the helping function based on value of 'type'
		foreach ($this->options as $option)
		{	
			$this->stripe();
			
			if (method_exists($this, $option['type']))
			{
				$this->$option['type']($option);
			}
		}
		echo '<div class="admin_submit"><p class="submit">';
		echo '<input type="hidden" value="1" name="save_my_options"/>';
		echo '<input type="submit" name="Submit" class="button-primary autowidth" value="Save Changes" /></p>';
		echo '<p class="reset">';
		echo '<input type="submit" name="Reset" class="button autowidth" value="Reset Changes" /></p></div>';
		echo '</form></div>';
	}
	
	function stripe()
	{	
		if($this->grouped === false)
		$this->table_bg_class = $this->table_bg_class == "" ? 'class="alternate"' : '';
	}
	
	function get_save_options()
	{
		$options = $newoptions  = get_option($this->saved_optionname);
		
		//reset update_option($saved_optionname, "");

		if ( isset($_POST['Reset']) && $_POST['Reset']== 'Reset Changes' ) 
		{
			$newoptions = '';
		}
		
		if ( isset($_POST['Submit']) && $_POST['Submit']== 'Save Changes' ) 
		{	
			echo '<div class="updated fade" id="message" style=""><p><strong>Settings saved.</strong></p></div>';
			//update_option($saved_optionname, "");
			foreach ($_POST as $key => $value)
			{	
				$value = stripslashes($value);
				
				$newoptions[$key] = htmlspecialchars($value, ENT_QUOTES,"UTF-8"); 
	
				//multiple cat "final" builder
				if (preg_match("/(\w+)(hidden)$/", $key, $result))
				{
					$loops = $newoptions[$key];
					$newoptions[$key] = 0;
					$final =  $result[1].'final';
					$newoptions[$final] = "";
					for($i = 0; $i < $loops; $i++)
					{
						$name = $result[1].$i;
						$newoptions[$name] = stripslashes($_POST[$name]);
						if($newoptions[$name] != "")
						{
							$newoptions[$key]++;
							
							$newoptions[$final] .= $newoptions[$name];
							if($i+2 < $loops)
							{
								$newoptions[$final] .=", ";
							}
						}		
					}
					$newoptions[$key]++;
				}
				
				if (preg_match("/^(matrix_)(page_)(\w+)(\d+)/", $key, $result))
				{
					$final_field_matrix = $result[1].$result[3].'final';
				}
				
			}
			
			//matrix divider
			if(isset($final_field_matrix))
				unset($newoptions[$final_field_matrix]);
			
			$save_matrix_count = 0;
			foreach ($newoptions as $key => $value) //check all fields
			{	
				if(isset($_POST['super_matrix_count']) && $save_matrix_count < $_POST['super_matrix_count']) // dont save fields that are to high
				{
					if (preg_match("/^(matrix_)(page_)(\w+)(\d+)/", $key, $result))
					{				
						foreach ($newoptions as $key2 => $value2)
						{	
							if (preg_match("/^(matrix_)(".$result[3].")(".$result[4].")_final/", $key2, $result2))
							{
								$newoptions[$final_field_matrix][$value] = $value2;
								$save_matrix_count++;
							}
						}		
					}
				}
			} 	
		}
			
		if ( $options != $newoptions ) 
		{
			$options = $newoptions;
			update_option($this->saved_optionname, $options);
		}
		
		if($options)
		{
			foreach ($options as $key => $value)
			{
				$options[$key] = empty($options[$key]) ? false : $options[$key];
			}
		}
	
		$this->database_options = $options;
	}
	
	
	function add_widget($values)
	{	
		for ($i = 1; $i <= $values['count']; $i++)
		{	
			if ( function_exists('register_sidebar') )
				register_sidebar(array(
				'name' => $values['widget'].' '.$i,
				'before_widget' => '<div id="%1$s" class="box_small box box'.$i.' widget %2$s">', 
				'after_widget' => '</div>', 
				'before_title' => '<h3 class="widgettitle">', 
				'after_title' => '</h3>', 
				));
		}
	}
	
	############################################################################################################################
	# Displaying helper functions:
	############################################################################################################################
	
	
	##############################################################
	# OPEN
	##############################################################
	function open($values)
	{
		if(!isset($values['desc'])) $values['desc'] = "";
		
		echo '<table class="widefat am_options">';
		echo '<thead><tr><th colspan="2">'.$values['desc'].'&nbsp;</th></tr></thead>';
	}
	
	##############################################################
	# CLOSE
	##############################################################
	function close($values)
	{
		echo '<tfoot><tr><th>&nbsp;</th><th>&nbsp;</th></tr></tfoot></table>';
	}

	##############################################################
	# GROUP
	##############################################################	
	function group($values)
	{	
		
		if($this->grouped === false)
		{
			$this->grouped = $this->table_bg_class;
			
			if($this->grouped === "" )
			{
				$this->table_bg_class = 'class="grouped"';
			}
			else
			{
				$this->table_bg_class = 'class="alternate grouped"';
			}
		}
		else
		{
			$this->table_bg_class = $this->table_bg_class == "" ? 'class="alternate"' : '';
			echo '<tr valign="top" '.$this->grouped.'>';
			echo '<td colspan="2" scope="row" class="no_height"></td></tr>';
			$this->grouped = false;
		}
	}

	##############################################################
	# TITLE
	##############################################################	
	function title($values)
	{
		echo '<h3>'.$values['name'].'</h3>';
		if (isset($values['desc'])) echo '<p>'.$values['desc'].'</p>';
	}

	##############################################################
	# TITLE_INSIDE
	##############################################################	
	function title_inside($values)
	{
		echo '<tr valign="top" '.$this->table_bg_class.'>';
		echo '<td colspan="2" scope="row"><h3>'.$values['name'].'</h3>';
		if (isset($values['desc'])) echo '<p>'.$values['desc'].'</p>';
		if (isset($values['id']) && $values['id']) echo '<input type="hidden" value="'.$values['std'].'" id="'.$values['id'].'" name="'.$values['id'].'"/>';
		echo '</td></tr>';
	}

	##############################################################
	# TEXTAREA
	##############################################################	
	function textarea($values)
	{
		if(isset($this->database_options[$values['id']])) $values['std'] = $this->database_options[$values['id']];
	
		echo '<tr valign="top" '.$this->table_bg_class.'>';
		echo '<th scope="row" width="200px">'.$values['name'].'</th>';
		echo '<td>'.$values['desc'].'<br/>';
		echo '<textarea name="'.$values['id'].'" cols="60" rows="7" id="'.$values['id'].'" style="width: 80%; font-size: 12px;" class="code">';
		echo $values['std'].'</textarea><br/>';
	    echo '<br/></td>';
		echo '</tr>';
	}
	
	##############################################################
	# WYSIWYG
	##############################################################	
	function wysiwyg($values)
	{
		if(isset($this->database_options[$values['id']])) $values['std'] = $this->database_options[$values['id']];
	
		echo '<tr valign="top" '.$this->table_bg_class.'>';
		echo '<th scope="row" width="200px">'.$values['name'].'</th>';
		echo '<td class="wysiwyg">'.$values['desc'].'<br/>'; 
		?> <script type="text/javascript">
			   /* <![CDATA[ */
			   jQuery(document).ready( function () { 
				   jQuery("#<?php echo $values['id']?>").addClass("mceEditor");
			   		if ( typeof( tinyMCE ) == "object" && typeof( tinyMCE.execCommand ) == "function" ) {
						tinyMCE.settings.theme_advanced_buttons1 += ",|,add_image,add_video,add_audio,add_media,|,code";	
			   			tinyMCE.execCommand("mceAddControl", false, "<?php echo $values['id']?>");
				   }
			   }); 
			   /* ]]> */
		</script>	<?php 
				   
		echo '<div style="display:none" >';
			do_action( 'media_buttons' ); 
		echo '</div>';
		echo '<textarea name="'.$values['id'].'" id="'.$values['id'].'">'.$values['std'];
			add_action('am_the_editor', 'the_editor', 10, 2);
		echo "</textarea>";
				   	
	    echo '<br/><br/></td>';
		echo '</tr>';
	}

	##############################################################
	# TEXT
	##############################################################	
	function text($values)
	{	
		if(isset($this->database_options[$values['id']])) $values['std'] = $this->database_options[$values['id']];
		
		echo '<tr valign="top" '.$this->table_bg_class.'>';
		echo '<th scope="row" width="200px">'.$values['name'].'</th>';
		echo '<td>'.$values['desc'].'<br/>';
		if(!isset($values['size']))
			$values['size'] = 20;
		echo '<input type="text" size="'.$values['size'].'" value="'.$values['std'].'" id="'.$values['id'].'" name="'.$values['id'].'"/>';
	    echo '<br/><br/></td>';
		echo '</tr>';
	}

	##############################################################
	# CHECKBOX
	##############################################################	
	function checkbox($values)
	{	
		if(isset($this->database_options[$values['id']]) && $this->database_options[$values['id']] == true) $checked = 'checked = "checked"'; 
		echo '<tr valign="top" '.$this->table_bg_class.'>';
		echo '<th scope="row" width="200px">'.$values['name'].'</th>';
		echo '<td><input class="am_check" type="checkbox" name="'.$values['id'].'" id="'.$values['id'].'" value="true"  '.$checked.' />';
		echo '<label for="'.$values['id'].'">'.$values['desc'].'</label><br/>';
	    echo '<br/></td>';
		echo '</tr>';
	}

	##############################################################
	# RADIO
	##############################################################	
	function radio($values)
	{	
		
		echo '<tr valign="top" '.$this->table_bg_class.'>';
		echo '<th scope="row" width="200px">'.$values['name'].'</th>';
		echo '<td>'.$values['desc'].'<br/>';
		
		$counter = 1;
		foreach($values['buttons'] as $radiobutton)
		{	
			$checked ="";
			if(isset($this->database_options[$values['id']])) 
			{
				if($this->database_options[$values['id']] == $counter)
				{
					$checked = 'checked = "checked"';
				}
			}
			else if(isset($values['std']) && $values['std'] == $counter) 
			{
				$checked = 'checked = "checked"';
			}
		
			echo '<p><input '.$checked.' type="radio" class="am_check" value="'.$counter.'" id="'.$values['id'].$counter.'" name="'.$values['id'].'"/>';
			echo '<label for="'.$values['id'].$counter.'">'.$radiobutton.'</label></p>';
			$counter++;
		}
		
	    echo '<br/></td>';
		echo '</tr>';
	}

	##############################################################
	# DROPDOWN
	##############################################################	
	function dropdown($values)
	{	
		if(!isset($this->database_options[$values['id']]) && isset($values['std'])) $this->database_options[$values['id']] = $values['std'];
				
		echo '<tr valign="top" '.$this->table_bg_class.'>';
		echo '<th scope="row" width="200px">'.$values['name'].'</th>';
		echo '<td>'.$values['desc'].'<br/>';
		
			if($values['subtype'] == 'page')
			{
				$select = 'Select page';
				$entries = get_pages('title_li=&orderby=name');
			}
			else if($values['subtype'] == 'cat')
			{
				$select = 'Select category';
				$entries = get_categories('title_li=&orderby=name&hide_empty=0');
			}
			else
			{	
				$select = 'Select...';
				$entries = $values['subtype'];
			}
		
			echo '<select class="postform" id="'. $values['id'] .'" name="'. $values['id'] .'"> ';
			echo '<option value="">'.$select .'</option>  ';

			foreach ($entries as $key => $entry)
			{
				if($values['subtype'] == 'page')
				{
					$id = $entry->ID;
					if($entry->post_parent==0)
						$title = $entry->post_title;
					else
						$title = get_the_title($entry->post_parent).': '.$entry->post_title;
				}
				else if($values['subtype'] == 'cat')
				{
					$id = $entry->term_id;
					if($entry->parent==0)
						$title = $entry->name;
					else
						$title = get_cat_name($entry->parent).': '.$entry->name;
				}
				else
				{
					$id = $entry;
					$title = $key;				
				}

				if ($this->database_options[$values['id']] == $id )
				{
					$selected = "selected='selected'";	
				}
				else
				{
					$selected = "";		
				}
				
				echo"<option $selected value='". $id."'>". $title."</option>";
			}
		
		echo '</select>';
		 
	    echo '<br/><br/></td>';
		echo '</tr>';
	}
	
	
	##############################################################
	# MULTI
	##############################################################	
	function multi($values)
	{
		echo '<tr valign="top" '.$this->table_bg_class.'>';
		echo '<th scope="row" width="200px">'.$values['name'].'</th>';
		echo '<td>'.$values['desc'].'<br/>';
		
		///////////////////
		echo '<div class="multiple_box">';
		$hidden_name = $values['id'].'_hidden';
		
		if($this->database_options[$hidden_name] == "" || $this->database_options[$hidden_name] == false) 
		{
			$this->database_options[$hidden_name] = 1;
		}
	
		for($i = 0; $i < $this->database_options[$hidden_name]; $i++)
		{
		
			if($values['subtype'] == 'page')
			{
				$select = 'Select additional page?';
				$entries = get_pages('title_li=&orderby=name');
			}
			else
			{
				$select = 'Select additional category?';
				$entries = get_categories('title_li=&orderby=name&hide_empty=0');
			} 

			echo '<select class="postform multiply_me disable_me" id="'. $values['id'] .'_'. $i .'" name="'. $values['id'] .'_'. $i .'"> ';
			echo '<option value="">'.$select .'</option>  ';

			foreach ($entries as $entry)
			{
				if($values['subtype'] == 'page')
				{
					$id = $entry->ID;
					if($entry->post_parent==0)
						$title = $entry->post_title;
					else
						$title = get_the_title($entry->post_parent).': '.$entry->post_title;
				}
				else
				{
					$id = $entry->term_id;
					if($entry->parent==0)
						$title = $entry->name;
					else
						$title = get_cat_name($entry->parent).': '.$entry->name;
				}
			
				if ($this->database_options[$values['id'] .'_'.$i] == $id )
				{
					$selected = "selected='selected'";	
				}
				else
				{
					$selected = "";		
				}
				
				echo"<option $selected value='". $id."'>". $title."</option>";
			}
		
		echo '</select>';
		} 
		
		if(isset($this->database_options[$hidden_name])) $values['std'] = $this->database_options[$hidden_name];

		echo '<input name="'.$hidden_name.'" class="'.$hidden_name.'" type="hidden" value="'.$this->database_options[$hidden_name].'" />';
		echo '</div>';
		
		echo '<br/> </td>';
		echo '</tr>'; 
		//////////////////
		
	    echo '<br/></td>';
		echo '</tr>';
	}
	
	##############################################################
	# BOXES
	##############################################################	
	function boxes($values)
	{
		for ($i = 1; $i <= $values['count']; $i++)
		{
			if ($i != 1) $this->stripe();
			
			echo '<tr valign="top" '.$this->table_bg_class.'>';
			echo '<th scope="row" width="200px">'.$values['name'].' '.$i.'</th><td>';
			echo $values['desc'].' '.$i;
			
			echo '<div class="how_to_populate">';
			
			//select box
			echo '<select name="'.$values['id'].$i.'_content" class="postform selector">';
			echo '<option value="">HTML (simple placeholder text gets applied) </option>';
			
			$s1 = $s2 = $s3 = '';
			if ($this->database_options[$values['id'].$i.'_content'] == 'post') 	$s1 = 'selected="selected"'; 
			if ($this->database_options[$values['id'].$i.'_content'] == 'page') 	$s2 = 'selected="selected"'; 
			if ($this->database_options[$values['id'].$i.'_content'] == 'widget') 	$s3 = 'selected="selected"'; 
		
			echo '<option '.$s1.' value="post">Post</option>';
			echo '<option '.$s2.' value="page">Page</option>';
			echo '<option '.$s3.' value="widget">Widget</option>';
					
			echo '</select><br/>';
			
			// 3 different dropdowns:
			
			//categories
			$s1 = $s2 = $s3 = '';
			if ($this->database_options[$values['id'].$i.'_content'] != "post") $s1 = "hidden";
			
			echo '<span class="selected_post '.$s1.'">';
			echo '<select class="postform" id="'.$values['id'].$i.'_content_post" name="'.$values['id'].$i.'_content_post">'; 
			echo '<option value="">Select post category</option>';
			
			$categories = get_categories('title_li=&orderby=name&hide_empty=0');
			foreach ($categories as $category)
			{
				
				if ($this->database_options[$values['id'].$i.'_content_post'] == $category->term_id)
				{
					$selected = "selected='selected'";	
				}
				else
				{
					$selected = "";		
				}
				
				echo "<option $selected value='". $category->term_id."'>". $category->name."</option>";
			}
			echo '</select> <br/></span>';
			
			//pages
			if ($this->database_options[$values['id'].$i.'_content'] != "page") $s2 = "hidden";	
			echo '<span class="selected_page '.$s2.'">';
			echo '<select class="postform" id="'.$values['id'].$i.'_content_page" name="'.$values['id'].$i.'_content_page">'; 
			echo '<option value="">Select page</option>';		
			
			$pages = get_pages('title_li=&orderby=name');
			foreach ($pages as $page)
			{
				if ($this->database_options[$values['id'].$i.'_content_page'] == $page->ID)
				{
					$selected = "selected='selected'";	
				}
				else
				{
					$selected = "";		
				}
				
				echo "<option $selected value='". $page->ID."'>". $page->post_title."</option>";
			}
			echo '</select> <br/></span>';
	
			//widgets
			if ($this->database_options[$values['id'].$i.'_content'] != "widget") $s3 = "hidden";	
			
			echo '<span class="selected_widget '.$s3.'">';
			echo 'Please save this page, then head over to the <a href="widgets.php">widget page</a> and add widgets to the <a href="widgets.php">"'.$values['widget'].' '.$i.' Widget Area"</a>';
			echo '</div><br/>';
				
		    echo '<br/>';
		    echo '<input type="hidden" name="'.$values['id'].'" value="'.$values['count'].'"';
			echo '</td></tr>';
		
		}
	}

##################################################################
} # end class
##################################################################
?>