<?php
class IndexForm extends ApplicationForm{

	function set_up(){
		$this->add_field("search",new SearchField(array(
			"label" => _("Hledat"),
			"required" => false,
		)));

		$this->set_button_text(_("Hledat"));
		$this->set_action(Atk14Url::BuildLink(["action" => "index"]));
	}
}
