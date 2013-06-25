@section('appcontainer')
<div ng-controller='MasterCtrl' class='content-box-content'>

	<div ng-include='show_template'></div>

	{{ Menu::build('main-menu') }}

</div>
@stop


@section('javascripts')
<script type="text/javascript">

	//Data Resource
	App.factory('DataSource', function($resource){
	  return $resource('<?php echo action("MenusApiController@index");?>/:id',
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

		$scope.recordset = [];

		//fetch recordset data
		$scope.fetchdata = function()
		{
	        var pageNumber = $scope.pageNumber;
	  		DataSource.get({},function(request)
	        {
	            $scope.recordset = request.data;
	            
	        });
		}

    

		$scope.fetchdata();

	}

</script>
@stop