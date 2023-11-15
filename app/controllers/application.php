<?php
require_once(__DIR__."/application_base.php");

class ApplicationController extends ApplicationBaseController{

	function error404(){
		$this->_output_error_page(404);
	}

	function error403(){
		$this->_output_error_page(403);
	}

	function _application_before_filter(){
		parent::_application_before_filter();

		$this->tpl_data["footer_wiki_page"] = WikiSystemPage::FindFirst("wiki_name","system","name","Footer");
	}

	function _output_error_page($code){
		$method = "error$code";

		if($this->request->xhr()){
			return parent::$method();
		}

		if($code==404 && $this->_redirected_on_error404()){
			return;
		}

		$wiki_page = WikiSystemPage::FindFirst("wiki_name","system","name","Error$code");

		if(!$wiki_page){
			return parent::$method();
		}

		$content = $wiki_page->getContent();
		Atk14Require::Helper("modifier.wiki_markdown");
		$content = smarty_modifier_wiki_markdown($content);
		$pattern = '/^<h1(|\s[^>]*)>(?<page_title>.+?)<\/h1>/';
		$content = preg_replace($pattern,'',$content); // odstraneni nadpisu <h1>

		$this->page_title = $wiki_page->getTitle();
		$this->tpl_data["content"] = $content;
		$this->tpl_data["wiki_page"] = $wiki_page;

		$this->response->setStatusCode($code);
		$this->template_name = "wiki_pages/detail";
	}

	function _add_page_to_breadcrumbs($page){
		$pages = array($page);
		$p = $page;
		while($parent = $p->getParentPage()){
			$p = $parent;
			if($p->getCode()=="homepage"){ continue; }
			$pages[] = $p;
		}
		$pages = array_reverse($pages);
		foreach($pages as $p){
			$this->breadcrumbs[] = array($p->getTitle(),$this->_link_to(array("action" => "pages/detail", "id" => $p)));
		}
	}

	function _add_user_detail_breadcrumb(){
		if(!$this->logged_user){ return; }

		$title = _("User profile");
		
		if("$this->controller/$this->action"=="users/detail"){
			$this->breadcrumbs[] = $title;
			return;
		}

		$this->breadcrumbs[] = [$title,"users/detail"];
	}
}
