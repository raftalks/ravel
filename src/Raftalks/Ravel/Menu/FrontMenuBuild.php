<?php namespace Raftalks\Ravel\Menu;

use Raftalks\Ravel\Menu\MenuBuild;
use LinkModel;
use MenuModel;
use Config;
use View;

class FrontMenuBuild extends MenuBuild
{

	protected function getDefaultTemplate()
	{
		$template =  Config::get('ravel::menulinks.frontend_template');
		if(is_null($template))
		{
			return array();
		}

		return $template;
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

		$menu = MenuModel::where('name','=',$name)->where('lang','=',$this->getLocale())->first();
		if(!empty($menu))
		{
			$links = $this->getProcessedLinks($this->getLinks($menu->id));
		}
		else
		{
			$links = array();
		}

		$template = $this->getTemplate();

		return $this->build = View::make($template,array('menu_links'=>$links));

	}

	/**
	 * Get Menu Links 
	 */
	protected function getLinks($id = null)
	{
		if(is_null($this->links))
		{
			$this->links = $this->getDefaultLinks($id);
		}

		return $this->links;
	}

	/**
	 * get Default Menu Links defined in the db
	 */
	protected function getDefaultLinks($menu_id = null)
	{
		if(is_null($menu_id))
		{
			return array();
		}
		//fetch all menus from db
		$menus = LinkModel::where('menu_id','=',$menu_id)->where('publish','=',true)->orderBy('parent_id','asc')->get();

		return $this->preparedMenuLinks($menus);
	}


	protected function getLocale()
	{
		return Config::get('app.locale');
	}


	protected function preparedMenuLinks($menus)
	{
		if(!empty($menus))
		{
			$menuItems = array();
			
			//fetch all parents & childrens
			foreach($menus as $menu)
			{
				$menuData = array(
							'label' => $menu->label,
							'link'	=> $this->makeContentLink($menu),
							'parent_id'	=> $menu->parent_id,
						);

				$id = $menu->id;

				$menuItems[$id] = $menuData;
				
			}

			return buildTree($menuItems);

		}

		return array();
	}


	


	protected function makeContentLink($menu)
	{
		$content_id = $menu->content_id;
		$content_type = $menu->content_type;
		$slug = '';
		$is_home = false;
		if(!empty($menu->slug))
		{
			$slug = '/'.$menu->slug;

			if($slug == '//')
			{
				$is_home = true;
			}

		} 
		
		if($is_home)
		{
			return "/";
		}
		else
		{
			$base_url = $content_type;
			$url = '';
			switch ($content_type) {
				case 'post':
						$url = action('PostController@getPost',array($content_id)) . $slug;
					break;

				case 'page':
						$url = action('PageController@getPage',array($content_id)) . $slug;
					break;
				
				default:
					$url = $base_url;
					break;
			}
		}

		return $url;
	}
}
