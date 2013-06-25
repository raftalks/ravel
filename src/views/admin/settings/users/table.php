<?php echo Xhtml::make('div',function($html)
    {
        $html->content_panel('Users',function($div)
        {
            $div->div(function($html)
            {

                $html->table(function($table)
                {
                    $table->thead(function($thead)
                    {
                        $thead->tr(function($tr)
                        {

                          $tr->th('username');
                          $tr->th('email');
                          $tr->th('usergroup');
                          $tr->th('status');
                          $tr->th('created');
                          $tr->th('updated');
                          $tr->th('');

                        });
                    });

                    $table->tbody(function($tbody)
                    {
                        $tbody->tr(function($tr)
                        {
                          $tr->td()->ng_bind('item.username','ng-bind');
                          $tr->td()->ng_bind('item.email','ng-bind');
                          $tr->td()->ng_bind('item.usergroup.group','ng-bind');
                          $tr->td(function($td)
                            {
                              $td->span(showActivated())->ng_show('item.activated','ng-show');
                              $td->span(showDeactivated())->ng_hide('item.activated','ng-hide');
                            });
                          $tr->td()->ng_bind('item.created_at','ng-bind');
                          $tr->td()->ng_bind('item.updated_at','ng-bind');
                          

                          $tr->td();

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