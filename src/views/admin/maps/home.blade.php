{{-- admin/maps/home.blade.php --}}



@section('appcontainer')
<div ng-controller="MasterCtrl">

	<div ng-include="show_template"></div>

    <script type="text/ng-template" id="maps/table">
		@include('ravel::admin.maps.table')
    </script>

    <script type="text/ng-template" id="maps/create">
     @include('ravel::admin.maps.create')
    </script>

    <script type="text/ng-template" id="maps/edit">
     @include('ravel::admin.maps.edit')
    </script>

    <script type="text/ng-template" id="maps/view">
     @include('ravel::admin.maps.view')
    </script>

</div>
@stop

@section('extra_head')

<!-- GOOGLE MAPS -->
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
<style type="text/css">
	html { height: 100% }
	body { height: 100%; margin: 0; padding: 0 }
	#map-canvas { height: 640px; width: 818px; }
</style>

<script type="text/javascript"
		{{-- you need a mapid.php that simply echo your google maps api --}}
		src="https://maps.googleapis.com/maps/api/js?key=@include('ravel::admin.maps.mapid')&sensor=true">
</script>

<script type="text/javascript">
	function initialize() {
		var mapOptions = {
			center: new google.maps.LatLng(-33.04529, 17.99415),
			zoom: 8,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		};
		var map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);
		var marker = new google.maps.Marker({
			position: new google.maps.LatLng(-33.04529, 17.99415),
			map: map,
			title: 'SBIDZ'
		});
	}
	//google.maps.event.addDomListener(window, 'load', initialize);
</script>		

@stop

