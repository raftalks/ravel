<?php echo Xhtml::make('div',function($html)
    {
        $html->content_panel(trans('ravel::content.post_categories'),function($div)
        {
            $div->div(function($html)
            {

                $html->table(function($table)
                {
                    $table->setClass('table table-striped table-hover');
                    
                    $table->thead(function($thead)
                    {
                        $thead->tr(function($tr)
                        {

                          $tr->th(trans('ravel::content.category_name'));
                          $tr->th(trans('ravel::content.list_layout'));
                          $tr->th(trans('ravel::content.item_layout'));
                          $tr->th(trans('ravel::app.created_at'));
                          $tr->th(trans('ravel::app.updated_at'));
                          $tr->th('');

                        });
                    });

                    $table->tbody(function($tbody)
                    {
                        $tbody->tr(function($tr)
                        {
                          $tr->td(function($td)
                            {
                              $td->span(function($span)
                              {
                                  $span->a(function($a)
                                  {
                                    $a->i()->class('icon-edit');
                                    // $a->setHref('#edit');
                                    $a->setTitle(trans('ravel::form.edit'));

                                    $a->setRootAttr('ng-click','edit(item)');
                                  });
                              });

                              $td->span()->ng_bind('item.name','ng-bind');
                            });
                          $tr->td()->ng_bind('item.list_layout','ng-bind');
                          $tr->td()->ng_bind('item.item_layout','ng-bind');
                          $tr->td()->ng_bind('item.created_at','ng-bind');
                          $tr->td()->ng_bind('item.updated_at','ng-bind');
                          

                          $tr->td(function($td)
                            {
                                
                            });

                          $tr->setNgRepeat('item in recordset','ng-repeat');
                        });

                    });


                    $table->tfoot(function($tfoot)
                    {
                        $tfoot->tr(function($tr)
                        {

                            $tr->td(function($td)
                            {
                              $td->div()->class('paginator pagination')->paginatepages('{{pages}}','paginate-pages');

                              $td->setColspan('6');
                            });
                        });
                    });

                });
            });
        },
        //toolbar
        function($html)
        {
          $html->button('create')->class('button')->ng_click('create()','ng-click');
        }
        );
    });
?>
