<?php /* Smarty version 2.6.11, created on 2015-11-27 12:06:34
         compiled from cache/modules/AOW_WorkFlow/LeadsDetailViewsales_stage_c.tpl */ ?>


<?php if (is_string ( $this->_tpl_vars['fields']['sales_stage_c']['options'] )): ?>
<input type="hidden" class="sugar_field" id="<?php echo $this->_tpl_vars['fields']['sales_stage_c']['name']; ?>
" value="<?php echo $this->_tpl_vars['fields']['sales_stage_c']['options']; ?>
">
<?php echo $this->_tpl_vars['fields']['sales_stage_c']['options']; ?>

<?php else: ?>
<input type="hidden" class="sugar_field" id="<?php echo $this->_tpl_vars['fields']['sales_stage_c']['name']; ?>
" value="<?php echo $this->_tpl_vars['fields']['sales_stage_c']['value']; ?>
">
<?php echo $this->_tpl_vars['fields']['sales_stage_c']['options'][$this->_tpl_vars['fields']['sales_stage_c']['value']]; ?>

<?php endif; ?>