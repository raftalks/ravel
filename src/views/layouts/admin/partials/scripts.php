<script type="text/javascript">
	//APP MODULE
	var App = angular.module('app', ['ngResource','ui','ck','ui.dropzone'], function ($routeProvider, $locationProvider, $httpProvider) {

    var interceptor = ['$rootScope', '$q', function (scope, $q) {

          scope.nowloading = true;

          function success(response) {
            scope.nowloading = false;
            
            return response;
          }

          function error(response) {
              scope.nowloading = false;
              var status = response.status;
              var data = response.data;
              var messages = data.error;

              //error handler
               console.log(data);

              show_error_message(messages);

              // if (status == 401) {
              //     var deferred = $q.defer();
              //     var req = {
              //         config:response.config,
              //         deferred:deferred
              //     }
              //     //window.location = "./index.html";
              // }  

              // otherwise
              return $q.reject(response);

          }

          return function (promise) {
              return promise.then(success, error);
          }

    }];

    $httpProvider.responseInterceptors.push(interceptor);

  });

</script>

<script type="text/javascript">
//Directive jquery datepicker
App.directive('ngdatepicker',function($parse)
{
  return {
    restrict: 'E',
    template: '<input type="text" />',
    replace:true,
    link: function($scope, $element, attrs)
    {
      attrs.$set('class', 'text-input isDatepicker');
      var ngModel = $parse(attrs.ngModel);
      $element.datepicker({
          onSelect:function (dateText, inst) {
                    $scope.$apply(function(scope){
                        // Change binded variable
                        ngModel.assign(scope, dateText);
                    });
          },
          dateFormat: "yy-mm-dd" 
      });
    }
  }
});




//jbar notification
function showWarning(message) {
  showMessage(message, 'warning');
}

function showError(message) {
  showMessage(message, 'error');
}

function showNotification(message) {
  showMessage(message, null);
}

function showMessage(message, classToUse) {
  var options = { message: message };
  if (classToUse != null) options.useClass = classToUse;
  $.bar(options);
}



function show_error_message(message)
{
  // if(angular.isArray(message.errors))
  // {
  //   var values = message.errors;
  //   angular.forEach(values, function(value, key){
        
  //       showWarning(value);

  //   });
  // }

  showError(message);

}


$(".ng_multi_select").select2(); 




</script>