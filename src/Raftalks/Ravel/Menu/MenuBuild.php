<?php namespace Raftalks\Ravel\Menu;
use View, Request;

class MenuBuild implements MenuBuildInterface
{

	protected $links = null;

	protected $template = null;

	protected $buildStatus = false;

	protected $build = null;

	protected $requestPath = null;



	public function setRequestPath($uri)
	{
		$this->requestPath = $uri;
	}

	protected function getRequestPath()
	{
		if(is_null($this->requestPath))
		{
			$this->requestPath = Request::url();
		}

		return $this->requestPath;
	}


	public function setTemplate($template)
	{
		$this->buildStatus = false;
		$this->template = $template;
	}



	protected function getTemplate()
	{
		if(is_null($this->template))
		{
			$this->template = $this->getDefaultTemplate();
		}

		return $this->template;
	}


	protected function getDefaultTemplate()
	{
		$template =  \Config::get('ravel::menulinks.template');
		if(is_null($template))
		{
			return array();
		}

		return $template;
	}


	/**
	 * Set Menu Links
	 */
	public function setLinks(array $links)
	{
		$this->buildStatus = false;
		$this->links = $links;
	}


	/**
	 * Get Menu Links 
	 */
	protected function getLinks($id=null)
	{
		if(is_null($this->links))
		{
			$this->links = $this->getDefaultLinks();
		}

		return $this->links;
	}


	/**
	 * get Default Menu Links defined in the configuration file menulinks
	 */
	protected function getDefaultLinks()
	{
		$links =  \Config::get('ravel::menulinks.default');
		if(is_null($links))
		{
			return array();
		}

		return $links;
	}



	/**
	 * Generate the Menu 
	 */
	public function build($name = null)
	{
		if($this->buildStatus)
		{
			return $this->build;
		}

		$links = $this->getProcessedLinks($this->getLinks());
		$template = $this->getTemplate();

		return $this->build = View::make($template,array('menu_links'=>$links));

	}


	public function getProcessedLinks($links, &$parent = null)
	{
		$processed = array();
		foreach($links as $key => $menu)
		{
			$menu['active'] = false;
			if($this->checkCurrent($menu))
			{
				$menu['active'] = true;
				if(!is_null($parent))
				{
					$parent['active'] = true;
				}
			}

			if(isset($menu['children']))
			{
				foreach($menu['children'] as $ckey => $cmenu)
				{
					$menu['children'] = $this->getProcessedLinks($menu['children'], $menu);
				}
			}

			$processed[$key] = $menu;

		}

		return $processed;
	}


	protected function checkCurrent($menu)
	{
		$currentRequest = $this->getRequestPath();

		$link = $menu['link'];

		if($currentRequest == $link)
		{
			return true;
		}

		return false;

	}
	
}