@section('appcontainer')
<div ng-controller='MasterCtrl'>

<div ng-include='show_template'></div>

    <script type="text/ng-template" id='media/view'>
       @include('ravel::admin.media.view')
    </script>

    <script type="text/ng-template" id='media/create'>
        @include('ravel::admin.media.create')
    </script>

    <script type="text/ng-template" id='media/edit'>
        @include('ravel::admin.media.edit')
    </script>

    <script type="text/ng-template" id='media/view'>
        @include('ravel::admin.media.view')
    </script>
</div>
@stop

@section('javascripts')
<script type="text/javascript">

	//Data Resource
	App.factory('DataSource', function($resource){
	  return $resource('<?php echo action("MediaUploadApiController@index");?>/:id',
	  		{id:'@id'},
	  		{
				    query: {method:'GET'},
				    get:{method:'GET'},
				    create: {method:'POST'},
				    save: {method:'PUT'},
				    remove: {method: 'DELETE'}
			});
	});


    



	MasterCtrl.$inject=['$scope','DataSource'];
	function MasterCtrl($scope, DataSource)
	{

	
	//attributes
	$scope.recordset = [];

	$scope.item = {};

	$scope.insertItem = true;

    $scope.show_template = 'media/view';

    $scope.pages = 1;

    $scope.itemsPerPage = 10;

    $scope.currentPage = 0;

    $scope.pageNumber = 1;

    $scope.post_categories = [];


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
        $scope.gotopage('media/create');

		}

		//read
		$scope.read = function(item)
		{
        $scope.item = item;
        $scope.gotopage('media/view');
		}

    $scope.edit = function(item)
    {
        $scope.insertItem = false;
        $scope.item = new DataSource(item);
        $scope.gotopage('media/edit');

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
            $scope.gotopage('media/view');
        });
	}


	//Form Actions

	$scope.cancel = function()
	{
        $scope.insertItem = true;
        $scope.item = {};
        $scope.gotopage('media/view');
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

</script>
@stop