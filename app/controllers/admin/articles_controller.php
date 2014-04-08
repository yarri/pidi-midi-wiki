<?php
class ArticlesController extends AdminController{
	function index(){
		$this->page_title = _("Listing Articles");

		$this->sorting->add("created_at",array("reverse" => true));

		($d = $this->form->validate($this->params)) || ($d = $this->form->get_initial());

		$conditions = $bind_ar = array();

		if($d["search"]){
			$conditions[] = "UPPER(id||' '||' '||COALESCE(title,'')||' '||COALESCE(body,'')) LIKE UPPER('%'||:search||'%')";
			$bind_ar[":search"] = $d["search"];
		}

		$this->tpl_data["finder"] = Article::Finder(array(
			"conditions" => $conditions,
			"bind_ar" => $bind_ar,
			"offset" => $this->params->getInt("from"),
			"order_by" => $this->sorting,
		));
	}

	function create_new(){
		$this->page_title = _("Create article");

		$this->_save_return_uri();

		if($this->request->post() && ($d = $this->form->validate($this->params))){
			$tags = $d["tags"];
			unset($d["tags"]);
			$d["author_id"] = $d["created_by_user_id"] = $this->logged_user;
			$article = Article::CreateNewRecord($d);
			$article->setTags($tags);
			$this->flash->success(_("The article has been created successfuly"));
			$this->_redirect_back();
		}
	}

	function edit(){
		$this->page_title = sprintf(_("Editing %s"),$this->article);

		$this->_save_return_uri();
		$this->form->set_initial($this->article);
		$this->form->set_initial("tags",$this->article->getTags());

		if($this->request->post() && ($d = $this->form->validate($this->params))){
			$d["updated_by_user_id"] = $this->logged_user;
			$this->article->setTags($d["tags"]);
			unset($d["tags"]);
			$this->article->s($d);
			$this->flash->success(_("The article has been updated successfuly"));
			$this->_redirect_back();
		}
	}

	function destroy(){
		if(!$this->request->post()){ return $this->_execute_action("error404"); }

		$this->article->destroy();

		if(!$this->request->xhr()){
			$this->flash->success(_("The article has been deleted"));
			$this->_redirect_to("index");
		}
	}

	function _before_filter(){
		if(in_array($this->action,array("edit","destroy"))){
			$this->_find("article");
		}
	}
}
