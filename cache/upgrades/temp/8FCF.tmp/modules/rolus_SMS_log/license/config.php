<?php

$outfitters_config = array(
    'name' => 'SampleLicenseAddon', //The matches the id value in your manifest file. This allow the library to lookup addon version from upgrade_history, so you can see what version of addon your customers are using
    'shortname' => 'samplelicenseaddon', //The short name of the Add-on. e.g. For the url https://www.sugaroutfitters.com/addons/sugaroutfitters the shortname would be sugaroutfitters
    'public_key' => '49ad23bff7c9cb22652196f8c7b7889a', //The public key associated with the group
    'api_url' => 'https://www.sugaroutfitters.com/api/v1',
    'validate_users' => false,
    'manage_licensed_users' => false, //Enable the user management tool to determine which users will be licensed to use the add-on. validate_users must be set to true if this is enabled. If the add-on must be licensed for all users then set this to false.
    'validation_frequency' => 'weekly', //default: weekly options: hourly, daily, weekly
    'continue_url' => '', //[optional] Will show a button after license validation that will redirect to this page. Could be used to redirect to a configuration page such as index.php?module=MyCustomModule&action=config
);


// [OPTIONAL] If you want to make a single package install on both Sugar 6 and Sugar 7
// You may need different continue URLs.
// Usually you would put your Sugar 7 url in the array above
// Below you can check to see if it's Sugar 6, then set the continue_url to your Sugar 6 url

// global $sugar_version;
// if(preg_match( "/^6.*/", $sugar_version) ) {
//     $outfitters_config['continue_url'] = 'index.php?module=SugarChimp&action=setup';
// }
