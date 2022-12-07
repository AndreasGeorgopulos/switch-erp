// PAGINATOR
var Paginator = function (loadFunc) {
    this.data = [];
    this.view = 'grid';
    this.total = 0;
    this.limit = 0;
    this.index = 0;
    this.from = 0;
    this.to = 0;
    this.steps = [];

    this.prev = function () {
        if (this.index > 0) {
            this.index--;
            this.load();
        }
    };

    this.next = function () {
        if (this.data.length > 0) {
            this.index++;
            this.load();
        }
    };

    this.select = function (index) {
        this.index = index >= 0 ? index : 0;
        this.load();
    };

    this.setData = function (data, total, limit) {
        this.data = data;
        this.total = total;
        this.limit = limit;
        this.from = (this.index * this.limit) + 1;
        this.to = (this.index * this.limit) + this.limit;

        var from, to, index = -1;
        this.steps = [];
        while (this.total > ((index * this.limit) + this.limit)) {
            index++;
            from = (index * this.limit) + 1;
            to = (index * this.limit) + this.limit;
            this.steps.push({
                value: index,
                title: from + '-' + (this.total < to ? this.total : to)
            });
        }
    };

    this.load = loadFunc != undefined ? loadFunc : function () {};

    this.load();
};

//ADMIN ANGULAR APP
var App = angular.module('App', [], function($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');
});

// PRODUCT CONTROLLER
var App = App.controller('Product', function($scope, filterFilter, $http) {
    $scope.Cart = {
        opened: false,
        items: [],
        user_id: 0,
        open: function () {
            this.opened = true;
        },
        close: function () {
            this.opened = false;
        },
        add: function (product) {
            var index = this.find(product);
            if (index == -1) {
                this.items.push(product);
            }
        },
        remove: function (product) {
            var index = this.find(product);
            if (index > -1) {
                this.items.splice(index, 1);
            }
            if (!this.items.length) this.close();
        },
        find: function (product) {
            var exists = -1;
            for (var i = 0; i < this.items.length; i++) {
                if (this.items[i].id == product.id) {
                    exists = i;
                    break;
                }
            }
            return exists;
        },
        clear: function () {
            this.items = [];
            this.close();
        },
        order: function () {
            var $this = this;
            var items = [];
            for (var i = 0; i < this.items.length; i++) {
                items.push(this.items[i].id);
            }

            $http.post('/api/products/add_new_order', { products: items, user_id: this.user_id }).then(function (response) {
                $this.clear();
            });
        }
    };


    $scope.init = function (user_id) {
        $scope.Cart.user_id = user_id;
        $scope.pager = new Paginator(function () {
            window.scrollTo(0, 0);
            var $this = this;
            $http.get('/api/products/' + $this.index).then(function (response) {
                $this.setData(response.data.products, response.data.total, response.data.limit);
            });
        });
    };
});