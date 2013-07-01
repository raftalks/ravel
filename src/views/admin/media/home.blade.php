@section('appcontainer')
<div ng-controller='MasterCtrl' class='content-box-content'>

<div class='media-collections align-left span3 well'>
    

    <div class='addCollection'>
        <h4>Add New Collection</h4>
        <input name='collection' ng-model='new_collection' type='text' class='text-input' />
        <span >
            <button ng-click='toggleLock()' class='shortcut-button normal'><i ng-class='lockIcon'></i></button>
            <button ng-click='addCollection()' class='button'><i class='icon-plus'></i></button>
        </span>
        <div>
            
        </div>
    </div>

    <div class='media-collections'>
        <h3>My Collections</h3>
        <ul class='media-collection-list'>
            <li ng-repeat='folder in collections | filter:{type:"private"}' ng-click='selectCollection(folder)'>
                <a src='#' class='block' ng-bind='folder.name' ></a>
            </li>
        </ul>
    </div>

    <div class='media-collections' ng-show='(collections | filter:{type:"shared"}).length'>
        <h5>Shared by Others</h5>
        <ul class='media-collection-list'>
            <li ng-repeat='folder in collections | filter:{type:"shared"}'>
                <div ng-bind='folder.name'></div>
            </li>
        </ul>
    </div>


</div>
<div class='collection-list align-left span8'>
    <div ng-include='show_template'></div>
</div>

<div class='clear'></div>
   
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


    App.factory('MediaCollection', function($resource)
    {
        return $resource('<?php echo action("MediaCollectionApiController@index");?>/:id',
            {id:'@id'},
            {
                    query: {method:'GET'},
                    get:{method:'GET'},
                    create: {method:'POST'},
                    save: {method:'PUT'},
                    remove: {method: 'DELETE'}
            });
    });


    



	MasterCtrl.$inject=['$scope','DataSource','MediaCollection'];
	function MasterCtrl($scope, DataSource, MediaCollection)
	{
       

        //new collection
        $scope.new_collection= '';

        $scope.collections = [];

        $scope.activeCollection = {};

        $scope.collectionShared = 0;
        $scope.lockIcon = 'icon-lock';

        $scope.addCollection = function()
        {
            var folder = angular.copy($scope.new_collection);
            var status = $scope.collectionShared;
            var collection = new MediaCollection({name: folder, shared:status, items:[]});

            collection.$create(function(data, response)
            {
                 $scope.$broadcast('insert_collection', true);
                 $scope.new_collection = '';
                 $scope.collections.push(collection);

            },function()
            {
                $scope.$broadcast('insert_collection', false);
            });
        
        }

        $scope.selectCollection = function(collection)
        {
            $scope.activeCollection = collection;
        }

        $scope.fetchCollections = function()
        {
            MediaCollection.get(function(request)
            {
                $scope.collections = request.data;
                
            });
        }

        $scope.fetchCollections();

         //action taken after submition of data
        $scope.$on('insert_collection',function(evt, status)
        {
            if(status)
            {
                $scope.fetchCollections(); //reloading data again
            }
        });

        $scope.toggleLock = function()
        {

            if($scope.collectionShared)
            {
                $scope.collectionShared = 0;
                $scope.lockIcon = 'icon-lock';
            }else{
                
                $scope.collectionShared= 1;
                $scope.lockIcon = 'icon-unlock';
            }
        }

	
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

    

		//$scope.fetchdata();


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