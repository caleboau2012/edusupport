
{if strlen($fields.primary_address_country.value) <= 0}
{assign var="value" value=$fields.primary_address_country.default_value }
{else}
{assign var="value" value=$fields.primary_address_country.value }
{/if} 
<span class="sugar_field" id="{$fields.primary_address_country.name}">{$fields.primary_address_country.value}</span>
