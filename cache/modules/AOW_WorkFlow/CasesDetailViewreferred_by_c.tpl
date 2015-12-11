
{if strlen($fields.referred_by_c.value) <= 0}
{assign var="value" value=$fields.referred_by_c.default_value }
{else}
{assign var="value" value=$fields.referred_by_c.value }
{/if} 
<span class="sugar_field" id="{$fields.referred_by_c.name}">{$fields.referred_by_c.value}</span>
