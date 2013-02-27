<?php echo HTML::make('div',function($html)
    {
        $html->content_panel('Posts',function($div)
        {
            $div->div(function($html)
            {

                $html->table(function($table)
                {
                    $table->thead(function($thead)
                    {
                        $thead->tr(function($tr)
                        {

                          $tr->th('Title');
                          $tr->th('author');
                          $tr->th('publish date');
                          $tr->th('created');
                          $tr->th('updated');
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

                              $td->span()->ng_bind('item.title','ng-bind');
                            });
                          $tr->td()->ng_bind('item.author.username','ng-bind');
                          $tr->td()->ng_bind('item.publish_date','ng-bind');
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

                              $td->div(function($div)
                              {

                                $content = '<a href="#" title="First Page">&laquo; First</a><a href="#" title="Previous Page">&laquo; Previous</a>
                      <a href="#" class="number" title="1">1</a>
                      <a href="#" class="number" title="2">2</a>
                      <a href="#" class="number current" title="3">3</a>
                      <a href="#" class="number" title="4">4</a>
                      <a href="#" title="Next Page">Next &raquo;</a><a href="#" title="Last Page">Last &raquo;</a>';

                                $div->putText($content);

                                $div->setClass('pagination');
                              });

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
Current Page: {{ currentPage }}
<div class='paginator' paginate-pages='{{pages}}'></div>