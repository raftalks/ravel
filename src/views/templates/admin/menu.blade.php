<?php
Html::macro('menulinks',function($menulinks, $parent = true)
{
	return Html::template('ul',function($ul) use ($menulinks, $parent)
	{
		foreach($menulinks as $key => $menu)
		{

			$ul->li(function($li) use($menu, $parent)
			{
				$ParentlinkClass = 'nav-top-item no-submenu';
				if($menu['active'])
				{
					$ParentlinkClass = 'nav-top-item no-submenu current';
				}

				if(isset($menu['children']))
				{

					$li->a($menu['label'])->href($menu['link'])->class($ParentlinkClass);
					$li->menulinks($menu['children'], false);
				}
				else
				{
					if($parent)
					{
						$li->a($menu['label'])->href($menu['link'])->class($ParentlinkClass);
					}
					else
					{
						if($menu['active'])
						{
							$li->a($menu['label'])->href($menu['link'])->class('current');
						}else
						{
							$li->a($menu['label'])->href($menu['link']);
						}
						
					}
				}
				
			});
		}

		if($parent)
		{
			$ul->setId('main-nav');
		}
		
	});
});

echo Html::make('div',function($div) use($menu_links)
{
	$div->menulinks($menu_links);
});
