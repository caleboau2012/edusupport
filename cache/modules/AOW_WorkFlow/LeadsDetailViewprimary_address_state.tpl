
{if strlen($fields.primary_address_state.value) <= 0}
{assign var="value" value=$fields.primary_address_state.default_value }
{else}
{assign var="value" value=$fields.primary_address_state.value }
{/if} 
<span class="sugar_field" id="{$fields.primary_address_state.name}">{$fields.primary_address_state.value}</span>
