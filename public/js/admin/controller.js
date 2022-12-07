// Ajax spinner
var AjaxLoader = {
	inProgress: false,
	title: '#ajaxprogress .container .title',
	container: '#ajaxprogress',	
	start: function (title) {
		$(this.title).html(title);
		$(this.container).show();
		this.inProgress = true;
	},
	stop: function () {
		$(this.title).html('');
		$(this.container).hide();
		this.inProgress = false;
	}
};

//Dialog windows
var BootstrapDialog = {
	setParams: function (params) {
		$('#modal_window .btn.ok').off('click');
		$('#modal_window .btn.ok').on('click', function () {
			if (params.okClick != undefined) params.okClick();
			else $('#modal_window').modal('hide');
		});
		// cancel button click event
		$('#modal_window .btn.ok').on('click');
		$('#modal_window .btn.cancel').on('click', function () {
			if (params.cancelClick != undefined) params.cancelClick();
			else $('#modal_window').modal('hide');
		});
		// call callback function
		if (params.callback != undefined) params.callback();
		// open modal window
		$('#modal_window').modal({
			modal: true
		});
	},
	open: function (params) {
		/*params: url, content, loadingTitle, modalHeaderTitle, callback, okClick, cancelClick */
		AjaxLoader.start(params.loadingTitle != undefined ? params.loadingTitle : Locale.loading);
		$('#modal_window .modal-header .modal-title').html(params.modalHeaderTitle != undefined ? params.modalHeaderTitle : 'n/a');
		if (params.url != '') {
			$('#modal_window .modal-body').load(params.url, function () {
				BootstrapDialog.setParams(params);
				AjaxLoader.stop();
			});
		}
		else if (params.content != '') {
			$('#modal_window .modal-body').html(params.content);
			BootstrapDialog.setParams(params);
			AjaxLoader.stop();
		}
	},
	alert: function (params) {
		// params: title, body, click
		$('#modal_alert .modal-title').html(params.title != undefined ? params.title : 'n/a');
		$('#modal_alert .modal-body p').html(params.body != undefined ? params.body : 'n/a');
		
		// yes button click event
		$('#modal_alert .btn.ok').off('click');
		$('#modal_alert .btn.ok').on('click', function () {
			if (params.click != undefined) params.click();
			else $('#modal_alert').modal('hide');
		});
		// open modal window
		$('#modal_alert').modal({
			modal: true
		});
	},
	confirm: function (params) {
		// params: title, body, yesClick, noClick
		$('#modal_confirm .modal-title').html(params.title != undefined ? params.title : 'n/a');
		$('#modal_confirm .modal-body p').html(params.body != undefined ? params.body : 'n/a');
		
		// yes button click event
		$('#modal_confirm .btn.yes').off('click');
		$('#modal_confirm .btn.yes').on('click', function () {
			if (params.yesClick != undefined) params.yesClick();
			else $('#modal_confirm').modal('hide');
		});
		// no button click event
		$('#modal_confirm .btn.no').off('click');
		$('#modal_confirm .btn.no').on('click', function () {
			if (params.noClick != undefined) params.noClick();
			else $('#modal_confirm').modal('hide');
		});
		// open modal window
		$('#modal_confirm').modal({
			modal: true
		});
	},
	close: function () {
		$('#modal_window, #modal_alert, #modal_confirm').modal('hide');
	}
};

//PAGINATOR
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
var Admin = angular.module('Admin', [], function($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');
});
