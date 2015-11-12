

<script>
{literal}
$(document).ready(function(){
$("ul.clickMenu").each(function(index, node){
$(node).sugarActionMenu();
});
});
{/literal}
</script>
<div class="clear"></div>
<form action="index.php" method="POST" name="{$form_name}" id="{$form_id}" {$enctype}>
<table width="100%" cellpadding="0" cellspacing="0" border="0" class="dcQuickEdit">
<tr>
<td class="buttons">
<input type="hidden" name="module" value="{$module}">
{if isset($smarty.request.isDuplicate) && $smarty.request.isDuplicate eq "true"}
<input type="hidden" name="record" value="">
<input type="hidden" name="duplicateSave" value="true">
<input type="hidden" name="duplicateId" value="{$fields.id.value}">
{else}
<input type="hidden" name="record" value="{$fields.id.value}">
{/if}
<input type="hidden" name="isDuplicate" value="false">
<input type="hidden" name="action">
<input type="hidden" name="return_module" value="{$smarty.request.return_module}">
<input type="hidden" name="return_action" value="{$smarty.request.return_action}">
<input type="hidden" name="return_id" value="{$smarty.request.return_id}">
<input type="hidden" name="module_tab"> 
<input type="hidden" name="contact_role">
{if (!empty($smarty.request.return_module) || !empty($smarty.request.relate_to)) && !(isset($smarty.request.isDuplicate) && $smarty.request.isDuplicate eq "true")}
<input type="hidden" name="relate_to" value="{if $smarty.request.return_relationship}{$smarty.request.return_relationship}{elseif $smarty.request.relate_to && empty($smarty.request.from_dcmenu)}{$smarty.request.relate_to}{elseif empty($isDCForm) && empty($smarty.request.from_dcmenu)}{$smarty.request.return_module}{/if}">
<input type="hidden" name="relate_id" value="{$smarty.request.return_id}">
{/if}
<input type="hidden" name="offset" value="{$offset}">
{assign var='place' value="_HEADER"} <!-- to be used for id for buttons with custom code in def files-->
<div class="action_buttons">{if $bean->aclAccess("save")}<input title="{$APP.LBL_SAVE_BUTTON_TITLE}"  class="button" onclick="var _form = document.getElementById('form_SubpanelQuickCreate_AOR_Scheduled_Reports'); disableOnUnloadEditView(); _form.action.value='Save';if(check_form('form_SubpanelQuickCreate_AOR_Scheduled_Reports'))return SUGAR.subpanelUtils.inlineSave(_form.id, 'AOR_Scheduled_Reports_subpanel_save_button');return false;" type="submit" name="AOR_Scheduled_Reports_subpanel_save_button" id="AOR_Scheduled_Reports_subpanel_save_button" value="{$APP.LBL_SAVE_BUTTON_LABEL}">{/if}  <input title="{$APP.LBL_CANCEL_BUTTON_TITLE}" class="button" onclick="return SUGAR.subpanelUtils.cancelCreate($(this).attr('id'));return false;" type="submit" name="AOR_Scheduled_Reports_subpanel_cancel_button" id="AOR_Scheduled_Reports_subpanel_cancel_button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}">  <input title="{$APP.LBL_FULL_FORM_BUTTON_TITLE}" class="button" onclick="var _form = document.getElementById('form_SubpanelQuickCreate_AOR_Scheduled_Reports'); disableOnUnloadEditView(_form); _form.return_action.value='DetailView'; _form.action.value='EditView'; if(typeof(_form.to_pdf)!='undefined') _form.to_pdf.value='0';" type="submit" name="AOR_Scheduled_Reports_subpanel_full_form_button" id="AOR_Scheduled_Reports_subpanel_full_form_button" value="{$APP.LBL_FULL_FORM_BUTTON_LABEL}"> <input type="hidden" name="full_form" value="full_form"> {if $bean->aclAccess("detail")}{if !empty($fields.id.value) && $isAuditEnabled}<input id="btn_view_change_log" title="{$APP.LNK_VIEW_CHANGE_LOG}" class="button" onclick='open_popup("Audit", "600", "400", "&record={$fields.id.value}&module_name=AOR_Scheduled_Reports", true, false,  {ldelim} "call_back_function":"set_return","form_name":"EditView","field_to_name_array":[] {rdelim} ); return false;' type="button" value="{$APP.LNK_VIEW_CHANGE_LOG}">{/if}{/if}<div class="clear"></div></div>
</td>
<td align='right'>
{$PAGINATION}
</td>
</tr>
</table>{sugar_include include=$includes}
<span id='tabcounterJS'><script>SUGAR.TabFields=new Array();//this will be used to track tabindexes for references</script></span>
<div id="form_SubpanelQuickCreate_AOR_Scheduled_Reports_tabs"
>
<div >
<div id="detailpanel_1" class="{$def.templateMeta.panelClass|default:'edit view edit508'}">
{counter name="panelFieldCount" start=0 print=false assign="panelFieldCount"}
<table width="100%" border="0" cellspacing="1" cellpadding="0"  id='LBL_SCHEDULED_REPORTS_INFORMATION'  class="yui3-skin-sam edit view panelContainer">
{counter name="fieldsUsed" start=0 print=false assign="fieldsUsed"}
{capture name="tr" assign="tableRow"}
<tr>
<td valign="top" id='name_label' width='12.5%' scope="col">
{capture name="label" assign="label"}{sugar_translate label='LBL_NAME' module='AOR_Scheduled_Reports'}{/capture}
{$label|strip_semicolon}:
<span class="required">*</span>
</td>
{counter name="fieldsUsed"}

