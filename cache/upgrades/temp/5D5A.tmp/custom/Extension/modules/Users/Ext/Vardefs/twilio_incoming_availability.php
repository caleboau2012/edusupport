<?php
	/**
	*	adding new fields to the module 
	*
	**/
$dictionary['User']['fields']['logged_in'] = array(
'name' => 'logged_in',
'vname' => 'LBL_LOGGED_IN',
'type' => 'bool',
'default' => 0,
'len' => '1',
'module' => 'Users',
'label' => 'LBL_LOGGED_IN' ,
'audited' => false,
'required' => false,
'importable' => true,
'studio' => false,
'comment' => 'User login status'
);
$dictionary['User']['fields']['availability'] = array(
'name' => 'availability',
'vname' => 'LBL_AVAILABILITY',
'type' => 'bool',
'default' => 0,
'len' => '1',
'module' => 'Users',
'label' => 'LBL_AVAILABILITY',
'audited' => false,
'required' => false,
'importable' => true,
'studio' => false,
'comment' => 'user call connected status'
); 
$dictionary['User']['fields']['extension'] = array(
'name' => 'extension',
'vname' => 'LBL_EXTENSION',
'type' => 'varchar',
'len' => '10',
'module' => 'Users',
'audited' => false,
'required' => false,
'importable' => true,
'comment' => 'User Call Accepting Extension',
);
$dictionary['User']['fields']['voip_access'] = array(
'required' => true,
'name' => 'voip_access',
'vname' => 'LBL_VOIP_ACCESS',
'type' => 'enum',
'massupdate' => 0,
'no_default' => false,
'comments' => '',
'help' => '',
'importable' => true,
'duplicate_merge' => 'disabled',
'duplicate_merge_dom_value' => '0',
'audited' => true,
'reportable' => true,
'unified_search' => false,
'merge_filter' => 'disabled',
'len' => '20',
'size' => '20',
'studio' => 'false',
'options' => 'voip_access_dom',
);
$dictionary['User']['fields']['allow_phone_mobile'] = array(
'required' => true,
'name' => 'allow_phone_mobile',
'vname' => 'LBL_ALLOW_PHONE_MOBILE',
'type' => 'bool',
'massupdate' => 0,
'no_default' => false,
'comments' => '',
'help' => '',
'importable' => true,
'duplicate_merge' => 'disabled',
'duplicate_merge_dom_value' => '0',
'audited' => true,
'reportable' => true,
'unified_search' => false,
'merge_filter' => 'disabled',
'studio' => 'false',
'len' => '1',
'size' => '1',
);
$dictionary['User']['fields']['allow_phone_work'] = array(
'required' => true,
'name' => 'allow_phone_work',
'vname' => 'LBL_ALLOW_PHONE_WORK',
'type' => 'bool',
'massupdate' => 0,
'no_default' => false,
'comments' => '',
'help' => '',
'importable' => true,
'duplicate_merge' => 'disabled',
'duplicate_merge_dom_value' => '0',
'audited' => true,
'reportable' => true,
'unified_search' => false,
'merge_filter' => 'disabled',
'studio' => 'false',
'len' => '1',
'size' => '1',
);
$dictionary['User']['fields']['allow_phone_home'] = array(
'required' => true,
'name' => 'allow_phone_home',
'vname' => 'LBL_ALLOW_PHONE_HOME',
'type' => 'bool',
'massupdate' => 0,
'no_default' => false,
'comments' => '',
'help' => '',
'importable' => true,
'duplicate_merge' => 'disabled',
'duplicate_merge_dom_value' => '0',
'audited' => true,
'reportable' => true,
'unified_search' => false,
'merge_filter' => 'disabled',
'studio' => 'false',
'len' => '1',
'size' => '1',
);
$dictionary['User']['fields']['allow_phone_other'] = array(
'required' => true,
'name' => 'allow_phone_other',
'vname' => 'LBL_ALLOW_PHONE_OTHER',
'type' => 'bool',
'massupdate' => 0,
'no_default' => false,
'comments' => '',
'help' => '',
'importable' => true,
'duplicate_merge' => 'disabled',
'duplicate_merge_dom_value' => '0',
'audited' => true,
'reportable' => true,
'unified_search' => false,
'merge_filter' => 'disabled',
'studio' => 'false',
'len' => '1',
'size' => '1',
);
$dictionary['User']['fields']['allow_browser'] = array(
'required' => true,
'name' => 'allow_browser',
'vname' => 'LBL_ALLOW_BROWSER',
'type' => 'bool',
'massupdate' => 0,
'no_default' => false,
'comments' => '',
'help' => '',
'importable' => true,
'duplicate_merge' => 'disabled',
'duplicate_merge_dom_value' => '0',
'audited' => true,
'reportable' => true,
'unified_search' => false,
'merge_filter' => 'disabled',
'studio' => 'false',
'len' => '1',
'size' => '1',
);	
?>