@extends('adminlte::page')
@section('title', 'Switch IT ERP')

@section('modals')
    <div class="modal modal-default fade" id="confirm_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Művelet megerősítése</h4>
                </div>
                <div class="modal-body">
                    <p>A művelet végrehajtásához megerősítés szükséges. Végrehajtja a műveletet?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">{{trans('Elvetés')}}</button>
                    <button type="button" class="btn btn-primary yes_btn">{{trans('Végrehajtom a műveletet')}}</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@endsection