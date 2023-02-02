<div class="tab-pane" id="acl_data">
	<p>{{trans('Válassza ki azokat az jogosultságokat, amelyek ehhez a felhasználóhoz tartoznak.')}}</p>

	<div class="form-group" style="height: 200px; overflow: auto;">
		@foreach ($roles as $id => $role)
			<div class="checkbox">
				<label>
					<input type="checkbox" name="roles[]" value="{{$id}}" @if($role['enabled']) checked="checked" @endif>
					{{$role['title']}}
				</label>
			</div>
		@endforeach
	</div>
	<div class="clearfix"></div>
</div>