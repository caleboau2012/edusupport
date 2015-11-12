<?php /* Smarty version 2.6.11, created on 2015-06-11 15:41:27
         compiled from cache/modules/Import/Contactsassistant_phone.tpl */ ?>


<?php if (strlen ( $this->_tpl_vars['fields']['assistant_phone']['value'] ) <= 0):  $this->assign('value', $this->_tpl_vars['fields']['assistant_phone']['default_value']);  else:  $this->assign('value', $this->_tpl_vars['fields']['assistant_phone']['value']);  endif; ?>  

<input type='text' name='<?php echo $this->_tpl_vars['fields']['assistant_phone']['name']; ?>
' id='<?php echo $this->_tpl_vars['fields']['assistant_phone']['name']; ?>
' size='30' maxlength='100' value='<?php echo $this->_tpl_vars['value']; ?>
' title='' tabindex='1'	  class="phone" >