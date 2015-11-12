<?php 
 //WARNING: The contents of this file are auto-generated


/**
 * Created by JetBrains PhpStorm.
 * User: andrew
 * Date: 01/03/13
 * Time: 15:13
 * To change this template use File | Settings | File Templates.
 */

$dictionary['Call']['fields']['reschedule_history'] = array(

    'required' => false,
    'name' => 'reschedule_history',
    'vname' => 'LBL_RESCHEDULE_HISTORY',
    'type' => 'varchar',
    'source' => 'non-db',
    'studio' => 'visible',
    'massupdate' => 0,
    'importable' => 'false',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => 0,
    'audited' => false,
    'reportable' => false,
    'function' =>
    array (
        'name' => 'reschedule_history',
        'returns' => 'html',
        'include' => 'custom/modules/Calls/reschedule_history.php'
    ),
);

$dictionary['Call']['fields']['reschedule_count'] = array(

    'required' => false,
    'name' => 'reschedule_count',
    'vname' => 'LBL_RESCHEDULE_COUNT',
    'type' => 'varchar',
    'source' => 'non-db',
    'studio' => 'visible',
    'massupdate' => 0,
    'importable' => 'false',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => 0,
    'audited' => false,
    'reportable' => false,
    'function' =>
    array (
        'name' => 'reschedule_count',
        'returns' => 'html',
        'include' => 'custom/modules/Calls/reschedule_history.php'
    ),
);

// created: 2010-12-20 02:55:45
$dictionary["Call"]["fields"]["calls_reschedule"] = array (
    'name' => 'calls_reschedule',
    'type' => 'link',
    'relationship' => 'calls_reschedule',
    'module'=>'Calls_Reschedule',
    'bean_name'=>'Calls_Reschedule',
    'source'=>'non-db',
);


// created: 2010-12-20 02:56:01
$dictionary["Call"]["relationships"]["calls_reschedule"] = array (
    'lhs_module'=> 'Calls',
    'lhs_table'=> 'calls',
    'lhs_key' => 'id',
    'rhs_module'=> 'Calls_Reschedule',
    'rhs_table'=> 'calls_reschedule',
    'rhs_key' => 'call_id',
    'relationship_type'=>'one-to-many',
);




$dictionary['Call']['fields']['SecurityGroups'] = array (
  	'name' => 'SecurityGroups',
    'type' => 'link',
	'relationship' => 'securitygroups_calls',
	'module'=>'SecurityGroups',
	'bean_name'=>'SecurityGroup',
    'source'=>'non-db',
	'vname'=>'LBL_SECURITYGROUPS',
);






	if(!defined('sugarEntry') || !sugarEntry) die("Not A Valid Entry Point");


	/**
	*	adding new fields to the module 
	*	extending the previous fields
	**/
$dictionary['Call']['fields']['twilio_call_id'] = array(
'name' => 'twilio_call_id',
'vname' => 'LBL_TWILIO_CALL_ID',
'type' => 'varchar',
'len' => '255',
'module' => 'Calls',
'audited' => false,
'required' => false,
'importable' => true,
'studio' => false,
'comment' => 'Twilio Call Id'
);	

$dictionary['Call']['fields']['price'] = array(
'name' => 'price',
'vname' => 'LBL_PRICE',
'type' => 'varchar',
'len' => '255',
'module' => 'Calls',
'audited' => false,
'required' => false,
'importable' => true,
'comment' => 'Price'
);	

$dictionary['Call']['fields']['uri'] = array(
'name' => 'uri',
'vname' => 'LBL_URI',
'type' => 'text',
'module' => 'Calls',
'audited' => false,
'required' => false,
'importable' => true,
'studio' => false,
'comment' => 'Uri'
);	

$dictionary['Call']['fields']['recordings'] = array(
'name' => 'recordings',
'vname' => 'LBL_RECORDINGS',
'type' => 'varchar',
'module' => 'Calls',
'audited' => false,
'required' => false,
'importable' => true,
'comment' => 'Recordings'
);		

$dictionary['Call']['fields']['source'] = array(
'name' => 'source',
'vname' => 'LBL_SOURCE',
'type' => 'varchar',
'len' => '50',
'module' => 'Calls',
'audited' => false,
'required' => false,
'importable' => true,
'comment' => 'Source',
);

$dictionary['Call']['fields']['destination'] = array(
'name' => 'destination',
'vname' => 'LBL_DESTINATION',
'type' => 'varchar',
'len' => '50',
'module' => 'Calls',
'audited' => false,
'required' => false,
'importable' => true,
'comment' => 'Destination',
);	

$dictionary['Call']['fields']['sync'] = array(
'name' => 'sync',
'vname' => 'LBL_SYNC',
'type' => 'bool',
'len' =>'1',
'default' => 0,
'module' => 'Calls',
'audited' => false,
'required' => false,
'importable' => true,
'studio' => false,
'comment' => 'Sync'
);

?>