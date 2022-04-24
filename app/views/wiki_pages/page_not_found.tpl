<div class="wiki">

<h1 class="text-muted">{$name}</h1>

<p>
	{t name=$name|h escape=no}Stránka <em>%1</em> neexistuje.{/t}
</p>

{if $logged_user && $logged_user->isAdmin()}
<p>
	{a namespace="admin" action="create_new" name=$name _class="btn btn-default"}{t}Vytvořit stránku?{/t}{/a}
</p>
{/if}

</div>
