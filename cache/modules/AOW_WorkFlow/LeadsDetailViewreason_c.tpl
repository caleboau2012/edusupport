

{if is_string($fields.reason_c.options)}
<input type="hidden" class="sugar_field" id="{$fields.reason_c.name}" value="{ $fields.reason_c.options }">
{ $fields.reason_c.options }
{else}
<input type="hidden" class="sugar_field" id="{$fields.reason_c.name}" value="{ $fields.reason_c.value }">
{ $fields.reason_c.options[$fields.reason_c.value]}
{/if}