@section('javascripts')
<script type="text/javascript">

	//Data Resource
	App.factory('DataSource', function($resource){
          //added MapsApiController to api routes
	  return $resource('<?php echo action("MapsApiController@index");?>/:id',
	  		{id:'@id'},
	  		{
				    query: {method:'GET'},
				    get:{method:'GET'},
				    create: {method:'POST'},
				    save: {method:'PUT'},
				    remove: {method: 'DELETE'}
			});
	});


  App.directive('paginator',function($timeout)
  {
        return {

            restrict:'C',
            replace:true,
            template: '<div class="pagination-holder">' + '</div>',
            controller: function($scope, $element, $attrs)
            {

                var halfDisplayed = 1.5,
                displayedPages = 3,
                edges = 2;

                $scope.getInterval = function()
                {
                    return {
                        start: Math.ceil($scope.currentPage > halfDisplayed ? Math.max(Math.min($scope.currentPage - halfDisplayed, ($scope.pages - displayedPages)), 0) : 0),
                        end: Math.ceil($scope.currentPage > halfDisplayed ? Math.min($scope.currentPage + halfDisplayed, $scope.pages) : Math.min(displayedPages, $scope.pages))
                    };
                }

                $scope.selectPage = function(pageIndex)
                {
                    $scope.currentPage = pageIndex;
                    $scope.$apply();
                    $scope.draw();
                }

                $scope.switchPage = function(pageNum)
                {
                    $scope.$emit('switchPage',pageNum);
                }

                $scope.appendItem = function(pageIndex, opts)
                {
                    var options, link;

                    pageIndex = pageIndex < 0 ? 0 : (pageIndex < $scope.pages ? pageIndex : $scope.pages - 1);

                    options = $.extend({
                        text: pageIndex + 1,
                        classes: ''
                    }, opts || {});

                    if (pageIndex == $scope.currentPage)
                    {
                        link = $('<a href="#" class="number current">' + (options.text) + '</a>');
                    } else 
                    {
                        link = $('<a href="javascript:void(0)" class="number page-link">' + (options.text) + '</a>');
                        link.bind('click', function() {
                            $scope.selectPage(pageIndex);
                            $scope.switchPage(pageIndex +1);
                        });
                    }

                    if (options.classes)
                    {
                        link.addClass(options.classes);
                    }

                    $element.append(link);
                }


                $scope.draw = function()
                {

                    $($element).empty();
                    var interval = $scope.getInterval(),i;

                    // Generate Prev link
                    if (true) {
                        $scope.appendItem($scope.currentPage - 1, {
                            text: 'Prev',
                            classes: 'prev'
                        });
                    }

                    // Generate start edges
                    if (interval.start > 0 && edges > 0) {
                        var end = Math.min(edges, interval.start);
                        for (i = 0; i < end; i++) {
                            $scope.appendItem(i);
                        }
                        if (edges < interval.start) {
                            $element.append('<span class="ellipse">...</span>');
                        }
                    }

                    // Generate interval links
                    for (i = interval.start; i < interval.end; i++) {
                        $scope.appendItem(i);
                    }

                    // Generate end edges
                    if (interval.end < $scope.pages && edges > 0) {
                        if ($scope.pages - edges > interval.end) {
                            $element.append('<span class="ellipse">...</span>');
                        }
                        var begin = Math.max($scope.pages - edges, interval.end);
                        for (i = begin; i < $scope.pages; i++) {
                            $scope.appendItem(i);
                        }
                    }

                    // Generate Next link
                    if (true) {
                        $scope.appendItem($scope.currentPage + 1, {
                            text: 'Next',
                            classes: 'next'
                        });
                    }
                }

            },
            link: function(scope, element, attrs, controller)
                  {
                      $timeout(function() {
                          scope.draw();
                      }, 2000);

                      scope.$watch(scope.paginatePages, function()
                      {
                          scope.draw();
                      });
                  }
            }
  });



	MasterCtrl.$inject=['$scope','DataSource'];
	function MasterCtrl($scope, DataSource)
	{
	
	//attributes
		$scope.recordset = [];

		$scope.item = {};

		$scope.insertItem = true;

    $scope.show_template = 'maps/table';

    $scope.pages = 1;

    $scope.itemsPerPage = 10;

    $scope.currentPage = 0;

    $scope.pageNumber = 1;

    $scope.$on('switchPage',function(evt, pageNum)
    {
            $scope.pageNumber = pageNum;
            $scope.fetchdata();
    });
	
	//fetch recordset data
		$scope.fetchdata = function()
		{
        var pageNumber = $scope.pageNumber;
  			DataSource.get({page: pageNumber},function(request)
        {
            $scope.recordset = request.data;
            $scope.pages = Math.ceil(request.totalrows / $scope.itemsPerPage);
        });
		}

    

		$scope.fetchdata();


    $scope.gotopage = function(path)
    {
        $scope.show_template = path;
    }

	//CRUD
		//create
		$scope.create = function()
		{
        $scope.insertItem = true;
        $scope.item = new DataSource;
        $scope.gotopage('maps/create');
		}

		//read
		$scope.read = function(item)
		{
        $scope.item = item;
        $scope.gotopage('maps/view');
		}

	    $scope.edit = function(item)
	    {
	        $scope.insertItem = false;
	        $scope.item = new DataSource(item);
	        $scope.gotopage('maps/edit');
	    }

		//update item
		$scope.update = function()
		{
        $scope.item.$save(function(data, response)
        {
             $scope.$broadcast('update_data', true);
        },function()
        {
            $scope.$broadcast('update_data', false);
        });
		}

    //insert new item
    $scope.insert = function()
    {
        $scope.item.$create(function(data, response)
        {
             $scope.$broadcast('insert_data', true);
        },function()
        {
            $scope.$broadcast('insert_data', false);
        });
    }


	//delete
	$scope.delete = function()
	{
        var selected = $scope.item;
        $scope.item.$remove(function(data, response)
        {
            var index = $scope.recordset.indexOf(selected);
            $scope.recordset.splice(index, 1);
            $scope.gotopage('maps/table');
        });
	}


	//Form Actions

	$scope.cancel = function()
	{
        $scope.insertItem = true;
        $scope.item = {};
        $scope.gotopage('maps/table');
	}


    //process submit action
    $scope.submit = function()
    {
        var success = false;
        if($scope.insertItem)
        {
          if($scope.insert())
          {
            success = true;
          }
        }
        else
        {
          if($scope.update())
          {
            success = true;
          }
        }

        if(success)
        {
            $scope.fetchdata(); //reloading data again
            $scope.cancel();
        }
    }


    //action taken after submition of data
    $scope.$on('insert_data',function(evt, status)
    {
        if(status)
        {
            $scope.fetchdata(); //reloading data again
            $scope.cancel();
        }
    });

    $scope.$on('update_data',function(evt, status)
    {
        if(status)
        {
            $scope.fetchdata(); //reloading data again
            $scope.cancel();
        }
    });

	}
        
//$('#jbar').bar();

</script>

@stop