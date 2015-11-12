

    {if strlen($fields.aow_temp_date.value) <= 0}
        {assign var="value" value=$fields.aow_temp_date.default_value }
    {else}
        {assign var="value" value=$fields.aow_temp_date.value }
    {/if}



<span class="sugar_field" id="{$fields.aow_temp_date.name}">{$value}</span>
