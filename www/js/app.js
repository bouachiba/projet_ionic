// Ionic Starter App

// angular.module is a global place for creating, registering and retrieving Angular modules
// 'starter' is the name of this angular module example (also set in a <body> attribute in index.html)
// the 2nd parameter is an array of 'requires'
var app = angular.module('starter', ['ionic','angularMoment']);

app.run(function($ionicPlatform, amMoment) {
    $ionicPlatform.ready(function() {
        if (window.cordova && window.cordova.plugins.Keyboard) {
            // Hide the accessory bar by default (remove this to show the accessory bar above the keyboard
            // for form inputs)
            cordova.plugins.Keyboard.hideKeyboardAccessoryBar(true);

            // Don't remove this line unless you know what you are doing. It stops the viewport
            // from snapping when text inputs are focused. Ionic handles this internally for
            // a much nicer keyboard experience.
            cordova.plugins.Keyboard.disableScroll(true);
        }
        if (window.StatusBar) {
            StatusBar.styleDefault();
        }
         amMoment.changeLocale('fr');
    });
});
app.service("RedditService", function($q, $http) {

    var self = {
        list: [],
        load: function(params) {
            var RedditParams = {params:params};
           var defer = $q.defer();
           $http.get('https://www.reddit.com/r/android/new/.json', params)
                   .success(function(data){
                       self.list=self.list.concat(data.data.children);
               console.log(self.list);
               
               defer.resolve();
           })
                   .error(function(error){
                       defer.reject(error);
                       
           })
           return defer.promise;
        }
    };
    return self;
});

app.controller('ctrl', function($scope, RedditService) {
    $scope.list = [];
    RedditService.load().then(
            function success(successMsg) {
                console.log(successMsg);
                $scope.list = RedditService.list;
                console.log($scope.list);
            },
            function error(errorMsg) {
                console.log(errorMsg);
            }
    );
    $scope.loadMore=function(){
        if($scope.list.length>0){
        lastItemId = $scope.list[$scope.list.length-1].data.name;
        params={
            "after":lastitemId
        }
            RedditService.load(params).then(
            function success(successMsg) {
                console.log(successMsg);
                $scope.list = RedditService.list;
                console.log($scope.list);
                $scope.$broadcast("inifiteScrollComplete");
            },
            function error(errorMsg) {
                console.log(errorMsg);
            }
                    
    )}
    }
    
});