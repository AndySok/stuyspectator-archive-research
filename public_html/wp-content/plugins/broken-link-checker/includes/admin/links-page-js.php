<script type='text/javascript'>

function alterLinkCounter(factor){
    var cnt = parseInt(jQuery('.current-link-count').eq(0).html());
    cnt = cnt + factor;
    jQuery('.current-link-count').html(cnt);
    
	if ( blc_is_broken_filter ){
		//Update the broken link count displayed beside the "Broken Links" menu
		var menuBubble = jQuery('span.blc-menu-bubble');
		if ( menuBubble.length > 0 ){
			cnt = parseInt(menuBubble.eq(0).html());
			cnt = cnt + factor;
			if ( cnt > 0 ){
				menuBubble.html(cnt);
			} else {
				menuBubble.parent().hide();
			}
		}
	}    
}

function replaceLinkId(old_id, new_id){
	var master = jQuery('#blc-row-'+old_id);
	
	master.attr('id', 'blc-row-'+new_id);
	master.find('.blc-link-id').html(new_id);
	
	var details_row = jQuery('#link-details-'+old_id);
	details_row.attr('id', 'link-details-'+new_id);
}

function reloadDetailsRow(link_id){
	var details_row = jQuery('#link-details-'+link_id);
	
	//Load up the new link info                     (so sue me)    
	details_row.find('td').html('<center><?php echo esc_js(__('Loading...' , 'broken-link-checker')); ?></center>').load(
		"<?php echo admin_url('admin-ajax.php'); ?>",
		{
			'action' : 'blc_link_details',
			'link_id' : link_id
		}
	);
}

