<?php /* Smarty version 2.6.11, created on 2015-11-27 12:10:14
         compiled from cache/modules/AOW_WorkFlow/AccountsDetailViewphone_office.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'sugar_phone', 'cache/modules/AOW_WorkFlow/AccountsDetailViewphone_office.tpl', 5, false),)), $this); ?>

<?php if (! empty ( $this->_tpl_vars['fields']['phone_office']['value'] )):  $this->assign('phone_value', $this->_tpl_vars['fields']['phone_office']['value']); ?>

<?php echo smarty_function_sugar_phone(array('value' => $this->_tpl_vars['phone_value'],'usa_format' => '0'), $this);?>


<?php endif; ?>