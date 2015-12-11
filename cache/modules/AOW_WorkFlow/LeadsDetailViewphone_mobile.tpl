
{if !empty($fields.phone_mobile.value)}
{assign var="phone_value" value=$fields.phone_mobile.value }

{sugar_phone value=$phone_value usa_format="0"}

{/if}