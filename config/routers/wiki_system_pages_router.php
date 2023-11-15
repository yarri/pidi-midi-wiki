<?php
require_once(__DIR__ . "/wiki_pages_router.php");
class WikiSystemPagesRouter extends WikiPagesRouter {

	var $wiki_url_prefix = "wiki_system";
	var $wiki_name = "system";
	var $wiki_controller = "wiki_system_pages";
}
