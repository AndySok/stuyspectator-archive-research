<?php
include_once('RC_Format.php');

class RCCWP_CustomField
{
	function Create($customWritePanelId, $name, $description, $order = 1, $type, $options = null, $default_value = null, $properties = null)
	{
		global $wpdb;
	
		$sql = sprintf(
			"INSERT INTO " . RC_CWP_TABLE_PANEL_CUSTOM_FIELD .
			" (panel_id, name, description, display_order, type) values (%d, %s, %s, %d, %d)",
			$customWritePanelId,
			RC_Format::TextToSql($name),
			RC_Format::TextToSql($description),
			$order,
			$type
			);
		$wpdb->query($sql);
		
		$customFieldId = $wpdb->insert_id;
		
		$field_type = RCCWP_CustomField::GetCustomFieldTypes($type);
		if ($field_type->has_options == "true")
		{
			$options = explode("\n", $options);
			array_walk($options, array(RC_Format, TrimArrayValues));
			
			$default_value = explode("\n", $default_value);
			array_walk($default_value, array(RC_Format, TrimArrayValues));
			
			$sql = sprintf(
				"INSERT INTO " . RC_CWP_TABLE_CUSTOM_FIELD_OPTIONS .
				" (custom_field_id, options, default_option) values (%d, %s, %s)",
				$customFieldId,
				RC_Format::TextToSql(serialize($options)),
				RC_Format::TextToSql(serialize($default_value))
				);	
			$wpdb->query($sql);	
		}
		
		if ($field_type->has_properties == "true")
		{
			$sql = sprintf(
				"INSERT INTO " . RC_CWP_TABLE_CUSTOM_FIELD_PROPERTIES .
				" (custom_field_id, properties) values (%d, %s)",
				$customFieldId,
				RC_Format::TextToSql(serialize($properties))
				);	
			$wpdb->query($sql);	
		}
	}
	
	function Delete($customFieldId = null)
	{
		global $wpdb;
		
		$customField = RCCWP_CustomField::Get($customFieldId);
		
		$sql = sprintf(
			"DELETE FROM " . RC_CWP_TABLE_PANEL_CUSTOM_FIELD .
			" WHERE id = %d",
			$customFieldId
			);
		$wpdb->query($sql);
		
		if ($customField->has_options == "true")
		{
			$sql = sprintf(
				"DELETE FROM " . RC_CWP_TABLE_CUSTOM_FIELD_OPTIONS .
				" WHERE custom_field_id = %d",
				$customFieldId
				);	
			$wpdb->query($sql);	
		}
	}
	
	function Get($customFieldId)
	{
		global $wpdb;
		$sql = "SELECT cf.id, cf.name, tt.name AS type, cf.description, cf.display_order, co.options, co.default_option AS default_value, tt.has_options, cp.properties, tt.has_properties, tt.allow_multiple_values FROM " . RC_CWP_TABLE_PANEL_CUSTOM_FIELD .
			" cf LEFT JOIN " . RC_CWP_TABLE_CUSTOM_FIELD_OPTIONS . " co ON cf.id = co.custom_field_id" .
			" LEFT JOIN " . RC_CWP_TABLE_CUSTOM_FIELD_PROPERTIES . " cp ON cf.id = cp.custom_field_id" .
			" JOIN " . RC_CWP_TABLE_CUSTOM_FIELD_TYPES . " tt ON cf.type = tt.id" . 
			" WHERE cf.id = " . $customFieldId;
		$results = $wpdb->get_row($sql);
			
		$results->options = unserialize($results->options);
		$results->properties = unserialize($results->properties);
		$results->default_value = unserialize($results->default_value);
		return $results;
	}
	
	function GetCustomFieldNames($customFieldTypeId = null)
	{
		$customFieldNames = array();
		$customFields = RCCWP_CustomField::GetCustomFieldTypes($customFieldTypeId);
		foreach ($customFields as $field)
		{
			$customFieldNames[] = $field->name;
		}
		
		return $customFieldNames;
	}
	
