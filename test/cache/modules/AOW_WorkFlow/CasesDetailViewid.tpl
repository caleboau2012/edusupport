
{if strlen($fields.id.value) <= 0}
{assign var="value" value=$fields.id.default_value }
{else}
{assign var="value" value=$fields.id.value }
{/if} 
<span class="sugar_field" id="{$fields.id.name}">{$fields.id.value}</span>
