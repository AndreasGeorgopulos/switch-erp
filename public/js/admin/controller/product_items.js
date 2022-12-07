// PRODUCT ITEM CONTROLLER
var ProductItem = Admin.controller('ProductItem', function($scope, filterFilter, $http) {
    $scope.selected = null;

    $scope.init = function () {
        $scope.pager = new Paginator(function () {
            window.scrollTo(0, 0);
            var $this = this;
            $http.get('/product_items/get_data/' + $this.index).then(function (response) {
                $this.setData(response.data.items, response.data.total, response.data.limit);
            });
        });
    };

    $scope.edit = function (item) {
        if (item == undefined) $scope.selected = { id: 0, name: '' };
        else $scope.selected = angular.copy(item);
    };
    $scope.cancel = function () {
        $scope.selected = null;
    };


    $scope.save = function () {
        $http.post('/product_items/save', $scope.selected).then(function (response) {
            if (response.data.success) {
                BootstrapDialog.alert({
                    title: 'Mentés',
                    body: 'A(z) ' + $scope.selected.name + ' feltét mentve lett.',
                    click: function () {
                        BootstrapDialog.close();
                        $scope.pager.load();
                        $scope.selected = null;
                    }
                });
            }
        });
    };

    $scope.remove = function (item) {
        BootstrapDialog.confirm({
            title: 'Törlés',
            body: 'Biztos, hogy törölni akarod ezt a feltétet?<br /><br /><b>' + item.name + '</b>',
            yesClick: function () {
                BootstrapDialog.close();
                $http.get('/product_items/remove/' + item.id).then(function (response) {
                    $scope.pager.load();
                });
            }
        });
    };
});