	function GetCustomFieldTypes($customFieldTypeId = null)
	{
		global $wpdb;
	
		if (isset($customFieldTypeId))
		{
			$sql = "SELECT id, name, description, has_options, has_properties, allow_multiple_values FROM " . RC_CWP_TABLE_CUSTOM_FIELD_TYPES .
				" WHERE id = " . (int)$customFieldTypeId;
			$results = $wpdb->get_row($sql);	
		}
		else
		{
			$sql = "SELECT id, name, description, has_options, has_properties, allow_multiple_values FROM " . RC_CWP_TABLE_CUSTOM_FIELD_TYPES;
			$results = $wpdb->get_results($sql);
			if (!isset($results))
				$results = array();
		}
		return $results;
	}
	
	function GetCustomFieldValue($postId, $customFieldName)
	{
		return get_post_meta($postId, $customFieldName, true);
	}
	
	function GetCustomFieldValues($postId, $customFieldName)
	{
		return get_post_meta($postId, $customFieldName, false);
	}
	
	function GetDefaultCustomFieldType()
	{
		return 'Textbox';
	}
	
	function GetOptions()
	{

	}

	function GetProperties()
	{

	}
	
	function Update($customFieldId, $name, $description, $order = 1, $type, $options = null, $default_value = null, $properties = null)
	{
		global $wpdb;
		
		$oldCustomField = RCCWP_CustomField::Get($customFieldId);
		
		if ($oldCustomField->name != $name)
		{
			$sql = sprintf(
				"UPDATE $wpdb->postmeta" .
				" SET meta_key = %s" .
				" WHERE meta_key = %s",
				RC_Format::TextToSql($name),
				RC_Format::TextToSql($oldCustomField->name)
				);
			
			$wpdb->query($sql);
		}
		
		$sql = sprintf(
			"UPDATE " . RC_CWP_TABLE_PANEL_CUSTOM_FIELD .
			" SET name = %s" .
			" , description = %s" .
			" , display_order = %d" .
			" , type = %d" .
			" WHERE id = %d",
			RC_Format::TextToSql($name),
			RC_Format::TextToSql($description),
			$order,
			$type,
			$customFieldId
			);
		$wpdb->query($sql);
		
		$field_type = RCCWP_CustomField::GetCustomFieldTypes($type);
		if ($field_type->has_options == "true")
		{
			$options = explode("\n", $options);
			array_walk($options, array(RC_Format, TrimArrayValues));
			
			$default_value = explode("\n", $default_value);
			array_walk($default_value, array(RC_Format, TrimArrayValues));
			
			$sql = sprintf(
				"INSERT INTO " . RC_CWP_TABLE_CUSTOM_FIELD_OPTIONS .
				" (custom_field_id, options, default_option) values (%d, %s, %s)" . 
				" ON DUPLICATE KEY UPDATE options = %s, default_option = %s",
				$customFieldId,
				RC_Format::TextToSql(serialize($options)),
				RC_Format::TextToSql(serialize($default_value)),
				RC_Format::TextToSql(serialize($options)),
				RC_Format::TextToSql(serialize($default_value))
				);	
			$wpdb->query($sql);	
		}
		else
		{
			$sql = sprintf(
				"DELETE FROM " . RC_CWP_TABLE_CUSTOM_FIELD_OPTIONS .
				" WHERE custom_field_id = %d",
				$customFieldId
				);
			$wpdb->query($sql);	
		}
		
		if ($field_type->has_properties == "true")
		{
			$sql = sprintf(
				"INSERT INTO " . RC_CWP_TABLE_CUSTOM_FIELD_PROPERTIES .
				" (custom_field_id, properties) values (%d, %s)" .
				" ON DUPLICATE KEY UPDATE properties = %s",
				$customFieldId,
				RC_Format::TextToSql(serialize($properties)),
				RC_Format::TextToSql(serialize($properties))
				);	
			$wpdb->query($sql);	
		}
		else
		{
			$sql = sprintf(
				"DELETE FROM " . RC_CWP_TABLE_CUSTOM_FIELD_PROPERTIES .
				" WHERE custom_field_id = %d",
				$customFieldId
				);
			$wpdb->query($sql);	
		}
	}
}
?>