<td valign="top" width='37.5%' >
{counter name="panelFieldCount"}

{if strlen($fields.name.value) <= 0}
{assign var="value" value=$fields.name.default_value }
{else}
{assign var="value" value=$fields.name.value }
{/if}  
<input type='text' name='{$fields.name.name}' 
id='{$fields.name.name}' size='30' 
maxlength='255' 
value='{$value}' title=''      accesskey='7'  >
<td valign="top" id='status_label' width='12.5%' scope="col">
{capture name="label" assign="label"}{sugar_translate label='LBL_STATUS' module='AOR_Scheduled_Reports'}{/capture}
{$label|strip_semicolon}:
</td>
{counter name="fieldsUsed"}

<td valign="top" width='37.5%' >
{counter name="panelFieldCount"}

{if !isset($config.enable_autocomplete) || $config.enable_autocomplete==false}
<select name="{$fields.status.name}" 
id="{$fields.status.name}" 
title=''       
>
{if isset($fields.status.value) && $fields.status.value != ''}
{html_options options=$fields.status.options selected=$fields.status.value}
{else}
{html_options options=$fields.status.options selected=$fields.status.default}
{/if}
</select>
{else}
{assign var="field_options" value=$fields.status.options }
{capture name="field_val"}{$fields.status.value}{/capture}
{assign var="field_val" value=$smarty.capture.field_val}
{capture name="ac_key"}{$fields.status.name}{/capture}
{assign var="ac_key" value=$smarty.capture.ac_key}
<select style='display:none' name="{$fields.status.name}" 
id="{$fields.status.name}" 
title=''          
>
{if isset($fields.status.value) && $fields.status.value != ''}
{html_options options=$fields.status.options selected=$fields.status.value}
{else}
{html_options options=$fields.status.options selected=$fields.status.default}
{/if}
</select>
<input
id="{$fields.status.name}-input"
name="{$fields.status.name}-input"
size="30"
value="{$field_val|lookup:$field_options}"
type="text" style="vertical-align: top;">
<span class="id-ff multiple">
<button type="button"><img src="{sugar_getimagepath file="id-ff-down.png"}" id="{$fields.status.name}-image"></button><button type="button"
id="btn-clear-{$fields.status.name}-input"
title="Clear"
onclick="SUGAR.clearRelateField(this.form, '{$fields.status.name}-input', '{$fields.status.name}');sync_{$fields.status.name}()"><img src="{sugar_getimagepath file="id-ff-clear.png"}"></button>
</span>
{literal}
<script>
SUGAR.AutoComplete.{/literal}{$ac_key}{literal} = [];
{/literal}
{literal}
(function (){
var selectElem = document.getElementById("{/literal}{$fields.status.name}{literal}");
if (typeof select_defaults =="undefined")
select_defaults = [];
select_defaults[selectElem.id] = {key:selectElem.value,text:''};
//get default
for (i=0;i<selectElem.options.length;i++){
if (selectElem.options[i].value==selectElem.value)
select_defaults[selectElem.id].text = selectElem.options[i].innerHTML;
}
//SUGAR.AutoComplete.{$ac_key}.ds = 
//get options array from vardefs
var options = SUGAR.AutoComplete.getOptionsArray("");
YUI().use('datasource', 'datasource-jsonschema',function (Y) {
SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.ds = new Y.DataSource.Function({
source: function (request) {
var ret = [];
for (i=0;i<selectElem.options.length;i++)
if (!(selectElem.options[i].value=='' && selectElem.options[i].innerHTML==''))
ret.push({'key':selectElem.options[i].value,'text':selectElem.options[i].innerHTML});
return ret;
}
});
});
})();
{/literal}
{literal}
YUI().use("autocomplete", "autocomplete-filters", "autocomplete-highlighters", "node","node-event-simulate", function (Y) {
{/literal}
SUGAR.AutoComplete.{$ac_key}.inputNode = Y.one('#{$fields.status.name}-input');
SUGAR.AutoComplete.{$ac_key}.inputImage = Y.one('#{$fields.status.name}-image');
SUGAR.AutoComplete.{$ac_key}.inputHidden = Y.one('#{$fields.status.name}');
{literal}
function SyncToHidden(selectme){
var selectElem = document.getElementById("{/literal}{$fields.status.name}{literal}");
var doSimulateChange = false;
if (selectElem.value!=selectme)
doSimulateChange=true;
selectElem.value=selectme;
for (i=0;i<selectElem.options.length;i++){
selectElem.options[i].selected=false;
if (selectElem.options[i].value==selectme)
selectElem.options[i].selected=true;
}
if (doSimulateChange)
SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputHidden.simulate('change');
}
//global variable 
sync_{/literal}{$fields.status.name}{literal} = function(){
SyncToHidden();
}
function syncFromHiddenToWidget(){
var selectElem = document.getElementById("{/literal}{$fields.status.name}{literal}");
//if select no longer on page, kill timer
if (selectElem==null || selectElem.options == null)
return;
var currentvalue = SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.get('value');
SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.simulate('keyup');
for (i=0;i<selectElem.options.length;i++){
if (selectElem.options[i].value==selectElem.value && document.activeElement != document.getElementById('{/literal}{$fields.status.name}-input{literal}'))
SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.set('value',selectElem.options[i].innerHTML);
}
}
YAHOO.util.Event.onAvailable("{/literal}{$fields.status.name}{literal}", syncFromHiddenToWidget);
{/literal}
SUGAR.AutoComplete.{$ac_key}.minQLen = 0;
SUGAR.AutoComplete.{$ac_key}.queryDelay = 0;
SUGAR.AutoComplete.{$ac_key}.numOptions = {$field_options|@count};
if(SUGAR.AutoComplete.{$ac_key}.numOptions >= 300) {literal}{
{/literal}
SUGAR.AutoComplete.{$ac_key}.minQLen = 1;
SUGAR.AutoComplete.{$ac_key}.queryDelay = 200;
{literal}
}
{/literal}
if(SUGAR.AutoComplete.{$ac_key}.numOptions >= 3000) {literal}{
{/literal}
SUGAR.AutoComplete.{$ac_key}.minQLen = 1;
SUGAR.AutoComplete.{$ac_key}.queryDelay = 500;
{literal}
}
{/literal}
SUGAR.AutoComplete.{$ac_key}.optionsVisible = false;
{literal}
SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.plug(Y.Plugin.AutoComplete, {
activateFirstItem: true,
{/literal}
minQueryLength: SUGAR.AutoComplete.{$ac_key}.minQLen,
queryDelay: SUGAR.AutoComplete.{$ac_key}.queryDelay,
zIndex: 99999,
{literal}
source: SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.ds,
resultTextLocator: 'text',
resultHighlighter: 'phraseMatch',
resultFilters: 'phraseMatch',
});
SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.expandHover = function(ex){
var hover = YAHOO.util.Dom.getElementsByClassName('dccontent');
if(hover[0] != null){
if (ex) {
var h = '1000px';
hover[0].style.height = h;
}
else{
hover[0].style.height = '';
}
}
}
if({/literal}SUGAR.AutoComplete.{$ac_key}.minQLen{literal} == 0){
// expand the dropdown options upon focus
SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.on('focus', function () {
SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.ac.sendRequest('');
SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.optionsVisible = true;
});
}
SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.on('click', function(e) {
SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputHidden.simulate('click');
});
SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.on('dblclick', function(e) {
SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputHidden.simulate('dblclick');
});
SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.on('focus', function(e) {
SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputHidden.simulate('focus');
});
SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.on('mouseup', function(e) {
SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputHidden.simulate('mouseup');
});
SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.on('mousedown', function(e) {
SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputHidden.simulate('mousedown');
});
SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.on('blur', function(e) {
SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputHidden.simulate('blur');
SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.optionsVisible = false;
var selectElem = document.getElementById("{/literal}{$fields.status.name}{literal}");
//if typed value is a valid option, do nothing
for (i=0;i<selectElem.options.length;i++)
if (selectElem.options[i].innerHTML==SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.get('value'))
return;
//typed value is invalid, so set the text and the hidden to blank
SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.set('value', select_defaults[selectElem.id].text);
SyncToHidden(select_defaults[selectElem.id].key);
});
// when they click on the arrow image, toggle the visibility of the options
SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputImage.ancestor().on('click', function () {
if (SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.optionsVisible) {
SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.blur();
} else {
SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.focus();
}
});
SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.ac.on('query', function () {
SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputHidden.set('value', '');
});
SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.ac.on('visibleChange', function (e) {
SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.expandHover(e.newVal); // expand
});
// when they select an option, set the hidden input with the KEY, to be saved
SUGAR.AutoComplete.{/literal}{$ac_key}{literal}.inputNode.ac.on('select', function(e) {
SyncToHidden(e.result.raw.key);
});
});
</script> 
{/literal}
{/if}
</tr>
{/capture}
{if $fieldsUsed > 0 }
{$tableRow}
{/if}
{counter name="fieldsUsed" start=0 print=false assign="fieldsUsed"}
{capture name="tr" assign="tableRow"}
<tr>
<td valign="top" id='aor_report_name_label' width='12.5%' scope="col">
{capture name="label" assign="label"}{sugar_translate label='LBL_AOR_REPORT_NAME' module='AOR_Scheduled_Reports'}{/capture}
{$label|strip_semicolon}:
<span class="required">*</span>
</td>
{counter name="fieldsUsed"}

