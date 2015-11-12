<?php
$module_name = 'rolus_SMS_log';
$viewdefs [$module_name] = 
array (
  'EditView' => 
  array (
    'templateMeta' => 
    array (
      'maxColumns' => '2',
      'widths' => 
      array (
        0 => 
        array (
          'label' => '10',
          'field' => '30',
        ),
        1 => 
        array (
          'label' => '10',
          'field' => '30',
        ),
      ),
      'useTabs' => false,
      'tabDefs' => 
      array (
        'DEFAULT' => 
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
      ),
    ),
    'panels' => 
    array (
      'LBL_MODULE_NAME' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'destinaiton',
            'label' => 'LBL_DESTINAITON',
          ),
          1 => 
          array (
            'name' => 'origin',
            'label' => 'LBL_ORIGIN',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'status',
            'studio' => 'visible',
            'label' => 'LBL_STATUS',
          ),
          1 => 
          array (
            'name' => 'direction',
            'studio' => 'visible',
            'label' => 'LBL_DIRECTION',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'subject',
            'label' => 'LBL_SUBJECT',
          ),
          1 => '',
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'message',
            'studio' => 'visible',
            'label' => 'LBL_MESSAGE',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'date_sent',
            'label' => 'LBL_DATE_SENT',
          ),
          1 => '',
        ),
      ),
    ),
  ),
);
?>