jQuery(function($){
	
	//The details button - display/hide detailed info about a link
    $(".blc-details-button, td.column-link-text, td.column-status, td.column-new-link-text").click(function () {
    	var master = $(this).parents('.blc-row');
    	var link_id = master.attr('id').split('-')[2];
		$('#link-details-'+link_id).toggle();
    });

	var ajaxInProgressHtml = '<?php echo esc_js(__('Wait...', 'broken-link-checker')); ?>';
	
	//The "Not broken" button - manually mark the link as valid. The link will be checked again later.
	$(".blc-discard-button").click(function () {
		var me = $(this);
		me.html(ajaxInProgressHtml);
		
		var master = me.parents('.blc-row');
    	var link_id = master.attr('id').split('-')[2];
        
        $.post(
			"<?php echo admin_url('admin-ajax.php'); ?>",
			{
				'action' : 'blc_discard',
				'link_id' : link_id,
				'_ajax_nonce' : '<?php echo esc_js(wp_create_nonce('blc_discard'));  ?>'
			},
			function (data, textStatus){
				if (data == 'OK'){
					var details = $('#link-details-'+link_id);
					
					//Remove the "Not broken" action
					me.parent().remove();
					
					//Set the displayed link status to OK
					var classNames = master.attr('class');
					classNames = classNames.replace(/(^|\s)link-status-[^\s]+(\s|$)/, ' ') + ' link-status-ok';
					master.attr('class', classNames);
					
					//Flash the main row green to indicate success, then remove it if the current view
					//is supposed to show only broken links.
					flashElementGreen(master, function(){
						if ( blc_is_broken_filter ){
							details.remove();
							master.remove();
						} else {
							reloadDetailsRow(link_id);
						}
					});
					
					//Update the elements displaying the number of results for the current filter.
					if( blc_is_broken_filter ){
                    	alterLinkCounter(-1);
                    }
				} else {
					me.html('<?php echo esc_js(__('Not broken' , 'broken-link-checker'));  ?>');
					alert(data);
				}
			}
		);
		
		return false;
    });

	//The "Dismiss" button - hide the link from the "Broken" and "Redirects" filters, but still apply link tweaks and so on.
	$(".blc-dismiss-button").click(function () {
		var me = $(this);
		var oldButtonHtml = me.html();
		me.html(ajaxInProgressHtml);

		var master = me.closest('.blc-row');
		var link_id = master.attr('id').split('-')[2];
		var should_hide_link = (blc_current_base_filter == 'broken') || (blc_current_base_filter == 'redirects');

		$.post(
			"<?php echo admin_url('admin-ajax.php'); ?>",
			{
				'action' : 'blc_dismiss',
				'link_id' : link_id,
				'_ajax_nonce' : '<?php echo esc_js(wp_create_nonce('blc_dismiss'));  ?>'
			},
			function (data, textStatus){
				if (data == 'OK'){
					var details = $('#link-details-'+link_id);

					//Remove the "Dismiss" action
					me.parent().hide();

					//Flash the main row green to indicate success, then remove it if necessary.
					flashElementGreen(master, function(){
						if ( should_hide_link ){
							details.remove();
							master.remove();
						}
					});

					//Update the elements displaying the number of results for the current filter.
					if( should_hide_link ){
						alterLinkCounter(-1);
					}
				} else {
					me.html(oldButtonHtml);
					alert(data);
				}
			}
		);

		return false;
	});

	//The "Undismiss" button.
	$(".blc-undismiss-button").click(function () {
		var me = $(this);
		var oldButtonHtml = me.html();
		me.html(ajaxInProgressHtml);

		var master = me.closest('.blc-row');
		var link_id = master.attr('id').split('-')[2];
		var should_hide_link = (blc_current_base_filter == 'dismissed');

		$.post(
			"<?php echo admin_url('admin-ajax.php'); ?>",
			{
				'action' : 'blc_undismiss',
				'link_id' : link_id,
				'_ajax_nonce' : '<?php echo esc_js(wp_create_nonce('blc_undismiss'));  ?>'
			},
			function (data, textStatus){
				if (data == 'OK'){
					var details = $('#link-details-'+link_id);

					//Remove the action.
					me.parent().hide();

					//Flash the main row green to indicate success, then remove it if necessary.
					flashElementGreen(master, function(){
						if ( should_hide_link ){
							details.remove();
							master.remove();
						}
					});

					//Update the elements displaying the number of results for the current filter.
					if( should_hide_link ){
						alterLinkCounter(-1);
					}
				} else {
					me.html(oldButtonHtml);
					alert(data);
				}
			}
		);

		return false;
	});

	function flashElementGreen(element, callback) {
		var oldColor = element.css('background-color');
		element.animate({ backgroundColor: "#E0FFB3" }, 200).animate({ backgroundColor: oldColor }, 300, callback);
	}


	/**
	 * Display the inline link editor.
	 *
	 * @param {Number} link_id Link ID. The link must be visible in the current view.
	 */
	function showLinkEditor(link_id) {
		var master = $('#blc-row-' + link_id),
			editorId = 'blc-edit-row-' + link_id,
			editRow;

		//Get rid of all existing inline editors.
		master.closest('table').find('tr.blc-inline-editor').each(function() {
			hideLinkEditor($(this));
		});

		//Create an inline editor for this link.
		editRow = $('#blc-inline-edit-row').clone(true).attr('id', editorId);
		editRow.toggleClass('alternate', master.hasClass('alternate'));
		master.after(editRow);

		//Populate editor fields.
		var urlElement = master.find('a.blc-link-url');
		var urlInput = editRow.find('.blc-link-url-field').val(urlElement.attr('href'));

		var titleInput = editRow.find('.blc-link-text-field');
		var linkText = master.data('link-text'),
			canEditText = master.data('can-edit-text') == 1, //jQuery will convert a '1' to 1 (number) when reading a data attribute.
			canEditUrl = master.data('can-edit-url') == 1,
			noneText = '<?php echo esc_js(_x('(None)', 'link text', 'broken-link-checker')); ?>',
			multipleLinksText = '<?php echo esc_js(_x('(Multiple links)', 'link text', 'broken-link-checker')); ?>';

		titleInput.prop('readonly', !canEditText);
		urlInput.prop('readonly', !canEditUrl);

		if ( (typeof linkText !== 'undefined') && (linkText !== null) ) {
			if (linkText === '') {
				titleInput.val(canEditText ? linkText : noneText);
			} else {
				titleInput.val(linkText)
			}
			titleInput.prop('placeholder', noneText);
		} else {
			if (canEditText) {
				titleInput.val('').prop('placeholder', multipleLinksText);
			} else {
				titleInput.val(multipleLinksText)
			}
		}

		//Populate the list of URL replacement suggestions.
		if (canEditUrl && blc_suggestions_enabled && (master.hasClass('link-status-error') || master.hasClass('link-status-warning'))) {
			editRow.find('.blc-url-replacement-suggestions').show();
			var suggestionList = editRow.find('.blc-suggestion-list');
			findReplacementSuggestions(urlElement.attr('href'), suggestionList);
		}

		editRow.find('.blc-update-link-button').prop('disabled', !(canEditUrl || canEditText));

		//Make the editor span the entire width of the table.
		editRow.find('td.blc-colspan-change').attr('colspan', master.closest('table').find('thead th:visible').length);

		master.hide();
		editRow.show();
		urlInput.focus();
		if (canEditUrl) {
			urlInput.select();
		}
	}

    /**
     * Hide the inline editor for a particular link.
	 *
	 * @param link_id Either a numeric link ID or a jQuery object that represents the editor row.
     */
	function hideLinkEditor(link_id) {
		var editRow = isNaN(link_id) ? link_id : $('#blc-edit-row-' + link_id);
		editRow.prev('tr.blc-row').show();
		editRow.remove();
	}

    /**
	 * Find possible replacements for a broken link and display them in a list.
     *
	 * @param {String} url The current link URL.
	 * @param suggestionList jQuery object that represents a list element.
     */
	function findReplacementSuggestions(url, suggestionList) {
		var searchingText     = '<?php echo esc_js(_x('Searching...', 'link suggestions', 'broken-link-checker')) ?>';
		var noSuggestionsText = '<?php echo esc_js(_x('No suggestions available.', 'link suggestions', 'broken-link-checker')) ?>';
		var iaSuggestionName  = '<?php echo esc_js(_x('Archived page from %s (via the Wayback Machine)', 'link suggestions', 'broken-link-checker')); ?>';

		suggestionList.empty().append('<li>' + searchingText + '</li>');

		var suggestionTemplate = $('#blc-suggestion-template').find('li').first();

		//Check the Wayback Machine for an archived version of the page.
		$.getJSON(
			'http://archive.org/wayback/available?callback=?',
			{ url: url },

			function(data) {
				suggestionList.empty();

				//Check if there are any results.
				if (!data || !data.archived_snapshots || !data.archived_snapshots.closest || !data.archived_snapshots.closest.available ) {
					suggestionList.append('<li>' + noSuggestionsText + '</li>');
					return;
				}

				var snapshot = data.archived_snapshots.closest;

				//Convert the timestamp from YYYYMMDDHHMMSS to ISO 8601 date format.
				var readableTimestamp = snapshot.timestamp.substr(0, 4) +
					'-' + snapshot.timestamp.substr(4, 2) +
					'-'	+ snapshot.timestamp.substr(6, 2);
				var name = sprintf(iaSuggestionName, readableTimestamp);

				//Display the suggestion.
				var item = suggestionTemplate.clone();
				item.find('.blc-suggestion-name a').text(name).attr('href', snapshot.url);
				item.find('.blc-suggestion-url').text(snapshot.url);
				suggestionList.append(item);
			}
		);
	}

    /**
     * Call our PHP backend and tell it to edit all occurrences of particular link.
	 * Updates UI with the new link info and displays any error messages that might be generated.
	 *
	 * @param linkId Either a numeric link ID or a jQuery object representing the link row.
     * @param {String} newUrl The new link URL.
     * @param {String} newText The new link text. Optional. Set to null to leave it unchanged.
     */
	function updateLink(linkId, newUrl, newText) {
		var master, editRow;
		if ( isNaN(linkId) ){
			master = linkId;
			linkId = master.attr('id').split("-")[2]; //id="blc-row-$linkid"
		} else {
			master = $('#blc-row-' + linkId);
		}
		editRow = $('#blc-edit-row-' + linkId);

		var urlElement = master.find('a.blc-link-url');
		var progressIndicator = editRow.find('.waiting'),
			updateButton = editRow.find('.blc-update-link-button');
		progressIndicator.show();
		updateButton.prop('disabled', true);

		$.post(
			'<?php echo admin_url('admin-ajax.php'); ?>',
			{
				'action'   : 'blc_edit',
				'link_id'  : linkId,
				'new_url'  : newUrl,
				'new_text' : newText,
				'_ajax_nonce' : '<?php echo esc_js(wp_create_nonce('blc_edit'));  ?>'
			},
			function(response) {
				progressIndicator.hide();
				updateButton.prop('disabled', false);

				if (response && (typeof(response['error']) != 'undefined')){
					//An internal error occurred before the link could be edited.
					alert(response.error);
				} else if (response.errors.length > 0) {
					//Build and display an error message.
					var msg = '';

					if ( response.cnt_okay > 0 ){
						var fragment = sprintf(
							'<?php echo esc_js(__('%d instances of the link were successfully modified.', 'broken-link-checker')); ?>',
							response.cnt_okay
						);
						msg = msg + fragment + '\n';
						if ( response.cnt_error > 0 ){
							fragment = sprintf(
								'<?php echo esc_js(__("However, %d instances couldn't be edited and still point to the old URL.", 'broken-link-checker')); ?>',
								response.cnt_error
							);
							msg = msg + fragment + "\n";
						}
					} else {
						msg = msg + '<?php echo esc_js(__('The link could not be modified.', 'broken-link-checker')); ?>\n';
					}

					msg = msg + '\n<?php echo esc_js(__("The following error(s) occurred :", 'broken-link-checker')); ?>\n* ';
					msg = msg + response.errors.join('\n* ');

					alert(msg);
				} else {
					//Everything went well. Update the link row with the new values.

					//Replace the displayed link URL with the new one.
					urlElement.attr('href', response.url).text(response.url);

					//Save the new ID
					replaceLinkId(linkId, response.new_link_id);
					//Load up the new link info
					reloadDetailsRow(response.new_link_id);

					//Update the link text if it was edited.
					if ((newText !== null) && (response.link_text !== null)) {
						master.data('link-text', response.link_text);
						if (response.ui_link_text !== null) {
							master.find('.column-new-link-text').html(response.ui_link_text);
						}
					}

					//Update the status code and class.
					var statusColumn = master.find('td.column-status');
					if (response.status_text) {
						statusColumn.find('.status-text').text(response.status_text);
					}
					statusColumn.find('.http-code').text(response.http_code ? response.http_code : '');

					var oldStatusClass = master.attr('class').match(/(?:^|\s)(link-status-[^\s]+)(?:\s|$)/);
					oldStatusClass = oldStatusClass ? oldStatusClass[1] : '';
					var newStatusClass = 'link-status-' + response.status_code;

					statusColumn.find('.link-status-row').removeClass(oldStatusClass).addClass(newStatusClass);
					master.removeClass(oldStatusClass).addClass(newStatusClass);

					//Last check time and failure duration are complicated to update, so we'll just hide them.
					//The user can refresh the page to get the new values.
					statusColumn.find('.link-last-checked td').html('&nbsp;');
					statusColumn.find('.link-broken-for td').html('&nbsp;');

					//We don't know if the link is still a redirect.
					master.removeClass('blc-redirect');

					//Flash the row green to indicate success
					flashElementGreen(master);
				}

				hideLinkEditor(editRow);
			},
			'json'
		);

	}

    //The "Edit URL" button - displays the inline editor
    $(".blc-edit-button").click(function () {
		var master = $(this).closest('.blc-row');
    	var link_id = master.attr('id').split('-')[2];
        showLinkEditor(link_id);
    });
    
    //Let the user use Enter and Esc as shortcuts for "Update" and "Cancel"
    $('.blc-inline-editor input[type="text"]').keypress(function (e) {
		var editRow = $(this).closest('.blc-inline-editor');
		if (e.which == 13) {
			editRow.find('.blc-update-link-button').click();
			return false;
		} else if (e.which == 27) {
			editRow.find('.blc-cancel-button').click();
			return false;
		}
		return true;
	});


	//The "Update" button in the inline editor.
	$('.blc-update-link-button').click(function() {
		var editRow = $(this).closest('tr'),
			master = editRow.prev('.blc-row');

		//Ensure the new URL is not empty.
		var urlField = editRow.find('.blc-link-url-field');
		var newUrl = urlField.val();
		if ($.trim(newUrl) == '') {
			alert('<?php echo esc_js(__('Error: Link URL must not be empty.', 'broken-link-checker')); ?>');
			urlField.focus();
			return;
		}

		var newLinkText = null,
			linkTextField = editRow.find('.blc-link-text-field');
		if (!linkTextField.prop('readonly')) {
			newLinkText = linkTextField.val();
			//Empty text = leave the text unchanged.
			if (newLinkText == '') {
				newLinkText = null;
			}
		}

		updateLink(master, newUrl, newLinkText);
	});

    //The "Cancel" in the inline editor.
    $(".blc-cancel-button").click(function () { 
		var editRow = $(this).closest('tr');
		hideLinkEditor(editRow);
    });

	//The "Use this URL" button in the inline editor replaces the link URL
	//with the selected suggestion URL.
	$('#blc-links').on('click', '.blc-use-url-button', function() {
		var button = $(this);
		var suggestionUrl = button.closest('tr').find('.blc-suggestion-name a').attr('href');
		button.closest('.blc-inline-editor').find('.blc-link-url-field').val(suggestionUrl);
	});


    //The "Unlink" button - remove the link/image from all posts, custom fields, etc.
    $(".blc-unlink-button").click(function () { 
    	var me = this;
    	var master = $(me).parents('.blc-row');
		$(me).html('<?php echo esc_js(__('Wait...' , 'broken-link-checker')); ?>');
		
		//Find the link ID
    	var link_id = master.attr('id').split('-')[2];
        
        $.post(
			"<?php echo admin_url('admin-ajax.php'); ?>",
			{
				'action' : 'blc_unlink',
				'link_id' : link_id,
				'_ajax_nonce' : '<?php echo esc_js(wp_create_nonce('blc_unlink'));  ?>'
			},
			function (data, textStatus){
				eval('data = ' + data);
				 
				if ( data && (typeof(data['error']) != 'undefined') ){
					//An internal error occured before the link could be edited.
					//data.error is an error message.
					alert(data.error);
				} else {
					if ( data.errors.length == 0 ){
						//The link was successfully removed. Hide its details. 
						$('#link-details-'+link_id).hide();
						//Flash the main row green to indicate success, then hide it.
						var oldColor = master.css('background-color');
						master.animate({ backgroundColor: "#E0FFB3" }, 200).animate({ backgroundColor: oldColor }, 300, function(){
							master.hide();
						});
						
						alterLinkCounter(-1);
						
						return;
					} else {
						//Build and display an error message.
						var msg = '';
						
						if ( data.cnt_okay > 0 ){
							msg = msg + sprintf(
								'<?php echo esc_js(__("%d instances of the link were successfully unlinked.", 'broken-link-checker')); ?>\n', 
								data.cnt_okay
							);
							
							if ( data.cnt_error > 0 ){
								msg = msg + sprintf(
									'<?php echo esc_js(__("However, %d instances couldn't be removed.", 'broken-link-checker')); ?>\n',
									data.cnt_error
								);
							}
						} else {
							msg = msg + '<?php echo esc_js(__("The plugin failed to remove the link.", 'broken-link-checker')); ?>\n';
						}
														
						msg = msg + '\n<?php echo esc_js(__("The following error(s) occured :", 'broken-link-checker')); ?>\n* ';
						msg = msg + data.errors.join('\n* ');
						
						//Show the error message
						alert(msg);
					}				
				}
				
				$(me).html('<?php echo esc_js(__('Unlink' , 'broken-link-checker')); ?>'); 
			}
		);
    });
    
    //--------------------------------------------
    //The search box(es)
    //--------------------------------------------
    
    var searchForm = $('#search-links-dialog');
	    
    searchForm.dialog({
		autoOpen : false,
		dialogClass : 'blc-search-container',
		resizable: false
	});
    
    $('#blc-open-search-box').click(function(){
    	if ( searchForm.dialog('isOpen') ){
			searchForm.dialog('close');
		} else {
			//Display the search form under the "Search" button
	    	var button_position = $('#blc-open-search-box').offset();
	    	var button_height = $('#blc-open-search-box').outerHeight(true);
	    	var button_width = $('#blc-open-search-box').outerWidth(true);
	    	
			var dialog_width = searchForm.dialog('option', 'width');
						
	    	searchForm.dialog('option', 'position', 
				[ 
					button_position.left - dialog_width + button_width/2, 
					button_position.top + button_height + 1 - $(document).scrollTop()
				]
			);
			searchForm.dialog('open');
		}
	});
	
	$('#blc-cancel-search').click(function(){
		searchForm.dialog('close');
	});
	
	//The "Save This Search Query" button creates a new custom filter based on the current search
	$('#blc-create-filter').click(function(){
		var filter_name = prompt("<?php echo esc_js(__("Enter a name for the new custom filter", 'broken-link-checker')); ?>", "");
		if ( filter_name ){
			$('#blc-custom-filter-name').val(filter_name);
			$('#custom-filter-form').submit();
		}
	});
	
	//Display a confirmation dialog when the user clicks the "Delete This Filter" button 
	$('#blc-delete-filter').click(function(){
		var message = '<?php
		echo esc_js(
			__("You are about to delete the current filter.\n'Cancel' to stop, 'OK' to delete", 'broken-link-checker')
		);
		?>';
		return confirm(message);
	});
	
	//--------------------------------------------
    // Bulk actions
    //--------------------------------------------
    
    $('#blc-bulk-action-form').submit(function(){
    	var action = $('#blc-bulk-action').val(), message;
    	if ( action ==  '-1' ){
			action = $('#blc-bulk-action2').val();
		}
    	
    	if ( action == 'bulk-delete-sources' ){
    		//Convey the gravitas of deleting link sources.
    		message = '<?php
				echo esc_js(  
					__("Are you sure you want to delete all posts, bookmarks or other items that contain any of the selected links? This action can't be undone.\n'Cancel' to stop, 'OK' to delete", 'broken-link-checker')
				); 
			?>'; 
			if ( !confirm(message) ){
				return false;
			}
		} else if ( action == 'bulk-unlink' ){
			//Likewise for unlinking.
			message = '<?php
				echo esc_js(  
					__("Are you sure you want to remove the selected links? This action can't be undone.\n'Cancel' to stop, 'OK' to remove", 'broken-link-checker')
				); 
			?>'; 
			if ( !confirm(message) ){
				return false;
			}
		}
	});
	
	//------------------------------------------------------------
    // Manipulate highlight settings for permanently broken links
    //------------------------------------------------------------
    var highlight_permanent_failures_checkbox = $('#highlight_permanent_failures');
	var failure_duration_threshold_input = $('#failure_duration_threshold');
	
    //Apply/remove highlights when the checkbox is (un)checked
    highlight_permanent_failures_checkbox.change(function(){
    	//save_highlight_settings();
    	
		if ( this.checked ){
			$('#blc-links tr.blc-permanently-broken').addClass('blc-permanently-broken-hl');
		} else {
			$('#blc-links tr.blc-permanently-broken').removeClass('blc-permanently-broken-hl');
		}
	});
	
	//Apply/remove highlights when the duration threshold is changed.
	failure_duration_threshold_input.change(function(){
		var new_threshold = parseInt($(this).val());
		//save_highlight_settings();
		if (isNaN(new_threshold) || (new_threshold < 1)) {
			return;
		}
		
		highlight_permanent_failures = highlight_permanent_failures_checkbox.is(':checked');
		
		$('#blc-links tr.blc-row').each(function(index){
			var days_broken = $(this).attr('data-days-broken');
			if ( days_broken >= new_threshold ){
				$(this).addClass('blc-permanently-broken');
				if ( highlight_permanent_failures ){
					$(this).addClass('blc-permanently-broken-hl');
				}
			} else {
				$(this).removeClass('blc-permanently-broken').removeClass('blc-permanently-broken-hl');
			}
		});
	});
	
	//Show/hide table columns dynamically
	$('#blc-column-selector input[type="checkbox"]').change(function(){
		var checkbox = $(this);
		var column_id = checkbox.attr('name').split(/\[|\]/)[1];
		if (checkbox.is(':checked')){
			$('td.column-'+column_id+', th.column-'+column_id, '#blc-links').removeClass('hidden');
		} else {
			$('td.column-'+column_id+', th.column-'+column_id, '#blc-links').addClass('hidden');
		}
		
		//Recalculate colspan's for detail rows to take into account the changed number of 
		//visible columns. Otherwise you can get some ugly layout glitches.
		$('#blc-links tr.blc-link-details td').attr(
			'colspan', 
			$('#blc-column-selector input[type="checkbox"]:checked').length+1
		);
	});
	
	//Unlike other fields in "Screen Options", the links-per-page setting 
	//is handled using straight form submission (POST), not AJAX.
	$('#blc-per-page-apply-button').click(function(){
		$('#adv-settings').submit();	
	});
	
	$('#blc_links_per_page').keypress(function(e){
		if ((e.which && e.which == 13) || (e.keyCode && e.keyCode == 13)) {
			$('#adv-settings').submit();
		}	
	});
	
	//Toggle status code colors when the corresponding checkbox is toggled
	$('#table_color_code_status').click(function(){
		if ( $(this).is(':checked') ){
			$('#blc-links').addClass('color-code-link-status');
		} else {
			$('#blc-links').removeClass('color-code-link-status');
		}
	});
	
	//Show the bulk edit/find & replace form when the user applies the appropriate bulk action 
	$('#doaction, #doaction2').click(function(e){
		var n = $(this).attr('id').substr(2);
		if ( $('select[name="'+n+'"]').val() == 'bulk-edit' ) {
			e.preventDefault();
			//Any links selected?
			if ($('tbody th.check-column input:checked').length > 0){
				$('#bulk-edit').show();
			}
		}
	});
	
	//Hide the bulk edit/find & replace form when "Cancel" is clicked
	$('#bulk-edit .cancel').click(function(){
		$('#bulk-edit').hide();
		return false;
	});
	
	//Minimal input validation for the bulk edit form
	$('#bulk-edit input[type="submit"]').click(function(e){
		if( $('#bulk-edit input[name="search"]').val() == '' ){
			alert('<?php echo esc_js(__('Enter a search string first.', 'broken-link-checker')); ?>');
			$('#bulk-edit input[name="search"]').focus();
			e.preventDefault();
			return;
		}
		
		if ($('tbody th.check-column input:checked').length == 0){
			alert('<?php echo esc_js(__('Select one or more links to edit.', 'broken-link-checker')); ?>');
			e.preventDefault();
		}
	});
});

</script>