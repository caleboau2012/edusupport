

{assign var=preForm value="<table width='100%' border='1' cellspacing='0' cellpadding='0'><tr><td><table width='100%'><tr><td>"}
{assign var=displayPreform value=false}
{if isset($bean->contact_id) && !empty($bean->contact_id)}
{assign var=displayPreform value=true}
{assign var=preForm value=$preForm|cat:$MOD.LBL_CONVERTED_CONTACT}
{assign var=preForm value=$preForm|cat:"&nbsp;<a href='index.php?module=Contacts&action=DetailView&record="}
{assign var=preForm value=$preForm|cat:$bean->contact_id}
{assign var=preForm value=$preForm|cat:"'>"}
{assign var=preForm value=$preForm|cat:$bean->contact_name}
{assign var=preForm value=$preForm|cat:"</a>"}
{/if}
{assign var=preForm value=$preForm|cat:"</td><td>"}
{if isset($bean->account_id) && !empty($bean->account_id)}
{assign var=displayPreform value=true}
{assign var=preForm value=$preForm|cat:$MOD.LBL_CONVERTED_ACCOUNT}
{assign var=preForm value=$preForm|cat:"&nbsp;<a href='index.php?module=Accounts&action=DetailView&record="}
{assign var=preForm value=$preForm|cat:$bean->account_id}
{assign var=preForm value=$preForm|cat:"'>"}
{assign var=preForm value=$preForm|cat:$bean->account_name}
{assign var=preForm value=$preForm|cat:"</a>"}
{/if}
{assign var=preForm value=$preForm|cat:"</td><td>"}
{if isset($bean->opportunity_id) && !empty($bean->opportunity_id)}
{assign var=displayPreform value=true}
{assign var=preForm value=$preForm|cat:$MOD.LBL_CONVERTED_OPP}
{assign var=preForm value=$preForm|cat:"&nbsp;<a href='index.php?module=Opportunities&action=DetailView&record="}
{assign var=preForm value=$preForm|cat:$bean->opportunity_id}
{assign var=preForm value=$preForm|cat:"'>"}
{assign var=preForm value=$preForm|cat:$bean->opportunity_name}
{assign var=preForm value=$preForm|cat:"</a>"}
{/if}
{assign var=preForm value=$preForm|cat:"</td></tr></table></td></tr></table>"}
{if $displayPreform}
{$preForm}
<br>
{/if}

