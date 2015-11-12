<?php /* Smarty version 2.6.11, created on 2015-06-15 05:21:07
         compiled from include/SugarFields/Fields/CronSchedule/DetailView.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'sugarvar', 'include/SugarFields/Fields/CronSchedule/DetailView.tpl', 1, false),)), $this); ?>
{if strlen(<?php echo smarty_function_sugarvar(array('key' => 'value','string' => true), $this);?>
) <= 0}
    {assign var="value" value=<?php echo smarty_function_sugarvar(array('key' => 'default_value','string' => true), $this);?>
 }
{else}
    {assign var="value" value=<?php echo smarty_function_sugarvar(array('key' => 'value','string' => true), $this);?>
 }
{/if}
<span id="<?php if (empty ( $this->_tpl_vars['displayParams']['idName'] )):  echo smarty_function_sugarvar(array('key' => 'name'), $this); else:  echo $this->_tpl_vars['displayParams']['idName'];  endif; ?>_cron_value">
    {$value}
</span>
<script>
    var id = '#<?php if (empty ( $this->_tpl_vars['displayParams']['idName'] )):  echo smarty_function_sugarvar(array('key' => 'name'), $this); else:  echo $this->_tpl_vars['displayParams']['idName'];  endif; ?>_cron_value';
    var el = $(id);
    el.text(getCRONHumanReadable(el.text()));

    {literal}
    function getCRONHumanReadable(schedule){
        schedule = schedule.trim();
        {/literal}var weekdays = <?php echo $this->_tpl_vars['weekday_vals']; ?>
;{literal}
        var bits = schedule.split(' ');
        var mins = bits[0];
        var hours = bits[1];
        var day = bits[2];
        var month = bits[3];
        var weekday = bits[4];

        if(month !== '*'){
            return schedule;
        }
        if(mins === '*') {
            return schedule;
        }
        if(hours === '*') {
            return schedule;
        }
        if(mins.length < 2){
            mins = '0'+mins;
        }
        if(hours.length < 2){
            hours = '0'+hours;
        }
        if(weekday !== '*' && day !== '*'){
            return schedule;
        }else if(weekday !== '*'){
            var days = weekday.split(',');
            var dayLabels = [];
            for(var x = 0; x < days.length; x++){
                dayLabels[x] = weekdays[days[x]];
            }
            {/literal}
            return '<?php echo $this->_tpl_vars['APP']['LBL_CRON_WEEKLY']; ?>
 <?php echo $this->_tpl_vars['APP']['LBL_CRON_ON_THE_WEEKDAY']; ?>
 '+dayLabels.join(', ')+' <?php echo $this->_tpl_vars['APP']['LBL_CRON_AT']; ?>
 '+hours+':'+mins;
            {literal}
        }else if(day !== '*'){
            {/literal}
            return '<?php echo $this->_tpl_vars['APP']['LBL_CRON_MONTHLY']; ?>
 <?php echo $this->_tpl_vars['APP']['LBL_CRON_ON_THE_MONTHDAY']; ?>
 '+day+' <?php echo $this->_tpl_vars['APP']['LBL_CRON_AT']; ?>
 '+hours+':'+mins;
            {literal}
        }
        {/literal}
        return '<?php echo $this->_tpl_vars['APP']['LBL_CRON_DAILY']; ?>
 <?php echo $this->_tpl_vars['APP']['LBL_CRON_AT']; ?>
 '+hours+':'+mins
        {literal}

    }
    {/literal}
</script>