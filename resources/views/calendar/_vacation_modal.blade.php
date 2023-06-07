<div id="vacationModal"
     class="modal"
     style="display: none;"
     data-approve-url="{{url(route('ajax_approve_vacation'))}}"
     data-reject-url="{{url(route('ajax_reject_vacation'))}}"
     data-delete-url="{{url(route('ajax_delete_profile_vacation'))}}"
>

	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Esemény lehetőségek</h4>
			</div>
			<div class="modal-body">
				<p class="notice"></p>
			</div>
			<div class="modal-footer">
				<button type="button" id="vacation_approve_btn" class="btn btn-success btn-sm">
					<i class="fa fa-check"></i> {{trans('Elfogad')}}
				</button>

				<button type="button" id="vacation_reject_btn" class="btn btn-secondary btn-sm">
					<i class="fa fa-ban"></i> {{trans('Elutasít')}}
				</button>

				<button type="button" id="vacation_delete_btn" class="btn btn-danger btn-sm">
					<i class="fa fa-trash"></i> {{trans('Töröl')}}
				</button>

				<button type="button" id="vacation_modal_close_btn" class="btn btn-default btn-sm">
					<i class="fa fa-close"></i> {{trans('Bezár')}}
				</button>
			</div>
		</div>
	</div>
</div>