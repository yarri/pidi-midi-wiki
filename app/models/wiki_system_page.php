<?php
class WikiSystemPage extends WikiPage {

	function __construct(){
		parent::__construct("wiki_pages",[
			"sequence_name" => "seq_wiki_pages",
		]);
	}

	function isDeletableBy($user){
		return false;
	}
}
