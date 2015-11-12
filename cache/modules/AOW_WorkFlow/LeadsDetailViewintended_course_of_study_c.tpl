
{if strlen($fields.intended_course_of_study_c.value) <= 0}
{assign var="value" value=$fields.intended_course_of_study_c.default_value }
{else}
{assign var="value" value=$fields.intended_course_of_study_c.value }
{/if} 
<span class="sugar_field" id="{$fields.intended_course_of_study_c.name}">{$fields.intended_course_of_study_c.value}</span>
