<?php
class RCCWP_CustomWritePanel
{
	function AssignToRole($customWritePanelId, $roleName)
	{
		$customWritePanel = RCCWP_CustomWritePanel::Get($customWritePanelId);
		$capabilityName = $customWritePanel->capability_name;
		$role = get_role($roleName);
		$role->add_cap($capabilityName);	
	}
	
	function Create($name, $description = '', $standardFields = array(), $hiddenExtFields = array(), $categories = array(), $display_order = 1)
	{
		include_once('RC_Format.php');
		global $wpdb;
		
		$capabilityName = RCCWP_CustomWritePanel::GetCapabilityName($name);
		
		$sql = sprintf(
			"INSERT INTO " . RC_CWP_TABLE_WRITE_PANELS .
			" (name, description, display_order, capability_name)" .
			" values" .
			" (%s, %s, %d, %s)", 
			RC_Format::TextToSql($name), 
			RC_Format::TextToSql($description),
			$display_order,
			RC_Format::TextToSql($capabilityName) );
			
		$wpdb->query($sql);
		$customWritePanelId = $wpdb->insert_id;
		
		if (!isset($categories))
			$categories = array();
		foreach ($categories as $cat_id)
		{
			$sql = sprintf(
				"INSERT INTO " . RC_CWP_TABLE_PANEL_CATEGORY .
				" (panel_id, cat_id)" .
				" values (%d, %d)",
				$customWritePanelId,
				$cat_id 
				);
			$wpdb->query($sql);
		}
		
		if (!isset($standardFields))
			$standardFields = array();
		foreach ($standardFields as $standard_field_id)
		{
			$sql = sprintf(
				"INSERT INTO " . RC_CWP_TABLE_PANEL_STANDARD_FIELD .
				" (panel_id, standard_field_id)" .
				" values (%d, %d)",
				$customWritePanelId,
				$standard_field_id 
				);
			$wpdb->query($sql);
		}
		
		if (!empty($hiddenExtFields))
		{
			foreach ($hiddenExtFields as $css_id)
			{
				if ($css_id != '')
				{
					$sql = sprintf(
						"INSERT INTO " . RC_CWP_TABLE_PANEL_HIDDEN_EXTERNAL_FIELD .
						" (panel_id, css_id)" .
						" values (%d, %s)",
						$customWritePanelId,
						RC_Format::TextToSql($css_id)
						);
					
					$wpdb->query($sql);
				}
			}
		}
		
		return $customWritePanelId;
	}
	
	function Delete($customWritePanelId = null)
	{
		include_once ('RCCWP_CustomField.php');
		if (isset($customWritePanelId))
		{
			global $wpdb;
			
			$customWritePanel = RCCWP_Application::GetCustomWritePanels($customWritePanelId);
			$customFields = RCCWP_CustomWritePanel::GetCustomFields($customWritePanel->id);
			foreach ($customFields as $field) 
			{
				RCCWP_CustomField::Delete($field->id);
  			}
		  	
  			$sql = sprintf(
				"DELETE FROM " . RC_CWP_TABLE_WRITE_PANELS .
				" WHERE id = %d",
				$customWritePanel->id
				);
			$wpdb->query($sql);
			
			$sql = sprintf(
				"DELETE FROM " . RC_CWP_TABLE_PANEL_CATEGORY .
				" WHERE panel_id = %d",
				$customWritePanel->id
				);
			$wpdb->query($sql);
			
			$sql = sprintf(
				"DELETE FROM " . RC_CWP_TABLE_PANEL_STANDARD_FIELD .
				" WHERE panel_id = %d",
				$customWritePanelId
				);
			$wpdb->query($sql);
			
			$sql = sprintf(
				"DELETE FROM " . RC_CWP_TABLE_PANEL_HIDDEN_EXTERNAL_FIELD .
				" WHERE panel_id = %d",
				$customWritePanelId
				);
			$wpdb->query($sql);
		}
	}
	
	function Get($customWritePanelId)
	{
		global $wpdb;
	
		$sql = "SELECT id, name, description, display_order, capability_name FROM " . RC_CWP_TABLE_WRITE_PANELS .
			" WHERE id = " . (int)$customWritePanelId;
		
		$results = $wpdb->get_row($sql);
		
		return $results;
	}
	
	function GetAssignedCategoryIds($customWritePanelId)
	{
		$results = RCCWP_CustomWritePanel::GetAssignedCategories($customWritePanelId);
		$ids = array();
		foreach ($results as $r)
		{
			$ids[] = $r->cat_id;
		}
		
		return $ids;
	}
	
