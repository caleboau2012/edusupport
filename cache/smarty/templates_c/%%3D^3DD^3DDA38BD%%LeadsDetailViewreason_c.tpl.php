<?php /* Smarty version 2.6.11, created on 2015-11-10 14:26:54
         compiled from cache/modules/AOW_WorkFlow/LeadsDetailViewreason_c.tpl */ ?>


<?php if (is_string ( $this->_tpl_vars['fields']['reason_c']['options'] )): ?>
<input type="hidden" class="sugar_field" id="<?php echo $this->_tpl_vars['fields']['reason_c']['name']; ?>
" value="<?php echo $this->_tpl_vars['fields']['reason_c']['options']; ?>
">
<?php echo $this->_tpl_vars['fields']['reason_c']['options']; ?>

<?php else: ?>
<input type="hidden" class="sugar_field" id="<?php echo $this->_tpl_vars['fields']['reason_c']['name']; ?>
" value="<?php echo $this->_tpl_vars['fields']['reason_c']['value']; ?>
">
<?php echo $this->_tpl_vars['fields']['reason_c']['options'][$this->_tpl_vars['fields']['reason_c']['value']]; ?>

<?php endif; ?>