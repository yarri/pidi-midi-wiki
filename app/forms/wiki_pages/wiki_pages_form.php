<?php
class WikiPagesForm extends ApplicationForm {

	function set_up(){
		$this->add_field("content", new MarkdownField([
			"label" => _("Obsah"),
		]));

		$this->add_field("name",new RegexField('/^([A-Z][a-z0-9]*)+$/',[
			"label" => _("Označení stránky ve formátu Wiki"),
			"hints" => [
				"Napoveda",
				"ImportDat",
				"PrechodNaRok2000"
			],
			"max_length" => 255,
		]));
	}
}
