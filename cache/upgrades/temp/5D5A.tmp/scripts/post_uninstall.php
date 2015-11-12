<?php
function post_uninstall()
{
	$installer_func = new ModuleInstaller();
			
	$calls_source = array('Calls'=>'source');
	$installer_func->removeFieldsFromLayout($calls_source);
	
	$calls_destination = array('Calls'=>'destination');
	$installer_func->removeFieldsFromLayout($calls_destination);
	
	$calls_price = array('Calls'=>'price');
	$installer_func->removeFieldsFromLayout($calls_price);
	
	$calls_recordings = array('Calls'=>'recordings');
	$installer_func->removeFieldsFromLayout($calls_recordings);
	
	$users_extension = array('Users'=>'extension');
	$installer_func->removeFieldsFromLayout($users_extension);
}
?>