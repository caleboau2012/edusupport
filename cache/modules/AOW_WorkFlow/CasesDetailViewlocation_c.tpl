
{if strlen($fields.location_c.value) <= 0}
{assign var="value" value=$fields.location_c.default_value }
{else}
{assign var="value" value=$fields.location_c.value }
{/if} 
<span class="sugar_field" id="{$fields.location_c.name}">{$fields.location_c.value}</span>
