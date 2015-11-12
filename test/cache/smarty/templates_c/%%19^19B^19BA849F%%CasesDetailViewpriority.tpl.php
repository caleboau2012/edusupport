<?php /* Smarty version 2.6.11, created on 2015-06-17 13:35:10
         compiled from cache/modules/AOW_WorkFlow/CasesDetailViewpriority.tpl */ ?>


<?php if (is_string ( $this->_tpl_vars['fields']['priority']['options'] )): ?>
<input type="hidden" class="sugar_field" id="<?php echo $this->_tpl_vars['fields']['priority']['name']; ?>
" value="<?php echo $this->_tpl_vars['fields']['priority']['options']; ?>
">
<?php echo $this->_tpl_vars['fields']['priority']['options']; ?>

<?php else: ?>
<input type="hidden" class="sugar_field" id="<?php echo $this->_tpl_vars['fields']['priority']['name']; ?>
" value="<?php echo $this->_tpl_vars['fields']['priority']['value']; ?>
">
<?php echo $this->_tpl_vars['fields']['priority']['options'][$this->_tpl_vars['fields']['priority']['value']]; ?>

<?php endif; ?>