

{if is_string($fields.interest_c.options)}
<input type="hidden" class="sugar_field" id="{$fields.interest_c.name}" value="{ $fields.interest_c.options }">
{ $fields.interest_c.options }
{else}
<input type="hidden" class="sugar_field" id="{$fields.interest_c.name}" value="{ $fields.interest_c.value }">
{ $fields.interest_c.options[$fields.interest_c.value]}
{/if}
