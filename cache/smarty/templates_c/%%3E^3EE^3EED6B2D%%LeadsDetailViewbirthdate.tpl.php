<?php /* Smarty version 2.6.11, created on 2015-11-10 14:26:54
         compiled from cache/modules/AOW_WorkFlow/LeadsDetailViewbirthdate.tpl */ ?>


    <?php if (strlen ( $this->_tpl_vars['fields']['birthdate']['value'] ) <= 0): ?>
        <?php $this->assign('value', $this->_tpl_vars['fields']['birthdate']['default_value']); ?>
    <?php else: ?>
        <?php $this->assign('value', $this->_tpl_vars['fields']['birthdate']['value']); ?>
    <?php endif; ?>



<span class="sugar_field" id="<?php echo $this->_tpl_vars['fields']['birthdate']['name']; ?>
"><?php echo $this->_tpl_vars['value']; ?>
</span>