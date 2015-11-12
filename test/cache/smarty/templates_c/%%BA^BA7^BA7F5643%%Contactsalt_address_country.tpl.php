<?php /* Smarty version 2.6.11, created on 2015-06-11 15:41:27
         compiled from cache/modules/Import/Contactsalt_address_country.tpl */ ?>

<?php if (strlen ( $this->_tpl_vars['fields']['alt_address_country']['value'] ) <= 0):  $this->assign('value', $this->_tpl_vars['fields']['alt_address_country']['default_value']);  else:  $this->assign('value', $this->_tpl_vars['fields']['alt_address_country']['value']);  endif; ?>  
<input type='text' name='<?php echo $this->_tpl_vars['fields']['alt_address_country']['name']; ?>
' 
    id='<?php echo $this->_tpl_vars['fields']['alt_address_country']['name']; ?>
' size='30' 
     
    value='<?php echo $this->_tpl_vars['value']; ?>
' title=''  tabindex='1'      >