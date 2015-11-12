<?php /* Smarty version 2.6.11, created on 2015-06-17 09:56:24
         compiled from cache/modules/Import/Caseswork_log.tpl */ ?>

<?php if (empty ( $this->_tpl_vars['fields']['work_log']['value'] )):  $this->assign('value', $this->_tpl_vars['fields']['work_log']['default_value']);  else:  $this->assign('value', $this->_tpl_vars['fields']['work_log']['value']);  endif; ?>  




<textarea  id='<?php echo $this->_tpl_vars['fields']['work_log']['name']; ?>
' name='<?php echo $this->_tpl_vars['fields']['work_log']['name']; ?>
'
rows="4" 
cols="60" 
title='' tabindex="1" 
 ><?php echo $this->_tpl_vars['value']; ?>
</textarea>

