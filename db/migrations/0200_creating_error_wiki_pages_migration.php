<?php
class CreatingErrorWikiPagesMigration extends ApplicationMigration {

	function up(){
		WikiPage::CreateNewRecord([
			"wiki_name" => "wiki",
			"name" => "Error404",
			"content" => trim("
# Error 404: Page not found

We are deeply sorry, but the requested page wasn't found.

[Go to the homepage](/)
			")
		]);

		WikiPage::CreateNewRecord([
			"wiki_name" => "wiki",
			"name" => "Error403",
			"content" => trim("
# Error 403: Forbidden

You don`t have a permission to access the requested page on this server.

[Go to the homepage](/) or [Sign in as an admin user](/en/logins/create_new/)
			")
		]);
	}
}
