<input type="hidden" name="id" />

<div class="row">
	<div class="col-sm-3">
	</div>
	<div class="col-sm-6">
		<div class="alert alert-warning hidden">
			<h4><i class="icon fa fa-warning"></i> {{trans('Hiba')}}</h4>
			<p>{{trans('A következő hibák miatt a szabadságigény felvitele nem sikerült')}}:</p>
			<p class="errors"></p>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-sm-3"></div>
	<div class="col-sm-3">
		<label>{{trans('Kezdete')}}</label>
		<input type="date" name="begin_date" class="form-control" required="required" max="2999-12-31" />
	</div>
	<div class="col-sm-3">
		<label>{{trans('Vége')}}</label>
		<input type="date" name="end_date" class="form-control" required="required" max="2999-12-31" />
	</div>
</div>
<div class="row">
	<div class="col-sm-3"></div>
	<div class="col-sm-6">
		<label>{{trans('Megjegyzés')}}</label>
		<textarea name="notice" class="form-control"></textarea>
	</div>
</div>

<div class="row">
	<div class="col-sm-3"></div>
	<div class="col-sm-6 text-right">
		<button type="button" class="btn btn-success btn-sm btn-form-save margin-r-5">
			<i class="fa fa-check"></i> {{trans('Rendben')}}
		</button>
		<button type="button" class="btn btn-default btn-sm btn-form-cancel">
			<i class="fa fa-ban"></i> {{trans('Mégsem')}}
		</button>
	</div>
</div>