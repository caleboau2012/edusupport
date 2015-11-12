<?php /* Smarty version 2.6.11, created on 2015-06-11 15:41:27
         compiled from cache/modules/Import/Contactsalt_address_city.tpl */ ?>

<?php if (strlen ( $this->_tpl_vars['fields']['alt_address_city']['value'] ) <= 0):  $this->assign('value', $this->_tpl_vars['fields']['alt_address_city']['default_value']);  else:  $this->assign('value', $this->_tpl_vars['fields']['alt_address_city']['value']);  endif; ?>  
<input type='text' name='<?php echo $this->_tpl_vars['fields']['alt_address_city']['name']; ?>
' 
    id='<?php echo $this->_tpl_vars['fields']['alt_address_city']['name']; ?>
' size='30' 
    maxlength='100' 
    value='<?php echo $this->_tpl_vars['value']; ?>
' title=''  tabindex='1'      >