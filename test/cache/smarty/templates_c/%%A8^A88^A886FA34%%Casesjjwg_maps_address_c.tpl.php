<?php /* Smarty version 2.6.11, created on 2015-06-17 08:49:18
         compiled from cache/modules/Import/Casesjjwg_maps_address_c.tpl */ ?>

<?php if (strlen ( $this->_tpl_vars['fields']['jjwg_maps_address_c']['value'] ) <= 0):  $this->assign('value', $this->_tpl_vars['fields']['jjwg_maps_address_c']['default_value']);  else:  $this->assign('value', $this->_tpl_vars['fields']['jjwg_maps_address_c']['value']);  endif; ?>  
<input type='text' name='<?php echo $this->_tpl_vars['fields']['jjwg_maps_address_c']['name']; ?>
' 
    id='<?php echo $this->_tpl_vars['fields']['jjwg_maps_address_c']['name']; ?>
' size='30' 
    maxlength='255' 
    value='<?php echo $this->_tpl_vars['value']; ?>
' title='Address'  tabindex='1'      >