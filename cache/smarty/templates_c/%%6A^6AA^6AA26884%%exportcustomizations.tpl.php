<?php /* Smarty version 2.6.11, created on 2015-12-10 14:04:59
         compiled from modules/ModuleBuilder/tpls/exportcustomizations.tpl */ ?>

<form name="exportcustom" id="exportcustom">
<input type='hidden' name='module' value='ModuleBuilder'>
<input type='hidden' name='action' value='ExportCustom'>
<div align="left">
<input type="submit" class="button" name="exportCustomBtn" value="<?php echo $this->_tpl_vars['mod_strings']['LBL_EC_EXPORTBTN']; ?>
" onclick="return check_form('exportcustom');">
</div>
<br>
    <table class="mbTable">
    <tbody>
    <tr>
    	<td class="mbLBL">
    		<b><font color="#ff0000">*</font> <?php echo $this->_tpl_vars['mod_strings']['LBL_EC_NAME']; ?>
 </b>
    	</td>
    	<td>
    		<input type="text" value="" size="50" name="name"/>
    	</td>
    </tr>
    <tr>
    	<td class="mbLBL">
    		<b><?php echo $this->_tpl_vars['mod_strings']['LBL_EC_AUTHOR']; ?>
 </b>
    	</td>
    	<td>
    		<input type="text" value="" size="50" name="author"/>
    	</td>
    </tr>
    <tr>
    	<td class="mbLBL">
    		<b><?php echo $this->_tpl_vars['mod_strings']['LBL_EC_DESCRIPTION']; ?>
 </b>
    	</td>
    	<td>
    		<textarea rows="3" cols="60" name="description"></textarea>
    	</td>
    </tr>
    <tr>
    	<td height="100%"/>
    	<td/>
    </tr>
    </tbody>
	</table>
	
    <table border="0" CELLSPACING="15" WIDTH="100%">
        <TR><input type="hidden" name="hiddenCount"></TR>
        <?php $_from = $this->_tpl_vars['modules']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['i']):
?>
        
        <TR>
            <TD><h3 style='margin-bottom:20px;'><?php if ($this->_tpl_vars['i'] != ""): ?><INPUT onchange="updateCount(this);" type="checkbox" name="modules[]" value=<?php echo $this->_tpl_vars['k']; ?>
><?php endif;  echo $this->_tpl_vars['moduleList'][$this->_tpl_vars['k']]; ?>
</h3></TD>
            <TD VALIGN="top">
            <?php $_from = $this->_tpl_vars['i']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['j']):
?>
            <?php echo $this->_tpl_vars['j']; ?>
<br>
            <?php endforeach; endif; unset($_from); ?>
            </TD>
        </TR>
        
        <?php endforeach; endif; unset($_from); ?> 
    </table>
    <br> 
</form>

<?php echo '
<script type="text/javascript">
var boxChecked = 0;

function updateCount(box) {
   boxChecked = box.checked == true ? ++boxChecked : --boxChecked;
   document.exportcustom.hiddenCount.value = (boxChecked == 0 ? "" : "CHECKED");
}
'; ?>

ModuleBuilder.helpRegister('exportcustom');
ModuleBuilder.helpSetup('exportcustom','exportHelp');
addToValidate('exportcustom', 'hiddenCount', 'varchar', true, '<?php echo $this->_tpl_vars['mod_strings']['LBL_EC_CHECKERROR']; ?>
');
addToValidate('exportcustom', 'name', 'varchar', true, '<?php echo $this->_tpl_vars['mod_strings']['LBL_PACKAGE_NAME']; ?>
'<?php echo ');
</script>
'; ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'modules/ModuleBuilder/tpls/assistantJavascript.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>