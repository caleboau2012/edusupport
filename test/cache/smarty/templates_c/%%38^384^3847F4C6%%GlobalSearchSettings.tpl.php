<?php /* Smarty version 2.6.11, created on 2015-06-15 07:34:56
         compiled from modules/Administration/templates/GlobalSearchSettings.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'sugar_getjspath', 'modules/Administration/templates/GlobalSearchSettings.tpl', 58, false),array('function', 'sugar_translate', 'modules/Administration/templates/GlobalSearchSettings.tpl', 114, false),)), $this); ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
    <td colspan="100">
        <h2> <?php echo $this->_tpl_vars['moduleTitle']; ?>
</h2>
    </td>
</tr>
<tr>
    <td colspan="100"><?php echo $this->_tpl_vars['MOD']['LBL_GLOBAL_SEARCH_SETTINGS_TITLE']; ?>
</td>
</tr>
<tr>
    <td>
        <br>
    </td>
</tr>
<tr>
<td colspan="100">

<script type="text/javascript" src="<?php echo smarty_function_sugar_getjspath(array('file' => 'cache/include/javascript/sugar_grp_yui_widgets.js'), $this);?>
"></script>
<link rel="stylesheet" type="text/css" href="<?php echo smarty_function_sugar_getjspath(array('file' => 'modules/Connectors/tpls/tabs.css'), $this);?>
"/>
<form name="GlobalSearchSettings" method="POST">
	<input type="hidden" name="module" value="Administration">
	<input type="hidden" name="action" value="saveGlobalSearchSettings">
	<input type="hidden" name="enabled_modules" value="">

	<table border="0" cellspacing="1" cellpadding="1">
		<tr>
			<td>
			<input title="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_LABEL']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_TITLE']; ?>
" class="button primary" onclick="SUGAR.saveGlobalSearchSettings();" type="button" name="button" value="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_LABEL']; ?>
">
                <input title="<?php echo $this->_tpl_vars['MOD']['LBL_SAVE_SCHED_BUTTON']; ?>
" class="button primary schedFullSystemIndex" onclick="SUGAR.FTS.schedFullSystemIndex();" style="<?php if (! $this->_tpl_vars['showSchedButton']): ?>display:none;<?php endif; ?>text-decoration: none;" id='schedFullSystemIndexBtn' type="button" name="button" value="<?php echo $this->_tpl_vars['MOD']['LBL_SAVE_SCHED_BUTTON']; ?>
">
            <input title="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_LABEL']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_KEY']; ?>
" class="button" onclick="document.GlobalSearchSettings.action.value='';" type="submit" name="button" value="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_LABEL']; ?>
">
			</td>
		</tr>
	</table>

	<div class='add_table' style='margin-bottom:5px'>
		<table id="GlobalSearchSettings" class="GlobalSearchSettings edit view" style='margin-bottom:0px;' border="0" cellspacing="0" cellpadding="0">
		    <tr>
				<td width='1%'>
					<div id="enabled_div"></div>
				</td>
				<td>
					<div id="disabled_div"></div>
				</td>
			</tr>
		</table>
	</div>
	<table border="0" cellspacing="1" cellpadding="1">
		<tr>
			<td>
				<input title="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_LABEL']; ?>
" class="button primary" onclick="SUGAR.saveGlobalSearchSettings();" type="button" name="button" value="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_LABEL']; ?>
">
                <input title="<?php echo $this->_tpl_vars['MOD']['LBL_SAVE_SCHED_BUTTON']; ?>
" class="button primary schedFullSystemIndex" onclick="SUGAR.FTS.schedFullSystemIndex();" style="<?php if (! $this->_tpl_vars['showSchedButton']): ?>display:none;<?php endif; ?>text-decoration: none;" id='schedFullSystemIndex' type="button" name="button" value="<?php echo $this->_tpl_vars['MOD']['LBL_SAVE_SCHED_BUTTON']; ?>
">
                <input title="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_LABEL']; ?>
" class="button" onclick="document.GlobalSearchSettings.action.value='';" type="submit" name="button" value="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_LABEL']; ?>
">
			</td>
		</tr>
	</table>
</form>

<div id='selectFTSModules' class="yui-hidden">
    <div style="background-color: white; padding: 20px;">
        <div id='selectFTSModulesTable' ></div>
        <div style="padding-top: 10px"><input type="checkbox" name="clearDataOnIndex" id="clearDataOnIndex" >&nbsp;<?php echo $this->_tpl_vars['MOD']['LBL_DELETE_FTS_DATA']; ?>
</div>
    </div>
</div>
<script type="text/javascript">
(function(){
    var Connect = YAHOO.util.Connect;
	Connect.url = 'index.php';
    Connect.method = 'POST';
    Connect.timeout = 300000;
	var get = YAHOO.util.Dom.get;

	var enabled_modules = <?php echo $this->_tpl_vars['enabled_modules']; ?>
;
	var disabled_modules = <?php echo $this->_tpl_vars['disabled_modules']; ?>
;
	var lblEnabled = '<?php echo smarty_function_sugar_translate(array('label' => 'LBL_ACTIVE_MODULES'), $this);?>
';
	var lblDisabled = '<?php echo smarty_function_sugar_translate(array('label' => 'LBL_DISABLED_MODULES'), $this);?>
';
	<?php echo '
	SUGAR.globalSearchEnabledTable = new YAHOO.SUGAR.DragDropTable(
		"enabled_div",
		[{key:"label",  label: lblEnabled, width: 200, sortable: false},
		 {key:"module", label: lblEnabled, hidden:true}],
		new YAHOO.util.LocalDataSource(enabled_modules, {
			responseSchema: {fields : [{key : "module"}, {key : "label"}]}
		}),
		{height: "300px"}
	);
	SUGAR.globalSearchDisabledTable = new YAHOO.SUGAR.DragDropTable(
		"disabled_div",
		[{key:"label",  label: lblDisabled, width: 200, sortable: false},
		 {key:"module", label: lblDisabled, hidden:true}],
		new YAHOO.util.LocalDataSource(disabled_modules, {
			responseSchema: {fields : [{key : "module"}, {key : "label"}]}
		}),
		{height: "300px"}
	);

	SUGAR.globalSearchEnabledTable.disableEmptyRows = true;
	SUGAR.globalSearchDisabledTable.disableEmptyRows = true;
	SUGAR.globalSearchEnabledTable.addRow({module: "", label: ""});
	SUGAR.globalSearchDisabledTable.addRow({module: "", label: ""});
	SUGAR.globalSearchEnabledTable.render();
	SUGAR.globalSearchDisabledTable.render();

    SUGAR.getEnabledModules = function()
    {
        var enabledTable = SUGAR.globalSearchEnabledTable;
        var modules = "";
        for(var i=0; i < enabledTable.getRecordSet().getLength(); i++)
        {
            var data = enabledTable.getRecord(i).getData();
            if (data.module && data.module != \'\')
                modules += "," + data.module;
        }
        return modules;
    }
    SUGAR.getEnabledModulesForFTSSched = function()
    {
        var enabledTable = SUGAR.FTS.selectedDataTable;
        var modules = [];
        var selectedIDs = enabledTable.getSelectedRows();
        for(var i=0; i < selectedIDs.length; i++)
        {
            var data = enabledTable.getRecord(selectedIDs[i]).getData();
            modules.push(data.module);
        }

        return modules;
    }
    SUGAR.getTranslatedEnabledModules = function()
    {
        var enabledTable = SUGAR.globalSearchEnabledTable;
        var modules = [{module:\'\', label: SUGAR.language.get(\'Administration\', \'LBL_ALL\')}];
        for(var i=0; i < enabledTable.getRecordSet().getLength(); i++)
        {
            var data = enabledTable.getRecord(i).getData();
            if (data.module && data.module != \'\')
            {
                var tmp = {\'module\' : data.module, \'label\' : data.label};
                modules.push(tmp);
            }
        }

        return modules;
    }
	SUGAR.saveGlobalSearchSettings = function()
	{
		var enabledTable = SUGAR.globalSearchEnabledTable;
		var modules = SUGAR.getEnabledModules();
		modules = modules == "" ? modules : modules.substr(1);

		ajaxStatus.showStatus(SUGAR.language.get(\'Administration\', \'LBL_SAVING\'));
		Connect.asyncRequest(
            Connect.method,
            Connect.url,
            {success: SUGAR.saveCallBack},
			SUGAR.util.paramsToUrl({
				module: "Administration",
				action: "saveglobalsearchsettings",
				enabled_modules: modules
			}) + "to_pdf=1"
        );

		return true;
	}

	SUGAR.saveCallBack = function(o)
	{
	   ajaxStatus.flashStatus(SUGAR.language.get(\'app_strings\', \'LBL_DONE\'));
	   if (o.responseText == "true")
	   {
	       window.location.assign(\'index.php?module=Administration&action=index\');
	   } else {
	       YAHOO.SUGAR.MessageBox.show({msg:o.responseText});
	   }
	}
})();
'; ?>

</script>
<script type="text/javascript">
</script>