<td valign="top" width='37.5%' colspan='3'>
{counter name="panelFieldCount"}

<input type="text" name="{$fields.aor_report_name.name}" class="sqsEnabled" tabindex="0" id="{$fields.aor_report_name.name}" size="" value="{$fields.aor_report_name.value}" title='' autocomplete="off"  	 >
<input type="hidden" name="{$fields.aor_report_name.id_name}" 
id="{$fields.aor_report_name.id_name}" 
value="{$fields.aor_report_id.value}">
<span class="id-ff multiple">
<button type="button" name="btn_{$fields.aor_report_name.name}" id="btn_{$fields.aor_report_name.name}" tabindex="0" title="{sugar_translate label="LBL_SELECT_BUTTON_TITLE"}" class="button firstChild" value="{sugar_translate label="LBL_SELECT_BUTTON_LABEL"}"
onclick='open_popup(
"{$fields.aor_report_name.module}", 
600, 
400, 
"", 
true, 
false, 
{literal}{"call_back_function":"set_return","form_name":"form_SubpanelQuickCreate_AOR_Scheduled_Reports","field_to_name_array":{"id":"aor_report_id","name":"aor_report_name"}}{/literal}, 
"single", 
true
);' ><img src="{sugar_getimagepath file="id-ff-select.png"}"></button><button type="button" name="btn_clr_{$fields.aor_report_name.name}" id="btn_clr_{$fields.aor_report_name.name}" tabindex="0" title="{sugar_translate label="LBL_ACCESSKEY_CLEAR_RELATE_TITLE"}"  class="button lastChild"
onclick="SUGAR.clearRelateField(this.form, '{$fields.aor_report_name.name}', '{$fields.aor_report_name.id_name}');"  value="{sugar_translate label="LBL_ACCESSKEY_CLEAR_RELATE_LABEL"}" ><img src="{sugar_getimagepath file="id-ff-clear.png"}"></button>
</span>
<script type="text/javascript">
SUGAR.util.doWhen(
		"typeof(sqs_objects) != 'undefined' && typeof(sqs_objects['{$form_name}_{$fields.aor_report_name.name}']) != 'undefined'",
		enableQS
);
</script>
</tr>
{/capture}
{if $fieldsUsed > 0 }
{$tableRow}
{/if}
{counter name="fieldsUsed" start=0 print=false assign="fieldsUsed"}
{capture name="tr" assign="tableRow"}
<tr>
<td valign="top" id='schedule_label' width='12.5%' scope="col">
{capture name="label" assign="label"}{sugar_translate label='LBL_SCHEDULE' module='AOR_Scheduled_Reports'}{/capture}
{$label|strip_semicolon}:
<span class="required">*</span>
</td>
{counter name="fieldsUsed"}

