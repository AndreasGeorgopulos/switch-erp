// USER CONTROLLER
var Order = Admin.controller('Order', function($scope, filterFilter, $http) {
    $scope.init = function () {
        $scope.pager = new Paginator(function () {
            window.scrollTo(0, 0);
            var $this = this;
            $http.get('/orders/get_data/' + $this.index).then(function (response) {
                $this.setData(response.data.orders, response.data.total, response.data.limit);
            });
        });
    };

    $scope.remove = function (order) {
        BootstrapDialog.confirm({
            title: 'Törlés',
            body: 'Biztos, hogy törölni akarod ezt a rendelést?',
            yesClick: function () {
                BootstrapDialog.close();
                $http.get('/orders/remove/' + order.id).then(function (response) {
                    $scope.pager.load();
                });
            }
        });
    };
});