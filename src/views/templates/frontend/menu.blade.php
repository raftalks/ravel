<?php
Xhtml::macro('menulinks',function($menulinks, $parent = true)
{
	return Xhtml::template('ul',function($ul) use ($menulinks, $parent)
	{
		foreach($menulinks as $key => $menu)
		{

			$ul->li(function($li) use($menu, $parent)
			{
				$ParentlinkClass = 'menu-parent';
				if($menu['active'])
				{
					$ParentlinkClass = 'menu-parent current';
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

echo Xhtml::make('nav',function($div) use($menu_links)
{
	$div->setClass('test');
	$div->menulinks($menu_links);
});
