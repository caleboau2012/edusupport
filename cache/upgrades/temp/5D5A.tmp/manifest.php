<?php
	$manifest = array (
		 'acceptable_sugar_versions' => 
		  array (
			"6.3.x",
			"6.4.x",
			"6.5.x",
			"6.6.x",
			"6.7.x",
			"6.8.x",
			"6.9.x",
		  ),
		  'acceptable_sugar_flavors' =>
		  array(
		  	'ENT','PRO','CE',
		  ),
		  'key'=>'',
		  'author' => 'Rolustech',
		  'description' => 'Make Twilio Calls Inbound(via phone to browser) and Outbound(via browser to phone & between two traditional phones) and send Outbound & receive Inbound SMS and SMS Conversation and Compose SMS',
		  'icon' => '',
		  'is_uninstallable' => true,
		  'name' => 'RT Telephony',
		  'published_date' => '2015-30-04 18:00:25',
		  'type' => 'module',
		  'version' => '1.0.0',
		  'remove_tables' => 'prompt',
		  );
	$installdefs = array (
			  'id' => 'Twilio_Integration_V_1.0.0',
			  'beans' => 
				 array (
					0 => 
					array (
					  'module' => 'rolus_Twilio_Account',
					  'class' => 'rolus_Twilio_Account',
					  'path' => 'modules/rolus_Twilio_Account/rolus_Twilio_Account.php',
					  'tab' => false,
			        ),
					1 => 
					array (
					  'module' => 'rolus_Twilio_Extension_Manager',
					  'class' => 'rolus_Twilio_Extension_Manager',
					  'path' => 'modules/rolus_Twilio_Extension_Manager/rolus_Twilio_Extension_Manager.php',
					  'tab' => false,
			        ),
					2 => 
					array (
					  'module' => 'rolus_SMS_log',
					  'class' => 'rolus_SMS_log',
					  'path' => 'modules/rolus_SMS_log/rolus_SMS_log.php',
					  'tab' => true,
			        ),
			     ),
			  'layoutdefs' => 
			  array (
			  ),
			  'relationships' => 
			  array (
			  ),
			  'copy' => 
			  array (
				0 => 
				array (
				  'from' => '<basepath>/custom/',
				  'to' => 'custom/',
				),
				1 => 
				array (
				  'from' => '<basepath>/modules/',
				  'to' => 'modules/',
				),
				2 => 
				array (
				  'from' => '<basepath>/themes/',
				  'to' => 'themes/',
				),
			  ), 
	         'layoutfields' => array(
				array(
					'additional_fields' =>
					array(
						'Calls' => 'source',
					),
				),
				array(
					'additional_fields' =>
					array(
						'Calls' => 'destination',
					),
				),
				array(
					'additional_fields' =>
					array(
						'Calls' => 'price',
					),
				),
				array(
					'additional_fields' =>
					array(
						'Calls' => 'recordings',
					),
				),
				array(
					'additional_fields' =>
					array(
						'Users' => 'extension',
					),
				),
			),		 
     			 
			  'post_install' => array(
				'<basepath>/scripts/post_install.php',
			  ),
			  'post_uninstall'=>array(
				'<basepath>/scripts/post_uninstall.php',
			  ), 
			);
?>

