// PRODUCT CONTROLLER
var Product = Admin.controller('Product', function($scope, filterFilter, $http) {
    $scope.selected = null;
    $scope.product_items = null;

    $scope.init = function () {
        $http.get('/product_items/get_data').then(function (response) {
            $scope.product_items = angular.copy(response.data.items);
        });

        $scope.pager = new Paginator(function () {
            window.scrollTo(0, 0);
            var $this = this;
            $http.get('/products/get_data/' + $this.index).then(function (response) {
                $this.setData(response.data.products, response.data.total, response.data.limit);
            });
        });
    };

    $scope.edit = function (product) {
        if (product == undefined) $scope.selected = { id: 0, name: '', items: [] };
        else $scope.selected = angular.copy(product);
        var items = [];
        $scope.selected.items.forEach(function (data) {
            items.push(data.id);
        });
        $scope.selected.items = angular.copy(items);
    };

    $scope.cancel = function () {
        $scope.selected = null;
    };

    $scope.setItem = function (item_id) {
        var index = $scope.selected.items.indexOf(item_id);
        if (index == -1) $scope.selected.items.push(item_id);
        else $scope.selected.items.splice(index, 1);
    };

    $scope.save = function () {
        $http.post('/products/save', $scope.selected).then(function (response) {
            if (response.data.success) {
                BootstrapDialog.alert({
                    title: 'Mentés',
                    body: 'A(z) ' + $scope.selected.name + ' pizza sikeresen mentésre került.',
                    click: function () {
                        BootstrapDialog.close();
                        $scope.pager.load();
                        $scope.selected = null;
                    }
                });
            }
        });
    };

    $scope.remove = function (product) {
        BootstrapDialog.confirm({
            title: 'Törlés',
            body: 'Biztos, hogy töröln akarod ezt a pizzát?<br /><br /><b>' + product.name + '</b>',
            yesClick: function () {
                BootstrapDialog.close();
                $http.get('/products/remove/' + product.id).then(function (response) {
                    $scope.pager.load();
                });
            }
        });
    };
});