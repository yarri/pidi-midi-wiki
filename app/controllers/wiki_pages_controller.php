<?php
class WikiPagesController extends ApplicationController {

	var $wiki_name = "wiki"; // "wiki", "instructions_and_manuals"... 
	var $wiki_name_humanized = "Wiki"; // "Wiki", "Instructions and Manuals"

	function index(){
		$this->page_title = $this->breadcrumbs[] = _("Vyhledávání");

		($d = $this->form->validate($this->params)) || ($d = $this->form->get_initial());

		$conditions = $bind_ar = [];

		$conditions[] = "wiki_name=:wiki_name";
		$bind_ar[":wiki_name"] = $this->wiki_name;
		$conditions[] = "NOT deleted";
		$conditions[] = "name NOT IN ('Error404','Error403')";

		$conditions[] = "revision=(SELECT MAX(revision) FROM wiki_pages wp WHERE wp.name=wiki_pages.name AND wp.wiki_name=wiki_pages.wiki_name)";

		if(strlen($d["search"])){
			$this->page_title = sprintf(_('Vyhledávání: „%s“'),$d["search"]);

			$q_up = Translate::Upper($d["search"]);

			$_fields = array();
			$_fields[] = "name";
			$_fields[] = "id";
			$_fields[] = "content";

			$ft_cond = FullTextSearchQueryLike::GetQuery("UPPER(".join("||' '||",$_fields).")",$q_up);
			if($ft_cond){
				$conditions[] = $ft_cond;
				$bind_ar[":search"] = $q_up;
			}
		}
		
		$this->sorting->add("updated_at","COALESCE(updated_at,created_at) DESC","COALESCE(updated_at,created_at) ASC");
		$this->sorting->add("name");

		$this->tpl_data["finder"] = WikiPage::Finder([
			"conditions" => $conditions,
			"bind_ar" => $bind_ar,

			"order_by" => $this->sorting,
			"offset" => null,
			"limit" => null,
		]);
	}

	function detail(){
		$name = $this->params->getString("name");
		if(!strlen($name)){ return $this->_redirect_to_index(); }

		if(!$wiki_page = $this->_find_wiki_page($name)){
			$this->tpl_data["name"] = $name;
			$this->template_name = "page_not_found";
			$this->page_title = sprintf(_("Stránka %s nenalezena"),$name);
			$this->response->setStatusCode(404);
			return;
		}

		if(in_array($wiki_page->getName(),["Error404","Error403"])){
			$this->_execute_action("error404");
			return;
		}

		if($wiki_page->isDeleted()){
			return $this->_execute_action("error404");
		}
		
		if($wiki_page->getName()!="Index"){
			$this->breadcrumbs[] = $wiki_page->getName();
		}

		$revision = $wiki_page->getRevision();

		$this->page_title = $wiki_page->getName();

		$content = $wiki_page->getContent();
		Atk14Require::Helper("modifier.wiki_markdown");
		$content = smarty_modifier_wiki_markdown($content);
		$pattern = '/^<h1(|\s[^>]*)>(?<page_title>.+?)<\/h1>/';
		$content = preg_replace($pattern,'',$content); // odstraneni nadpisu <h1>

		$this->tpl_data["content"] = $content;
		$this->tpl_data["wiki_page"] = $wiki_page;
	}

	function _find_wiki_page($name,$revision = 0){
		return WikiPage::FindFirst("name",$name,"wiki_name",$this->wiki_name);
	}

	function _before_filter(){
		if(in_array($this->action,["edit","destroy"])){
			$this->_find("wiki_page");
		}
	}

	function _before_render(){
		parent::_before_render();

		$this->tpl_data["wiki_name"] = $this->wiki_name;
		$this->tpl_data["wiki_name_humanized"] = $this->wiki_name_humanized;
		$this->tpl_data["search_form"] = $this->_get_form("index");
	}
}
