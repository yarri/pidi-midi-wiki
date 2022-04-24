<div class="wiki">

{dropdown_menu clearfix=false}
	{if $wiki_page->isEditableBy($logged_user)}
		{a namespace="admin" action="edit" id=$wiki_page}{!"edit"|icon} {t}Edit{/t}{/a}
	{/if}
	{if $wiki_page->isDeletableBy($logged_user)}
		{a namespace="admin" action="destroy" id=$wiki_page}{!"remove"|icon} {t}Delete{/t}{/a}
	{/if}
{/dropdown_menu}

<h1>{$wiki_page->getTitle()}</h1>

{!$content}

</div>
