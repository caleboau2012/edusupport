<?php /* Smarty version 2.6.11, created on 2015-06-11 15:41:28
         compiled from cache/modules/Import/Contactsjjwg_maps_lat_c.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'sugar_number_format', 'cache/modules/Import/Contactsjjwg_maps_lat_c.tpl', 10, false),)), $this); ?>

<?php if (strlen ( $this->_tpl_vars['fields']['jjwg_maps_lat_c']['value'] ) <= 0):  $this->assign('value', $this->_tpl_vars['fields']['jjwg_maps_lat_c']['default_value']);  else:  $this->assign('value', $this->_tpl_vars['fields']['jjwg_maps_lat_c']['value']);  endif; ?>  
<input type='text' name='<?php echo $this->_tpl_vars['fields']['jjwg_maps_lat_c']['name']; ?>
'
id='<?php echo $this->_tpl_vars['fields']['jjwg_maps_lat_c']['name']; ?>
'
size='30'
maxlength='10'value='<?php echo smarty_function_sugar_number_format(array('var' => $this->_tpl_vars['value'],'precision' => 8), $this);?>
'
title='Latitude'
tabindex='1'
 
>