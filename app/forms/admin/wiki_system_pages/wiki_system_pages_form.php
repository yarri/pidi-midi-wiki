<?php
require_once(__DIR__ . "/../wiki_pages/wiki_pages_form.php");

class WikiSystemPagesForm extends WikiPagesForm {

	function set_up(){
		parent::set_up();
		$this->fields["name"]->disabled = true;
	}
}
