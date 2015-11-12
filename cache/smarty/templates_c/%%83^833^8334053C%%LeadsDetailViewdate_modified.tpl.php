<?php /* Smarty version 2.6.11, created on 2015-11-10 18:13:18
         compiled from cache/modules/AOW_WorkFlow/LeadsDetailViewdate_modified.tpl */ ?>


    <?php if (strlen ( $this->_tpl_vars['fields']['aow_temp_date']['value'] ) <= 0): ?>
        <?php $this->assign('value', $this->_tpl_vars['fields']['aow_temp_date']['default_value']); ?>
    <?php else: ?>
        <?php $this->assign('value', $this->_tpl_vars['fields']['aow_temp_date']['value']); ?>
    <?php endif; ?>



<span class="sugar_field" id="<?php echo $this->_tpl_vars['fields']['aow_temp_date']['name']; ?>
"><?php echo $this->_tpl_vars['value']; ?>
</span>