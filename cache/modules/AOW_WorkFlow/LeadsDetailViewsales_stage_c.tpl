

{if is_string($fields.sales_stage_c.options)}
<input type="hidden" class="sugar_field" id="{$fields.sales_stage_c.name}" value="{ $fields.sales_stage_c.options }">
{ $fields.sales_stage_c.options }
{else}
<input type="hidden" class="sugar_field" id="{$fields.sales_stage_c.name}" value="{ $fields.sales_stage_c.value }">
{ $fields.sales_stage_c.options[$fields.sales_stage_c.value]}
{/if}
