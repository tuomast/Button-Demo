var config = config || {};

angular.module('spending',[]).
config(function($routeProvider) {
    $routeProvider
        .when('/', {controller:AccountsController, templateUrl:'app/views/spending/accounts.html'});
});

function AccountsController($scope, $http) {

    $scope.savedTransactions = [];

    $scope.selectAccount = function(selectedAccount) {

        var req = {
            method: 'GET',
            url: '/api/accounts/' + selectedAccount.accountId + '/transactions',
        };

        $http(req).
            then(function(response) {
                $scope.transactions = response.data;
                console.log($scope.transactions );
            });
    };

    $scope.saveTransactionType = function( $type ){
        $scope.savedTransactions.push($type);
        console.log($scope.savedTransactions);
    }

    var req = {
        method: 'GET',
        url: '/api/accounts',
    };
    $http(req).
        then(function(response) {
            $scope.accounts = response.data;
            console.log($scope.accounts );

        });
}