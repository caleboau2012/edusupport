<?php /* Smarty version 2.6.11, created on 2015-06-11 15:41:27
         compiled from cache/modules/Import/Contactsreports_to_id.tpl */ ?>

<?php if (strlen ( $this->_tpl_vars['fields']['reports_to_id']['value'] ) <= 0):  $this->assign('value', $this->_tpl_vars['fields']['reports_to_id']['default_value']);  else:  $this->assign('value', $this->_tpl_vars['fields']['reports_to_id']['value']);  endif; ?>  
<input type='text' name='<?php echo $this->_tpl_vars['fields']['reports_to_id']['name']; ?>
' 
    id='<?php echo $this->_tpl_vars['fields']['reports_to_id']['name']; ?>
' size='30' 
     
    value='<?php echo $this->_tpl_vars['value']; ?>
' title=''  tabindex='1'      >