<td valign="top" width='37.5%' colspan='3'>
{counter name="panelFieldCount"}
<script type="text/javascript" src='{sugar_getjspath file="include/SugarFields/Fields/CronSchedule/SugarFieldCronSchedule.js"}'></script>
{if strlen($fields.schedule.value) <= 0}
{assign var="value" value=$fields.schedule.default_value }
{else}
{assign var="value" value=$fields.schedule.value }
{/if}
<input type='hidden'
name='{$fields.schedule.name}'
id='{$fields.schedule.name}'
value='{$value}'>
<label>
Advanced
<input type="checkbox"
name='{$fields.schedule.name}_raw'
id='{$fields.schedule.name}_raw'
>
</label>
<span style='display:none;' id='{$fields.schedule.name}_basic'>
<select
name='{$fields.schedule.name}_type'
id='{$fields.schedule.name}_type'>
<OPTION value='monthly'>Monthly</OPTION>
<OPTION value='weekly'>Weekly</OPTION>
<OPTION value='daily'>Daily</OPTION>
</select>
<span id="{$fields.schedule.name}_monthly_options" style="display: none">
on the
<select
multiple="multiple"
name='{$fields.schedule.name}_days'
id='{$fields.schedule.name}_days'>
<OPTION value='1'>1st</OPTION>
<OPTION value='2'>2nd</OPTION>
<OPTION value='3'>3rd</OPTION>
<OPTION value='4'>4th</OPTION>
<OPTION value='5'>5th</OPTION>
<OPTION value='6'>6th</OPTION>
<OPTION value='7'>7th</OPTION>
<OPTION value='8'>8th</OPTION>
<OPTION value='9'>9th</OPTION>
<OPTION value='10'>10th</OPTION>
<OPTION value='11'>11th</OPTION>
<OPTION value='12'>12th</OPTION>
<OPTION value='13'>13th</OPTION>
<OPTION value='14'>14th</OPTION>
<OPTION value='15'>15th</OPTION>
<OPTION value='16'>16th</OPTION>
<OPTION value='17'>17th</OPTION>
<OPTION value='18'>18th</OPTION>
<OPTION value='19'>19th</OPTION>
<OPTION value='20'>20th</OPTION>
<OPTION value='21'>21st</OPTION>
<OPTION value='22'>22nd</OPTION>
<OPTION value='23'>23rd</OPTION>
<OPTION value='24'>24th</OPTION>
<OPTION value='25'>25th</OPTION>
<OPTION value='26'>26th</OPTION>
<OPTION value='27'>27th</OPTION>
<OPTION value='28'>28th</OPTION>
<OPTION value='29'>29th</OPTION>
<OPTION value='30'>30th</OPTION>
<OPTION value='31'>31st</OPTION>
</select>
</span>
<span id="{$fields.schedule.name}_weekly_options" style="display: none">
on
<select
multiple="multiple"
name='{$fields.schedule.name}_weekdays'
id='{$fields.schedule.name}_weekdays'>
<OPTION selected value='0'>Sun</OPTION>
<OPTION value='1'>Mon</OPTION>
<OPTION value='2'>Tue</OPTION>
<OPTION value='3'>Wed</OPTION>
<OPTION value='4'>Thu</OPTION>
<OPTION value='5'>Fri</OPTION>
<OPTION value='6'>Sat</OPTION>
</select>
</span>
at
<select
type="text"
name='{$fields.schedule.name}_time_hours'
id='{$fields.schedule.name}_time_hours'
value="23:00"
>
<OPTION selected value='0'>00</OPTION>
<OPTION value='1'>01</OPTION>
<OPTION value='2'>02</OPTION>
<OPTION value='3'>03</OPTION>
<OPTION value='4'>04</OPTION>
<OPTION value='5'>05</OPTION>
<OPTION value='6'>06</OPTION>
<OPTION value='7'>07</OPTION>
<OPTION value='8'>08</OPTION>
<OPTION value='9'>09</OPTION>
<OPTION value='10'>10</OPTION>
<OPTION value='11'>11</OPTION>
<OPTION value='12'>12</OPTION>
<OPTION value='13'>13</OPTION>
<OPTION value='14'>14</OPTION>
<OPTION value='15'>15</OPTION>
<OPTION value='16'>16</OPTION>
<OPTION value='17'>17</OPTION>
<OPTION value='18'>18</OPTION>
<OPTION value='19'>19</OPTION>
<OPTION value='20'>20</OPTION>
<OPTION value='21'>21</OPTION>
<OPTION value='22'>22</OPTION>
<OPTION value='23'>23</OPTION></select>:
<select
type="text"
name='{$fields.schedule.name}_time_minutes'
id='{$fields.schedule.name}_time_minutes'
value="23:00"
>
<OPTION selected value='0'>00</OPTION>
<OPTION value='1'>01</OPTION>
<OPTION value='2'>02</OPTION>
<OPTION value='3'>03</OPTION>
<OPTION value='4'>04</OPTION>
<OPTION value='5'>05</OPTION>
<OPTION value='6'>06</OPTION>
<OPTION value='7'>07</OPTION>
<OPTION value='8'>08</OPTION>
<OPTION value='9'>09</OPTION>
<OPTION value='10'>10</OPTION>
<OPTION value='11'>11</OPTION>
<OPTION value='12'>12</OPTION>
<OPTION value='13'>13</OPTION>
<OPTION value='14'>14</OPTION>
<OPTION value='15'>15</OPTION>
<OPTION value='16'>16</OPTION>
<OPTION value='17'>17</OPTION>
<OPTION value='18'>18</OPTION>
<OPTION value='19'>19</OPTION>
<OPTION value='20'>20</OPTION>
<OPTION value='21'>21</OPTION>
<OPTION value='22'>22</OPTION>
<OPTION value='23'>23</OPTION>
<OPTION value='24'>24</OPTION>
<OPTION value='25'>25</OPTION>
<OPTION value='26'>26</OPTION>
<OPTION value='27'>27</OPTION>
<OPTION value='28'>28</OPTION>
<OPTION value='29'>29</OPTION>
<OPTION value='30'>30</OPTION>
<OPTION value='31'>31</OPTION>
<OPTION value='32'>32</OPTION>
<OPTION value='33'>33</OPTION>
<OPTION value='34'>34</OPTION>
<OPTION value='35'>35</OPTION>
<OPTION value='36'>36</OPTION>
<OPTION value='37'>37</OPTION>
<OPTION value='38'>38</OPTION>
<OPTION value='39'>39</OPTION>
<OPTION value='40'>40</OPTION>
<OPTION value='41'>41</OPTION>
<OPTION value='42'>42</OPTION>
<OPTION value='43'>43</OPTION>
<OPTION value='44'>44</OPTION>
<OPTION value='45'>45</OPTION>
<OPTION value='46'>46</OPTION>
<OPTION value='47'>47</OPTION>
<OPTION value='48'>48</OPTION>
<OPTION value='49'>49</OPTION>
<OPTION value='50'>50</OPTION>
<OPTION value='51'>51</OPTION>
<OPTION value='52'>52</OPTION>
<OPTION value='53'>53</OPTION>
<OPTION value='54'>54</OPTION>
<OPTION value='55'>55</OPTION>
<OPTION value='56'>56</OPTION>
<OPTION value='57'>57</OPTION>
<OPTION value='58'>58</OPTION>
<OPTION value='59'>59</OPTION>
</select>
</span>
<span style='display:none;' id='{$fields.schedule.name}_advanced'>
<label>Min
<input type="text"
size="2"
name='{$fields.schedule.name}_raw_minutes'
id='{$fields.schedule.name}_raw_minutes'
>
</label>
<label>Hour
<input type="text"
size="2"
name='{$fields.schedule.name}_raw_hours'
id='{$fields.schedule.name}_raw_hours'
>
</label>
<label>Day
<input type="text"
size="2"
name='{$fields.schedule.name}_raw_day'
id='{$fields.schedule.name}_raw_day'
>
</label>
<label>Month
<input type="text"
size="2"
name='{$fields.schedule.name}_raw_month'
id='{$fields.schedule.name}_raw_month'
>
</label>
<label>DOW
<input type="text"
size="2"
placeholder=""
name='{$fields.schedule.name}_raw_weekday'
id='{$fields.schedule.name}_raw_weekday'
>
</label>
</span>
<script>
{literal}
$(document).ready(function(){
{/literal}
var id = '{$fields.schedule.name}';
{literal}
$('#'+id+'_type').on('change',function(){
updateCRONType(id);
});
$('#'+id+'_raw').on('change',function(){
updateCRONDisplay(id);
});
$('#'+id+'_basic').on('change',function(){
updateCRONValue(id);
});
var rawChange = function(){
updateCRONValue(id);
}
$('#'+id+'_raw_minutes').change(rawChange);
$('#'+id+'_raw_hours').change(rawChange);
$('#'+id+'_raw_day').change(rawChange);
$('#'+id+'_raw_month').change(rawChange);
$('#'+id+'_raw_weekday').change(rawChange);
updateCRONDisplay(id);
updateCRONType(id);
updateCRONFields(id);
});
{/literal}
</script>
</tr>
{/capture}
{if $fieldsUsed > 0 }
{$tableRow}
{/if}
{counter name="fieldsUsed" start=0 print=false assign="fieldsUsed"}
{capture name="tr" assign="tableRow"}
<tr>
<td valign="top" id='email1_label' width='12.5%' scope="col">
&nbsp;
</td>
{counter name="fieldsUsed"}

