// USER CONTROLLER
var User = Admin.controller('User', function($scope, filterFilter, $http) {
    $scope.selected = null;

    $scope.init = function () {
        $scope.pager = new Paginator(function () {
            window.scrollTo(0, 0);
            var $this = this;
            $http.get('/users/get_data/' + $this.index).then(function (response) {
                $this.setData(response.data.users, response.data.total, response.data.limit);
            });
        });
    };

    $scope.edit = function (user) {
        if (user == undefined) $scope.selected = { id: 0, name: '', group: 'user' };
        else $scope.selected = angular.copy(user);
    };

    $scope.cancel = function () {
        $scope.selected = null;
    };

    $scope.save = function () {
        $http.post('/users/save', $scope.selected).then(function (response) {
            if (response.data.success) {
                $('#modalFrm').modal('hide');
                BootstrapDialog.alert({
                    title: 'Save',
                    body: 'A(z) ' + $scope.selected.name + ' nevű gyártó felhasználó mentésre került.',
                    click: function () {
                        BootstrapDialog.close();
                        $scope.pager.load();
                        $scope.selected = null;
                    }
                });
            }
        });
    };

    $scope.remove = function (user) {
        BootstrapDialog.confirm({
            title: 'Törlés',
            body: 'Biztos, hogy törölni akarod ezt a felhasználót?<br /><br /><b>' + user.name + '</b>',
            yesClick: function () {
                BootstrapDialog.close();
                $http.get('/users/remove/' + user.id).then(function (response) {
                    $scope.pager.load();
                });
            }
        });
    };

    $scope.unlock = function (user) {
        $http.get('/users/unlock/' + user.id).then(function (response) {
            $scope.pager.load();
        });
    };
});