<script language="javascript">
{literal}
SUGAR.util.doWhen(function(){
    return $("#contentTable").length == 0;
}, SUGAR.themes.actionMenu);
{/literal}
</script>
<table cellpadding="0" cellspacing="0" border="0" width="100%" id="">
<tr>
<td class="buttons" align="left" NOWRAP width="80%">
<div class="actionsContainer">
<form action="index.php" method="post" name="DetailView" id="formDetailView">
<input type="hidden" name="module" value="{$module}">
<input type="hidden" name="record" value="{$fields.id.value}">
<input type="hidden" name="return_action">
<input type="hidden" name="return_module">
<input type="hidden" name="return_id">
<input type="hidden" name="module_tab">
<input type="hidden" name="isDuplicate" value="false">
<input type="hidden" name="offset" value="{$offset}">
<input type="hidden" name="action" value="EditView">
<input type="hidden" name="sugar_body_only">
</form>
<ul id="detail_header_action_menu" class="clickMenu fancymenu" ><li class="sugar_action_button" >{if $bean->aclAccess("edit")}<input title="{$APP.LBL_EDIT_BUTTON_TITLE}" accessKey="{$APP.LBL_EDIT_BUTTON_KEY}" class="button primary" onclick="var _form = document.getElementById('formDetailView'); _form.return_module.value='Leads'; _form.return_action.value='DetailView'; _form.return_id.value='{$id}'; _form.action.value='EditView';SUGAR.ajaxUI.submitForm(_form);" type="button" name="Edit" id="edit_button" value="{$APP.LBL_EDIT_BUTTON_LABEL}">{/if} <ul id class="subnav" ><li>{if $bean->aclAccess("edit")}<input title="{$APP.LBL_DUPLICATE_BUTTON_TITLE}" accessKey="{$APP.LBL_DUPLICATE_BUTTON_KEY}" class="button" onclick="var _form = document.getElementById('formDetailView'); _form.return_module.value='Leads'; _form.return_action.value='DetailView'; _form.isDuplicate.value=true; _form.action.value='EditView'; _form.return_id.value='{$id}';SUGAR.ajaxUI.submitForm(_form);" type="button" name="Duplicate" value="{$APP.LBL_DUPLICATE_BUTTON_LABEL}" id="duplicate_button">{/if} </li><li>{if $bean->aclAccess("delete")}<input title="{$APP.LBL_DELETE_BUTTON_TITLE}" accessKey="{$APP.LBL_DELETE_BUTTON_KEY}" class="button" onclick="var _form = document.getElementById('formDetailView'); _form.return_module.value='Leads'; _form.return_action.value='ListView'; _form.action.value='Delete'; if(confirm('{$APP.NTC_DELETE_CONFIRMATION}')) SUGAR.ajaxUI.submitForm(_form);" type="submit" name="Delete" value="{$APP.LBL_DELETE_BUTTON_LABEL}" id="delete_button">{/if} </li><li>{if $bean->aclAccess("edit") && $bean->aclAccess("delete")}<input title="{$APP.LBL_DUP_MERGE}" class="button" onclick="var _form = document.getElementById('formDetailView'); _form.return_module.value='Leads'; _form.return_action.value='DetailView'; _form.return_id.value='{$id}'; _form.action.value='Step1'; _form.module.value='MergeRecords';SUGAR.ajaxUI.submitForm(_form);" type="button" name="Merge" value="{$APP.LBL_DUP_MERGE}" id="merge_duplicate_button">{/if} </li><li>{if $bean->aclAccess("edit") && !$DISABLE_CONVERT_ACTION}<input title="{$MOD.LBL_CONVERTLEAD_TITLE}" accessKey="{$MOD.LBL_CONVERTLEAD_BUTTON_KEY}" class="button" onClick="document.location='index.php?module=Leads&action=ConvertLead&record={$fields.id.value}'" name="convert" id="convert_lead_button" type="button" value="{$MOD.LBL_CONVERTLEAD}"/>{/if}</li><li><input title="{$APP.LBL_MANAGE_SUBSCRIPTIONS}" class="button" id="manage_subscriptions_button" onclick="var _form = document.getElementById('formDetailView');_form.return_module.value='Leads'; _form.return_action.value='DetailView';_form.return_id.value='{$fields.id.value}'; _form.action.value='Subscriptions'; _form.module.value='Campaigns'; _form.module_tab.value='Leads';_form.submit();" name="{$APP.LBL_MANAGE_SUBSCRIPTIONS}" type="button" value="{$APP.LBL_MANAGE_SUBSCRIPTIONS}"/></li><li><input type="button" class="button" onClick="showPopup();" value="{$APP.LBL_GENERATE_LETTER}"/></li><li>{if $bean->aclAccess("detail")}{if !empty($fields.id.value) && $isAuditEnabled}<input id="btn_view_change_log" title="{$APP.LNK_VIEW_CHANGE_LOG}" class="button" onclick='open_popup("Audit", "600", "400", "&record={$fields.id.value}&module_name=Leads", true, false,  {ldelim} "call_back_function":"set_return","form_name":"EditView","field_to_name_array":[] {rdelim} ); return false;' type="button" value="{$APP.LNK_VIEW_CHANGE_LOG}">{/if}{/if}</li></ul></li></ul>
</div>
</td>
<td align="right" width="20%">{$ADMIN_EDIT}
{$PAGINATION}
</td>
</tr>
</table>{sugar_include include=$includes}
<div id="Leads_detailview_tabs"
>
<div >
<div id='detailpanel_1' class='detail view  detail508 expanded'>
{counter name="panelFieldCount" start=0 print=false assign="panelFieldCount"}
<h4>
<a href="javascript:void(0)" class="collapseLink" onclick="collapsePanel(1);">
<img border="0" id="detailpanel_1_img_hide" src="{sugar_getimagepath file="basic_search.gif"}"></a>
<a href="javascript:void(0)" class="expandLink" onclick="expandPanel(1);">
<img border="0" id="detailpanel_1_img_show" src="{sugar_getimagepath file="advanced_search.gif"}"></a>
{sugar_translate label='LBL_CONTACT_INFORMATION' module='Leads'}
<script>
document.getElementById('detailpanel_1').className += ' expanded';
</script>
</h4>
<table id='LBL_CONTACT_INFORMATION' class="panelContainer" cellspacing='{$gridline}'>
{counter name="fieldsUsed" start=0 print=false assign="fieldsUsed"}
{counter name="fieldsHidden" start=0 print=false assign="fieldsHidden"}
{capture name="tr" assign="tableRow"}
<tr>
{counter name="fieldsUsed"}
<td width='12.5%' scope="col">
{if !$fields.first_name.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_FIRST_NAME' module='Leads'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="" type="varchar" field="first_name" width='37.5%' colspan='3' >
{if !$fields.first_name.hidden}
{counter name="panelFieldCount"}

{if strlen($fields.first_name.value) <= 0}
{assign var="value" value=$fields.first_name.default_value }
{else}
{assign var="value" value=$fields.first_name.value }
{/if} 
<span class="sugar_field" id="{$fields.first_name.name}">{$fields.first_name.value}</span>
{/if}
</td>
</tr>
{/capture}
{if $fieldsUsed > 0 && $fieldsUsed != $fieldsHidden}
{$tableRow}
{/if}
{counter name="fieldsUsed" start=0 print=false assign="fieldsUsed"}
{counter name="fieldsHidden" start=0 print=false assign="fieldsHidden"}
{capture name="tr" assign="tableRow"}
<tr>
{counter name="fieldsUsed"}
<td width='12.5%' scope="col">
{if !$fields.last_name.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_LAST_NAME' module='Leads'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="" type="varchar" field="last_name" width='37.5%'  >
{if !$fields.last_name.hidden}
{counter name="panelFieldCount"}

{if strlen($fields.last_name.value) <= 0}
{assign var="value" value=$fields.last_name.default_value }
{else}
{assign var="value" value=$fields.last_name.value }
{/if} 
<span class="sugar_field" id="{$fields.last_name.name}">{$fields.last_name.value}</span>
{/if}
</td>
{counter name="fieldsUsed"}
<td width='12.5%' scope="col">
{if !$fields.phone_mobile.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_MOBILE_PHONE' module='Leads'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="" type="phone" field="phone_mobile" width='37.5%'  class="phone">
{if !$fields.phone_mobile.hidden}
{counter name="panelFieldCount"}

{if !empty($fields.phone_mobile.value)}
{assign var="phone_value" value=$fields.phone_mobile.value }
{sugar_phone value=$phone_value usa_format="0"}
{/if}
{/if}
</td>
</tr>
{/capture}
{if $fieldsUsed > 0 && $fieldsUsed != $fieldsHidden}
{$tableRow}
{/if}
{counter name="fieldsUsed" start=0 print=false assign="fieldsUsed"}
{counter name="fieldsHidden" start=0 print=false assign="fieldsHidden"}
{capture name="tr" assign="tableRow"}
<tr>
{counter name="fieldsUsed"}
<td width='12.5%' scope="col">
{if !$fields.title.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_TITLE' module='Leads'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="" type="varchar" field="title" width='37.5%'  >
{if !$fields.title.hidden}
{counter name="panelFieldCount"}

{if strlen($fields.title.value) <= 0}
{assign var="value" value=$fields.title.default_value }
{else}
{assign var="value" value=$fields.title.value }
{/if} 
<span class="sugar_field" id="{$fields.title.name}">{$fields.title.value}</span>
{/if}
</td>
{counter name="fieldsUsed"}
<td width='12.5%' scope="col">
{if !$fields.sales_stage_c.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_SALES_STAGE' module='Leads'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="" type="enum" field="sales_stage_c" width='37.5%'  >
{if !$fields.sales_stage_c.hidden}
{counter name="panelFieldCount"}


{if is_string($fields.sales_stage_c.options)}
<input type="hidden" class="sugar_field" id="{$fields.sales_stage_c.name}" value="{ $fields.sales_stage_c.options }">
{ $fields.sales_stage_c.options }
{else}
<input type="hidden" class="sugar_field" id="{$fields.sales_stage_c.name}" value="{ $fields.sales_stage_c.value }">
{ $fields.sales_stage_c.options[$fields.sales_stage_c.value]}
{/if}
{/if}
</td>
</tr>
{/capture}
{if $fieldsUsed > 0 && $fieldsUsed != $fieldsHidden}
{$tableRow}
{/if}
{counter name="fieldsUsed" start=0 print=false assign="fieldsUsed"}
{counter name="fieldsHidden" start=0 print=false assign="fieldsHidden"}
{capture name="tr" assign="tableRow"}
<tr>
{counter name="fieldsUsed"}
<td width='12.5%' scope="col">
{if !$fields.lead_source.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_LEAD_SOURCE' module='Leads'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="" type="enum" field="lead_source" width='37.5%'  >
{if !$fields.lead_source.hidden}
{counter name="panelFieldCount"}


{if is_string($fields.lead_source.options)}
<input type="hidden" class="sugar_field" id="{$fields.lead_source.name}" value="{ $fields.lead_source.options }">
{ $fields.lead_source.options }
{else}
<input type="hidden" class="sugar_field" id="{$fields.lead_source.name}" value="{ $fields.lead_source.value }">
{ $fields.lead_source.options[$fields.lead_source.value]}
{/if}
{/if}
</td>
{counter name="fieldsUsed"}
<td width='12.5%' scope="col">
{if !$fields.lead_source_description.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_LEAD_SOURCE_DESCRIPTION' module='Leads'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="" type="text" field="lead_source_description" width='37.5%'  >
{if !$fields.lead_source_description.hidden}
{counter name="panelFieldCount"}

<span class="sugar_field" id="{$fields.lead_source_description.name|escape:'html'|url2html|nl2br}">{$fields.lead_source_description.value|escape:'htmlentitydecode'|escape:'html'|url2html|nl2br}</span>
{/if}
</td>
</tr>
{/capture}
{if $fieldsUsed > 0 && $fieldsUsed != $fieldsHidden}
{$tableRow}
{/if}
{counter name="fieldsUsed" start=0 print=false assign="fieldsUsed"}
{counter name="fieldsHidden" start=0 print=false assign="fieldsHidden"}
{capture name="tr" assign="tableRow"}
<tr>
{counter name="fieldsUsed"}
<td width='12.5%' scope="col">
{if !$fields.interest_c.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_INTEREST' module='Leads'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="" type="enum" field="interest_c" width='37.5%'  >
{if !$fields.interest_c.hidden}
{counter name="panelFieldCount"}


{if is_string($fields.interest_c.options)}
<input type="hidden" class="sugar_field" id="{$fields.interest_c.name}" value="{ $fields.interest_c.options }">
{ $fields.interest_c.options }
{else}
<input type="hidden" class="sugar_field" id="{$fields.interest_c.name}" value="{ $fields.interest_c.value }">
{ $fields.interest_c.options[$fields.interest_c.value]}
{/if}
{/if}
</td>
{counter name="fieldsUsed"}
<td width='12.5%' scope="col">
{if !$fields.buying_power_c.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_BUYING_POWER' module='Leads'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="" type="enum" field="buying_power_c" width='37.5%'  >
{if !$fields.buying_power_c.hidden}
{counter name="panelFieldCount"}


{if is_string($fields.buying_power_c.options)}
<input type="hidden" class="sugar_field" id="{$fields.buying_power_c.name}" value="{ $fields.buying_power_c.options }">
{ $fields.buying_power_c.options }
{else}
<input type="hidden" class="sugar_field" id="{$fields.buying_power_c.name}" value="{ $fields.buying_power_c.value }">
{ $fields.buying_power_c.options[$fields.buying_power_c.value]}
{/if}
{/if}
</td>
</tr>
{/capture}
{if $fieldsUsed > 0 && $fieldsUsed != $fieldsHidden}
{$tableRow}
{/if}
{counter name="fieldsUsed" start=0 print=false assign="fieldsUsed"}
{counter name="fieldsHidden" start=0 print=false assign="fieldsHidden"}
{capture name="tr" assign="tableRow"}
<tr>
{counter name="fieldsUsed"}
<td width='12.5%' scope="col">
{if !$fields.primary_address_street.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_PRIMARY_ADDRESS' module='Leads'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="" type="varchar" field="primary_address_street" width='37.5%'  >
{if !$fields.primary_address_street.hidden}
{counter name="panelFieldCount"}

<table border='0' cellpadding='0' cellspacing='0' width='100%'>
<tr>
<td width='99%'>
<input type="hidden" class="sugar_field" id="primary_address_street" value="{$fields.primary_address_street.value|escape:'htmlentitydecode'|escape:'html'|url2html|nl2br}">
<input type="hidden" class="sugar_field" id="primary_address_city" value="{$fields.primary_address_city.value|escape:'htmlentitydecode'|escape:'html'|url2html|nl2br}">
<input type="hidden" class="sugar_field" id="primary_address_state" value="{$fields.primary_address_state.value|escape:'htmlentitydecode'|escape:'html'|url2html|nl2br}">
<input type="hidden" class="sugar_field" id="primary_address_country" value="{$fields.primary_address_country.value|escape:'htmlentitydecode'|escape:'html'|url2html|nl2br}">
<input type="hidden" class="sugar_field" id="primary_address_postalcode" value="{$fields.primary_address_postalcode.value|escape:'htmlentitydecode'|escape:'html'|url2html|nl2br}">
{$fields.primary_address_street.value|escape:'htmlentitydecode'|escape:'html'|url2html|nl2br}<br>
{$fields.primary_address_city.value|escape:'htmlentitydecode'|escape:'html'|url2html|nl2br} {$fields.primary_address_state.value|escape:'htmlentitydecode'|strip_tags|url2html|nl2br}&nbsp;&nbsp;{$fields.primary_address_postalcode.value|escape:'htmlentitydecode'|strip_tags|url2html|nl2br}<br>
{$fields.primary_address_country.value|escape:'htmlentitydecode'|escape:'html'|url2html|nl2br}
</td>
<td class='dataField' width='1%'>
{$custom_code_primary}
</td>
</tr>
</table>
{/if}
</td>
{counter name="fieldsUsed"}
<td width='12.5%' scope="col">
{if !$fields.intended_course_of_study_c.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_INTENDED_COURSE_OF_STUDY' module='Leads'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="" type="varchar" field="intended_course_of_study_c" width='37.5%'  >
{if !$fields.intended_course_of_study_c.hidden}
{counter name="panelFieldCount"}

{if strlen($fields.intended_course_of_study_c.value) <= 0}
{assign var="value" value=$fields.intended_course_of_study_c.default_value }
{else}
{assign var="value" value=$fields.intended_course_of_study_c.value }
{/if} 
<span class="sugar_field" id="{$fields.intended_course_of_study_c.name}">{$fields.intended_course_of_study_c.value}</span>
{/if}
</td>
</tr>
{/capture}
{if $fieldsUsed > 0 && $fieldsUsed != $fieldsHidden}
{$tableRow}
{/if}
{counter name="fieldsUsed" start=0 print=false assign="fieldsUsed"}
{counter name="fieldsHidden" start=0 print=false assign="fieldsHidden"}
{capture name="tr" assign="tableRow"}
<tr>
{counter name="fieldsUsed"}
<td width='12.5%' scope="col">
{if !$fields.email1.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_EMAIL_ADDRESS' module='Leads'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="" type="varchar" field="email1" width='37.5%' colspan='3' >
{if !$fields.email1.hidden}
{counter name="panelFieldCount"}
<span id='email1_span'>
{$fields.email1.value}
</span>
{/if}
</td>
</tr>
{/capture}
{if $fieldsUsed > 0 && $fieldsUsed != $fieldsHidden}
{$tableRow}
{/if}
{counter name="fieldsUsed" start=0 print=false assign="fieldsUsed"}
{counter name="fieldsHidden" start=0 print=false assign="fieldsHidden"}
{capture name="tr" assign="tableRow"}
<tr>
{counter name="fieldsUsed"}
<td width='12.5%' scope="col">
{if !$fields.description.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_DESCRIPTION' module='Leads'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="" type="text" field="description" width='37.5%' colspan='3' >
{if !$fields.description.hidden}
{counter name="panelFieldCount"}

<span class="sugar_field" id="{$fields.description.name|escape:'html'|url2html|nl2br}">{$fields.description.value|escape:'htmlentitydecode'|escape:'html'|url2html|nl2br}</span>
{/if}
</td>
</tr>
{/capture}
{if $fieldsUsed > 0 && $fieldsUsed != $fieldsHidden}
{$tableRow}
{/if}
</table>
<script type="text/javascript">SUGAR.util.doWhen("typeof initPanel == 'function'", function() {ldelim} initPanel(1, 'expanded'); {rdelim}); </script>
</div>
{if $panelFieldCount == 0}
<script>document.getElementById("LBL_CONTACT_INFORMATION").style.display='none';</script>
{/if}
<div id='detailpanel_2' class='detail view  detail508 expanded'>
{counter name="panelFieldCount" start=0 print=false assign="panelFieldCount"}
<h4>
<a href="javascript:void(0)" class="collapseLink" onclick="collapsePanel(2);">
<img border="0" id="detailpanel_2_img_hide" src="{sugar_getimagepath file="basic_search.gif"}"></a>
<a href="javascript:void(0)" class="expandLink" onclick="expandPanel(2);">
<img border="0" id="detailpanel_2_img_show" src="{sugar_getimagepath file="advanced_search.gif"}"></a>
{sugar_translate label='LBL_PANEL_ADVANCED' module='Leads'}
<script>
document.getElementById('detailpanel_2').className += ' expanded';
</script>
</h4>
<table id='LBL_PANEL_ADVANCED' class="panelContainer" cellspacing='{$gridline}'>
{counter name="fieldsUsed" start=0 print=false assign="fieldsUsed"}
{counter name="fieldsHidden" start=0 print=false assign="fieldsHidden"}
{capture name="tr" assign="tableRow"}
<tr>
{counter name="fieldsUsed"}
<td width='12.5%' scope="col">
{if !$fields.status.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_STATUS' module='Leads'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="" type="enum" field="status" width='37.5%'  >
{if !$fields.status.hidden}
{counter name="panelFieldCount"}


{if is_string($fields.status.options)}
<input type="hidden" class="sugar_field" id="{$fields.status.name}" value="{ $fields.status.options }">
{ $fields.status.options }
{else}
<input type="hidden" class="sugar_field" id="{$fields.status.name}" value="{ $fields.status.value }">
{ $fields.status.options[$fields.status.value]}
{/if}
{/if}
</td>
{counter name="fieldsUsed"}
<td width='12.5%' scope="col">
{if !$fields.phone_work.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_OFFICE_PHONE' module='Leads'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="" type="phone" field="phone_work" width='37.5%'  class="phone">
{if !$fields.phone_work.hidden}
{counter name="panelFieldCount"}

{if !empty($fields.phone_work.value)}
{assign var="phone_value" value=$fields.phone_work.value }
{sugar_phone value=$phone_value usa_format="0"}
{/if}
{/if}
</td>
</tr>
{/capture}
{if $fieldsUsed > 0 && $fieldsUsed != $fieldsHidden}
{$tableRow}
{/if}
{counter name="fieldsUsed" start=0 print=false assign="fieldsUsed"}
{counter name="fieldsHidden" start=0 print=false assign="fieldsHidden"}
{capture name="tr" assign="tableRow"}
<tr>
{counter name="fieldsUsed"}
<td width='12.5%' scope="col">
{if !$fields.account_name.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_ACCOUNT_NAME' module='Leads'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="" type="varchar" field="account_name" width='37.5%'  >
{if !$fields.account_name.hidden}
{counter name="panelFieldCount"}

{if strlen($fields.account_name.value) <= 0}
{assign var="value" value=$fields.account_name.default_value }
{else}
{assign var="value" value=$fields.account_name.value }
{/if} 
<span class="sugar_field" id="{$fields.account_name.name}">{$fields.account_name.value}</span>
{/if}
</td>
{counter name="fieldsUsed"}
<td width='12.5%' scope="col">
{if !$fields.status_description.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_STATUS_DESCRIPTION' module='Leads'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="" type="text" field="status_description" width='37.5%'  >
{if !$fields.status_description.hidden}
{counter name="panelFieldCount"}

<span class="sugar_field" id="{$fields.status_description.name|escape:'html'|url2html|nl2br}">{$fields.status_description.value|escape:'htmlentitydecode'|escape:'html'|url2html|nl2br}</span>
{/if}
</td>
</tr>
{/capture}
{if $fieldsUsed > 0 && $fieldsUsed != $fieldsHidden}
{$tableRow}
{/if}
{counter name="fieldsUsed" start=0 print=false assign="fieldsUsed"}
{counter name="fieldsHidden" start=0 print=false assign="fieldsHidden"}
{capture name="tr" assign="tableRow"}
<tr>
{counter name="fieldsUsed"}
<td width='12.5%' scope="col">
{if !$fields.modified_by_name.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_MODIFIED_NAME' module='Leads'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="" type="relate" field="modified_by_name" width='37.5%'  >
{if !$fields.modified_by_name.hidden}
{counter name="panelFieldCount"}

<span id="modified_user_id" class="sugar_field" data-id-value="{$fields.modified_user_id.value}">{$fields.modified_by_name.value}</span>
{/if}
</td>
{counter name="fieldsUsed"}
<td width='12.5%' scope="col">
{if !$fields.refered_by.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_REFERED_BY' module='Leads'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="" type="varchar" field="refered_by" width='37.5%'  >
{if !$fields.refered_by.hidden}
{counter name="panelFieldCount"}

{if strlen($fields.refered_by.value) <= 0}
{assign var="value" value=$fields.refered_by.default_value }
{else}
{assign var="value" value=$fields.refered_by.value }
{/if} 
<span class="sugar_field" id="{$fields.refered_by.name}">{$fields.refered_by.value}</span>
{/if}
</td>
</tr>
{/capture}
{if $fieldsUsed > 0 && $fieldsUsed != $fieldsHidden}
{$tableRow}
{/if}
{counter name="fieldsUsed" start=0 print=false assign="fieldsUsed"}
{counter name="fieldsHidden" start=0 print=false assign="fieldsHidden"}
{capture name="tr" assign="tableRow"}
<tr>
{counter name="fieldsUsed"}
<td width='12.5%' scope="col">
{if !$fields.reason_c.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_REASON' module='Leads'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="" type="enum" field="reason_c" width='37.5%' colspan='3' >
{if !$fields.reason_c.hidden}
{counter name="panelFieldCount"}


{if is_string($fields.reason_c.options)}
<input type="hidden" class="sugar_field" id="{$fields.reason_c.name}" value="{ $fields.reason_c.options }">
{ $fields.reason_c.options }
{else}
<input type="hidden" class="sugar_field" id="{$fields.reason_c.name}" value="{ $fields.reason_c.value }">
{ $fields.reason_c.options[$fields.reason_c.value]}
{/if}
{/if}
</td>
</tr>
{/capture}
{if $fieldsUsed > 0 && $fieldsUsed != $fieldsHidden}
{$tableRow}
{/if}
</table>
<script type="text/javascript">SUGAR.util.doWhen("typeof initPanel == 'function'", function() {ldelim} initPanel(2, 'expanded'); {rdelim}); </script>
</div>
{if $panelFieldCount == 0}
<script>document.getElementById("LBL_PANEL_ADVANCED").style.display='none';</script>
{/if}
<div id='detailpanel_3' class='detail view  detail508 expanded'>
{counter name="panelFieldCount" start=0 print=false assign="panelFieldCount"}
<h4>
<a href="javascript:void(0)" class="collapseLink" onclick="collapsePanel(3);">
<img border="0" id="detailpanel_3_img_hide" src="{sugar_getimagepath file="basic_search.gif"}"></a>
<a href="javascript:void(0)" class="expandLink" onclick="expandPanel(3);">
<img border="0" id="detailpanel_3_img_show" src="{sugar_getimagepath file="advanced_search.gif"}"></a>
{sugar_translate label='LBL_PANEL_ASSIGNMENT' module='Leads'}
<script>
document.getElementById('detailpanel_3').className += ' expanded';
</script>
</h4>
<table id='LBL_PANEL_ASSIGNMENT' class="panelContainer" cellspacing='{$gridline}'>
{counter name="fieldsUsed" start=0 print=false assign="fieldsUsed"}
{counter name="fieldsHidden" start=0 print=false assign="fieldsHidden"}
{capture name="tr" assign="tableRow"}
<tr>
{counter name="fieldsUsed"}
<td width='12.5%' scope="col">
{if !$fields.assigned_user_name.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_ASSIGNED_TO' module='Leads'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="" type="relate" field="assigned_user_name" width='37.5%' colspan='3' >
{if !$fields.assigned_user_name.hidden}
{counter name="panelFieldCount"}

<span id="assigned_user_id" class="sugar_field" data-id-value="{$fields.assigned_user_id.value}">{$fields.assigned_user_name.value}</span>
{/if}
</td>
</tr>
{/capture}
{if $fieldsUsed > 0 && $fieldsUsed != $fieldsHidden}
{$tableRow}
{/if}
</table>
<script type="text/javascript">SUGAR.util.doWhen("typeof initPanel == 'function'", function() {ldelim} initPanel(3, 'expanded'); {rdelim}); </script>
</div>
{if $panelFieldCount == 0}
<script>document.getElementById("LBL_PANEL_ASSIGNMENT").style.display='none';</script>
{/if}
</div>
</div>

</form>
<script>SUGAR.util.doWhen("document.getElementById('form') != null",
function(){ldelim}SUGAR.util.buildAccessKeyLabels();{rdelim});
</script><script type="text/javascript" src="include/InlineEditing/inlineEditing.js"></script>