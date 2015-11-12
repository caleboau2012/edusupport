<?php
function post_install(){			
	/* adding modules to AjaxUI Banned List to ensure outbound call via Firefox */
	$module_list =array( 
		'Contacts',
		'Leads',
		'Users',
		'Accounts',
		'Targets',
		'SMS',	
		);

	// Add banning of AjaxUI for modules capable to originate Outbound Call through them 

	require_once('modules/Configurator/Configurator.php');

	$cfg = new Configurator();
	$overrideArray = $cfg->readOverride();
	if(array_key_exists('addAjaxBannedModules',$overrideArray)) 
	{		
		$disabled_modules = $overrideArray['addAjaxBannedModules'];
		$updatedArray = array_merge($disabled_modules, array_diff($module_list, $disabled_modules));
	}
	else 
	{ 
		$updatedArray = $module_list;
	}
	$cfg->config['addAjaxBannedModules'] = empty($updatedArray) ? FALSE : $updatedArray;
	$cfg->handleOverride();		
}
?>