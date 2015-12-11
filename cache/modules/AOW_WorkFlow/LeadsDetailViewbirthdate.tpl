

    {if strlen($fields.birthdate.value) <= 0}
        {assign var="value" value=$fields.birthdate.default_value }
    {else}
        {assign var="value" value=$fields.birthdate.value }
    {/if}



<span class="sugar_field" id="{$fields.birthdate.name}">{$value}</span>
