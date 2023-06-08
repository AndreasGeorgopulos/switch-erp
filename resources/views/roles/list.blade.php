<div class="box-body">
    <div class="dataTables_wrapper form-inline dt-bootstrap">
        @include('layout.table.header')
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-bordered table-striped dataTable">
                    <thead>
                    <tr role="row">
                        <th class="@if($sort == 'id') sorting_{{$direction}} @else sorting @endif" data-column="id">#</th>
                        <th class="@if($sort == 'key') sorting_{{$direction}} @else sorting @endif" data-column="key">{{trans('Kulcs')}}</th>
                        <th data-column="name">{{trans('Név')}}</th>
                        <th data-column="description">{{trans('Leírás')}}</th>
                        <th>
                            <a href="{{url(route('roles_edit'))}}" class="btn btn-primary btn-sm pull-right"><i class="fa fa-plus"></i> {{trans('Új jogosultság')}}</a>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($list as $model)
                        <?php $translate = $model->translates()->where('language_code', App::getLocale())->first(); ?>
                        <tr role="row" class="odd">
                            <td>{{$model->id}}</td>
                            <td>{{$model->key}}</td>
                            <td>{{!empty($translate->name) ? $translate->name : ''}}</td>
                            <td>{{!empty($translate->description) ? $translate->description : ''}}</td>
                            <td class="text-right" style="width: 150px;">
                                <a href="{{url(route('roles_edit', ['id' => $model->id]))}}" class="btn btn-primary btn-sm">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a href="{{url(route('roles_delete', ['id' => $model->id]))}}" class="btn btn-danger btn-sm confirm">
                                    <i class="fa fa-trash"></i>
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