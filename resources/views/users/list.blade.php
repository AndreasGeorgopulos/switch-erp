<div class="box-body">
    <div class="dataTables_wrapper form-inline dt-bootstrap">
        @include('layout.table.header')
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-bordered table-striped dataTable">
                    <thead>
                    <tr role="row">
                        <th class="@if($sort == 'id') sorting_{{$direction}} @else sorting @endif" data-column="id">#</th>
                        <th class="@if($sort == 'name') sorting_{{$direction}} @else sorting @endif" data-column="name">{{trans('Név')}}</th>
                        <th class="text-center">{{trans('Szabadnapok')}} ({{trans('Felhasznált/Éves')}})</th>
                        <th class="text-center @if($sort == 'monogram') sorting_{{$direction}} @else sorting @endif" data-column="monogram">{{trans('Monogram')}}</th>
                        <th class="@if($sort == 'email') sorting_{{$direction}} @else sorting @endif" data-column="email">{{trans('E-mail')}}</th>
                        <th>
                            <a href="{{url(route('users_edit'))}}" class="btn btn-primary btn-sm pull-right"><i class="fa fa-plus"></i> {{trans('Új felhasználó')}}</a>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($list as $model)
                        <tr role="row" class="odd">
                            <td>{{$model->id}}</td>
                            <td class="sorting_1">{{$model->name}}</td>
                            <td class="sorting_1 text-center">
                                @if(!empty($model->vacation_days_per_year))
                                    {{$model->free_vacation_days}} / {{$model->vacation_days_per_year}}
                                @endif
                            </td>
                            <td class="sorting_1 text-center">{{$model->monogram}}</td>
                            <td>{{$model->email}}</td>
                            <td class="text-right" style="width: 150px;">
                                <a href="{{url(route('users_edit', ['id' => $model->id]))}}" class="btn btn-primary btn-sm">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a href="{{url(route('users_delete', ['id' => $model->id]))}}" class="btn btn-danger btn-sm confirm">
                                    <i class="fa fa-trash"></i>
                                </a>
                                <a href="{{url(route('users_force_login', ['id' => $model->id]))}}" class="btn btn-default btn-sm confirm">
                                    <i class="fa fa-sign-in"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @include('layout.table.footer')
    </div>
</div>