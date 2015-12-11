
{if strlen($fields.primary_address_city.value) <= 0}
{assign var="value" value=$fields.primary_address_city.default_value }
{else}
{assign var="value" value=$fields.primary_address_city.value }
{/if} 
<span class="sugar_field" id="{$fields.primary_address_city.name}">{$fields.primary_address_city.value}</span>
