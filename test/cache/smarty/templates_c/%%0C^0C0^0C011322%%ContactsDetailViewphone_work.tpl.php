<?php /* Smarty version 2.6.11, created on 2015-06-24 09:33:42
         compiled from cache/modules/AOW_WorkFlow/ContactsDetailViewphone_work.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'sugar_phone', 'cache/modules/AOW_WorkFlow/ContactsDetailViewphone_work.tpl', 5, false),)), $this); ?>

<?php if (! empty ( $this->_tpl_vars['fields']['phone_work']['value'] )):  $this->assign('phone_value', $this->_tpl_vars['fields']['phone_work']['value']); ?>

<?php echo smarty_function_sugar_phone(array('value' => $this->_tpl_vars['phone_value'],'usa_format' => '0'), $this);?>


<?php endif; ?>