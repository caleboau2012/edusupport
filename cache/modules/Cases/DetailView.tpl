

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
<ul id="detail_header_action_menu" class="clickMenu fancymenu" ><li class="sugar_action_button" >{if $bean->aclAccess("edit")}<input title="{$APP.LBL_EDIT_BUTTON_TITLE}" accessKey="{$APP.LBL_EDIT_BUTTON_KEY}" class="button primary" onclick="var _form = document.getElementById('formDetailView'); _form.return_module.value='Cases'; _form.return_action.value='DetailView'; _form.return_id.value='{$id}'; _form.action.value='EditView';SUGAR.ajaxUI.submitForm(_form);" type="button" name="Edit" id="edit_button" value="{$APP.LBL_EDIT_BUTTON_LABEL}">{/if} <ul id class="subnav" ><li>{if $bean->aclAccess("edit")}<input title="{$APP.LBL_DUPLICATE_BUTTON_TITLE}" accessKey="{$APP.LBL_DUPLICATE_BUTTON_KEY}" class="button" onclick="var _form = document.getElementById('formDetailView'); _form.return_module.value='Cases'; _form.return_action.value='DetailView'; _form.isDuplicate.value=true; _form.action.value='EditView'; _form.return_id.value='{$id}';SUGAR.ajaxUI.submitForm(_form);" type="button" name="Duplicate" value="{$APP.LBL_DUPLICATE_BUTTON_LABEL}" id="duplicate_button">{/if} </li><li>{if $bean->aclAccess("delete")}<input title="{$APP.LBL_DELETE_BUTTON_TITLE}" accessKey="{$APP.LBL_DELETE_BUTTON_KEY}" class="button" onclick="var _form = document.getElementById('formDetailView'); _form.return_module.value='Cases'; _form.return_action.value='ListView'; _form.action.value='Delete'; if(confirm('{$APP.NTC_DELETE_CONFIRMATION}')) SUGAR.ajaxUI.submitForm(_form);" type="submit" name="Delete" value="{$APP.LBL_DELETE_BUTTON_LABEL}" id="delete_button">{/if} </li><li>{if $bean->aclAccess("edit") && $bean->aclAccess("delete")}<input title="{$APP.LBL_DUP_MERGE}" class="button" onclick="var _form = document.getElementById('formDetailView'); _form.return_module.value='Cases'; _form.return_action.value='DetailView'; _form.return_id.value='{$id}'; _form.action.value='Step1'; _form.module.value='MergeRecords';SUGAR.ajaxUI.submitForm(_form);" type="button" name="Merge" value="{$APP.LBL_DUP_MERGE}" id="merge_duplicate_button">{/if} </li><li>{if $bean->aclAccess("detail")}{if !empty($fields.id.value) && $isAuditEnabled}<input id="btn_view_change_log" title="{$APP.LNK_VIEW_CHANGE_LOG}" class="button" onclick='open_popup("Audit", "600", "400", "&record={$fields.id.value}&module_name=Cases", true, false,  {ldelim} "call_back_function":"set_return","form_name":"EditView","field_to_name_array":[] {rdelim} ); return false;' type="button" value="{$APP.LNK_VIEW_CHANGE_LOG}">{/if}{/if}</li></ul></li></ul>
</div>
</td>
<td align="right" width="20%">{$ADMIN_EDIT}
{$PAGINATION}
</td>
</tr>
</table>{sugar_include include=$includes}
<div id="Cases_detailview_tabs"
>
<div >
<div id='detailpanel_1' class='detail view  detail508 expanded'>
{counter name="panelFieldCount" start=0 print=false assign="panelFieldCount"}
<h4>
<a href="javascript:void(0)" class="collapseLink" onclick="collapsePanel(1);">
<img border="0" id="detailpanel_1_img_hide" src="{sugar_getimagepath file="basic_search.gif"}"></a>
<a href="javascript:void(0)" class="expandLink" onclick="expandPanel(1);">
<img border="0" id="detailpanel_1_img_show" src="{sugar_getimagepath file="advanced_search.gif"}"></a>
{sugar_translate label='LBL_CASE_INFORMATION' module='Cases'}
<script>
document.getElementById('detailpanel_1').className += ' expanded';
</script>
</h4>
<table id='LBL_CASE_INFORMATION' class="panelContainer" cellspacing='{$gridline}'>
{counter name="fieldsUsed" start=0 print=false assign="fieldsUsed"}
{counter name="fieldsHidden" start=0 print=false assign="fieldsHidden"}
{capture name="tr" assign="tableRow"}
<tr>
{counter name="fieldsUsed"}
<td width='12.5%' scope="col">
{if !$fields.case_number.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_CASE_NUMBER' module='Cases'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="" type="int" field="case_number" width='37.5%'  >
{if !$fields.case_number.hidden}
{counter name="panelFieldCount"}

<span class="sugar_field" id="{$fields.case_number.name}">
{assign var="value" value=$fields.case_number.value }
{$value}
</span>
{/if}
</td>
{counter name="fieldsUsed"}
<td width='12.5%' scope="col">
{if !$fields.priority.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_PRIORITY' module='Cases'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="" type="enum" field="priority" width='37.5%'  >
{if !$fields.priority.hidden}
{counter name="panelFieldCount"}


{if is_string($fields.priority.options)}
<input type="hidden" class="sugar_field" id="{$fields.priority.name}" value="{ $fields.priority.options }">
{ $fields.priority.options }
{else}
<input type="hidden" class="sugar_field" id="{$fields.priority.name}" value="{ $fields.priority.value }">
{ $fields.priority.options[$fields.priority.value]}
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
{if !$fields.state.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_STATE' module='Cases'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="" type="enum" field="state" width='37.5%'  >
{if !$fields.state.hidden}
{counter name="panelFieldCount"}


{if is_string($fields.state.options)}
<input type="hidden" class="sugar_field" id="{$fields.state.name}" value="{ $fields.state.options }">
{ $fields.state.options }
{else}
<input type="hidden" class="sugar_field" id="{$fields.state.name}" value="{ $fields.state.value }">
{ $fields.state.options[$fields.state.value]}
{/if}
{/if}
</td>
{counter name="fieldsUsed"}
<td width='12.5%' scope="col">
{if !$fields.account_name.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_ACCOUNT_NAME' module='Cases'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="" type="relate" field="account_name" width='37.5%'  >
{if !$fields.account_name.hidden}
{counter name="panelFieldCount"}

{if !empty($fields.account_id.value)}
{capture assign="detail_url"}index.php?module=Accounts&action=DetailView&record={$fields.account_id.value}{/capture}
<a href="{sugar_ajax_url url=$detail_url}">{/if}
<span id="account_id" class="sugar_field" data-id-value="{$fields.account_id.value}">{$fields.account_name.value}</span>
{if !empty($fields.account_id.value)}</a>{/if}
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
{if !$fields.type.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_TYPE' module='Cases'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="" type="enum" field="type" width='37.5%'  >
{if !$fields.type.hidden}
{counter name="panelFieldCount"}


{if is_string($fields.type.options)}
<input type="hidden" class="sugar_field" id="{$fields.type.name}" value="{ $fields.type.options }">
{ $fields.type.options }
{else}
<input type="hidden" class="sugar_field" id="{$fields.type.name}" value="{ $fields.type.value }">
{ $fields.type.options[$fields.type.value]}
{/if}
{/if}
</td>
{counter name="fieldsUsed"}
<td width='12.5%' scope="col">
{if !$fields.location_c.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_LOCATION' module='Cases'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="" type="varchar" field="location_c" width='37.5%'  >
{if !$fields.location_c.hidden}
{counter name="panelFieldCount"}

{if strlen($fields.location_c.value) <= 0}
{assign var="value" value=$fields.location_c.default_value }
{else}
{assign var="value" value=$fields.location_c.value }
{/if} 
<span class="sugar_field" id="{$fields.location_c.name}">{$fields.location_c.value}</span>
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
{if !$fields.comm_channel_c.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_COMM_CHANNEL' module='Cases'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="" type="enum" field="comm_channel_c" width='37.5%'  >
{if !$fields.comm_channel_c.hidden}
{counter name="panelFieldCount"}


{if is_string($fields.comm_channel_c.options)}
<input type="hidden" class="sugar_field" id="{$fields.comm_channel_c.name}" value="{ $fields.comm_channel_c.options }">
{ $fields.comm_channel_c.options }
{else}
<input type="hidden" class="sugar_field" id="{$fields.comm_channel_c.name}" value="{ $fields.comm_channel_c.value }">
{ $fields.comm_channel_c.options[$fields.comm_channel_c.value]}
{/if}
{/if}
</td>
{counter name="fieldsUsed"}
<td width='12.5%' scope="col">
{if !$fields.created_by_name.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_CREATED' module='Cases'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="" type="relate" field="created_by_name" width='37.5%'  >
{if !$fields.created_by_name.hidden}
{counter name="panelFieldCount"}

<span id="created_by" class="sugar_field" data-id-value="{$fields.created_by.value}">{$fields.created_by_name.value}</span>
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
{if !$fields.name.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_SUBJECT' module='Cases'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="" type="name" field="name" width='37.5%' colspan='3' >
{if !$fields.name.hidden}
{counter name="panelFieldCount"}

{if strlen($fields.name.value) <= 0}
{assign var="value" value=$fields.name.default_value }
{else}
{assign var="value" value=$fields.name.value }
{/if} 
<span class="sugar_field" id="{$fields.name.name}">{$fields.name.value}</span>
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
{capture name="label" assign="label"}{sugar_translate label='LBL_DESCRIPTION' module='Cases'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="" type="text" field="description" width='37.5%'  >
{if !$fields.description.hidden}
{counter name="panelFieldCount"}

<span class="sugar_field" id="{$fields.description.name|escape:'html'|url2html|nl2br}">{$fields.description.value|escape:'htmlentitydecode'|escape:'html'|url2html|nl2br}</span>
{/if}
</td>
{counter name="fieldsUsed"}
<td width='12.5%' scope="col">
{if !$fields.referred_by_c.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_REFERRED_BY' module='Cases'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="" type="varchar" field="referred_by_c" width='37.5%'  >
{if !$fields.referred_by_c.hidden}
{counter name="panelFieldCount"}

{if strlen($fields.referred_by_c.value) <= 0}
{assign var="value" value=$fields.referred_by_c.default_value }
{else}
{assign var="value" value=$fields.referred_by_c.value }
{/if} 
<span class="sugar_field" id="{$fields.referred_by_c.name}">{$fields.referred_by_c.value}</span>
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
{if !$fields.resolution.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_RESOLUTION' module='Cases'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="" type="text" field="resolution" width='37.5%' colspan='3' >
{if !$fields.resolution.hidden}
{counter name="panelFieldCount"}

<span class="sugar_field" id="{$fields.resolution.name|escape:'html'|url2html|nl2br}">{$fields.resolution.value|escape:'htmlentitydecode'|escape:'html'|url2html|nl2br}</span>
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
{if !$fields.update_text.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_UPDATE_TEXT' module='Cases'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="" type="text" field="update_text" width='37.5%'  >
{if !$fields.update_text.hidden}
{counter name="panelFieldCount"}

<span class="sugar_field" id="{$fields.update_text.name|escape:'html'|url2html|nl2br}">{$fields.update_text.value|escape:'htmlentitydecode'|escape:'html'|url2html|nl2br}</span>
{/if}
</td>
{counter name="fieldsUsed"}
<td width='12.5%' scope="col">
{if !$fields.internal.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_INTERNAL' module='Cases'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="" type="bool" field="internal" width='37.5%'  >
{if !$fields.internal.hidden}
{counter name="panelFieldCount"}

{if strval($fields.internal.value) == "1" || strval($fields.internal.value) == "yes" || strval($fields.internal.value) == "on"} 
{assign var="checked" value="CHECKED"}
{else}
{assign var="checked" value=""}
{/if}
<input type="checkbox" class="checkbox" name="{$fields.internal.name}" id="{$fields.internal.name}" value="$fields.internal.value" disabled="true" {$checked}>
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
{if !$fields.case_update_form.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_CASE_UPDATE_FORM' module='Cases'}{/capture}
{$label|strip_semicolon}:
{/if}
</td>
<td class="" type="function" field="case_update_form" width='37.5%' colspan='3' >
{if !$fields.case_update_form.hidden}
{counter name="panelFieldCount"}
<span id='case_update_form_span'>
{$fields.case_update_form.value}
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
{if !$fields.assigned_user_name.hidden}
{capture name="label" assign="label"}{sugar_translate label='LBL_ASSIGNED_TO' module='Cases'}{/capture}
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
<script type="text/javascript">SUGAR.util.doWhen("typeof initPanel == 'function'", function() {ldelim} initPanel(1, 'expanded'); {rdelim}); </script>
</div>
{if $panelFieldCount == 0}
<script>document.getElementById("LBL_CASE_INFORMATION").style.display='none';</script>
{/if}
</div>
</div>

</form>
<script>SUGAR.util.doWhen("document.getElementById('form') != null",
function(){ldelim}SUGAR.util.buildAccessKeyLabels();{rdelim});
</script><script type="text/javascript" src="include/InlineEditing/inlineEditing.js"></script>