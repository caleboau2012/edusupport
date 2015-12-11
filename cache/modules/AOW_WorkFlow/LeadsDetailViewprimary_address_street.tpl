
{if strlen($fields.primary_address_street.value) <= 0}
{assign var="value" value=$fields.primary_address_street.default_value }
{else}
{assign var="value" value=$fields.primary_address_street.value }
{/if} 
<span class="sugar_field" id="{$fields.primary_address_street.name}">{$fields.primary_address_street.value}</span>
