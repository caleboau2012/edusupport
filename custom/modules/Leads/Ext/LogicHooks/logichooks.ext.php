<?php 
 //WARNING: The contents of this file are auto-generated


// Do not store anything in this file that is not part of the array or the hook version.  This file will	
// be automatically rebuilt in the future. 
if(!isset($hook_version) || empty($hook_version))
 	$hook_version = 1; 

if(!isset($hook_array) || !is_array($hook_array))
	$hook_array = array();

if(!isset($hook_array['after_save']) || !is_array($hook_array['after_save']))
	$hook_array['after_save'] = array();	

$hook_array['after_save'][] = Array(1, 'Leads Calls Relationship Saving', 'custom/modules/Leads/SaveLeadCallRelationship.php','SaveLeadCallRelationship', 'save_lead_call_Relationship');

?>