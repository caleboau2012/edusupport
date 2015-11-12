
{if !empty($fields.phone_work.value)}
{assign var="phone_value" value=$fields.phone_work.value }

{sugar_phone value=$phone_value usa_format="0"}

{/if}