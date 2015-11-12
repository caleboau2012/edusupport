<?php /* Smarty version 2.6.11, created on 2015-06-11 15:44:04
         compiled from cache/modules/Import/Contactsfull_name.tpl */ ?>

<?php if (strlen ( $this->_tpl_vars['fields']['full_name']['value'] ) <= 0):  $this->assign('value', $this->_tpl_vars['fields']['full_name']['default_value']);  else:  $this->assign('value', $this->_tpl_vars['fields']['full_name']['value']);  endif; ?>  
<input type='text' name='<?php echo $this->_tpl_vars['fields']['full_name']['name']; ?>
' 
    id='<?php echo $this->_tpl_vars['fields']['full_name']['name']; ?>
' size='30' 
    maxlength='510' 
    value='<?php echo $this->_tpl_vars['value']; ?>
' title=''  tabindex='1'      >