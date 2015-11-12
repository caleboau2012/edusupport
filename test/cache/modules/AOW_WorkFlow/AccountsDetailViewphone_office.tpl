
{if !empty($fields.phone_office.value)}
{assign var="phone_value" value=$fields.phone_office.value }

{sugar_phone value=$phone_value usa_format="0"}

{/if}