	function GetAssignedCategories($customWritePanelId)
	{
		global $wpdb;
		$sql = "SELECT rc.cat_id, cat_name FROM " . RC_CWP_TABLE_PANEL_CATEGORY . 
			" rc JOIN $wpdb->categories wp ON rc.cat_ID = wp.cat_ID" . 
			" WHERE panel_id = " . $customWritePanelId;
		$results = $wpdb->get_results($sql);
		if (!isset($results))
			$results = array();
		
		return $results;
	}
	
	function GetCapabilityName($customWritePanelName)
	{
		// copied from WP's sanitize_title_with_dashes($title) (formatting.php)
		$capabilityName = strip_tags($customWritePanelName);
		// Preserve escaped octets.
		$capabilityName = preg_replace('|%([a-fA-F0-9][a-fA-F0-9])|', '---$1---', $capabilityName);
		// Remove percent signs that are not part of an octet.
		$capabilityName = str_replace('%', '', $capabilityName);
		// Restore octets.
		$capabilityName = preg_replace('|---([a-fA-F0-9][a-fA-F0-9])---|', '%$1', $capabilityName);
   
		$capabilityName = remove_accents($capabilityName);
		if (seems_utf8($capabilityName)) 
		{
			if (function_exists('mb_strtolower')) 
			{
				$capabilityName = mb_strtolower($capabilityName, 'UTF-8');
			}
			$capabilityName = utf8_uri_encode($capabilityName, 200);
		}
   
		$capabilityName = strtolower($capabilityName);
		$capabilityName = preg_replace('/&.+?;/', '', $capabilityName); // kill entities
		$capabilityName = preg_replace('/[^%a-z0-9 _-]/', '', $capabilityName);
		$capabilityName = preg_replace('/\s+/', '_', $capabilityName);
		$capabilityName = preg_replace('|-+|', '_', $capabilityName);
		$capabilityName = trim($capabilityName, '_');
   
		return $capabilityName;
	}

	function GetCustomFields($customWritePanelId)
	{
		global $wpdb;
		$sql = "SELECT cf.id, cf.name, tt.name AS type, cf.description, cf.display_order, co.options, co.default_option AS default_value, tt.has_options, cp.properties, tt.has_properties, tt.allow_multiple_values FROM " . RC_CWP_TABLE_PANEL_CUSTOM_FIELD .
			" cf LEFT JOIN " . RC_CWP_TABLE_CUSTOM_FIELD_OPTIONS . " co ON cf.id = co.custom_field_id" .
			" LEFT JOIN " . RC_CWP_TABLE_CUSTOM_FIELD_PROPERTIES . " cp ON cf.id = cp.custom_field_id" .
			" JOIN " . RC_CWP_TABLE_CUSTOM_FIELD_TYPES . " tt ON cf.type = tt.id" . 
			" WHERE panel_id = " . $customWritePanelId .
			" ORDER BY cf.display_order";
		$results =$wpdb->get_results($sql);
		if (!isset($results))
			$results = array();
		
		for ($i = 0; $i < $wpdb->num_rows; ++$i)
		{
			$results[$i]->options = unserialize($results[$i]->options);
			$results[$i]->properties = unserialize($results[$i]->properties);
			$results[$i]->default_value = unserialize($results[$i]->default_value);
		}
		
		return $results;
	}
	
	function GetHiddenExternalFieldCssIds($customWritePanelId)
	{
		global $wpdb;
		$sql = "SELECT css_id FROM " . RC_CWP_TABLE_PANEL_HIDDEN_EXTERNAL_FIELD . 
			" WHERE panel_id = " . $customWritePanelId;
		$results = $wpdb->get_col($sql);
		if (!isset($results))
			$results = array();
		
		return $results;
	}
	
	function GetStandardFieldCssIds($customWritePanelId)
	{
		$results = RCCWP_CustomWritePanel::GetStandardFields($customWritePanelId);
		$ids = array();
		foreach ($results as $r)
		{
			$ids[] = $r->css_id; 
		}
		
		return $ids; 
	}
	
	function GetStandardFieldIds($customWritePanelId)
	{
		$results = RCCWP_CustomWritePanel::GetStandardFields($customWritePanelId);
		$ids = array();
		foreach ($results as $r)
		{
			$ids[] = $r->standard_field_id;
		}
		
		return $ids;
	}

	function GetStandardFields($customWritePanelId)
	{
		global $wpdb;
		$sql = "SELECT ps.standard_field_id, name, css_id FROM " . RC_CWP_TABLE_PANEL_STANDARD_FIELD . 
			" ps JOIN " . RC_CWP_TABLE_STANDARD_FIELDS . " sf ON ps.standard_field_id = sf.id" . 
			" WHERE panel_id = " . $customWritePanelId;
		$results = $wpdb->get_results($sql);
		if (!isset($results))
			$results = array();
		
		return $results;
	}
	
