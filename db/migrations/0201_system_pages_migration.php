<?php
class SystemPagesMigration extends ApplicationMigration {

	function up(){
		foreach(["Error404","Error403"] as $name){
			$page = WikiPage::FindFirst("wiki_name","wiki","name",$name);
			$page && $page->s("wiki_name","system");
		}

		$footer = WikiPage::CreateNewRecord([
			"wiki_name" => "system",
			"name" => "Footer",
			"content" => "This site is powered by a super lightweight WIKI engine called [Pidi Midi Wiki](https://pidi-midi-wiki.plovarna.cz/) and a PHP [framework ATK14](https://www.atk14.net/) ingeniously designed for fearless guys."
		]);

		$index = WikiPage::CreateNewRecord([
			"wiki_name" => "system",
			"name" => "Index",
			"content" => trim("
# System Components

* [Error404](Error404)
* [Error403](Error403)
* [Footer](Footer)
			"),
		]);
	}
}
