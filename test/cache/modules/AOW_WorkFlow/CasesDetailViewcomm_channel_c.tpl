

{if is_string($fields.comm_channel_c.options)}
<input type="hidden" class="sugar_field" id="{$fields.comm_channel_c.name}" value="{ $fields.comm_channel_c.options }">
{ $fields.comm_channel_c.options }
{else}
<input type="hidden" class="sugar_field" id="{$fields.comm_channel_c.name}" value="{ $fields.comm_channel_c.value }">
{ $fields.comm_channel_c.options[$fields.comm_channel_c.value]}
{/if}