	function Update($customWritePanelId, $name, $description = '', $standardFields = array(), $hiddenExtFields = array(), $categories = array(), $display_order = 1)
	{
		include_once('RC_Format.php');
		global $wpdb;
		
		$capabilityName = RCCWP_CustomWritePanel::GetCapabilityName($name);
		
		$sql = sprintf(
			"UPDATE " . RC_CWP_TABLE_WRITE_PANELS .
			" SET name = %s" .
			" , description = %s" .
			" , display_order = %d" .
			" , capability_name = %s" .
			" where id = %d",
			RC_Format::TextToSql($name), 
			RC_Format::TextToSql($description),
			$display_order,
			RC_Format::TextToSql($capabilityName),
			$customWritePanelId );
		
		$wpdb->query($sql);
		
		if (!isset($categories) || empty($categories))
		{
			$sql = sprintf(
				"DELETE FROM " . RC_CWP_TABLE_PANEL_CATEGORY .
				" WHERE panel_id = %d",
				$customWritePanelId
				);
			
			$wpdb->query($sql);
		}
		else
		{
			$currentCategoryIds = array();
			$currentCategoryIds = RCCWP_CustomWritePanel::GetAssignedCategoryIds($customWritePanelId);
			
			$keepCategoryIds = array_intersect($currentCategoryIds, $categories);
			$deleteCategoryIds = array_diff($currentCategoryIds, $keepCategoryIds);
			$insertCategoryIds = array_diff($categories, $keepCategoryIds);
			
			foreach ($insertCategoryIds as $cat_id)
			{
				$sql = sprintf(
					"INSERT INTO " . RC_CWP_TABLE_PANEL_CATEGORY .
					" (panel_id, cat_id)" .
					" values (%d, %d)",
					$customWritePanelId,
					$cat_id 
					);
				$wpdb->query($sql);
			}
			
			if (!empty($deleteCategoryIds))
			{
				$sql = sprintf(
					"DELETE FROM " . RC_CWP_TABLE_PANEL_CATEGORY .
					" WHERE panel_id = %d" .
					" AND cat_id IN (%s)",
					$customWritePanelId,
					implode(',', $deleteCategoryIds)
					);
				
				$wpdb->query($sql);
			}
		}
		
		if (!isset($standardFields) || empty($standardFields))
		{			
			$sql = sprintf(
				"DELETE FROM " . RC_CWP_TABLE_PANEL_STANDARD_FIELD .
				" WHERE panel_id = %d",
				$customWritePanelId
				);
			$wpdb->query($sql);
		}
		else
		{
			$currentStandardFieldIds = array();
			$currentStandardFieldIds = RCCWP_CustomWritePanel::GetStandardFieldIds($customWritePanelId);
			
			$keepStandardFieldIds = array_intersect($currentStandardFieldIds, $standardFields);
			$deleteStandardFieldIds = array_diff($currentStandardFieldIds, $keepStandardFieldIds);
			$insertStandardFieldIds = array_diff($standardFields, $keepStandardFieldIds);
			
			foreach ($insertStandardFieldIds as $standard_field_id)
			{
				$sql = sprintf(
					"INSERT INTO " . RC_CWP_TABLE_PANEL_STANDARD_FIELD .
					" (panel_id, standard_field_id)" .
					" values (%d, %d)",
					$customWritePanelId,
					$standard_field_id 
					);
				$wpdb->query($sql);
			}
			
			if (!empty($deleteStandardFieldIds))
			{
				$sql = sprintf(
					"DELETE FROM " . RC_CWP_TABLE_PANEL_STANDARD_FIELD .
					" WHERE panel_id = %d" .
					" AND standard_field_id IN (%s)",
					$customWritePanelId,
					implode(',', $deleteStandardFieldIds)
					);
				
				$wpdb->query($sql);
			}
		}
		
		$sql = sprintf(
			"DELETE FROM " . RC_CWP_TABLE_PANEL_HIDDEN_EXTERNAL_FIELD .
			" WHERE panel_id = %d",
			$customWritePanelId
			);
		
		$wpdb->query($sql);
		
		if (!empty($hiddenExtFields))
		{
			foreach ($hiddenExtFields as $css_id)
			{
				if ($css_id != '')
				{
					$sql = sprintf(
						"INSERT INTO " . RC_CWP_TABLE_PANEL_HIDDEN_EXTERNAL_FIELD .
						" (panel_id, css_id)" .
						" values (%d, %s)",
						$customWritePanelId,
						RC_Format::TextToSql($css_id)
						);
					
					$wpdb->query($sql);
				}
			}
		}
	}
}
?>