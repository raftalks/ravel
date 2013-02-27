@section('appcontainer')
<div ng-controller='MasterCtrl'>

<div ng-include='show_template'></div>



<script type="text/ng-template" id='users/table'>
  @include('ravel::admin.settings.users.table')
</script>

<script type="text/ng-template" id='users/create'>
  @include('ravel::admin.settings.users.create')
</script>

@stop

@section('javascripts')
<script type="text/javascript">

	//Data Resource
	App.factory('DataSource', function($resource){
	  return $resource('<?php echo action("UsersApiController@index");?>/:id',
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

    $scope.show_template = 'users/table';

	
	//fetch recordset data
		$scope.fetchdata = function()
		{
  			DataSource.get({},function(request)
        {
            $scope.recordset = request.data;
            
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
        $scope.gotopage('users/create');
		}

		//read
		$scope.read = function()
		{

		}

    $scope.edit = function(item)
    {
        $scope.insertItem = false;
        $scope.item = item;
        $scope.gotopage('users/edit');
    }

		//update item
		$scope.update = function()
		{

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


		}


	//Form Actions
		$scope.cancel = function()
		{
        $scope.insertItem = true;
        $scope.item = {};
        $scope.gotopage('users/table');
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






		
		// $scope.list = [];

		// $scope.loadTemplate = 'facility/empty';

		// $scope.formNew = true;

		// $scope.selectedItem = [];

		// $scope.item = {};

		// $scope.loadData = function()
	 //    {
	 //        DataSource.query({},function(data)
	 //        {
	 //             $scope.list = data;
	 //        });
	 //    }


		// $scope.filterOptions = {
  //       	filterText: '',
  //       	useExternalFilter: false
  //   	};

    	
  //   	$scope.pagingOptions = {
  //       	pageSizes: [10,20,50, 100],
  //       	pageSize: 10,
  //       	currentPage: 1
  //   	};

 
		// $scope.gridOptions = { 
  //       		data: 'list',
  //       		columnDefs: [
  //       		{field:'code', displayName:'Code'}, 
  //       		{field:'facility', displayName:'Facility'},
  //           {field:'type', displayName:'Type'},
  //       		{field:'updated_at', displayName:'Modified'}, 
  //       		{field:'created_at', displayName:'Created'}
  //       		],
  //          	//pagingOptions: $scope.pagingOptions,
  //       		filterOptions: $scope.filterOptions,
  //       		multiSelect: false,
  //       		selectedItems: $scope.selectedItem,
  //       		afterSelectionChange: function(){ $scope.selectionChanged() },
  //     			displaySelectionCheckbox: false,
  //           groups:['type']
  //   	};

  //  		$scope.selectionChanged = function()
  //  		{  
  //       $scope.formNew = false;
  //       $scope.item = angular.copy($scope.selectedItem[0]);
  //       $scope.loadTemplate = 'facility/view';
   			
  //  		};
       

  //    	$scope.create = function()
  //    	{
  //    		$scope.item = new DataSource();
  //    		$scope.formNew = true;
  //       $scope.loadTemplate = 'facility/create';
  //    	}


  //    	$scope.edit = function()
  //    	{
  //      		$scope.loadTemplate = 'facility/edit';
  //     }

  //     $scope.cancel = function()
  //     {
  //         //$scope.item = $scope.itemHistory;
  //         $scope.loadData();
  //     		$scope.loadTemplate = 'facility/empty';
  //     }

  //     $scope.deleteItem = function()
  //     {
  //       $scope.item.$delete(function(data, response)
  //         {
  //             showNotice('Facility is now deleted','info');
  //             $scope.loadData();
  //             $scope.loadTemplate = 'facility/empty';
  //         });
        
  //     }

  //    	$scope.save = function()
  //    	{
        

  //    		if($scope.formNew)
  //    		{
  //      			$scope.item.$create(function(data, response)
  // 				  {
  //     					$scope.item = data;
               
  //     					$scope.list.push(data);
  //     					showNotice('Successfully Saved','info');
  //               $scope.reloadBlankView();

  // 				  },
  //           function(response)
  //   				{
  //   					$scope.errors = response.data.errors;
    					
  //   					var status = response.status;
  //   					showAllErrors($scope.errors);
    					
  //   				});
  //     	}
  //    		else
  //    		{
  //        		$scope.item.$save(function(data, response)
  //   				{
  //   					$scope.item = data;
  //             $scope.selectedItem[0] = $scope.item;					
  //             showNotice('Successfully Saved','info');
  //             $scope.reloadBlankView();
  //   				},
  //           function(response)
  //   				{
  //   					$scope.errors = response.data.errors;
  //   					var status = response.status;
  //   					showAllErrors($scope.errors);
  //   				});
		// 	   }

         

  //    	}

  //     $scope.reloadBlankView = function()
  //     {
  //        $scope.loadData();
  //        $scope.loadTemplate = 'facility/empty';
  //     }

  //     $scope.loadData();
	}

</script>


@stop