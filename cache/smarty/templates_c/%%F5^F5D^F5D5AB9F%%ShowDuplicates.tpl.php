<?php /* Smarty version 2.6.11, created on 2015-11-25 09:56:38
         compiled from modules/Leads/tpls/ShowDuplicates.tpl */ ?>
<?php echo $this->_tpl_vars['TITLE']; ?>

<p>
<form action='index.php' method='post' name='Save'>
<input type="hidden" name="module" value="Leads">
<input type="hidden" name="return_module" value="<?php echo $this->_tpl_vars['RETURN_MODULE']; ?>
">
<input type="hidden" name="return_action" value="<?php echo $this->_tpl_vars['RETURN_ACTION']; ?>
">
<input type="hidden" name="return_id" value="<?php echo $this->_tpl_vars['RETURN_ID']; ?>
">
<input type="hidden" name="inbound_email_id" value="<?php echo $this->_tpl_vars['INBOUND_EMAIL_ID']; ?>
">
<input type="hidden" name="start" value="<?php echo $this->_tpl_vars['START']; ?>
">
<input type="hidden" name="dup_checked" value="true">
<input type="hidden" name="action" value="">
<?php echo $this->_tpl_vars['INPUT_FIELDS']; ?>

<table cellpadding="0" cellspacing="0" width="100%" border="0" >
<tr>
<td>
<table cellpadding="0" cellspacing="0" width="100%" border="0" >
<tr>
<td  valign='top' align='left'><?php echo $this->_tpl_vars['FORMBODY'];  echo $this->_tpl_vars['FORMFOOTER'];  echo $this->_tpl_vars['POSTFORM']; ?>
</td>
</tr>
</table>
</td>
</tr>
</table>
<p>