<td valign="top" width='37.5%' colspan='3'>
</tr>
{/capture}
{if $fieldsUsed > 0 }
{$tableRow}
{/if}
</table>
</div>
{if $panelFieldCount == 0}
<script>document.getElementById("LBL_SCHEDULED_REPORTS_INFORMATION").style.display='none';</script>
{/if}
</div></div>

<script language="javascript">
    var _form_id = '{$form_id}';
    {literal}
    SUGAR.util.doWhen(function(){
        _form_id = (_form_id == '') ? 'EditView' : _form_id;
        return document.getElementById(_form_id) != null;
    }, SUGAR.themes.actionMenu);
    {/literal}
</script>
{assign var='place' value="_FOOTER"} <!-- to be used for id for buttons with custom code in def files-->
<div class="buttons">
<div class="action_buttons">{if $bean->aclAccess("save")}<input title="{$APP.LBL_SAVE_BUTTON_TITLE}"  class="button" onclick="var _form = document.getElementById('form_SubpanelQuickCreate_AOR_Scheduled_Reports'); disableOnUnloadEditView(); _form.action.value='Save';if(check_form('form_SubpanelQuickCreate_AOR_Scheduled_Reports'))return SUGAR.subpanelUtils.inlineSave(_form.id, 'AOR_Scheduled_Reports_subpanel_save_button');return false;" type="submit" name="AOR_Scheduled_Reports_subpanel_save_button" id="AOR_Scheduled_Reports_subpanel_save_button" value="{$APP.LBL_SAVE_BUTTON_LABEL}">{/if}  <input title="{$APP.LBL_CANCEL_BUTTON_TITLE}" class="button" onclick="return SUGAR.subpanelUtils.cancelCreate($(this).attr('id'));return false;" type="submit" name="AOR_Scheduled_Reports_subpanel_cancel_button" id="AOR_Scheduled_Reports_subpanel_cancel_button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}">  <input title="{$APP.LBL_FULL_FORM_BUTTON_TITLE}" class="button" onclick="var _form = document.getElementById('form_SubpanelQuickCreate_AOR_Scheduled_Reports'); disableOnUnloadEditView(_form); _form.return_action.value='DetailView'; _form.action.value='EditView'; if(typeof(_form.to_pdf)!='undefined') _form.to_pdf.value='0';" type="submit" name="AOR_Scheduled_Reports_subpanel_full_form_button" id="AOR_Scheduled_Reports_subpanel_full_form_button" value="{$APP.LBL_FULL_FORM_BUTTON_LABEL}"> <input type="hidden" name="full_form" value="full_form"> {if $bean->aclAccess("detail")}{if !empty($fields.id.value) && $isAuditEnabled}<input id="btn_view_change_log" title="{$APP.LNK_VIEW_CHANGE_LOG}" class="button" onclick='open_popup("Audit", "600", "400", "&record={$fields.id.value}&module_name=AOR_Scheduled_Reports", true, false,  {ldelim} "call_back_function":"set_return","form_name":"EditView","field_to_name_array":[] {rdelim} ); return false;' type="button" value="{$APP.LNK_VIEW_CHANGE_LOG}">{/if}{/if}<div class="clear"></div></div>
</div>
</form>
{$set_focus_block}
<script>SUGAR.util.doWhen("document.getElementById('EditView') != null",
function(){ldelim}SUGAR.util.buildAccessKeyLabels();{rdelim});
</script><script type="text/javascript">
YAHOO.util.Event.onContentReady("form_SubpanelQuickCreate_AOR_Scheduled_Reports",
    function () {ldelim} initEditView(document.forms.form_SubpanelQuickCreate_AOR_Scheduled_Reports) {rdelim});
