<?php
$module_name = 'rolus_SMS_log';
$listViewDefs [$module_name] = 
array (
  'ORIGIN' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_ORIGIN',
    'width' => '10%',
    'default' => true,
	'link' => true,
  ),
  'DESTINAITON' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_DESTINAITON',
    'width' => '10%',
    'default' => true,
	'link' => true,
  ),
  'SUBJECT' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_SUBJECT',
    'width' => '10%',
    'default' => true,
	'link' => true,
  ),
  'STATUS' => 
  array (
    'type' => 'enum',
    'studio' => 'visible',
    'label' => 'LBL_STATUS',
    'width' => '10%',
    'default' => true,
  ),
  'DIRECTION' => 
  array (
    'type' => 'enum',
    'default' => true,
    'studio' => 'visible',
    'label' => 'LBL_DIRECTION',
    'width' => '10%',
  ),
  'ASSIGNED_USER_NAME' => 
  array (
    'width' => '9%',
    'label' => 'LBL_ASSIGNED_TO_NAME',
    'module' => 'Employees',
    'id' => 'ASSIGNED_USER_ID',
    'default' => false,
  ),
  'NAME' => 
  array (
    'width' => '32%',
    'label' => 'LBL_NAME',
    'default' => false,
    'link' => true,
  ),
);
?>
