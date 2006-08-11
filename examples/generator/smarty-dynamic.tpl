<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3c.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>PEAR::HTML_Progress2 - Generator </title>
<meta name="author" content="Laurent Laville" />
<style type="text/css">
<!--
{$qf_style}
 -->
</style>
{if $qf_script}
<script type="text/javascript">
//<![CDATA[
{$qf_script}
//]]>
</script>
{/if}
</head>
<body>

{if $form.javascript}
    {$form.javascript}
{/if}

<form{$form.attributes}>{$form.hidden}
<table class="maintable">

    {foreach item=sec key=i from=$form.sections}
        <tr>
            <th colspan="2">{$sec.header}</th>
        </tr>

        {foreach item=element from=$sec.elements}

            <!-- submit or reset button (don't display on frozen forms) -->
            {if $element.type eq "submit" or $element.type eq "reset"}
                {if not $form.frozen}
                <tr>
                    <td>&nbsp;</td>
                    <td align="left">{$element.html}</td>
                </tr>
                {/if}

            <!-- normal elements -->
            {else}
                <tr>
                    <td class="qfLabel">&nbsp;{$element.label}<td>

                    {if $element.error}<span class="qfError">{$element.error}</span><br />{/if}
                    {if $element.type eq "group"}
                        {foreach key=gkey item=gitem from=$element.elements}
                            {$gitem.label}
                            {$gitem.html}
                            {if $element.separator}{cycle values=$element.separator}{/if}
                        {/foreach}
                    {else}
                        {$element.html}
                    {/if}
                    </td>
                </tr>

            {/if}
        {/foreach}
    {/foreach}

</table>
</form>

{if $form.errors}
<p>
{foreach key=name item=error from=$form.errors}
    <span class="qfError">{$error}</span> in element [{$name}]<br />
{/foreach}
</p>
{/if}

</body>
</html>