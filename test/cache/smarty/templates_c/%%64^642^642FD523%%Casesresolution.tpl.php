<?php /* Smarty version 2.6.11, created on 2015-06-17 08:52:04
         compiled from cache/modules/Import/Casesresolution.tpl */ ?>

<?php if (empty ( $this->_tpl_vars['fields']['resolution']['value'] )):  $this->assign('value', $this->_tpl_vars['fields']['resolution']['default_value']);  else:  $this->assign('value', $this->_tpl_vars['fields']['resolution']['value']);  endif; ?>  




<textarea  id='<?php echo $this->_tpl_vars['fields']['resolution']['name']; ?>
' name='<?php echo $this->_tpl_vars['fields']['resolution']['name']; ?>
'
rows="6" 
cols="80" 
title='' tabindex="1" 
 ><?php echo $this->_tpl_vars['value']; ?>
</textarea>

