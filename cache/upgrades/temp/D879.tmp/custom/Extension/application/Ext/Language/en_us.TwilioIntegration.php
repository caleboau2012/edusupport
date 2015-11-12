<?php
	if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2012 SugarCRM Inc.
 * 
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 * 
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 * 
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 * 
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 * 
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 * 
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 ********************************************************************************/


$app_list_strings['moduleList']['rolus_Twilio_Account'] = 'Call Account';
$app_list_strings['moduleList']['rolus_Twilio_Extension_Manager'] = 'Twilio Extension Manager';
$app_list_strings['moduleList']['rolus_SMS_log'] = 'RT SMS';
$app_list_strings['twilio_status_list'][''] = '';
$app_list_strings['twilio_status_list']['received'] = 'Received';
$app_list_strings['twilio_status_list']['failed'] = 'Failed';
$app_list_strings['twilio_status_list']['not_enough_credit'] = 'Not Enough Credit';
$app_list_strings['twilio_status_list']['not_authorized'] = 'Not Authorized';
$app_list_strings['twilio_status_list']['sending'] = 'Sending';
$app_list_strings['twilio_status_list']['sent'] = 'Sent';
$app_list_strings['twilio_status_list']['scheduled'] = 'Scheduled';
$app_list_strings['twilio_direction_list']['incoming'] = 'Incoming';
$app_list_strings['twilio_direction_list']['outgoing'] = 'Outgoing';
$app_list_strings['twilio_country_code']=array (
  '' => '',
  '+1' => 'United States & Canada',
  '+503' => 'El Salvador',
  '+52' => 'Mexico',
  '+1809' => 'Dominican Republic(1809)',
  '+1829' => 'Dominican Republic(1829)',
  '+1849' => 'Dominican Republic(1849)',
  '+51' => 'Peru',
  '+1787' => 'Puerto Rico(1787)',
  '+1939' => 'Puerto Rico(1939)',
  '+43'	=> 'Austria',
  '+32' => 'Belgium',
  '+359' => 'Bulgaria',
  '+420' => 'Czech Republic',
  '+45' => 'Denmark',
  '+372' => 'Estonia',
  '+358' => 'Finland/Aland Islands',
  '+33' => 'France',
  '+49' => 'Germany',
  '+30' => 'Greece',
  '+353' => 'Ireland',
  '+39' => 'Italy',
  '+371' => 'Latvia',
  '+370' => 'Lithuania',
  '+352' => 'Luxembourg',
  '+356' => 'Malta',
  '+31' => 'Netherlands',
  '+48' => 'Poland',
  '+351' => 'Portugal',
  '+40' => 'Romania',
  '+421' => 'Slovakia',
  '+34' => 'Spain',
  '+46' => 'Sweden',
  '+41' => 'Switzerland',
  '+44' => 'United Kingdom',
  '+973' => 'Bahrain',
  '+86' => 'China',
  '+357' => 'Cyprus',
  '+852' => 'Hong Kong',
  '+91' => 'India',
  '+972' => 'Israel',
  '+81' => 'Japan',
  '+27' => 'South Africa',
  '+55' => 'Brazil',
  '+61' => 'Australia/Cocos/Christmas ',
  '+64' => 'New Zealand',  
);
$app_list_strings['ivr_voice_dom']=array (
  'man' => 'Man',
  'woman' => 'Woman',
);
$app_list_strings['voip_access_dom']=array (
  '' => '-none-',
  'no-access' => 'No Access',
  'inbound' => 'Inbound',
  'outbound' => 'Outbound',
  'both' => 'Both',
); 
$app_list_strings['call_status_dom']=array (
  'Planned' => 'Planned',
  'Held' => 'Held',
  'Not Held' => 'Not Held',
  'dialing' => 'Dialing',
  'established' => 'Established',
  'canceled' => 'Canceled',
  'rejected' => 'Rejected',
);
