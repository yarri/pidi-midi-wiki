<footer class="footer">
	<div class="container-fluid">
		<hr>

		{*
		<div class="row justify-content-between">
			{render partial="shared/layout/footer/link_list" link_list=LinkList::GetInstanceByCode("footer_1")}
			{render partial="shared/layout/footer/link_list" link_list=LinkList::GetInstanceByCode("footer_2")}
			{render partial="shared/layout/footer/link_list" link_list=LinkList::GetInstanceByCode("footer_3")}
		</div>
		*}

		{if $footer_wiki_page}
			{render partial="shared/admin_menu" wiki_page=$footer_wiki_page}
			{!$footer_wiki_page->getContent()|markdown}
		{/if}
	</div>
</footer>