//window.setTimeout(, 100);
window.onbeforeunload = function () {ldelim} return onUnloadEditView(); {rdelim};
// bug 55468 -- IE is too aggressive with onUnload event
if ($.browser.msie) {ldelim}
$(document).ready(function() {ldelim}
    $(".collapseLink,.expandLink").click(function (e) {ldelim} e.preventDefault(); {rdelim});
  {rdelim});
{rdelim}
</script>{literal}
<script type="text/javascript">
addForm('form_SubpanelQuickCreate_AOR_Scheduled_Reports');addToValidate('form_SubpanelQuickCreate_AOR_Scheduled_Reports', 'name', 'name', true,'{/literal}{sugar_translate label='LBL_NAME' module='AOR_Scheduled_Reports' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_AOR_Scheduled_Reports', 'date_entered_date', 'date', false,'Date Created' );
addToValidate('form_SubpanelQuickCreate_AOR_Scheduled_Reports', 'date_modified_date', 'date', false,'Date Modified' );
addToValidate('form_SubpanelQuickCreate_AOR_Scheduled_Reports', 'modified_user_id', 'assigned_user_name', false,'{/literal}{sugar_translate label='LBL_MODIFIED' module='AOR_Scheduled_Reports' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_AOR_Scheduled_Reports', 'modified_by_name', 'relate', false,'{/literal}{sugar_translate label='LBL_MODIFIED_NAME' module='AOR_Scheduled_Reports' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_AOR_Scheduled_Reports', 'created_by', 'assigned_user_name', false,'{/literal}{sugar_translate label='LBL_CREATED' module='AOR_Scheduled_Reports' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_AOR_Scheduled_Reports', 'created_by_name', 'relate', false,'{/literal}{sugar_translate label='LBL_CREATED' module='AOR_Scheduled_Reports' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_AOR_Scheduled_Reports', 'description', 'text', false,'{/literal}{sugar_translate label='LBL_DESCRIPTION' module='AOR_Scheduled_Reports' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_AOR_Scheduled_Reports', 'deleted', 'bool', false,'{/literal}{sugar_translate label='LBL_DELETED' module='AOR_Scheduled_Reports' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_AOR_Scheduled_Reports', 'schedule', 'CronSchedule', true,'{/literal}{sugar_translate label='LBL_SCHEDULE' module='AOR_Scheduled_Reports' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_AOR_Scheduled_Reports', 'last_run', 'readonly', false,'{/literal}{sugar_translate label='LBL_LAST_RUN' module='AOR_Scheduled_Reports' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_AOR_Scheduled_Reports', 'status', 'enum', false,'{/literal}{sugar_translate label='LBL_STATUS' module='AOR_Scheduled_Reports' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_AOR_Scheduled_Reports', 'email_recipients', 'longtext', false,'{/literal}{sugar_translate label='LBL_EMAIL_RECIPIENTS' module='AOR_Scheduled_Reports' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_AOR_Scheduled_Reports', 'aor_report_name', 'relate', true,'{/literal}{sugar_translate label='LBL_AOR_REPORT_NAME' module='AOR_Scheduled_Reports' for_js=true}{literal}' );
addToValidate('form_SubpanelQuickCreate_AOR_Scheduled_Reports', 'aor_report_id', 'id', false,'{/literal}{sugar_translate label='LBL_AOR_REPORT_ID' module='AOR_Scheduled_Reports' for_js=true}{literal}' );
addToValidateBinaryDependency('form_SubpanelQuickCreate_AOR_Scheduled_Reports', 'assigned_user_name', 'alpha', false,'{/literal}{sugar_translate label='ERR_SQS_NO_MATCH_FIELD' module='AOR_Scheduled_Reports' for_js=true}{literal}: {/literal}{sugar_translate label='LBL_ASSIGNED_TO' module='AOR_Scheduled_Reports' for_js=true}{literal}', 'assigned_user_id' );
addToValidateBinaryDependency('form_SubpanelQuickCreate_AOR_Scheduled_Reports', 'aor_report_name', 'alpha', true,'{/literal}{sugar_translate label='ERR_SQS_NO_MATCH_FIELD' module='AOR_Scheduled_Reports' for_js=true}{literal}: {/literal}{sugar_translate label='LBL_AOR_REPORT_NAME' module='AOR_Scheduled_Reports' for_js=true}{literal}', 'aor_report_id' );
</script><script language="javascript">if(typeof sqs_objects == 'undefined'){var sqs_objects = new Array;}sqs_objects['form_SubpanelQuickCreate_AOR_Scheduled_Reports_aor_report_name']={"form":"form_SubpanelQuickCreate_AOR_Scheduled_Reports","method":"query","modules":["AOR_Reports"],"group":"or","field_list":["name","id"],"populate_list":["aor_report_name","aor_report_id"],"required_list":["parent_id"],"conditions":[{"name":"name","op":"like_custom","end":"%","value":""}],"order":"name","limit":"30","no_match_text":"No Match"};</script>{/literal}
