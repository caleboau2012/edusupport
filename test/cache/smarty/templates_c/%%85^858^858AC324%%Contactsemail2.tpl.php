<?php /* Smarty version 2.6.11, created on 2015-06-11 15:46:50
         compiled from cache/modules/Import/Contactsemail2.tpl */ ?>

<?php if (strlen ( $this->_tpl_vars['fields']['email2']['value'] ) <= 0):  $this->assign('value', $this->_tpl_vars['fields']['email2']['default_value']);  else:  $this->assign('value', $this->_tpl_vars['fields']['email2']['value']);  endif; ?>  
<input type='text' name='<?php echo $this->_tpl_vars['fields']['email2']['name']; ?>
' 
    id='<?php echo $this->_tpl_vars['fields']['email2']['name']; ?>
' size='30' 
     
    value='<?php echo $this->_tpl_vars['value']; ?>
' title=''  tabindex='1'      >