<?php 
 //WARNING: The contents of this file are auto-generated


// created: 2013-04-30 14:52:24
$dictionary["Lead"]["fields"]["fp_events_leads_1"] = array (
  'name' => 'fp_events_leads_1',
  'type' => 'link',
  'relationship' => 'fp_events_leads_1',
  'source' => 'non-db',
  'vname' => 'LBL_FP_EVENTS_LEADS_1_FROM_FP_EVENTS_TITLE',
);



$dictionary['Lead']['fields']['SecurityGroups'] = array (
  	'name' => 'SecurityGroups',
    'type' => 'link',
	'relationship' => 'securitygroups_leads',
	'module'=>'SecurityGroups',
	'bean_name'=>'SecurityGroup',
    'source'=>'non-db',
	'vname'=>'LBL_SECURITYGROUPS',
);






 // created: 2015-09-28 07:03:48
$dictionary['Lead']['fields']['buying_power_c']['labelValue']='Buying Power';

 

 // created: 2015-11-09 10:30:14
$dictionary['Lead']['fields']['date_modified']['audited']=true;
$dictionary['Lead']['fields']['date_modified']['inline_edit']=true;
$dictionary['Lead']['fields']['date_modified']['comments']='Date record last modified';
$dictionary['Lead']['fields']['date_modified']['merge_filter']='disabled';

 


$dictionary['Lead']['fields']['e_invite_status_fields'] =
		array (
			'name' => 'e_invite_status_fields',
			'rname' => 'id',
			'relationship_fields'=>array('id' => 'event_invite_id', 'invite_status' => 'event_status_name'),
			'vname' => 'LBL_CONT_INVITE_STATUS',
			'type' => 'relate',
			'link' => 'fp_events_leads_1',
			'link_type' => 'relationship_info',
            'join_link_name' => 'fp_events_leads_1',
			'source' => 'non-db',
			'importable' => 'false',
            'duplicate_merge'=> 'disabled',
			'studio' => false,
		);


$dictionary['Lead']['fields']['event_status_name'] =
		array(
            'massupdate' => false,
            'name' => 'event_status_name',
            'type' => 'enum',
            'studio' => 'false',
            'source' => 'non-db',
            'vname' => 'LBL_LIST_INVITE_STATUS_EVENT',
            'options' => 'fp_event_invite_status_dom',
            'importable' => 'false',
        );
$dictionary['Lead']['fields']['event_invite_id'] =
    array(
        'name' => 'event_invite_id',
        'type' => 'varchar',
        'source' => 'non-db',
        'vname' => 'LBL_LIST_INVITE_STATUS',
        'studio' => array('listview' => false),
    );


$dictionary['Lead']['fields']['e_accept_status_fields'] =
        array (
            'name' => 'e_accept_status_fields',
            'rname' => 'id',
            'relationship_fields'=>array('id' => 'event_status_id', 'accept_status' => 'event_accept_status'),
            'vname' => 'LBL_CONT_ACCEPT_STATUS',
            'type' => 'relate',
            'link' => 'fp_events_leads_1',
            'link_type' => 'relationship_info',
            'join_link_name' => 'fp_events_leads_1',
            'source' => 'non-db',
            'importable' => 'false',
            'duplicate_merge'=> 'disabled',
            'studio' => false,
        );


$dictionary['Lead']['fields']['event_accept_status'] =
        array(
            'massupdate' => false,
            'name' => 'event_accept_status',
            'type' => 'enum',
            'studio' => 'false',
            'source' => 'non-db',
            'vname' => 'LBL_LIST_ACCEPT_STATUS_EVENT',
            'options' => 'fp_event_status_dom',
            'importable' => 'false',
        );
$dictionary['Lead']['fields']['event_status_id'] =
    array(
        'name' => 'event_status_id',
        'type' => 'varchar',
        'source' => 'non-db',
        'vname' => 'LBL_LIST_ACCEPT_STATUS',
        'studio' => array('listview' => false),
    );

 // created: 2015-10-26 08:58:48
$dictionary['Lead']['fields']['intended_course_of_study_c']['inline_edit']='1';
$dictionary['Lead']['fields']['intended_course_of_study_c']['labelValue']='intended course of study';

 

 // created: 2015-09-28 07:05:35
$dictionary['Lead']['fields']['interest_c']['labelValue']='Interest';

 

 // created: 2014-01-20 12:22:31

 


 // created: 2014-01-20 12:22:31

 


 // created: 2014-01-20 12:22:31

 


 // created: 2014-01-20 12:22:30

 


 // created: 2015-10-30 13:07:42
$dictionary['Lead']['fields']['lead_source_description']['inline_edit']=true;
$dictionary['Lead']['fields']['lead_source_description']['comments']='Description of the lead source';
$dictionary['Lead']['fields']['lead_source_description']['merge_filter']='disabled';
$dictionary['Lead']['fields']['lead_source_description']['rows']='4';
$dictionary['Lead']['fields']['lead_source_description']['cols']='20';

 

 // created: 2015-10-23 06:03:32
$dictionary['Lead']['fields']['reason_c']['inline_edit']='1';
$dictionary['Lead']['fields']['reason_c']['labelValue']='Reason';

 

 // created: 2015-10-29 20:17:43
$dictionary['Lead']['fields']['refered_by']['inline_edit']=true;
$dictionary['Lead']['fields']['refered_by']['comments']='Identifies who refered the lead';
$dictionary['Lead']['fields']['refered_by']['merge_filter']='disabled';

 

 // created: 2015-10-07 10:12:36
$dictionary['Lead']['fields']['sales_stage_c']['labelValue']='Sales Stage';

 
?>