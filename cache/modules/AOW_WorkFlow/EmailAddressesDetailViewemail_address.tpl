
{if strlen($fields.email_address.value) <= 0}
{assign var="value" value=$fields.email_address.default_value }
{else}
{assign var="value" value=$fields.email_address.value }
{/if} 
<span class="sugar_field" id="{$fields.email_address.name}">{$fields.email_address.value}</span>
