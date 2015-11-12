<?php
	if(!defined('sugarEntry') || !sugarEntry) die("Not A Valid Entry Point");
?>
<?php
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