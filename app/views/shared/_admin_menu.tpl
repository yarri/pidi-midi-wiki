{dropdown_menu clearfix=false}
	{assign admin_ctrl "wiki_pages"}
	{if is_a($wiki_page,"WikiSystemPage")}
		{assign admin_ctrl "wiki_system_pages"}
	{/if}
	{if $wiki_page->isEditableBy($logged_user)}
		{a namespace="admin" controller=$admin_ctrl action="edit" id=$wiki_page}{!"edit"|icon} {t}Edit{/t}{/a}
	{/if}
	{if $wiki_page->isDeletableBy($logged_user)}
		{a namespace="admin" controller=$admin_ctrl action="destroy" id=$wiki_page}{!"remove"|icon} {t}Delete{/t}{/a}
	{/if}
{/dropdown_menu}
